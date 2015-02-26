<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrBaseModule Class
 */
 
 class CloudMngrDisplay extends CloudMngr{

	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);
		
		if(!$this->menus['dashboard']['link']){
			$this->menus['dashboard']['link'] = "/";
			$this->menus['dashboard']['name'] = "Dashboard";
		}

		if(!$this->menus['regions']['link']){
			$this->menus['regions']['link'] = "/?page=regions";
			$this->menus['regions']['name'] = "Regions";
			$this->menus['regions']['sub'][] = array("link"=>"?page=regions", "name"=>"View All");
			$this->menus['regions']['sub'][] = array("name"=>"-");
			$regions = $this->region()->getAllRegions();
			foreach($regions as $key=>$region){
				$this->menus['regions']['sub'][] = array("link"=>"?page=region&id=".$key, "name"=>$region['name']);
			}
		}
		
		if(!$this->menus['groups']['link']){
			$this->menus['groups']['link'] = "/?page=groups";
			$this->menus['groups']['name'] = "Groups";
			$this->menus['groups']['sub'][] = array("link"=>"?page=groups", "name"=>"View All");
			$this->menus['groups']['sub'][] = array("name"=>"-");
			$groups = $this->group()->getAllGroups();
			foreach($groups as $key=>$group){
				$this->menus['groups']['sub'][] = array("link"=>"?page=group&id=".$key, "name"=>$group['name']);
			}
		}

		if(!$this->menus['modules']['link']){
			$this->menus['modules']['link'] = "/?page=modules";
			$this->menus['modules']['name'] = "Modules";
		}
	}

	function getMenu($menu){
		$this->runHooks("menu", $menu);
		if(is_array($this->menus[$menu]['sub'])){
			$html .= '<li class="dropdown">
						<a href="'.$this->menus[$menu]['link'].'" data-toggle="dropdown" class="dropdown-toggle">'.$this->menus[$menu]['name'].' <b class="caret"></b> </a>
						<ul class="dropdown-menu">';
			foreach($this->menus[$menu]['sub'] as $sub){
				if($sub['name'] == '-'){$html .= '<li class="divider"></li>';}
				else{$html .= '<li><a href="'.$sub['link'].'">'.$sub['name'].'</a></li>';}
			}

			$html .= '</ul>';
		}elseif($this->menus[$menu]['link']){
			$html .= '<li class="dropdown"><a href="'.$this->menus[$menu]['link'].'">'.$this->menus[$menu]['name'].'</a></li>';
		}
		unset($this->menus[$menu]);
		
		return $html;
	}
	
	function getExtraMenus(){
		if($this->arrFull($this->menus)){
			foreach($this->menus as $menu=>$arr){
				$html .= $this->getMenu($menu);
			}
			return $html;
		}		
	}

}
?>
