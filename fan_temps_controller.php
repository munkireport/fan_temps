<?php 

/**
 * Fan_temps_controller class
 *
 * @package fan_temps
 * @author tuxudo
 **/
class Fan_temps_controller extends Module_controller
{
    function __construct()
    {
        $this->module_path = dirname(__FILE__);
    }

    /**
     * Default method
     *
     * @author AvB
     **/
    function index()
    {
        echo "You've loaded the fan_temps module!";
    }

    /**
    * Retrieve GPU overtemp in json format
    *
    * @return void
    * @author tuxudo
    **/
    public function get_gpu_overtemp()
    {
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `sght` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `sght` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');

        $obj = new View();
        $queryobj = new Fan_temps_model();
        $obj->view('json', array('msg' => current($queryobj->query($sql))));
    }

    /**
    * Retrieve fans manually set in json format
    *
    * @return void
    * @author tuxudo
    **/
    public function get_fan_manually()
    {
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `fnfd` = '2' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `fnfd` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');

        $obj = new View();  
        $queryobj = new Fan_temps_model();
        $obj->view('json', array('msg' => current($queryobj->query($sql))));
    }

    /**
    * Retrieve CPU hot in json format
    *
    * @return void
    * @author tuxudo
    **/
    public function get_cpu_hot()
    {
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `spht` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `spht` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');

        $obj = new View();  
        $queryobj = new Fan_temps_model();
        $obj->view('json', array('msg' => current($queryobj->query($sql))));
    }

    /**
    * Retrieve disc inserted in json format
    *
    * @return void
    * @author tuxudo
    **/
    public function get_odd_inserted()
    {
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `msdi` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `msdi` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');

        $obj = new View();  
        $queryobj = new Fan_temps_model();
        $obj->view('json', array('msg' => current($queryobj->query($sql))));
    }

    /**
    * Retrieve bad fans in json format
    *
    * @return void
    * @author tuxudo
    **/
    public function get_bad_fans()
    {
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `mssf` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `mssf` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');

        $obj = new View();  
        $queryobj = new Fan_temps_model();
        $obj->view('json', array('msg' => current($queryobj->query($sql))));
    }

    /**
     * Retrieve data in json format for client tab
     *
     * @return void
     * @author tuxudo
     **/
    public function get_tab_data($serial_number = '')
    {
        // Remove serial number characters
        $serial_number = preg_replace("/[^A-Za-z0-9_\-]]/", '', $serial_number);

        $sql = "SELECT json_info 
                    FROM fan_temps 
                    LEFT JOIN reportdata USING (serial_number)
                    ".get_machine_group_filter()."
                    AND serial_number = '$serial_number'";

        $obj = new View();
        $queryobj = new Fan_temps_model();
        $fan_temps_tab = $queryobj->query($sql);

        // Extract just the JSON string and make it an object
        if (array_key_exists(0, $fan_temps_tab) && !is_null($fan_temps_tab[0]->json_info)){
            $data_json = json_decode(json_decode(json_encode($fan_temps_tab[0]),true)['json_info']);
        } else {
            $data_json = (object) array();
        }

        if(!is_null($data_json)){
            // Add the temperature type to the object for the client tab
            if(!conf('temperature_unit')){
                $data_json->TEMPERATURE_UNIT = "C";
            } else {
                $data_json->TEMPERATURE_UNIT = conf('temperature_unit');
            }
        }

        $obj->view('json', array('msg' => current(array('msg' => $data_json)))); 
    }

    /**
     * Retrieve data in json format
     *
     * @return void
     * @author tuxudo
     **/
    public function get_data($serial_number = '')
    {
        $obj = new View();
        $fan_temps = new Fan_temps_model;
        $obj->view('json', array('msg' => $fan_temps->retrieve_records($serial_number)));
    }
    
    /**
     * Get list data for widget
     *
     * @param string $column Column to summarize
     **/
    public function get_list($column = '')
    {
        if ($column == 'keyboard_language') {
            $sql = "SELECT keyboard_language AS label, COUNT(*) AS count
                    FROM fan_temps
                    LEFT JOIN reportdata USING (serial_number)
                    ".get_machine_group_filter()."
                    AND keyboard_language IS NOT NULL 
                    AND keyboard_language <> ''
                    GROUP BY keyboard_language
                    ORDER BY count DESC";
                    
            $obj = new View();
            $queryobj = new Fan_temps_model();
            $obj->view('json', array('msg' => $queryobj->query($sql)));
        } else {
            $obj = new View();
            $obj->view('json', array('msg' => array()));
        }
    }
} // End class Fan_temps_controller
