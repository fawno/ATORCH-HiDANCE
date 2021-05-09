<?php
	namespace Fawno\HiDANCE;

	use Fawno\HiDANCE\JDY16;

	class J7H extends JDY16 {
		protected const SIGNAL_CONN  = '\+CONNECTED>>0x[0-9A-F]{12}\r\n';
		protected const SIGNAL_DISC  = '\+DISCONNECTED\r\n';
		protected const DATA         = '\xFF\x55\x01\x03[\x00-\xFF]{32}';
		protected const RESPONSE     = '\xFF\x55\x02\x03[\x00-\xFF]{4}';
		protected const RST_ELECTRIC = '\xFF\x55\x11\x03\x01\x00\x00\x00\x00\x51';
		protected const RST_CAPACITY = '\xFF\x55\x11\x03\x02\x00\x00\x00\x00\x52';
		protected const RST_TIME     = '\xFF\x55\x11\x03\x03\x00\x00\x00\x00\x53';
		protected const RST_ALL      = '\xFF\x55\x11\x03\x05\x00\x00\x00\x00\x5D';
		protected const BTN_SETUP    = '\xFF\x55\x11\x03\x31\x00\x00\x00\x00\x01';
		protected const BTN_ENTER    = '\xFF\x55\x11\x03\x32\x00\x00\x00\x00\x02';
		protected const BTN_PLUS     = '\xFF\x55\x11\x03\x33\x00\x00\x00\x00\x03';
		protected const BTN_MINUS    = '\xFF\x55\x11\x03\x34\x00\x00\x00\x00\x0C';

		public const J7H_FIELDS_UNPACK = [
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

		public const J7H_FIELDS_SCALE = [
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

		public const J7H_FIELDS_FORMAT = [
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

		public const J7H_FIELDS_UNITS = [
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

		public function record (string $filename) {
			do {
				do {
					$buffer = $this->serial->readPort();
				} while (!$buffer);

				if (preg_match('~'  . self::SIGNAL_CONN . '|' . self::SIGNAL_DISC . '$~', $buffer)) {
					echo $buffer;
				} else {
					file_put_contents($filename, $buffer, FILE_APPEND);
					echo preg_replace('~ff550103~', PHP_EOL . 'ff550103', bin2hex($buffer));
				}
			} while (!preg_match('~'  . self::SIGNAL_DISC . '$~', $buffer));

		}

		public function read (string $filename = null) {
			static $buffer = '';

			do {
				do {
					$buffer .= $this->serial->readPort();
					//usleep(10000);
				} while (!self::isSignal($buffer) and !self::isData($buffer));

				if (self::isData($buffer)) {
					$data = self::getData($buffer);

					if ($filename) {
						file_put_contents($filename, $data, FILE_APPEND);
					}

					return $data;
				}

				if (self::isSignal($buffer)) {
					return self::getSignal($buffer);
				}
			} while (!self::isDisconnectedSignal($buffer));
		}

		public static function isData (string $data) : bool {
			return preg_match('~^.*' . self::DATA . '~', $data);
		}

		public static function getData (string &$data) : string {
			$record = preg_replace('~^.*('  . self::DATA . ').*~', '$1', $data);
			$data = preg_replace('~.*' . self::DATA . '~', '', $data);
			return $record;
		}

		public static function isSignal (string $data) : bool {
			return preg_match('~' . self::SIGNAL_CONN . '|'  . self::SIGNAL_DISC . '$~', $data);
		}

		public static function getSignal (string &$data) : string {
			$signal = preg_replace('~('  . self::SIGNAL_CONN . '|' . self::SIGNAL_DISC . ')$~', '$1', $data);
			$data = preg_replace('~' . self::SIGNAL_CONN . '|' . self::SIGNAL_DISC . '$~', '', $data);
			return $signal;
		}

		public static function isConnectedSignal (string $data) : bool {
			return preg_match('~' . self::SIGNAL_CONN . '$~', $data);
		}

		public static function isDisconnectedSignal (string $data) : bool {
			return preg_match('~' . self::SIGNAL_DISC . '$~', $data);
		}

		public static function bin2array (string $data) {
			$j7h_unpack = null;
			foreach (self::J7H_FIELDS_UNPACK as $name => $format) {
				$j7h_unpack .= $format . $name . '/';
			}

			$data = unpack($j7h_unpack, $data);
			$data['Time'] = sprintf('%04u:%02u:%02u', $data['Hours'], $data['Minuts'], $data['Seconds']);

			foreach (self::J7H_FIELDS_SCALE as $field => $scale) {
				$data[$field] = isset($data[$field]) ? $scale * $data[$field] : null;
			}

			return $data;
		}

		public static function format (array $data) {
			foreach (self::J7H_FIELDS_FORMAT as $field => $format) {
				$data[$field] = isset($data[$field]) ? sprintf($format, $data[$field]) : null;
			}

			return $data;
		}

		public static function array2csv (array $data, string $separator = ';') {
			$output = [];
			foreach (self::J7H_FIELDS_UNITS as $field => $unit) {
				$output[$field] = !empty($data[$field]) ? $data[$field] : null;
			}

			return implode($separator, $output) . PHP_EOL;
		}

		public static function parse2csv (string $raw, string $separator = ';', bool $header = false) {
			$output = null;

			if ($header) {
				//$output .= implode($separator, array_keys(self::J7H_FIELDS_UNITS)) . PHP_EOL;
				$header = [];
				foreach (self::J7H_FIELDS_UNITS as $field => $unit) {
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

		public static function parse2array (string $raw, bool $header = false) {
			$rows = [];

			if ($header) {
				//$rows[] = array_keys(self::J7H_FIELDS_UNITS);
				$header = [];
				foreach (self::J7H_FIELDS_UNITS as $field => $unit) {
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
