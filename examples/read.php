<?php
	require __DIR__ . '/autoload.php';

	use Fawno\HiDANCE\J7H;

	$jdy = new J7H('COM8');

	//$filename = strftime('data/jdy-%Y%m%d-%H%M.raw');
	$filename = null;

	//$jdy->read();
	//$jdy->record($filename);

	echo $jdy->parse2csv('', "\t", true);
	do {
		$data = $jdy->read($filename);
		if ($jdy->isData($data)) {
			echo $jdy->parse2csv($data, "\t");
		} else {
			echo $data;
		}
	} while (!$jdy->isDisconnectedSignal($data));

