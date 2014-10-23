<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrLoadBalancer Class
 */

class CloudMngrLoadBalancer extends CloudMngr{
	private $load_arr;

	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	function loadByGroup($group_id=""){
		$group_id = ($group_id!="") ? $group_id : $this->group_id;	
		if(!$group_id) return $this->_error("No Group ID");

		$load_str = file_get_contents($this->base_path."/data/load/group-".$group_id);
		$this->load_arr = json_decode($load_str, true);

		return $this->load_arr;
	}

	function writeLoadBalancerArray(){
		file_put_contents($this->base_path. "/data/load/group-".$this->group_id, json_encode($this->load_arr, 128));
	}

	function getLoadBalancer(){
		$this->loadByGroup();
		if(! is_array($this->load_arr['loadbalancer'])) return $this->_error("Invalid Load Balancer Array");
		return $this->load_arr['loadbalancer'];

	}

	function getRegion($region_id=""){
		$region_id = ($region_id!="") ? $region_id : $this->region_id;	
		if(!$region_id) return -1;

		$this->loadByGroup();
		if(! is_array($this->load_arr['loadbalancer'])) return $this->_error("Invalid Load Balancer Array");

		return $this->load_arr['loadbalancer']['regions'][$region_id];
	}


	function saveLoadBalancerConfig(){
		$this->loadByGroup();
		if(! is_array($this->load_arr['loadbalancer'])) return $this->_error("Invalid Load Balancer Array");

		$group = $this->group()->getGroup($this->group_id);
		foreach($group['regions'] as $index=>$id){
			$this->load_arr['loadbalancer']['regions'][$id]['ami'] = $_POST['ami-'.$index];
			$this->load_arr['loadbalancer']['regions'][$id]['security'] = $_POST['security-'.$index];
			$this->load_arr['loadbalancer']['regions'][$id]['type'] = $_POST['type-'.$index];
			$this->load_arr['loadbalancer']['regions'][$id]['zone'] = $_POST['zone-'.$index];
			$this->load_arr['loadbalancer']['regions'][$id]['config'] = $_POST['config-'.$index];
			$this->load_arr['loadbalancer']['regions'][$id]['subnet'] = $_POST['subnet-'.$index];
		}
		$this->writeLoadBalancerArray();
		return $this->load_arr['loadbalancer'];

	}


	function launchNew($load){
		$imageId = $load['ami'];
		$security = array($load['security']);
		$type = $load['type'];
		$placement = array('AvailabilityZone'=>$load['zone']);
		$subnet = $load['subnet'];

		$instances = $this->instance()->launchNewInstance($imageId, 1, 1, $security, $type, $placement, $subnet);

		if(count($instances) > 0){
			foreach($instances as $instance){
				echo($instance['InstanceId']);
				
				$ip = $this->instance()->assignPublicIp($instance['InstanceId']);

				$this->instance()->setInstanceTags(array($instance['InstanceId'])
				, array(
					array('Key'=>'cloudMngrRole', 'Value'=>'load'),
					array('Key'=>'Name', 'Value'=>'loadbalancer')
				));

				$instance_id = $instance['InstanceId'];
				$this->load_arr['loadbalancer']['regions'][$this->region_id]['instances'][$instance_id] = array(
					'ip'=>$ip,
					'type' => $type,
					'launched' => date("Y-m-d")
				);
				echo("Load Balancer Created");
			}
			$this->writeLoadBalancerArray();
		}

	}

	function terminate($instance_id){
		echo("Terminated");
		$res = $this->instance()->terminateInstance($instance_id);

		unset($this->load_arr['loadbalancer']['regions'][$this->region_id]['instances'][$instance_id]);
		$this->writeLoadBalancerArray();
	}
}
