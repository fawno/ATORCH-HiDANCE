<?php
	require __DIR__ . '/autoload.php';

	use Fawno\HiDANCE\J7H;
	use Fawno\HiDANCE\DL24;

	$data = file_get_contents('data/jdy-20210509-0037.raw');
	$csv = J7H::parse2csv($data, ';', true);
	file_put_contents('data/jdy-20210509-0037.csv', $csv);

	$data = file_get_contents('data/jdy-20210531-2308.raw');
	$csv = DL24::parse2csv($data, ';', true);
	file_put_contents('data/jdy-20210531-2308.csv', $csv);
