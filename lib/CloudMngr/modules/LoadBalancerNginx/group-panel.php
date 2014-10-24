<?php
$group = $this->group()->getGroup();
$load = $this->getLoadBalancer();
$regions = $this->region()->getAllRegions();
foreach($group['regions'] as $index=>$id){
	$regions_select .= "<option value='".$id."'>".$regions[$id]['name']."</option>";
}

?>					<div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><?=$group['name']?> - <?=$this->getDisplayName()?></div>
                                    <div class="pull-right">
					<span id="toggleLoadbalance" style="display:none"><select id="launchLoadRegion"><?=$regions_select?></select><input type="button" id="launchLoadbalanceGo" value="Go"></span>
					<span class="badge badge-info"><a href='#' id='launchLoadbalance'>Launch</a></span>
                                    	<span class="badge badge-info"><a href='/?page=loadbalancer&id=<?=$this->group()->getId()?>'>Config</a></span>
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
<?php
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


<script type="text/javascript">
	$(document).ready(function(){
		$("#launchLoadbalance").click(function(){
			$("#toggleLoadbalance").toggle();
		});
	
		$("#launchLoadbalanceGo").click(function(){
			$.ajax({
				"url": "/cmd.php?action=launch",
				"data": {
					"group": "<?=$this->group()->getId()?>",
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
			"group": "<?=$this->group()->getId()?>",
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

