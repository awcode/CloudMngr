
                    <div class="row-fluid">
                        <div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Success</h4>
                        	The operation completed successfully</div>
                        	<div class="navbar">
                            	<div class="navbar-inner">
	                                <ul class="breadcrumb">
	                                    <i class="icon-chevron-left hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
	                                    <i class="icon-chevron-right show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
	                                    <li>
	                                        <a href="/?page=regions">Regions</a> <span class="divider">/</span>	
	                                    </li>
	                                   
	                                    <li class="active">All</li>
	                                </ul>
                            	</div>
                        	</div>
                    	</div>
 		    </div>
                    <div class="row-fluid">
<?
	$groups = $CloudMngr->group()->getAllGroups();
	
	$regions = $CloudMngr->region()->getAllRegions();
	foreach($regions as $key=>$region){
	$odd +=1;
	$group_arr = array();
	$group_cnt = 0;
	foreach($groups as $k=>$group){
		if(in_array($key, $group['regions'])){
			$group_arr[] = "<a href='/?page=group&id=".$k."'>".$group['name']."</a> ";
		}
	}
?>


                        <div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><a href='/?page=region&id=<?=$key?>'><?=$region['name']?></a></div>
                                    <div class="pull-right"><span class="badge badge-info">1,234</span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Active</th>
                                                <th>Health</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Groups</td>
                                                <td><?=count($group_arr)." ".implode(", ",$group_arr)?></td>
                                                <td>100%</td>
                                            </tr>
						                	<?php
						                	if($CloudMngr->arrFull($CloudMngr->active_modules)){
												foreach($CloudMngr->active_modules as $module){
													$ob = $CloudMngr->module($module);
													?>
						                               <tr>
						                                    <td><?=$ob->getDisplayName()?></td>
						                                    <td><?=$ob->getCountByRegion($key)?></td>
						                                    <td><?=$ob->getHealthByRegion($key)?></td>
						                                </tr>
											
													<?php
												}
											} 
						                	?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
<?php
	if($odd == 2){$odd = 0; echo('</div><div class="row-fluid">');}
}
?>
                       </div>


<script src="assets/scripts.js"></script>
          
    
