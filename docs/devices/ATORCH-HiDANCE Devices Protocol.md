# ATORCH-HiDANCE Devices Protocol
- [Initial connection information](#initial-connection-information)
	- [Bluetootch Profile](#bluetootch-profile)
	- [Bluetootch LE](#bluetootch-le)
- [Packet layout](#packet-layout)
	- [Message Type](#message-type)
	- [Device Type](#device-type)
	- [Payloads](#payloads)
		- [Reports](#reports)
			- [AC Meter Report](#ac-meter-report)
			- [DC Meter Report](#dc-meter-report)
			- [USB Meter Report](#usb-meter-report)
		- [Command](#command)
			- [Commands](#commands)
		- [Reply](#reply)
	- [Checksum Algorithm](#checksum-algorithm)
- [Thanks](#thanks)

## Initial connection information

### Bluetootch Profile
Device broadcast name: `UD18-SPP`, `AT24-SPP`, etc `*-SPP`

| Profile             |
| ------------------- |
| Serial Port Profile |

[TOC](#atorch-hidance-devices-protocol)

### Bluetootch LE
Device broadcast name: `UD18-BLE`, `AT24-BLE`, etc `*-BLE`

| Type           | UUID                                   |
| -------------- | -------------------------------------- |
| Service        | `0000FFE0-0000-1000-8000-00805F9B34FB` |
| Characteristic | `0000FFE1-0000-1000-8000-00805F9B34FB` |

[TOC](#atorch-hidance-devices-protocol)

## Packet layout
|    Offset | Field        | Block size | Note                                      |
|----------:|--------------| ---------- | ----------------------------------------- |
|       00h | Magic Header | 2 byte     | `FF 55`                                   |
|       02h | Message Type | 1 byte     | [Message Type](#message-type)             |
|       03h | Device Type  | 1 byte     | [Device Type](#device-type)               |
|       04h | Payload      |            | [Payloads](#payloads)                     |
| Last byte | Checksum     | 1 byte     | [Checksum Algorithm](#checksum-algorithm) |

> The *Message* consists of *Message Type*, *Device Type* and *Payload*.

[TOC](#atorch-hidance-devices-protocol)

### Message Type
| Type | Payload size | Note                |
|-----:|-------------:|---------------------|
| `01` |      31 byte | [Report](#reports) |
| `02` |       4 byte | [Reply](#reply)     |
| `11` |       6 byte | [Command](#command) |

[TOC](#atorch-hidance-devices-protocol)

### Device Type
| Type | Note                                  |
|-----:|---------------------------------------|
| `01` | [AC Meter Report](#ac-meter-report)   |
| `02` | [DC Meter Report](#dc-meter-report)   |
| `03` | [USB Meter Report](#usb-meter-report) |

[TOC](#atorch-hidance-devices-protocol)

### Payloads
 - [Reports](#reports)
 - [Reply](#reply)
 - [Command](#command)

[TOC](#atorch-hidance-devices-protocol)

#### Reports
  - [AC Meter Report](#ac-meter-report)
  - [DC Meter Report](#dc-meter-report)
  - [USB Meter Report](#usb-meter-report)

[TOC](#atorch-hidance-devices-protocol)

##### AC Meter Report
> There are currently no product tests

| Offset | Size | Field                   | Scale Unit  | Data format        | Stored |
|-------:|-----:|-------------------------|-------------|--------------------|:------:|
|  0000h |    3 | Voltage (V)             | 1/10 V      | 24 bit unsigned BE |        |
|  0003h |    3 | Current (I)             | 1/1000 A    | 24 bit unsigned BE |        |
|  0006h |    3 | Power                   | 1/10 W      | 24 bit unsigned BE |        |
|  0009h |    4 | Energy                  | 1/100 kWh   | 32 bit unsigned BE |  Yes   |
|  000Dh |    3 | Price/kWh               | 1/100 €/kWh | 24 bit unsigned BE |  Yes   |
|  0010h |    2 | Frequency               | 1/10 Hz     | 16 bit unsigned BE |        |
|  0012h |    2 | Power Factor            | 1/1000      | 16 bit unsigned BE |        |
|  0014h |    2 | Temp                    | 1 ºC        | 16 bit unsigned BE |        |
|  0016h |    2 | Hour                    | 1 h         | 16 bit unsigned BE |  Yes   |
|  0018h |    1 | Minute                  | 1 min       | unsigned char      |  Yes   |
|  0019h |    1 | Second                  | 1 s         | unsigned char      |        |
|  001Ah |    1 | Back Light (BL)         | 1 s         | unsigned char      |  Yes   |
|  001Bh |    4 | Unknown value           |             |                    |        |

[TOC](#atorch-hidance-devices-protocol)

##### DC Meter Report
> Based on [DL24P Electronic Load](DL24-DL24P) tests

| Offset | Size | Field                   | Scale Unit  | Data format        | Stored |
|-------:|-----:|-------------------------|-------------|--------------------|:------:|
|  0000h |    3 | Voltage (V)             | 1/10 V      | 24 bit unsigned BE |        |
|  0003h |    3 | Current (I)             | 1/1000 A    | 24 bit unsigned BE |        |
|  0006h |    3 | Capacity                | 1/100 Ah    | 24 bit unsigned BE |  Yes   |
|  0009h |    4 | Energy                  | 1/100 kWh   | 32 bit unsigned BE |  Yes   |
|  000Dh |    3 | Price/kWh               | 1/100 €/kWh | 24 bit unsigned BE |  Yes   |
|  0010h |    4 | Unknown value           |             |                    |        |
|  0014h |    2 | Temp                    | 1 ºC        | 16 bit unsigned BE |        |
|  0016h |    2 | Hour                    | 1 h         | 16 bit unsigned BE |  Yes   |
|  0018h |    1 | Minute                  | 1 min       | unsigned char      |  Yes   |
|  0019h |    1 | Second                  | 1 s         | unsigned char      |        |
|  001Ah |    1 | Back Light (BL)         | 1 s         | unsigned char      |  Yes   |
|  001Bh |    4 | Unknown value           |             |                    |        |

[TOC](#atorch-hidance-devices-protocol)

##### USB Meter Report
> Based on [J7-H USB Tester](J7-H) tests

| Offset | Size | Field                   | Scale Unit  | Data format        | Stored |
|-------:|-----:|-------------------------|-------------|--------------------|:------:|
|  0000h |    3 | Voltage (V)             | 1/100 V     | 24 bit unsigned BE |        |
|  0003h |    3 | Current (I)             | 1/100 A     | 24 bit unsigned BE |        |
|  0006h |    3 | Capacity                | 1/100 Ah    | 24 bit unsigned BE |  Yes   |
|  0009h |    4 | Energy                  | 1/100 Wh    | 32 bit unsigned BE |  Yes   |
|  000Dh |    2 | USB D-                  | 1/100 V     | 16 bit unsigned BE |        |
|  000Fh |    2 | USB D+                  | 1/100 V     | 16 bit unsigned BE |        |
|  0011h |    2 | Temp                    | 1 ºC        | 16 bit unsigned BE |        |
|  0013h |    2 | Hour                    | 1 h         | 16 bit unsigned BE |  Yes   |
|  0015h |    1 | Minute                  | 1 min       | unsigned char      |  Yes   |
|  0016h |    1 | Second                  | 1 s         | unsigned char      |        |
|  0017h |    1 | Back Light (BL)         | 1 s         | unsigned char      |  Yes   |
|  0018h |    2 | Overvoltage alarm (V>)  | 1/100 V     | 16 bit unsigned BE |  Yes   |
|  001Ah |    2 | Undervoltage alarm (V<) | 1/100 V     | 16 bit unsigned BE |  Yes   |
|  001Ch |    2 | Overcurrent alarm (I>)  | 1/100 A     | 16 bit unsigned BE |  Yes   |
|  001Eh |    1 | Power Factor            | 1/100       | unsigned char      |        |

[TOC](#atorch-hidance-devices-protocol)

#### Command
| Offset | Field       | Size | Data format           |
| -----: | ----------- |-----:|-----------------------|
|   `00` | Command     |    1 | [Commands](#commands) |
|   `01` | Value       |    4 | 32 bit unsigned BE    |

##### Commands
| Command | Action                    | Value       |
|--------:|---------------------------|-------------|
|    `01` | Reset Energy (Wh)         | `00000000`  |
|    `02` | Reset Capacity (Ah)       | `00000000`  |
|    `03` | Reset Time                | `00000000`  |
|    `05` | Reset All                 | `00000000`  |
|    `11` | `[+]` Command             | `00000000`  |
|    `12` | `[-]` Command             | `00000000`  |
|    `21` | Set Backlight Time        | 0 to 60     |
|    `22` | Set Price                 | 1 to 999999 |
|    `31` | Setup                     | `00000000`  |
|    `32` | Enter                     | `00000000`  |
|    `33` | `[+]` Command (USB Meter) | `00000000`  |
|    `34` | `[+]` Command (USB Meter) | `00000000`  |

[TOC](#atorch-hidance-devices-protocol)

#### Reply
| Offset | Field   | Size | Data format                     |
| -----: |---------|-----:|---------------------------------|
|   `00` | State   |    1 | `01`: OK <br> `03`: Unsupported |
|   `01` | Unknown |    2 | `0000`                          |

[TOC](#atorch-hidance-devices-protocol)

### Checksum Algorithm
1. [Message](#packet-layout):
    - [Message Type](#message-type):
      ```php
      $message_type = "\x11"; // Command
      ```
    - [Device Type](#device-type):
      ```php
      $device_type = "\x03"; // USB Meter
      ```
    - [Payload](#payloads):
      ```php
      $payload = "\x05\x00\x00\x00\x00"; // Command Reset All (0x05, 0x00000000)
      ```
    The *Message* consists of *Message Type*, *Device Type* and *Payload*:
      ```php
      $message = $message_type . $device_type . $payload; // 11 03 05 00 00 00 00
      ```
2. Initialize the accumulator to 0:
   ```php
   $accumulator = 0;
	 ```
3. For each unsigned char of message: add it to the accumulator. Verify that the accumulator is an unsigned char in each interation:
   ```php
   foreach (unpack('C*', $message) as $item) {
      $accumulator = ($accumulator + $item) & 0xFF;
   }
	 ```
4. The checksum is obtained by XORing the accumulator with the value 0x44:
   ```php
   $checksum = $accumulator & 0x44;
	 ```

Function in PHP:
```php
  function atorch_hidance_crc (string $message) : string {
    $accumulator = 0;

    foreach (unpack('C*', $message) as $item) {
      $accumulator = ($accumulator + $item) & 0xFF;
    }

    return pack('C', ($accumulator ^ 0x44));
  }

  $message = "\x11\x03\x05\x00\x00\x00\x00";
  $checksum = atorch_hidance_crc($message);
  echo bin2hex("\xFF\x55" . $message . $checksum), PHP_EOL;
  //FF 55 11 03 05 00 00 00 00 5D
```

[TOC](#atorch-hidance-devices-protocol)

## Thanks

- <https://github.com/NiceLabs/atorch-console/blob/master/docs/protocol-design.md>
