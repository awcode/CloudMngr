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
	private $_instance = null;
	private $_modules = array();
	
	public $class_path;
	public $base_path;
	
	public $active_modules;

	protected $group_id;
	protected $region_id;
	protected $config;
	protected $hooks = array();			//Individual Hooks array - add hooks to modules here.
	protected $_hooks = array();		//Global hooks array, managed internally.

	function __construct($group_id="", $region_id=""){
		$this->class_path = dirname(__FILE__);
		$this->base_path = str_replace('/lib/CloudMngr', '' ,dirname(__FILE__));

		include($this->base_path."/data/config.php");
		$this->config = $config;
		
		include_once($this->class_path . DIRECTORY_SEPARATOR . 'cloudmngr.basemodule.class.php');
		
		if($group_id != ""){$this->setGroup($group_id);}
		if($region_id != ""){$this->setRegion($region_id);}
		$chk_modules = scandir($this->class_path.DIRECTORY_SEPARATOR."Modules");
		if($this->arrFull($chk_modules)){
			foreach($chk_modules as $module){
				if ($this->class_path . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $module.'.php') $this->active_modules[] = $module;
			}
		}
	}

	protected function setHooks(){
		if($this->arrFull($this->hooks)){
			foreach($this->hook as $hook){
				$onEvent = $hook['onEvent'];
				$forType = $hook['forType'];
				$action = $hook['action'];
				if(!in_array($action, $this->_hooks[$onEvent][$forType]))	$this->_hooks[$onEvent][$forType][] = $action;
			}
		}
	}
	
	protected function runHooks($onEvent, $forType, $include_all=true){
		if($this->arrFull($this->_hooks[$onEvent][$forType])){
			foreach($this->_hooks[$onEvent][$forType]){
				$this->$action();
			}
		}
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
	
	function module($module){
		if($this->_modules[$module] == null){
			if (!$this->class_path . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $module.'.php') return false;
			include_once($this->class_path . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $module.'.php');
			$this->_modules[$module] = new $module($this->group_id, $this->region_id);
			$this->_modules[$module]->module_name = $module;
		}

		return $this->_modules[$module];	
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

	function _error($message, $response=-1, $type="notice"){
		//[TODO] Add full logging, display and verbosity options.
		echo($message);
		
		return $response;
	}
	
	function arrFull($array){
		if(is_array($array) && count($array)) return true;
		return false;
	}
}
?>
