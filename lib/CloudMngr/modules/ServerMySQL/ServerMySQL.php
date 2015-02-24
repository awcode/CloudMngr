<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrMySQLServer Class
 */

class CloudMngrServerMySQL extends CloudMngrServerModule{
	protected $module_display_name = "MySQL Database";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}
}
