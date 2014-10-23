<?
include("../lib/CloudMngr/cloudmngr.core.class.php");

$CloudMngr = new CloudMngr($_GET['id']);

$group = $CloudMngr->group()->getGroup();
$regions = $CloudMngr->region()->getAllRegions();
$load = $CloudMngr->loadBalancer()->getLoadBalancer();

foreach($group['regions'] as $index=>$id){
	$regions_arr[] = "<a href='/?page=region&id=".$id."'>".$regions[$id]['name']."</a> ";
	$regions_select .= "<option value='".$id."'>".$regions[$id]['name']."</option>";
}
?>

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
	                                        <a href="/?page=groups">Groups</a> <span class="divider">/</span>	
	                                    </li>
	                                    <li class="active"><?=$CloudMngr->group()->getName()?></li>
	                                </ul>
                            	</div>
                        	</div>
                    	</div>
 		    </div>
                    <div class="row-fluid">

 			<div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><?=$group['name']?> - Summary</div>
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
                                                <td>Regions</td>
                                                <td><?=count($regions_arr)." ".implode(", ",$regions_arr)?></td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td>Load Balancer</td>
                                                <td>1</td>
                                                <td>100%</td>
                                            </tr>
                                            <tr>
                                                <td>Web server</td>
                                                <td>3</td>
                                                <td>90%</td>
                                            </tr>
                                            <tr>
                                                <td>Database</td>
                                                <td>2</td>
                                                <td>100%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>

			<div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><?=$group['name']?> - Load Balancers</div>
                                    <div class="pull-right">
					<span id="toggleLoadbalance" style="display:none"><select id="launchLoadRegion"><?=$regions_select?></select><input type="button" id="launchLoadbalanceGo" value="Go"></span>
					<span class="badge badge-info"><a href='#' id='launchLoadbalance'>Launch</a></span>
                                    	<span class="badge badge-info"><a href='/?page=loadbalancer&id=<?=$CloudMngr->group()->getId()?>'>Config</a></span>
                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Region</th>
                                                <th>Size</th>
                                                <th>IP</th>
                                                <th>Health</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
foreach($group['regions'] as $index=>$id){
	if(count($load['regions'][$id]['instances']) > 0){
		foreach($load['regions'][$id]['instances'] as $inst_id => $inst){
?>
                                            <tr>
                                                <td><?=$inst_id?></td>
                                                <td><?=$regions[$id]['name']?></td>
                                                <td><?=$inst['type']?></td>
                                                <td><?=$inst['ip']?></td>
                                                <td>100%</td>
                                                <td><a href='#' onclick="terminateInstance('load', '<?=$inst_id?>'); return false;">Del</a></td>
                                            </tr>
<? 
		}
	}
} 
?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>

                    </div>


<script src="assets/scripts.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#launchLoadbalance").click(function(){
			$("#toggleLoadbalance").toggle();
		});
	
		$("#launchLoadbalanceGo").click(function(){
			$.ajax({
				"url": "/cmd.php?action=launch",
				"data": {
					"group": "<?=$CloudMngr->group()->getId()?>",
					"region": $("#launchLoadRegion option:selected").val()
				},
				"method": "post",
				"success": function(data){
					alert(data);
				}
			});
		});
	});
function terminateInstance(insttype, id){
	$.ajax({
		"url": "/cmd.php?action=terminate",
		"data": {
			"group": "<?=$CloudMngr->group()->getId()?>",
			"region": $("#launchLoadRegion option:selected").val(),
			"type": insttype,
			"instance_id": id
		},
		"method": "post",
		"success": function(data){
			alert(data);
		}
	});
}
</script>
          
    