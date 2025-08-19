<?php

if (!defined('ABSPATH')) {
	exit;
}

class WSFM_Menu_Builder {
	private $terms_provider;
	private const CHILDREN_PER_LEVEL2 = 3;
	private const CHILDREN_PER_LEVEL3 = 2;

	public function __construct($terms_provider = null) {
		$this->terms_provider = $terms_provider ?: new WSFM_Terms_Provider();
	}

	public function build_fake_menu($menu_name, $levels, $num_root_links) {
		$menu_name = (string) $menu_name;
		$levels = (int) $levels;
		$num_root_links = (int) $num_root_links;

		if ($menu_name === '') {
			return new WP_Error('wsfm_empty_name', __('Le nom du menu est obligatoire.', WSFM_TEXT_DOMAIN));
		}

		$menu = wp_get_nav_menu_object($menu_name);
		if (!$menu) {
			$menu_id = wp_create_nav_menu($menu_name);
			if (is_wp_error($menu_id)) {
				return $menu_id;
			}
		} else {
			$menu_id = (int) $menu->term_id;
			$existing_items = wp_get_nav_menu_items($menu_id, ['post_status' => 'any']);
			if (!empty($existing_items)) {
				foreach ($existing_items as $item) {
					wp_delete_post((int) $item->ID, true);
				}
			}
		}

		$counts = [
			'level1' => 0,
			'level2' => 0,
			'level3' => 0,
		];

		for ($i = 1; $i <= $num_root_links; $i++) {
			$title1 = $this->terms_provider->generate_label(1, $i);
			$root_id = $this->add_menu_item($menu_id, $title1, 0);
			if (!is_wp_error($root_id)) {
				$counts['level1']++;

				if ($levels >= 2) {
					for ($j = 1; $j <= self::CHILDREN_PER_LEVEL2; $j++) {
						$title2 = $this->terms_provider->generate_label(2, $j, $title1);
						$child_id = $this->add_menu_item($menu_id, $title2, (int) $root_id);
						if (!is_wp_error($child_id)) {
							$counts['level2']++;

							if ($levels >= 3) {
								for ($k = 1; $k <= self::CHILDREN_PER_LEVEL3; $k++) {
									$title3 = $this->terms_provider->generate_label(3, $k, $title2);
									$grand_id = $this->add_menu_item($menu_id, $title3, (int) $child_id);
									if (!is_wp_error($grand_id)) {
										$counts['level3']++;
									}
								}
							}
						}
					}
				}
			}
		}

		return [
			'menu_id' => (int) $menu_id,
			'counts' => $counts,
		];
	}

	private function add_menu_item($menu_id, $title, $parent_id = 0) {
		$args = [
			'menu-item-title' => $title,
			'menu-item-url' => '#',
			'menu-item-status' => 'publish',
			'menu-item-type' => 'custom',
		];
		if ($parent_id > 0) {
			$args['menu-item-parent-id'] = (int) $parent_id;
		}
		return wp_update_nav_menu_item((int) $menu_id, 0, $args);
	}
}