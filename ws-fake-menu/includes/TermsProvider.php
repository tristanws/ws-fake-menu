<?php

if (!defined('ABSPATH')) {
	exit;
}

class WSFM_Terms_Provider {
	private $level1;
	private $level2;
	private $level3;

	public function __construct() {
		$this->level1 = [
			__('Destinations', WSFM_TEXT_DOMAIN),
			__('Séjours', WSFM_TEXT_DOMAIN),
			__('Expériences', WSFM_TEXT_DOMAIN),
			__('Guides', WSFM_TEXT_DOMAIN),
			__('Inspiration', WSFM_TEXT_DOMAIN),
			__('Offres', WSFM_TEXT_DOMAIN),
			__('Circuits', WSFM_TEXT_DOMAIN),
			__('Hébergements', WSFM_TEXT_DOMAIN),
			__('Activités', WSFM_TEXT_DOMAIN),
			__('Transports', WSFM_TEXT_DOMAIN),
		];
		$this->level2 = [
			__('Europe', WSFM_TEXT_DOMAIN),
			__('Asie', WSFM_TEXT_DOMAIN),
			__('Amériques', WSFM_TEXT_DOMAIN),
			__('Afrique', WSFM_TEXT_DOMAIN),
			__('Océanie', WSFM_TEXT_DOMAIN),
			__('France', WSFM_TEXT_DOMAIN),
			__('Italie', WSFM_TEXT_DOMAIN),
			__('Espagne', WSFM_TEXT_DOMAIN),
			__('Grèce', WSFM_TEXT_DOMAIN),
			__('Portugal', WSFM_TEXT_DOMAIN),
		];
		$this->level3 = [
			__('Plages', WSFM_TEXT_DOMAIN),
			__('Randonnées', WSFM_TEXT_DOMAIN),
			__('Villes', WSFM_TEXT_DOMAIN),
			__('Culture', WSFM_TEXT_DOMAIN),
			__('Gastronomie', WSFM_TEXT_DOMAIN),
			__('Aventure', WSFM_TEXT_DOMAIN),
			__('Bien-être', WSFM_TEXT_DOMAIN),
			__('Ski', WSFM_TEXT_DOMAIN),
			__('Nature', WSFM_TEXT_DOMAIN),
			__('Musées', WSFM_TEXT_DOMAIN),
		];
	}

	public function generate_label($level, $index, $parent_title = '') {
		$level = (int) $level;
		$index = (int) $index;

		switch ($level) {
			case 1:
				$base = $this->level1[($index - 1) % count($this->level1)];
				return sprintf('%1$s %2$d', $base, $index);
			case 2:
				$base = $this->level2[($index - 1) % count($this->level2)];
				return $base;
			case 3:
				$base = $this->level3[($index - 1) % count($this->level3)];
				return $base;
			default:
				return sprintf(__('Élément %d', WSFM_TEXT_DOMAIN), $index);
		}
	}
}