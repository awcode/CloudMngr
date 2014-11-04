<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrApachePHPServer Class
 */

class CloudMngrServerModule extends CloudMngrBaseModule{
	private $data_arr;
	protected $module_display_name = "";
	
	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	protected function _getTotalCount(){
		$cnt = 0;
		$groups = $this->group()->getAllGroups();
		if(! $this->arrFull($groups)) return 0;
		foreach($groups as $id => $group){
			$data = $this->loadByGroup($id);
			if($this->arrFull($this->data_arr['regions'])){
				foreach($this->data_arr['regions'] as $rid=>$region){
					if($this->arrFull($region['instances'])) $cnt += count($this->data_arr['regions'][$rid]['instances']);
				}
			}
		}
		return $cnt;
	}
	
	protected function _getCountByRegion($region_id=""){
		$cnt = 0;
		$region_id = (($region_id)?$region_id:$this->region_id);
		$groups = $this->group()->getAllGroups();
		if(! $this->arrFull($groups)) return 0;
		foreach($groups as $id => $group){
			$data = $this->loadByGroup($id);	
			if($this->arrFull($this->data_arr['regions'][$region_id]['instances'])) $cnt += count($this->data_arr['regions'][$region_id]['instances']);
		}
		return $cnt;
	}
	
	protected function _getCountByGroup($group_id=""){
		$group_id = ($group_id!="") ? $group_id : $this->group_id;	
		$data = $this->loadByGroup($group_id);
		if(! $this->arrFull($this->data_arr['regions'])) return 0;
		$cnt = 0;
		foreach($this->data_arr['regions'] as $region){
			if($this->arrFull($region['instances'])) $cnt += count($region['instances']);
		}
		return $cnt;
	}
	
	protected function _getHealthByRegion(){
		return "Coming soon";
	}
	
	protected function _getHealthByGroup(){
		return "Coming soon";
	}

	function loadByGroup($group_id=""){
		$group_id = ($group_id!="") ? $group_id : $this->group_id;	
		if(!$group_id) return $this->_error("No Group ID");

		$data_str = @file_get_contents($this->base_path."/data/".$this->module_name."/group-".$group_id);
		$this->data_arr = json_decode($data_str, true);

		return $this->data_arr;
	}

	function writeArray(){
		$this->runHooks("beforeWriteArray", $this->module_name);
		if(!is_dir($this->base_path. "/data/".$this->module_name)){mkdir($this->base_path. "/data/".$this->module_name);}
		file_put_contents($this->base_path. "/data/".$this->module_name."/group-".$this->group_id, json_encode($this->data_arr, 128));
		$this->runHooks("afterWriteArray", $this->module_name);
	}

	function getData(){
		$this->loadByGroup();
		if(! is_array($this->data_arr)) return array();
		return $this->data_arr;

	}

	function getRegion($region_id=""){
		$region_id = ($region_id!="") ? $region_id : $this->region_id;	
		if(!$region_id) return -1;

		$this->loadByGroup();
		if(! is_array($this->data_arr)) return array();

		return $this->data_arr['regions'][$region_id];
	}


	function saveConfig(){
		$this->runHooks("beforeSaveConfig", $this->module_name);
		$this->loadByGroup();
		if(! is_array($this->data_arr))  $this->data_arr = array();

		$group = $this->group()->getGroup($this->group_id);
		foreach($group['regions'] as $index=>$id){
			$this->data_arr['regions'][$id]['ami'] = $_POST['ami-'.$index];
			$this->data_arr['regions'][$id]['security'] = $_POST['security-'.$index];
			$this->data_arr['regions'][$id]['type'] = $_POST['type-'.$index];
			$this->data_arr['regions'][$id]['zone'] = $_POST['zone-'.$index];
			$this->data_arr['regions'][$id]['config'] = $_POST['config-'.$index];
			$this->data_arr['regions'][$id]['subnet'] = $_POST['subnet-'.$index];
		}
		$this->writeArray();
		return $this->data_arr;
		$this->runHooks("afterSaveConfig", $this->module_name);
	}


	function launchNew($config){
		$this->runHooks("beforeLaunchNewServer", $this->module_name);
		$imageId = $config['ami'];
		$security = array($config['security']);
		$type = $config['type'];
		$placement = array('AvailabilityZone'=>$config['zone']);
		$subnet = $config['subnet'];

		$instances = $this->instance()->launchNewInstance($imageId, 1, 1, $security, $type, $placement, $subnet);

		if(count($instances) > 0){
			foreach($instances as $instance){
				
				$ip = $this->instance()->assignPublicIp($instance['InstanceId']);

				$this->instance()->setInstanceTags(array($instance['InstanceId'])
				, array(
					array('Key'=>'Name', 'Value'=>'Web Server'),
					array('Key'=>'cloudMngrRole', 'Value'=>'web'),
					array('Key'=>'cloudMngrModule', 'Value'=>$this->module_name)
				));

				$instance_id = $instance['InstanceId'];
				$this->data_arr['regions'][$this->region_id]['instances'][$instance_id] = array(
					'ip'=>$ip,
					'type' => $type,
					'launched' => date("Y-m-d")
				);
				echo($this->module_display_name." Created: ID ".$instance['InstanceId']);
			}
			$this->writeArray();
		}
		$this->runHooks("afterLaunchNewServer", $this->module_name);
	}

	function terminate($instance_id){
		$this->runHooks("beforeTerminateServer", $this->module_name);
		
		$res = $this->instance()->terminateInstance($instance_id);

		unset($this->data_arr['regions'][$this->region_id]['instances'][$instance_id]);
		$this->writeArray();
		
		echo($this->module_display_name." Terminated");
		
		$this->runHooks("afterTerminateServer", $this->module_name);
	}
}
