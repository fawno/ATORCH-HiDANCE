<?php
	require __DIR__ . '/autoload.php';

	use Fawno\HiDANCE\J7H;

	$data = file_get_contents('data/jdy-20210509-0037.raw');
	$csv = J7H::parse2csv($data, ';', true);
	file_put_contents('data/jdy-20210509-0037.csv', $csv);
