<?php
	namespace Fawno\HiDANCE;

	use Fawno\HiDANCE\JDY16;

	/**
	 * @package Fawno\HiDANCE
	 *
	*/
	class HiDANCE extends JDY16 {
		protected const SIGNAL_CONN  = '\+CONNECTED>>0x[0-9A-F]{12}\r\n';
		protected const SIGNAL_DISC  = '\+DISCONNECTED\r\n';
		protected const MARK         = 'ff5501[\da-f]{2}';
		protected const DATA         = '\xFF\x55\x01[\x00-\x0F][\x00-\xFF]{32}';
		protected const RESPONSE     = '\xFF\x55\x02[\x00-\x0F][\x00-\xFF]{4}';
		protected const RST_ELECTRIC = '\xFF\x55\x11[\x00-\x0F]\x01\x00\x00\x00\x00\x51';
		protected const RST_CAPACITY = '\xFF\x55\x11[\x00-\x0F]\x02\x00\x00\x00\x00\x52';
		protected const RST_TIME     = '\xFF\x55\x11[\x00-\x0F]\x03\x00\x00\x00\x00\x53';
		protected const RST_ALL      = '\xFF\x55\x11[\x00-\x0F]\x05\x00\x00\x00\x00\x5D';
		protected const BTN_SETUP    = '\xFF\x55\x11[\x00-\x0F]\x31\x00\x00\x00\x00\x01';
		protected const BTN_ENTER    = '\xFF\x55\x11[\x00-\x0F]\x32\x00\x00\x00\x00\x02';
		protected const BTN_PLUS     = '\xFF\x55\x11[\x00-\x0F]\x33\x00\x00\x00\x00\x03';
		protected const BTN_MINUS    = '\xFF\x55\x11[\x00-\x0F]\x34\x00\x00\x00\x00\x0C';

		/**
		 * @param string $filename
		 * @return void
		 */
		public function record (string $filename) {
			do {
				do {
					$buffer = $this->serial->readPort();
				} while (!$buffer);

				if (preg_match('~'  . self::SIGNAL_CONN . '|' . self::SIGNAL_DISC . '$~', $buffer)) {
					echo $buffer;
				} else {
					file_put_contents($filename, $buffer, FILE_APPEND);
					echo preg_replace('~(' . self::MARK . ')~', PHP_EOL . '$1', bin2hex($buffer));
				}
			} while (!preg_match('~'  . self::SIGNAL_DISC . '$~', $buffer));
		}

		/**
		 * @param string|null $filename
		 * @return string|void
		 */
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

		/**
		 * @param string $data
		 * @return bool
		 */
		public static function isData (string $data) : bool {
			return preg_match('~^.*' . self::DATA . '~', $data);
		}

		/**
		 * @param string $data
		 * @return string
		 */
		public static function getData (string &$data) : string {
			$record = preg_replace('~^.*('  . self::DATA . ').*~', '$1', $data);
			$data = preg_replace('~.*' . self::DATA . '~', '', $data);
			return $record;
		}

		/**
		 * @param string $data
		 * @return bool
		 */
		public static function isSignal (string $data) : bool {
			return preg_match('~' . self::SIGNAL_CONN . '|'  . self::SIGNAL_DISC . '$~', $data);
		}

		/**
		 * @param string $data
		 * @return string
		 */
		public static function getSignal (string &$data) : string {
			$signal = preg_replace('~('  . self::SIGNAL_CONN . '|' . self::SIGNAL_DISC . ')$~', '$1', $data);
			$data = preg_replace('~' . self::SIGNAL_CONN . '|' . self::SIGNAL_DISC . '$~', '', $data);
			return $signal;
		}

		/**
		 * @param string $data
		 * @return bool
		 */
		public static function isConnectedSignal (string $data) : bool {
			return preg_match('~' . self::SIGNAL_CONN . '$~', $data);
		}

		/**
		 * @param string $data
		 * @return bool
		 */
		public static function isDisconnectedSignal (string $data) : bool {
			return preg_match('~' . self::SIGNAL_DISC . '$~', $data);
		}
	}
