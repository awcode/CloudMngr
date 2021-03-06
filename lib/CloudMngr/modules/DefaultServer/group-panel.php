<?php
$group = $this->group()->getGroup();
$this_arr = $this->getData();
$regions = $this->region()->getAllRegions();
foreach($group['regions'] as $index=>$id){
	$regions_select .= "<option value='".$id."'>".$regions[$id]['name']."</option>";
}

?>					<div class="row-fluid">
						<div class="span12">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><?=$this->getDisplayName()?></div>
                                    <div class="pull-right">
					<span id="toggle<?=$this->getName()?>" style="display:none"><select id="launch<?=$this->getName()?>Region"><?=$regions_select?></select><input type="button" id="launch<?=$this->getName()?>Go" value="Go"></span>
					<span class="badge badge-info"><a href="#" id="launch<?=$this->getName()?>">Launch</a></span>
                                    	<span class="badge badge-info"><a href="?module=<?=$this->getName()?>&page=edit-config&id=<?=$this->group()->getId()?>">Config</a></span>
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
$cnt = 0;
foreach($group['regions'] as $index=>$id){
	if(count($this_arr['regions'][$id]['instances']) > 0){
		foreach($this_arr['regions'][$id]['instances'] as $inst_id => $inst){
			$cnt++;
?>
                                            <tr>
                                                <td><?=$inst_id?></td>
                                                <td><?=$regions[$id]['name']?></td>
                                                <td><?=$inst['type']?></td>
                                                <td><?=$inst['ip']?></td>
                                                <td>100%</td>
                                                <td><a href='#' onclick="terminate<?=$this->getName()?>Instance('<?=$this->getName()?>', '<?=$inst_id?>'); return false;">Del</a></td>
                                            </tr>
<?php
		}
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
                    </div>


<script type="text/javascript">
	$(document).ready(function(){
		$("#launch<?=$this->getName()?>").click(function(){
			$("#toggle<?=$this->getName()?>").toggle();
		});
	
		$("#launch<?=$this->getName()?>Go").click(function(){
			$.ajax({
				"url": "cmd.php",
				"data": {
					"group": "<?=$this->group()->getId()?>",
					"region": $("#launch<?=$this->getName()?>Region option:selected").val(),
					"module": "<?=$this->getName()?>",
					"action": "launch"
				},
				"method": "post",
				"success": function(data){
					alert(data);
					window.location.reload();
				}
			});
		});
	});
function terminate<?=$this->getName()?>Instance(insttype, id){
	$.ajax({
		"url": "cmd.php",
		"data": {
			"group": "<?=$this->group()->getId()?>",
			"region": $("#launch<?=$this->getName()?>Region option:selected").val(),
			"type": insttype,
			"instance_id": id,
			"module": "<?=$this->getName()?>",
			"action": "terminate"
		},
		"method": "post",
		"success": function(data){
			alert(data);
			window.location.reload();
		}
	});
}
</script>

