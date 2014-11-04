<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrLoadBalancer Class
 */

class CloudMngrServerLoadBalancerNginx extends CloudMngrServerModule{
	protected $module_display_name = "Load Balancer (NginX)";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	
}
