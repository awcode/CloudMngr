<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrMemcachedServer Class
 */

class CloudMngrServerMemcached extends CloudMngrServerModule{
	protected $module_display_name = "Memcached Server";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	
}
