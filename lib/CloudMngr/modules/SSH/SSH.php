<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrBaseModule Class
 */
 
class CloudMngrSSH extends CloudMngrBaseModule{

	protected $module_name;
	protected $module_display_name;
	protected $module_path;
	protected $module_default_path;
	protected $module_type = "Module";
	

	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
		
		if(!$this->menus['settings']['link']){
			$this->menus['settings']['link'] = "#";
			$this->menus['settings']['name'] = "Settings";
		}
		$this->menus['settings']['sub'][] = array("link"=>"?module=SSH&page=ssh-settings", "name"=>"SSH Settings");
	}

}
?>
