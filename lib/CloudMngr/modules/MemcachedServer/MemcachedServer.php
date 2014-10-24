<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrMySQLServer Class
 */

class CloudMngrMySQLServer extends CloudMngrServerModule{
	protected $module_display_name = "Memcached Server";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	
}
