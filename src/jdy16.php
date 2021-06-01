<?php
	namespace Fawno\HiDANCE;

	use SerialConnection\SerialConnection;

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
			$this->serial = new SerialConnection;
			$this->serial->setDevice($device);
			$this->serial->setBaudRate('9600');
			$this->serial->setParity('none');
			$this->serial->setCharacterLength(8);
			$this->serial->setStopBits(1);
			$this->serial->setFlowControl('none');
			$this->serial->open();
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
			return $this->serial->readPort();
		}
	}
