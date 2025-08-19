<?php

if (!defined('ABSPATH')) {
	exit;
}

class WSFM_Admin_Page {
	private $menu_builder;

	public function __construct($menu_builder) {
		$this->menu_builder = $menu_builder;
		add_action('admin_menu', [$this, 'register_menu']);
		add_action('admin_post_wsfm_create_menu', [$this, 'handle_form']);
		add_action('admin_notices', [$this, 'maybe_render_notice']);
	}

	public function register_menu() {
		add_management_page(
			__('WS Fake Menu', WSFM_TEXT_DOMAIN),
			__('WS Fake Menu', WSFM_TEXT_DOMAIN),
			'manage_options',
			'ws-fake-menu',
			[$this, 'render_page']
		);
	}

	public function render_page() {
		if (!current_user_can('manage_options')) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html(__('WS Fake Menu', WSFM_TEXT_DOMAIN)); ?></h1>
			<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
				<?php wp_nonce_field('wsfm_create_menu', 'wsfm_nonce'); ?>
				<input type="hidden" name="action" value="wsfm_create_menu" />

				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row"><label for="wsfm_menu_name"><?php echo esc_html(__('Nom du menu à créer', WSFM_TEXT_DOMAIN)); ?></label></th>
							<td><input name="menu_name" type="text" id="wsfm_menu_name" class="regular-text" required /></td>
						</tr>
						<tr>
							<th scope="row"><label for="wsfm_levels"><?php echo esc_html(__('Nombre de niveaux', WSFM_TEXT_DOMAIN)); ?></label></th>
							<td>
								<select name="levels" id="wsfm_levels">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>
								<p class="description"><?php echo esc_html(__('De 1 à 3 max', WSFM_TEXT_DOMAIN)); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="wsfm_links_lvl1"><?php echo esc_html(__('Nombre de liens de niveau 1', WSFM_TEXT_DOMAIN)); ?></label></th>
							<td><input name="num_links_level1" type="number" id="wsfm_links_lvl1" class="small-text" min="1" max="50" step="1" value="5" required /></td>
						</tr>
					</tbody>
				</table>

				<?php submit_button(__('Créer', WSFM_TEXT_DOMAIN)); ?>
			</form>
		</div>
		<?php
	}

	public function handle_form() {
		if (!current_user_can('manage_options')) {
			wp_die(__('Accès refusé', WSFM_TEXT_DOMAIN));
		}
		check_admin_referer('wsfm_create_menu', 'wsfm_nonce');

		$menu_name = isset($_POST['menu_name']) ? sanitize_text_field(wp_unslash($_POST['menu_name'])) : '';
		$levels = isset($_POST['levels']) ? absint($_POST['levels']) : 1;
		$levels = max(1, min(3, $levels));
		$num_links_level1 = isset($_POST['num_links_level1']) ? absint($_POST['num_links_level1']) : 1;
		$num_links_level1 = max(1, min(50, $num_links_level1));

		$result = $this->menu_builder->build_fake_menu($menu_name, $levels, $num_links_level1);

		if (is_wp_error($result)) {
			$notice = [
				'type' => 'error',
				'message' => $result->get_error_message(),
			];
		} else {
			$counts = isset($result['counts']) ? $result['counts'] : [];
			$menu_id = isset($result['menu_id']) ? (int) $result['menu_id'] : 0;
			$items_summary = sprintf(
				__('Liens créés — Niveau 1: %1$d, Niveau 2: %2$d, Niveau 3: %3$d', WSFM_TEXT_DOMAIN),
				(int) ($counts['level1'] ?? 0),
				(int) ($counts['level2'] ?? 0),
				(int) ($counts['level3'] ?? 0)
			);
			$notice = [
				'type' => 'success',
				'message' => sprintf(__('Menu "%1$s" (ID %2$d) créé. %3$s', WSFM_TEXT_DOMAIN), esc_html($menu_name), $menu_id, $items_summary),
			];
		}

		set_transient('wsfm_notice_' . get_current_user_id(), $notice, 30);

		$redirect = add_query_arg(['page' => 'ws-fake-menu'], admin_url('tools.php'));
		wp_safe_redirect($redirect);
		exit;
	}

	public function maybe_render_notice() {
		if (!isset($_GET['page']) || $_GET['page'] !== 'ws-fake-menu') {
			return;
		}
		$notice = get_transient('wsfm_notice_' . get_current_user_id());
		if (!$notice) {
			return;
		}
		delete_transient('wsfm_notice_' . get_current_user_id());
		$type = $notice['type'] === 'success' ? 'notice-success' : 'notice-error';
		?>
		<div class="notice <?php echo esc_attr($type); ?> is-dismissible">
			<p><?php echo wp_kses_post($notice['message']); ?></p>
		</div>
		<?php
	}
}