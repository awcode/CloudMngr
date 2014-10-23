<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngr Core Class
 */

class CloudMngr {
	
	protected $AWS;
	protected $GCE;

	private $_region = null;
	private $_group = null;
	private $_load = null;
	private $_instance = null;
	
	public $class_path;
	public $base_path;

	protected $group_id;
	protected $region_id;
	protected $config;

	function __construct($group_id="", $region_id=""){
		$this->class_path = dirname(__FILE__);
		$this->base_path = str_replace('/lib/CloudMngr', '' ,dirname(__FILE__));

		include($this->base_path."/data/config.php");
		$this->config = $config;
		
		if($group_id != ""){$this->setGroup($group_id);}
		if($region_id != ""){$this->setRegion($region_id);}

	}

	function group(){
		if($this->_group == null){
			include_once($this->class_path . DIRECTORY_SEPARATOR . 'cloudmngr.group.class.php');
			$this->_group = new CloudMngrGroup($this->group_id, $this->region_id);
		}
		return $this->_group;
	}

	function region(){
		if($this->_region == null){
			include_once($this->class_path . DIRECTORY_SEPARATOR . 'cloudmngr.region.class.php');
			$this->_region = new CloudMngrRegion($this->group_id, $this->region_id);
		}
		return $this->_region;
	}

	function loadBalancer(){
		if($this->_load == null){
			include_once($this->class_path . DIRECTORY_SEPARATOR . 'cloudmngr.loadbalancer.class.php');
			$this->_load = new CloudMngrLoadBalancer($this->group_id, $this->region_id);
		}

		return $this->_load;
	}

	function instance(){
		if($this->_instance == null){
			if(!$this->region_id){return -1;}
			$region = $this->region()->getRegion();

			include_once($this->class_path . DIRECTORY_SEPARATOR . 'cloudmngr.instance-'.$region['provider'].'.class.php');
			$instanceType = "CloudMngrInstance".$region['provider'];
			$this->_instance = new $instanceType($this->group_id, $this->region_id);
		}

		return $this->_instance;
	}

	function setGroup($group_id){
		$this->group_id = $group_id;
	}

	function setRegion($region_id){
		$this->region_id = $region_id;
	}



}
?>