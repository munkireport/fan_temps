<?php

return array(
    'client_tabs' => array(
        'fans-tab' => array('view' => 'fans_tab', 'i18n' => 'fan_temps.tabtitle_fans'),
        'temps-tab' => array('view' => 'temps_tab', 'i18n' => 'fan_temps.tabtitle_temps'),
        'smc-tab' => array('view' => 'smc_tab', 'i18n' => 'fan_temps.tabtitle_smc'),
        'amps-tab' => array('view' => 'amps_tab', 'i18n' => 'fan_temps.tabtitle_amps'),
    ),
    'listings' => array(
        'fans' => array('view' => 'fans_listing', 'i18n' => 'fan_temps.tabtitle_fans'),
        'temps' => array('view' => 'temps_listing', 'i18n' => 'fan_temps.tabtitle_temps'),
        'smc' => array('view' => 'smc_listing', 'i18n' => 'fan_temps.tabtitle_smc'),
    ),
    'widgets' => array(
        'fan_temps_bad_fans' => array('view' => 'fan_temps_bad_fans_widget', 'i18n' => 'fan_temps.MSSF'),
        'fan_temps_fans_set' => array('view' => 'fan_temps_fans_set_widget', 'i18n' => 'fan_temps.FNFD'),
        'fan_temps_odd_inserted' => array('view' => 'fan_temps_odd_inserted_widget', 'i18n' => 'fan_temps.MSDI'),
        'fan_temps_cpu_hot' => array('view' => 'fan_temps_cpu_hot_widget', 'i18n' => 'fan_temps.SPHT'),
        'fan_temps_gpu_overtemp' => array('view' => 'fan_temps_gpu_overtemp_widget', 'i18n' => 'fan_temps.SGHT'),
    ),
    'reports' => array(
        'fan_temps_report' => array('view' => 'fan_temps_report', 'i18n' => 'fan_temps.reporttitle_more'),
    ),
);
