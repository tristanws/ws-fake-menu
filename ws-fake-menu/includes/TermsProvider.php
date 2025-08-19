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
			__('Découvertes', WSFM_TEXT_DOMAIN),
			__('Inspirations voyage', WSFM_TEXT_DOMAIN),
			__('Idées week-end', WSFM_TEXT_DOMAIN),
			__('Thématiques', WSFM_TEXT_DOMAIN),
			__('Collections', WSFM_TEXT_DOMAIN),
			__('Nos coups de cœur', WSFM_TEXT_DOMAIN),
			__('Carnets de voyage', WSFM_TEXT_DOMAIN),
			__('Top destinations', WSFM_TEXT_DOMAIN),
			__('Conseils & Astuces', WSFM_TEXT_DOMAIN),
			__('Expéditions', WSFM_TEXT_DOMAIN),
			__('Croisières', WSFM_TEXT_DOMAIN),
		];
		$this->level2 = [
			__('Europe', WSFM_TEXT_DOMAIN),
			__('Asie', WSFM_TEXT_DOMAIN),
			__('Amériques', WSFM_TEXT_DOMAIN),
			__('Amérique du Nord', WSFM_TEXT_DOMAIN),
			__('Amérique du Sud', WSFM_TEXT_DOMAIN),
			__('Amérique centrale', WSFM_TEXT_DOMAIN),
			__('Afrique', WSFM_TEXT_DOMAIN),
			__('Océanie', WSFM_TEXT_DOMAIN),
			__('Moyen-Orient', WSFM_TEXT_DOMAIN),
			__('Méditerranée', WSFM_TEXT_DOMAIN),
			__('Caraïbes', WSFM_TEXT_DOMAIN),
			__('Îles paradisiaques', WSFM_TEXT_DOMAIN),
			__('Pays nordiques', WSFM_TEXT_DOMAIN),
			__('Balkans', WSFM_TEXT_DOMAIN),
			__('Alpes', WSFM_TEXT_DOMAIN),
			__('Andalousie', WSFM_TEXT_DOMAIN),
			__('Provence', WSFM_TEXT_DOMAIN),
			__('Bretagne', WSFM_TEXT_DOMAIN),
			__('Sicile', WSFM_TEXT_DOMAIN),
			__('Grèce', WSFM_TEXT_DOMAIN),
			__('Portugal', WSFM_TEXT_DOMAIN),
			__('Espagne', WSFM_TEXT_DOMAIN),
			__('Italie', WSFM_TEXT_DOMAIN),
			__('France', WSFM_TEXT_DOMAIN),
			__('Islande', WSFM_TEXT_DOMAIN),
			__('Japon', WSFM_TEXT_DOMAIN),
			__('Thaïlande', WSFM_TEXT_DOMAIN),
			__('Vietnam', WSFM_TEXT_DOMAIN),
			__('Indonésie', WSFM_TEXT_DOMAIN),
			__('Australie', WSFM_TEXT_DOMAIN),
			__('Nouvelle-Zélande', WSFM_TEXT_DOMAIN),
			__('Canada', WSFM_TEXT_DOMAIN),
			__('États-Unis', WSFM_TEXT_DOMAIN),
			__('Mexique', WSFM_TEXT_DOMAIN),
			__('Brésil', WSFM_TEXT_DOMAIN),
			__('Argentine', WSFM_TEXT_DOMAIN),
			__('Chili', WSFM_TEXT_DOMAIN),
			__('Pérou', WSFM_TEXT_DOMAIN),
			__('Maroc', WSFM_TEXT_DOMAIN),
			__('Tunisie', WSFM_TEXT_DOMAIN),
			__('Égypte', WSFM_TEXT_DOMAIN),
			__('Kenya', WSFM_TEXT_DOMAIN),
			__('Tanzanie', WSFM_TEXT_DOMAIN),
			__('Afrique du Sud', WSFM_TEXT_DOMAIN),
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
			__('Road trips', WSFM_TEXT_DOMAIN),
			__('Îles & archipels', WSFM_TEXT_DOMAIN),
			__('Parcs nationaux', WSFM_TEXT_DOMAIN),
			__('Safari', WSFM_TEXT_DOMAIN),
			__('Spa & détente', WSFM_TEXT_DOMAIN),
			__('Vin & vignobles', WSFM_TEXT_DOMAIN),
			__('Histoire', WSFM_TEXT_DOMAIN),
			__('Art', WSFM_TEXT_DOMAIN),
			__('Architecture', WSFM_TEXT_DOMAIN),
			__('Festivals', WSFM_TEXT_DOMAIN),
			__('Vie nocturne', WSFM_TEXT_DOMAIN),
			__('Sports nautiques', WSFM_TEXT_DOMAIN),
			__('Plongée', WSFM_TEXT_DOMAIN),
			__('Surf', WSFM_TEXT_DOMAIN),
			__('Montagne', WSFM_TEXT_DOMAIN),
			__('Déserts', WSFM_TEXT_DOMAIN),
			__('Forêts', WSFM_TEXT_DOMAIN),
			__('Lacs', WSFM_TEXT_DOMAIN),
			__('Châteaux', WSFM_TEXT_DOMAIN),
			__('Patrimoine UNESCO', WSFM_TEXT_DOMAIN),
			__('Famille', WSFM_TEXT_DOMAIN),
			__('Lune de miel', WSFM_TEXT_DOMAIN),
			__('Budget', WSFM_TEXT_DOMAIN),
			__('Luxe', WSFM_TEXT_DOMAIN),
			__('Écotourisme', WSFM_TEXT_DOMAIN),
		];
	}

	public function generate_label($level, $index, $parent_title = '') {
		$level = (int) $level;
		$index = (int) $index;

		switch ($level) {
			case 1:
				$labels = $this->get_random_labels(1, 1);
				return $labels[0];
			case 2:
				$labels = $this->get_random_labels(2, 1);
				return $labels[0];
			case 3:
				$labels = $this->get_random_labels(3, 1);
				return $labels[0];
			default:
				return sprintf(__('Élément %d', WSFM_TEXT_DOMAIN), $index);
		}
	}

	public function get_random_labels($level, $count) {
		$level = (int) $level;
		$count = max(1, (int) $count);
		$pool = [];
		switch ($level) {
			case 1:
				$pool = $this->level1;
				break;
			case 2:
				$pool = $this->level2;
				break;
			case 3:
				$pool = $this->level3;
				break;
			default:
				$pool = [sprintf(__('Élément %d', WSFM_TEXT_DOMAIN), 1)];
		}

		$pool = array_values($pool);
		$pool_count = count($pool);
		$labels = [];
		$this->shuffle_array($pool);

		if ($count <= $pool_count) {
			return array_slice($pool, 0, $count);
		}

		for ($i = 0; $i < $count; $i++) {
			$index = $i % $pool_count;
			$round = (int) floor($i / $pool_count);
			$label = $pool[$index];
			if ($round > 0) {
				$label = sprintf('%1$s %2$d', $label, $round + 1);
			}
			$labels[] = $label;
		}

		// Re-mélanger pour éviter un motif répétitif
		$this->shuffle_array($labels);
		return $labels;
	}

	private function shuffle_array(&$array) {
		$length = count($array);
		for ($i = $length - 1; $i > 0; $i--) {
			$j = function_exists('wp_rand') ? wp_rand(0, $i) : rand(0, $i);
			$tmp = $array[$i];
			$array[$i] = $array[$j];
			$array[$j] = $tmp;
		}
	}
}