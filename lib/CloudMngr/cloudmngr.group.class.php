<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrGroup Class
 */

class CloudMngrGroup extends CloudMngr{
	private $group_arr;

	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
	}

	function getId(){
		return $this->group_id;
	}

	function getName($group_id=""){
		$group = $this->getGroup($group_id);
		return $group['name'];
	}

	function getAllGroups(){
		$groups_str = file_get_contents($this->base_path."/data/groups");
		$this->group_arr = json_decode($groups_str, true);

		if(! is_array($this->group_arr['groups'])) return -1;
		return $this->group_arr['groups'];
	}

	function getGroup($group_id=""){
		$group_id = ($group_id!="") ? $group_id : $this->group_id;	
		if(!$group_id) return $this->_error("No Group ID");

		if(!$this->group_arr){$this->getAllGroups();}	

		return $this->group_arr['groups'][$group_id];
	}

}
