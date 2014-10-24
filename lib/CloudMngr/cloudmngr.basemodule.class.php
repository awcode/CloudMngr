<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrBaseModule Class
 */

class CloudMngrBaseModule extends CloudMngr{
	private $module_type;
	private $module_sub_type;
	protected $module_name;
	protected $module_display_name;
	protected $module_path;
	

	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}
	
	public function getName(){
		return $this->module_name;
	}
	public function getDisplayName(){
		return $this->module_display_name;
	}

	public function getTotalCount(){
		return $this->_getTotalCount();
	}
	protected function _getTotalCount(){
		return 0;
	}
	
	public function getCountByRegion($region_id=""){
		return $this->_getCountByRegion($region_id);
	}
	protected function _getCountByRegion($region_id=""){
		return 0;
	}
	
	public function getCountByGroup($group_id=""){
		return $this->_getCountByGroup($group_id);
	}
	protected function _getCountByGroup($group_id=""){
		return 0;
	}

	public function getHealthByRegion($region_id=""){
		return $this->_getHealthByRegion($region_id);
	}
	protected function _getHealthByRegion($region_id=""){
		return "N/A";
	}

	public function getHealthByGroup($group_id=""){
		return $this->_getHealthByGroup($group_id);
	}
	protected function _getHealthByGroup($group_id=""){
		return "N/A";
	}
	
	public function displayDashboardPanel(){
		$this->_displayDashboardPanel();
	}
	protected function _displayDashboardPanel(){
		$module = $this->module_name;
		if(file_exists($this->module_path . DIRECTORY_SEPARATOR ."dashboard-panel.php")) include($this->module_path . DIRECTORY_SEPARATOR ."dashboard-panel.php");			
	}
	
	public function displayRegionPanel(){
		$this->_displayRegionPanel();
	}
	protected function _displayRegionPanel(){
		$module = $this->module_name;
		if(file_exists($this->module_path . DIRECTORY_SEPARATOR ."region-panel.php")) include($this->module_path . DIRECTORY_SEPARATOR ."region-panel.php");	
	}
	
	public function displayGroupPanel(){
		$this->_displayGroupPanel();
	}
	protected function _displayGroupPanel(){
		$module = $this->module_name;
		if(file_exists($this->module_path . DIRECTORY_SEPARATOR ."group-panel.php")) include($this->module_path . DIRECTORY_SEPARATOR ."group-panel.php");
	}
}
