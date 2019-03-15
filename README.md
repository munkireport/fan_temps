Fans and Temperatures Module
==============

Reports on amps, fan speeds, temperatures, voltages, watts, and other SMC data from a client Mac.


Remarks
----

* Uses smc binary from smcFanControl to get data from SMC, included version is 2.6.1 Beta 1
* Using FakeSMC with this module with result in some/many sensor values not showing up

Table Schema
-----

* f0ac-f8ac (int) Current fan speed for fans 0 through 8
* f0mn-f8mn (int) Minimum fan speed for fans 0 through 8
* f0mx-f8mx(int) Maximum fan speed for fans 0 through 8
* f0id-f8id (string) Names of fans 0 through 8
* ta0p (double) - Ambient Air 0
* tc0f (double) - CPU 1
* tc0d (double) - CPU Diode
* tc0p (double) - CPU 1 Proximity
* tb0t (double) - Battery 0
* tb1t (double) - Battery 1
* tb2t (double) - Battery 2
* tg0d (double) - GPU Diode
* tg0h (double) - GPU Heatsink
* tg0p (double) - GPU Proximity
* tl0p (double) - LCD Proximity
* th0p (double) - Hard Drive Bay
* th0h (double) - Heatsink 0
* th1h (double) - Heatsink 1
* th2h (double) - Heatsink 2
* tm0p (double) - Memory Slot Proximity
* ts0p (double) - Body
* tn0h (double) - Northbridge
* tn0d (double) - Northbridge Diode
* tn0p (double) - Northbridge Proximity
* tp0p (double) - Power Supply Proximity
* tm0s (double) - Memory Slot
* alsl (integer) - Average ALS Ambient Light
* fnum (integer) - Number of Fans
* fnfd (boolean) - Fans Manually Set
* lsof (boolean) - Sleep Light Indicator Status
* msld (boolean) - Clamshell State
* spht (boolean) - Processor Hot
* mssd (boolean) - Last Known Shutdown Cause
* mssf (boolean) - Possible Bad Fan Detected
* mstm (boolean) - Power Balancing Enabled
* sght (boolean) - GPU Overtemp
* sph0 (integer) - Processor Hot Count Since Boot
* msdi (boolean) - Optical Disc Inserted
* json_info (medium text) - JSON string containing SMC keys and values