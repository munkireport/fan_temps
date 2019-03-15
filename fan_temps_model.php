<?php

use CFPropertyList\CFPropertyList;

class Fan_temps_model extends \Model {
    
	function __construct($serial='')
	{
		parent::__construct('id', 'fan_temps'); // Primary key, tablename
		$this->rs['id'] = 0;
		$this->rs['serial_number'] = $serial;
		$this->rs['f0ac'] = 0;
		$this->rs['f1ac'] = 0;
		$this->rs['f2ac'] = 0;
		$this->rs['f3ac'] = 0;
		$this->rs['f4ac'] = 0;
		$this->rs['f5ac'] = 0;
		$this->rs['f6ac'] = 0;
		$this->rs['f7ac'] = 0;
		$this->rs['f8ac'] = 0;
		$this->rs['f0mn'] = 0;
		$this->rs['f1mn'] = 0;
		$this->rs['f2mn'] = 0;
		$this->rs['f3mn'] = 0;
		$this->rs['f4mn'] = 0;
		$this->rs['f5mn'] = 0;
		$this->rs['f6mn'] = 0;
		$this->rs['f7mn'] = 0;
		$this->rs['f8mn'] = 0;
		$this->rs['f0mx'] = 0;
		$this->rs['f1mx'] = 0;
		$this->rs['f2mx'] = 0;
		$this->rs['f3mx'] = 0;
		$this->rs['f4mx'] = 0;
		$this->rs['f5mx'] = 0;
		$this->rs['f6mx'] = 0;
		$this->rs['f7mx'] = 0;
		$this->rs['f8mx'] = 0;
		$this->rs['f0id'] = "";
		$this->rs['f1id'] = "";
		$this->rs['f2id'] = "";
		$this->rs['f3id'] = "";
		$this->rs['f4id'] = "";
		$this->rs['f5id'] = "";
		$this->rs['f6id'] = "";
		$this->rs['f7id'] = "";
		$this->rs['f8id'] = "";
		$this->rs['ta0p'] = 0.0;
		$this->rs['tc0f'] = 0.0;
		$this->rs['tc0d'] = 0.0;
		$this->rs['tc0p'] = 0.0;
		$this->rs['tb0t'] = 0.0;
		$this->rs['tb1t'] = 0.0;
		$this->rs['tb2t'] = 0.0;
		$this->rs['tg0d'] = 0.0;
		$this->rs['tg0h'] = 0.0;
		$this->rs['tg0p'] = 0.0;
		$this->rs['tl0p'] = 0.0;
		$this->rs['th0p'] = 0.0;
		$this->rs['th0h'] = 0.0;
		$this->rs['th1h'] = 0.0;
		$this->rs['th2h'] = 0.0;
		$this->rs['tm0p'] = 0.0;
		$this->rs['ts0p'] = 0.0;
		$this->rs['tn0h'] = 0.0;
		$this->rs['tn0d'] = 0.0;
		$this->rs['tn0p'] = 0.0;
		$this->rs['tp0p'] = 0.0;
		$this->rs['msdi'] = 0; // True/False
		$this->rs['alsl'] = 0;
		$this->rs['fnum'] = 0;
		$this->rs['fnfd'] = 0; // True/False
		$this->rs['lsof'] = 0; // True/False
		$this->rs['msld'] = 0; // True/False
		$this->rs['spht'] = 0; // True/False
		$this->rs['mssd'] = 0;
		$this->rs['mssf'] = 0; // True/False
		$this->rs['mstm'] = 0; // True/False
		$this->rs['sght'] = 0; // True/False
		$this->rs['sph0'] = 0;
		$this->rs['json_info'] = "";
        		
		// Retrieve data for serial number
		if ($serial)
		{
		    $this->retrieve_record($serial);
		}
		
		$this->serial = $serial;
    }

