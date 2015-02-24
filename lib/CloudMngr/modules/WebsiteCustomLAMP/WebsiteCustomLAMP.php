<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrMySQLServer Class
 */

class CloudMngrWebsiteCustomLAMP extends CloudMngrWebsiteModule{
	protected $module_display_name = "LAMP Website";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}
}
