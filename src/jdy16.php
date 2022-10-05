<?php
	namespace Fawno\HiDANCE;

	use Fawno\PhpSerial\SerialDio;

	/**
	 * @package Fawno\HiDANCE
	 */
	class JDY16 {
		protected $serial = null;

		/**
		 * @param string $device
		 * @return void
		 */
		public function __construct (string $device) {
			$this->serial = new SerialDio($device);
			//$this->serial->setDevice($device);
			$this->serial->setDataRate('9600');
			$this->serial->setParity(0);
			$this->serial->setDataBits(8);
			$this->serial->setStopBits(1);
			$this->serial->setFlowControl(0);
			$this->serial->open();
			$this->serial->setBlocking(0);
			//$this->serial->setTimeout(0, 100000);
		}

		/**
		 * @return void
		 */
		public function __destruct () {
			$this->serial->close();
		}

		/**
		 * @param string|null $command
		 * @return string
		 */
		public function sendAT (string $command = null) {
			$message = ($command ? 'at+' . $command : 'at') . "\r\n";
			$this->serial->send($message, true);
			return $this->serial->read();
		}
	}
