<?php
$group = $this->group()->getGroup();
$this_arr = $this->getData();
$regions = $this->region()->getAllRegions();
foreach($group['regions'] as $index=>$id){
	$regions_select .= "<option value='".$id."'>".$regions[$id]['name']."</option>";
}

?>					<div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><?=$group['name']?> - <?=$this->getModuleType()?> - <?=$this->getDisplayName()?></div>
                                    <div class="pull-right"><form action="?module=<?=$this->getName()?>&page=add-new&id=<?=$this->group()->getId()?>" method="post">
					<span id="toggle<?=$this->getName()?>" style="display:none"><select name="new_region" id="add<?=$this->getName()?>Region"><?=$regions_select?></select><input type="button" id="add<?=$this->getName()?>Go" value="Go"></span></form>
					<span class="badge badge-info"><a href="#" id="add<?=$this->getName()?>">Add</a></span>
                                    	<span class="badge badge-info"><a href="?module=<?=$this->getName()?>&page=edit-config&id=<?=$this->group()->getId()?>">Config</a></span>
                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>URL</th>
                                                <th>User</th>
                                                <th>Home</th>
                                                <th>Health</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$cnt = 0;
if(count($this_arr['websites']) > 0){
	foreach($group['websites'] as $web_key=>$web){
			$cnt++;
?>
                                            <tr>
                                                <td><?=$web_key?></td>
                                                <td><?=$web['hostname']?></td>
                                                <td><?=$web['user']?></td>
                                                <td><?=$web['directory']?></td>
                                                <td>100%</td>
                                                <td><a href='#' onclick="remove<?=$this->getName()?>Instance('<?=$this->getName()?>', '<?=$web_key?>'); return false;">Del</a></td>
                                            </tr>
<?php
	}
} 
if(!$cnt) echo("<tr><td colspan='5'>No ".$this->getDisplayName()." created</td></tr>");
?>
                                        </tbody>
                                    </table>
</div>
                            </div>
                            <!-- /block -->
                        </div>


<script type="text/javascript">
	$(document).ready(function(){
		$("#add<?=$this->getName()?>").click(function(){
			$("#toggle<?=$this->getName()?>").toggle();
		});
	/*
		$("#add<?=$this->getName()?>Go").click(function(){
			$.ajax({
				"url": "cmd.php",
				"data": {
					"group": "<?=$this->group()->getId()?>",
					"region": $("#add<?=$this->getName()?>Region option:selected").val(),
					"module": "<?=$this->getName()?>",
					"action": "add"
				},
				"method": "post",
				"success": function(data){
					alert(data);
					window.location.reload();
				}
			});
		});
	*/
	});
function remove<?=$this->getName()?>Instance(insttype, id){
	$.ajax({
		"url": "cmd.php",
		"data": {
			"group": "<?=$this->group()->getId()?>",
			"region": $("#launch<?=$this->getName()?>Region option:selected").val(),
			"type": insttype,
			"instance_id": id,
			"module": "<?=$this->getName()?>",
			"action": "remove"
		},
		"method": "post",
		"success": function(data){
			alert(data);
			window.location.reload();
		}
	});
}
</script>

