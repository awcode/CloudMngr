<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrGlusterServer Class
 */

class CloudMngrGlusterServer extends CloudMngrServerModule{
	protected $module_display_name = "Gluster Filesystem";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	
}