    /**
     * Process data sent by postflight
     *
     * @param plist data
     * @author tuxudo
     * 
     **/
    function process($data)
    {
		// If data is empty, throw error
		if (! $data) {
		    throw new Exception("Error Processing Fan_Temps Module Request: No data found", 1);
		}
		
		// Process incoming fan_temps.plist
		$parser = new CFPropertyList();
		$parser->parse($data, CFPropertyList::FORMAT_XML);
		$plist = $parser->toArray();
    
		// Process each of the items
		foreach (array('f0ac', 'f1ac', 'f2ac', 'f3ac', 'f4ac', 'f5ac', 'f6ac', 'f7ac', 'f8ac', 'f0mn', 'f1mn', 'f2mn', 'f3mn', 'f4mn', 'f5mn', 'f6mn', 'f7mn', 'f8mn', 'f0mx', 'f1mx', 'f2mx', 'f3mx', 'f4mx', 'f5mx', 'f6mx', 'f7mx', 'f8mx', 'f0id', 'f1id', 'f2id', 'f3id', 'f4id', 'f5id', 'f6id', 'f7id', 'f8id', 'ta0p', 'tc0f', 'tc0d', 'tc0p', 'tb0t', 'tb1t', 'tb2t', 'tg0d', 'tg0h', 'tg0p', 'tl0p', 'th0p', 'th0h', 'th0h', 'th2h', 'tm0p', 'ts0p', 'tn0h', 'tn0d', 'tn0p', 'tp0p', 'f0ac', 'f0mn', 'f0mx', 'f1ac', 'f1mn', 'f1mx', 'f2ac', 'f2mn', 'f2mx', 'msdi', 'alsl', 'fnum', 'fnfd', 'lsof', 'msld', 'spht', 'mssd', 'mssf', 'mstm', 'sght', 'sph0', 'json_info') as $item) {  

                    // If key does not exist in $plist, null it
                    if ( ! array_key_exists($item, $plist) || $plist[$item] == "") {
                        $this->$item = null;
                                        
                    // Clean JSON elements to remove invalid values
                    } else if ( $item == "json_info" && array_key_exists($item, $plist)) {  
                    
                        $json_elements = json_decode($plist[$item]);
                        $cleaned_json = [];
                        foreach($json_elements as $key => $value){
                            // If value contains bytes or value is empty, skip it
                            if(strpos($value, "(bytes") !== false || $value == "") {
                            	continue;
                            
                            // Else if does not start with I, P, T, V, then save the item
                            } else if ((strpos($key, "I") !== 0) && (strpos($key, "P") !== 0) && (strpos($key, "T") !== 0) && (strpos($key, "S") !== 0) && (strpos($key, "V") !== 0)) {
                            	$cleaned_json[$key] = $value;
                            
                            // Else if greater or equal to than 10, is numeric, and starts with T, then save the item
                            } else if ( floatval($value) >= 10 && is_numeric($value) && (strpos($key, "T") === 0) || (strpos($key, "S") === 0)) {  
                            	$cleaned_json[$key] = $value;

                            // Else if is greater than 0, is numeric, and starts with I, P, or V, then save the item
                            } else if ( floatval($value) > 0 && is_numeric($value) && ((strpos($key, "I") === 0) || (strpos($key, "P") === 0) || (strpos($key, "V") === 0))) {
                            	$cleaned_json[$key] = $value;
                            }
                        }
                    
		    	// Sort array
		    	ksort($cleaned_json);
                                            
		    	// Save encoded JSON to outgoing data thingy
		    	$this->$item = json_encode($cleaned_json);

                    // Else if does not start with I, P, T, V, then save the item
                    } else if ((strpos($item, "i") !== 0) && (strpos($item, "p") !== 0) && (strpos($item, "t") !== 0) && (strpos($item, "v") !== 0) ) {
		    	$this->$item = $plist[$item];
                
                    // Else if greater or equal to than 10, is numeric, and starts with T, then save the item
                    } else if ( floatval($plist[$item]) >= 10 && is_numeric($plist[$item]) && (strpos($item, "t") === 0)) {  
		    	$this->$item = $plist[$item];

                    // Else if is greater than 0, is numeric, and starts with I, P, or V, then save the item
                    } else if ( floatval($plist[$item]) > 0 && is_numeric($plist[$item]) && ((strpos($item, "i") === 0) || (strpos($item, "p") === 0) || (strpos($item, "v") === 0))) {  
		    	$this->$item = $plist[$item];
                    
                    // Else null the item
                    } else {
                    
		    	$this->$item = null;
                    }
		}
    
		// Save the crunchy data. Mmmm dataaaa
		$this->save();
    }
}
