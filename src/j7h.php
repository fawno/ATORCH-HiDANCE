<?php
	namespace Fawno\HiDANCE;

	use Fawno\HiDANCE\HiDANCE;

	/**
	 * @package Fawno\HiDANCE
	 *
	*/
	class J7H extends HiDANCE {
		protected const RST_ELECTRIC = '\xFF\x55\x11\x03\x01\x00\x00\x00\x00\x51';
		protected const RST_CAPACITY = '\xFF\x55\x11\x03\x02\x00\x00\x00\x00\x52';
		protected const RST_TIME     = '\xFF\x55\x11\x03\x03\x00\x00\x00\x00\x53';
		protected const RST_ALL      = '\xFF\x55\x11\x03\x05\x00\x00\x00\x00\x5D';
		protected const BTN_SETUP    = '\xFF\x55\x11\x03\x31\x00\x00\x00\x00\x01';
		protected const BTN_ENTER    = '\xFF\x55\x11\x03\x32\x00\x00\x00\x00\x02';
		protected const BTN_PLUS     = '\xFF\x55\x11\x03\x33\x00\x00\x00\x00\x03';
		protected const BTN_MINUS    = '\xFF\x55\x11\x03\x34\x00\x00\x00\x00\x0C';

		public const FIELDS_UNPACK = [
			'Mark' => 'H8',
			'Reserved1' => 'H2',
			'V+' => 'n1',
			'V-' => 'C1',
			'I' => 'n1',
			'Reserved2' => 'H2',
			'Capacity' => 'n1',
			'Energy' => 'N1',
			'D-' => 'n1',
			'D+' => 'n1',
			'Temp' => 'n1',
			'Hours' => 'n1',
			'Minuts' => 'C1',
			'Seconds' => 'C1',
			'BL' => 'C1',
			'V>' => 'n1',
			'V<' => 'n1',
			'I>' => 'n1',
			'PF' => 'C1',
			'Reserved3' => 'H2',
		];

		public const FIELDS_SCALE = [
			'V+'       => 1/100,	// cV / 100  => V
			'V-'       => 1/100,	// cV / 100  => V
			'I'        => 1/100,	// cA / 100  => A
			'Capacity' => 1,	    // mAh / 1   => mAh
			'Energy'   => 1/100,	// cWh / 100 => Wh
			'D-'       => 1/100,	// cV / 100  => V
			'D+'       => 1/100,	// cV / 100  => V
			'Temp'     => 1,	    // ºC / 1    => ºC
			'BL'       => 1,      // s / 1     => s
			'V>'       => 1/100,  // cV / 100  => V
			'V<'       => 1/100,  // cV / 100  => V
			'I>'       => 1/100,  // cA / 100  => A
			'PF'       => 1/100,  // 100 => 1.00 Power Factor
		];

		public const FIELDS_FORMAT = [
			'V+'       => '% 5.2f',
			'V-'       => '% 5.2f',
			'I'        => '% 5.2f',
			'Capacity' => '% 5u',
			'Energy'   => '% 7.2f',
			'D-'       => '% 5.2f',
			'D+'       => '% 5.2f',
			'Temp'     => '% 2u',
			'BL'       => '% 2u',
			'V>'       => '% 5.2f',
			'V<'       => '% 5.2f',
			'I>'       => '% 5.2f',
			'PF'       => '%03.2f',
		];

		public const FIELDS_UNITS = [
			'Time'      => null,
			'Mark'      => null,
			'Reserved1' => null,
			'V+'        => 'V',
			'V-'        => 'V',
			'I'         => 'A',
			'Reserved2' => null,
			'Capacity'  => 'mAh',
			'Energy'    => 'Wh',
			'D-'        => 'V',
			'D+'        => 'V',
			'Temp'      => 'ºC',
			'BL'        => 's',
			'V>'        => 'V',
			'V<'        => 'V',
			'I>'        => 'A',
			'PF'        => null,
			'Reserved3' => null,
		];

		/**
		 * @param string $data
		 * @return array|false
		 */
		public static function bin2array (string $data) {
			$unpack = null;
			foreach (self::FIELDS_UNPACK as $name => $format) {
				$unpack .= $format . $name . '/';
			}

			$data = unpack($unpack, $data);
			$data['Time'] = sprintf('%04u:%02u:%02u', $data['Hours'], $data['Minuts'], $data['Seconds']);

			foreach (self::FIELDS_SCALE as $field => $scale) {
				$data[$field] = isset($data[$field]) ? $scale * $data[$field] : null;
			}

			return $data;
		}

		/**
		 * @param array $data
		 * @return array
		 */
		public static function format (array $data) {
			foreach (self::FIELDS_FORMAT as $field => $format) {
				$data[$field] = isset($data[$field]) ? sprintf($format, $data[$field]) : null;
			}

			return $data;
		}

		/**
		 * @param array $data
		 * @param string $separator
		 * @return string
		 */
		public static function array2csv (array $data, string $separator = ';') {
			$output = [];
			foreach (self::FIELDS_UNITS as $field => $unit) {
				$output[$field] = !empty($data[$field]) ? $data[$field] : null;
			}

			return implode($separator, $output) . PHP_EOL;
		}

		/**
		 * @param string $raw
		 * @param string $separator
		 * @param bool $header
		 * @return null|string
		 */
		public static function parse2csv (string $raw, string $separator = ';', bool $header = false) {
			$output = null;

			if ($header) {
				//$output .= implode($separator, array_keys(self::FIELDS_UNITS)) . PHP_EOL;
				$header = [];
				foreach (self::FIELDS_UNITS as $field => $unit) {
					$header[] = $unit ? sprintf('%s (%s)', $field, $unit) : $field;
				}
				$output .= implode($separator, $header) . PHP_EOL;
			}

			if (preg_match_all('~(' . self::DATA . ')~', $raw, $registers)) {
				$registers = end($registers);

				foreach ($registers as $register) {
					$register = self::bin2array($register);
					$register = self::format($register);
					$output .= self::array2csv($register, $separator);
				}
			}

			return $output;
		}

		/**
		 * @param string $raw
		 * @param bool $header
		 * @return array
		 */
		public static function parse2array (string $raw, bool $header = false) {
			$rows = [];

			if ($header) {
				//$rows[] = array_keys(self::FIELDS_UNITS);
				$header = [];
				foreach (self::FIELDS_UNITS as $field => $unit) {
					$header[] = $unit ? sprintf('%s (%s)', $field, $unit) : $field;
				}
				$rows[] = $header;
			}

			if (preg_match_all('~(' . self::DATA . ')~', $raw, $registers)) {
				$registers = end($registers);

				foreach ($registers as $register) {
					$register = self::bin2array($register);
					$rows[] = self::format($register);
				}
			}

			return $rows;
		}
	}
