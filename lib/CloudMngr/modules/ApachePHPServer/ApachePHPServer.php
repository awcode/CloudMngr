<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrApachePHPServer Class
 */

class CloudMngrApachePHPServer extends CloudMngrServerModule{
	private $data_arr;
	protected $module_display_name = "Web Server (Apache + PHP)";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

}
