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
        $obj = new View();
        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }
  
        $queryobj = new Fan_temps_model();
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `sght` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `sght` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');
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
        $obj = new View();
        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }
  
        $queryobj = new Fan_temps_model();
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `fnfd` = '2' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `fnfd` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');
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
        $obj = new View();
        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }
  
        $queryobj = new Fan_temps_model();
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `spht` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `spht` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');
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
        $obj = new View();
        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }
  
        $queryobj = new Fan_temps_model();
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `msdi` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `msdi` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');
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
        $obj = new View();
        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }
  
        $queryobj = new Fan_temps_model();
        $sql = "SELECT COUNT(1) as total,
                        COUNT(CASE WHEN `mssf` = '1' THEN 1 END) AS 'yes',
                        COUNT(CASE WHEN `mssf` = '0' THEN 1 END) AS 'no'
                        from fan_temps
                        LEFT JOIN reportdata USING (serial_number)
                        WHERE
                        ".get_machine_group_filter('');
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
        $obj = new View();
        
        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }

        $queryobj = new Fan_temps_model();
        
        $sql = "SELECT json_info FROM fan_temps WHERE serial_number = '$serial_number'";
        
        $fan_temps_tab = $queryobj->query($sql);
        
        // Extract just the JSON string and make it an object
        $data_json = json_decode(json_decode(json_encode($fan_temps_tab[0]),true)['json_info']);

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

        if (! $this->authorized()) {
            $obj->view('json', array('msg' => 'Not authorized'));
            return;
        }

        $fan_temps = new Fan_temps_model;
        $obj->view('json', array('msg' => $fan_temps->retrieve_records($serial_number)));
    }
} // End class Fan_temps_controller
