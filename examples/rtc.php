<?php
	require __DIR__ . '/autoload.php';

	use Fawno\HiDANCE\J7H;

	$jdy = new J7H('COM8');

	if ('+RTCOPEN=0' == trim($jdy->sendAT('rtcopen'))) {
		echo $jdy->sendAT('rtcopen1');
	}

	$local = '+RTCDATE=' . date('Y-m-d,H:i:s');
	$rtcd =  trim($jdy->sendAT('rtcd'));
	if ($local != $rtcd) {
		echo $jdy->sendAT('rtcd' . date('Y-m-d,H:i:s'));
	}

	echo date('Y-m-d H:i:s'), PHP_EOL;
	echo $jdy->sendAT('rtcd');
