<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrRegion Class
 */

class CloudMngrRegion extends CloudMngr{
	private $region_arr;

	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	function getId(){
		return $this->region_id;
	}

	function getAllRegions(){
		$region_str = file_get_contents($this->base_path."/data/regions");
		$this->region_arr = json_decode($region_str, true);

		if(! is_array($this->region_arr['regions'])) return $this->_error("No Region ID");
		return $this->region_arr['regions'];
	}

	function getRegion($region_id=""){
		$region_id = ($region_id!="") ? $region_id : $this->region_id;	
		if(!$region_id) return $this->_error("No Region ID");

		if(!$this->region_arr){$this->getAllRegions();}	

		return $this->region_arr['regions'][$region_id];
	}

}
