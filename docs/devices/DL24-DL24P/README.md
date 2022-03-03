# HiDANCE DL24/DL24P Electronic Load

DL24 Color Screen Bluetooth Data Transmission Digital control Curve Load Meter

# Table of contents
- [User Manual](#user-manual)
	- [Introduction and parameters of interface and key functions](#introduction-and-parameters-of-interface-and-key-functions)
		- [Electrical parameters](#electrical-parameters)
		- [2 Wire version](#2-wire-version)
		- [4 Wire DIY version](#4-wire-diy-version)
			- [DIY 1000W](#diy-1000w)
			- [Schematic diagram and PCB layout](#schematic-diagram-and-pcb-layout)
	- [Fast application method of constant current (CC) discharge mode](#fast-application-method-of-constant-current-cc-discharge-mode)
	- [Application methods of constant resistance (CR), constant power (CP) and costant voltage (CV)](#application-methods-of-constant-resistance-cr-constant-power-cp-and-costant-voltage-cv)
	- [Methods and techniques for the inspecting and measuring of battery capacity and electric quantify](#methods-and-techniques-for-the-inspecting-and-measuring-of-battery-capacity-and-electric-quantify)
	- [Detectiong methods and techniques for the output voltage and current value and maximum power value of DC power adapter](#detectiong-methods-and-techniques-for-the-output-voltage-and-current-value-and-maximum-power-value-of-dc-power-adapter)
	- [Testing methods and techinques for capacity and electricity quantity of mobile power supply](#testing-methods-and-techinques-for-capacity-and-electricity-quantity-of-mobile-power-supply)
	- [Tesing the rated current value and quality of the charging cable and data cable](#tesing-the-rated-current-value-and-quality-of-the-charging-cable-and-data-cable)
	- [Testing the maximum output current method of the charger and ist quality](#testing-the-maximum-output-current-method-of-the-charger-and-ist-quality)
	- [The download and installation of the online mobile APP and computer APP](#the-download-and-installation-of-the-online-mobile-app-and-computer-app)
- [Software download address:](#software-download-address)
- [SDK](#sdk)
			- [Record structure:](#record-structure)
			- [Commands](#commands)
			- [Data formats](#data-formats)
- [Images](#images)

## User Manual
![](img/DL24-DL24P%20User%20Manual%2000.png)

This product is used to inspect and test the capacity of varius batteries, discharge and aging various power adapters, USB chargers, various mobile power and other power supply equipment.

### Introduction and parameters of interface and key functions
#### Electrical parameters
- Test voltage: 2  - 200 V
- Working current: 0.2 A - 20.00 A
- DL24  Discharge power: voltage * current < 150 W
- DL24P  Discharge power: voltage * current < 180 W
  The fan starts working at 10W or 55°C.
	Default assembly fan is 150W or 180W
  (The actual running current is limited by the maximum power, please adjust the current according to the law of energy conservation)
	The built-in over-current, over-temperature, over-power safety protection functions, if the protection interface is popped up, please pay attention to the parameter adjustment, shall adjust to the maximum power, and then discharge, you can first slowly and smoothly adjust the preset value in the start and discharge, in order to adjust up to the maximum power for discharging.

[TOC](#table-of-contents)

#### 2 Wire version
![2 Wire version](img/DL24-DL24P%20User%20Manual%2001%20-%202%20Wire.jpg)

[TOC](#table-of-contents)

#### 4 Wire DIY version
![4 Wire DIY version](img/DL24-DL24P%20User%20Manual%2001%20-%204%20Wire%20DIY.jpg)

Install a 75x75mm fan according to the requirements. If you find that the fan is not installed, then the test is damaged.
[Installation Manual](http://www.mediafire.com/folder/mqnr9m3svln7v/DL24-PCB)
[Installation Manual](DL24-150W-180W-DIY-1000W%20Installation%20Manual.pdf)
[Installation Manual - B version](DL24-150W-180W-DIY-1000W%20Installation%20Manual-B-version.pdf)

![](img/DL24%20DIY%20002.jpg)

[TOC](#table-of-contents)

##### DIY 1000W
If you need DIY 1000W, you need to meet 3 conditions

1. Need to add IRFP260N (150W) discharge tube
2. Need to add a powerful radiator (support 1000W)
3. Need strong modification ability!

[TOC](#table-of-contents)

##### Schematic diagram and PCB layout
[DL24 PCB layout](DL24%20PCB%20layout.pdf)
[![](DL24%20PCB%20layout.svg)](DL24%20PCB%20layout.pdf)

[TOC](#table-of-contents)

[DL24P Schematic diagram](DL24P%20Schematic%20diagram.pdf)
[![](DL24P%20Schematic%20diagram.svg)](DL24P%20Schematic%20diagram.pdf)

[TOC](#table-of-contents)

### Fast application method of constant current (CC) discharge mode
Insert the power supply adapter inside the packing box into the power input port of product end, at this time the product is lit up, and then after the power supply under test is connected, the display screen shows the present measured values of the input voltage, short press the set key at this time, the cursor below the constant current digital move the cursor around, again through the short press add or substract keys, after the corresponding numerical is adjusted to the current value that you need the discharge, again press the start key, the display screen shows "ON", begin the constant current discharge, battery capacity accumulation, and timing; if you need to set a time-limit discharge time and the stop voltage value, please, when the stop of discharging, long press the set key one time, the CC of display interface begin the beating show, then short press set key, moves to the numerical flicker of limit-time discharge column, the beating numerical can be adjusted by short pressing the plus or minus keys, after setting a short press start key, save and confirm or wait the stop of flicking, automatically save.

[TOC](#table-of-contents)

### Application methods of constant resistance (CR), constant power (CP) and costant voltage (CV)
Under the state of the product electricity and stop discharge, long press the set key, the CC of display interface begin the beating show, at this time, again short push the add or substract key, adjustment a few model of CR-CP-CV-CC for cycling the show, after selecting the corresponding function model, and after waiting for the stop of lickering, the system saves and enters into this function model, and then can adjust and open, close, discharge by using the same application methods of constant current discharge model in the above section.

[TOC](#table-of-contents)

### Methods and techniques for the inspecting and measuring of battery capacity and electric quantify
Firstly, your battery to be measured is fully charged, and then long press the start key of this product to enter the backstage, the accumulated data is reset, and exit the backstage, long press the set key CC again, start flickering, short press the set key to the stop voltage column, after setting your lowest voltage of battery discharge, short press the start key to save, and then set the rated current value of discharge well, short press the start key to start measuring the accumulated capacity value of battery, when the discharge aging is up to the stop voltage value of battery that you set, the system will display a "Complete!", indicating that the capacity measuring and testing is completed, at this point, the capacity mAh and power Wh showed on the display screen is the capacity and power value of battery.

[TOC](#table-of-contents)

### Detectiong methods and techniques for the output voltage and current value and maximum power value of DC power adapter
Connect the output of your power supply to the product, the display screen displays the current voltage value, and then set the nominal current value of the power supply to be tested to this device, and then start the load for 3-6 hours discharge aging. During the process, the temperature of the power supply to be tested is not high and the voltage is stable, indicating that the quality of the power supply under testing is stable, and the nominal value is acurate without any false marking; in the process of statring "ON" to discharge, by short pressing the +/- key, the current is increased to the moment whn the voltage of the power supply under test drops and the voltage is zero, read the current value and power value, this is the maximum output current value and output maximum power value of the power supply under test.

[TOC](#table-of-contents)

### Testing methods and techinques for capacity and electricity quantity of mobile power supply
First, charge your charge pal fully, and then the load capacity and electricity quantity are reset, begin to access this load and set discharge value well, began to discharge until the charge pal runs out, at this time, read the cumulative capacity and power value above the display screen, this is the approximate values for the capacity and electricity quantity of charge pal, treasure because this product inside has the power-off memory function, the discharge can be completed in one time, the discharge process can also divided into the many-times discharge, check the capacity value again until the power of charge pal runs out.

> The operation method for one key clear-zero of data: long press the start key, after entering the background, and then short press the setting key to change color and move to the data clear-zero column, and then short press the start key to pop up "OK!" The word indicates that all data is cleared.

Kindly remind: Because the nominal capacity value marked by the charge pal on market at present is mosly the batteries value inside the machine, and thus from the 3.7 V batteries are increased to 5 V or 9 V and other physical capacity difference of voltage, and the voltage loss is produced during the process of voltage rise, so that the above 5 V voltage is tested, the electric capacity value is far less than the nominal value, according to the experience, according to the assessment of current mainstream brands mobile power, the total loss for the loss of voltage rising plate plus the difference of voltage rise is about 35%, so the true and false nominal value for the charge pal need to be tested, take the boosting to 5 V output voltage as an example, the measured capacity value needs to be multiplied by about 1.35, which is approximately equal to the nominal value of the charge pal itself, this evaluation value can only be taken as the relative value but not as the absolute value.

[TOC](#table-of-contents)

### Tesing the rated current value and quality of the charging cable and data cable
Connect as show in the following figure, when the load is applied, short press +/-, when the voltage drop is 1 V less than the no-load voltage, the current value at this point is the current value of the cable line under test.

![Charging cable test](img/DL24-DL24P%20User%20Manual%2004%20-%20Fig%201.jpg)

[TOC](#table-of-contents)

### Testing the maximum output current method of the charger and ist quality
Connect according to Figure 1, the constant current of the load during discharge is changed to make the voltage drop sharply or the voltage abrupt change to zero. At this time, the current value is the maximum current value that can be output by the charget; again change the load to the nominal current value of charget for the discharge aged 2-6 hours, the current voltage is stable in the process of aging, the temperature of the charger is also less than 50ºC or so, indicating the nominal current of this charger conforms to reality with no virtual marking, the charging speed can be satisfied, on the contrary, if the voltage is reduced, the current value difference is too big or the temperature is too hight, even U meter alarm to flicker, and there is no output, these belong to the current virtual marking, there is a sign of poor quality, this method is also suitable for the output current test judgment method of all the USB interface.

[TOC](#table-of-contents)

### The download and installation of the online mobile APP and computer APP
Android mobile phone: after scaning the code and entering the link to download and install, and then open the APP, click the bluetooth icon in the upper left corner of the interface, select the model DL24 to connect, return to the APP interface, this time the bluetooth icon changes from grey to blue, indicating the connection and communication are successful, the Apple mobile phone can be downloaded, installed and used in the application search E_test

Warning: If the bluetooth device model corresponding to J cannot be found in the APP of the electric energy meter, please be sure to open the storage permissions and location information of the device APP in the settings of the mobile phone!.

[TOC](#table-of-contents)

## Software download address:
[E-test](../../software/E-test)

1. User manual, PC software installation instruction and PC software and Android APP [download link](http://www.mediafire.com/folder/m09i9bjv8703d/DL24-DL24P)
2. [iOS App](https://apps.apple.com/app/e-test/id1478623332): search E_test on iphone APP store to download
3. [Android App](https://play.google.com/store/apps/details?id=com.tang.etest.e_test): search E-test at Google play to down load

[TOC](#table-of-contents)

## SDK

##### Record structure:

| Offset | Meaning                 | Scale Unit | Data format    | Stored |
|--------|-------------------------|------------|----------------|:------:|
| 0000h  | Data mark (0xFF550102)  |            | char[4]        |        |
| 0004h  | reserved                |            | char           |        |
| 0005h  | Voltage (V)             | 1/10 V     | unsigned word  |        |
| 0007h  | reserved                |            | char           |        |
| 0008h  | Current (I)             | 1/1000 A   | unsigned word  |        |
| 000Ah  | reserved                |            | char           |        |
| 000Bh  | Capacity                | 1/100 Ah   | unsigned word  |  Yes   |
| 000Dh  | Energy                  | 1/100 kWh  | unsigned dword |  Yes   |
| 0011h  | reserved                |            | char[7]        |        |
| 0018h  | Temp                    | 1 ºC       | unsigned word  |        |
| 001Ah  | Hours                   | 1 h        | unsigned word  |  Yes   |
| 001Ch  | Minuts                  | 1 min      | unsigned char  |  Yes   |
| 001Dh  | Seconds                 | 1 s        | unsigned char  |        |
| 001Eh  | Back Light (BL)         | 1 s        | unsigned char  |  Yes   |
| 001Fh  | reserved                |            | char[5]        |        |

[TOC](#table-of-contents)

##### Commands
| Command        | Send                          | Receive                 |
|----------------|-------------------------------|-------------------------|
| Electric Reset | FF 55 11 02 01 00 00 00 00 51 | FF 55 02 02 01 00 00 42 |
| Capacity Reset | FF 55 11 02 02 00 00 00 00 52 | FF 55 02 02 01 00 00 42 |
| Time Reset     | FF 55 11 02 03 00 00 00 00 53 | FF 55 02 02 01 00 00 42 |
| All Reset      | FF 55 11 02 05 00 00 00 00 5D | FF 55 02 02 01 00 00 42 |
| Setup          | FF 55 11 02 31 00 00 00 00 01 | FF 55 02 02 03 00 00 4C |
| Enter          | FF 55 11 02 32 00 00 00 00 02 | FF 55 02 02 03 00 00 4C |
| +              | FF 55 11 02 33 00 00 00 00 03 | FF 55 02 02 01 00 00 42 |
| -              | FF 55 11 02 34 00 00 00 00 0C | FF 55 02 02 01 00 00 42 |


[TOC](#table-of-contents)

##### Data formats

| Data format | Lenght  | Byte order |
|-------------|--------:|------------|
| char        |  8 bits |            |
| word        | 16 bits | Big endian |
| dword       | 32 bits | Big endian |

[TOC](#table-of-contents)

## Images
![](img/DL24-DL24P%20000.jpg)
![](img/DL24-DL24P%20000b.jpg)
![](img/DL24%20DIY%20001.jpg)
![](img/DL24-DL24P%20001.jpg)
![](img/DL24-DL24P%20002.jpg)
![](img/DL24-DL24P%20003.jpg)
![](img/DL24-DL24P%20004.jpg)
![](img/DL24-DL24P%20005.jpg)
![](img/DL24-DL24P%20006.jpg)
![](img/DL24-DL24P%20007.jpg)
![](img/DL24-DL24P%20008.jpg)
![](img/DL24-DL24P%20009.jpg)
![](img/DL24-DL24P%20010.jpg)
![](img/DL24-DL24P%20011.jpg)
![](img/DL24-DL24P%20012.jpg)
![](img/DL24-DL24P%20013.jpg)
![](img/DL24-DL24P%20014.jpg)
![](img/DL24-DL24P%20015.jpg)
![](img/DL24-DL24P%20016.jpg)
![](img/DL24-DL24P%20017.jpg)
![](img/DL24-DL24P%20018.jpg)
![](img/DL24-DL24P%20019.jpg)
![](img/DL24-DL24P%20020.jpg)
![](img/DL24-DL24P%20021.jpg)
![](img/DL24-DL24P%20022.jpg)
![](img/DL24-DL24P%20023.jpg)
![](img/DL24-DL24P%20024.jpg)
![](img/DL24-DL24P%20025.jpg)
![](img/DL24-DL24P%20026.jpg)
![](img/DL24-DL24P%20027.jpg)
![](img/DL24-DL24P%20028.jpg)

[TOC](#table-of-contents)
