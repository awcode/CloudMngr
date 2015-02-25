<?php
$group = $this->group()->getGroup();
$this_arr = $this->getData();

?>					<div class="span6">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"><?=$group['name']?> - <?=$this->getModuleType()?> - <?=$this->getDisplayName()?></div>
                                    <div class="pull-right">
                                    	<span class="badge badge-info"><a href="?module=<?=$this->getName()?>&page=add-new&id=<?=$this->group()->getId()?>" id="add<?=$this->getName()?>">Add</a></span>
                                    	<span class="badge badge-info"><a href="?module=<?=$this->getName()?>&page=edit-config&id=<?=$this->group()->getId()?>">Config</a></span>
                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
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
if(count($this_arr['websites'][$this->module_display_name]) > 0){
	foreach($this_arr['websites'][$this->module_display_name] as $web_key=>$web){
			$cnt++;
?>
                                            <tr>
                                                <td><?=$web['hostname']?></td>
                                                <td><?=$web['user']?></td>
                                                <td><?=$web['directory']?></td>
                                                <td>100%</td>
                                                <td><a href='#' onclick="remove<?=$this->getName()?>Website('<?=$this->getName()?>', '<?=$web_key?>'); return false;">Del</a></td>
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
function remove<?=$this->getName()?>Website(webtype, id){
	$.ajax({
		"url": "cmd.php",
		"data": {
			"group": "<?=$this->group()->getId()?>",
			"type": webtype,
			"web_key": id,
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

