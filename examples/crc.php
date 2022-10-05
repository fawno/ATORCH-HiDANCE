<?php
/*
const packet = Buffer.from('FF551103310000000001', 'hex');

const payload = packet.slice(2, -1);
// "11033100000000" (hex string)

const checksum = payload.reduce((acc, item) => (acc + item) & 0xff, 0) ^ 0x44;

FF 55 11030100000000 51
FF 55 11030200000000 52
FF 55 11030300000000 53
FF 55 11030500000000 5D
FF 55 11033100000000 01
FF 55 11033200000000 02
FF 55 11033300000000 03
FF 55 11033400000000 0C
FF 55 0203010000 42
FF 55 0203010000 42
FF 55 0203010000 42
FF 55 0203010000 42
FF 55 0203030000 4C
FF 55 0203030000 4C
FF 55 0203010000 42
FF 55 0203010000 42
*/

const atorch_hidance_magic_header = "\xFF\x55";

function atorch_hidance_crc (string $message) : string {
	$accumulator = 0;

	foreach (unpack('C*', $message) as $item) {
		$accumulator = ($accumulator + $item) & 0xFF;
	}

	return pack('C', ($accumulator ^ 0x44));
}

$message = hex2bin('11030500000000');
$checksum = atorch_hidance_crc($message);

echo bin2hex($checksum), PHP_EOL;
echo bin2hex(atorch_hidance_magic_header . $message . $checksum), PHP_EOL;
