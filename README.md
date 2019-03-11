Fans and Temperatures Module
==============

Reports on amps, fan speeds, temperatures, voltages, watts, and other SMC data from a client Mac.

Remarks
----

* Uses smc binary from smcFanControl to get data from SMC
* Using FakeSMC with this module with result in some/many sensor values not showing up

Table Schema
-----

* fan_0-17 (int) Current fan speed for fans 0 through 17
* fanmin0-17 (int) Minimum fan speed for fans 0 through 17
* fanmax0-17 (int) Maximum fan speed for fans 0 through 17
* fanlabel0-8 (string) Names of fans 0 through 17
* discin (string) Is an optical disc inserted, true/false
* \[four/five digit SMC code] (float) Sensors and other SMC data in Macs are listed in their own columns as floats and record the data
