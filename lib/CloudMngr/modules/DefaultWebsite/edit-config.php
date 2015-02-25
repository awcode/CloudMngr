<?php
$this->setGroup($_GET['id']);

$group = $this->group()->getGroup();
//$regions = $this->region()->getAllRegions();

if($_POST['update'] != ""){
	$this->saveConfig();
}



$this_arr = $this->getData();

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
	                                        <a href="?page=groups">Groups</a> <span class="divider">/</span>	
	                                    </li>
	                                    <li>
	                                        <a href="?page=group&id=<?=$this->group()->getId()?>"><?=$this->group()->getName()?></a> <span class="divider">/</span>	
	                                    </li>
	                                    <li class="active"><?=$this->getName()?></li>
	                                </ul>
                            	</div>
                        	</div>
                    	</div>
 		    </div>
		<form action="#" method="post">
                    <div class="row-fluid">

<?php
	
	$website = $this_arr['website-default'];

?>
 			<div class="span12">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left"> <?=$group['name']?> - <?=$this->getDisplayName()?> setup</div>
                                    <div class="pull-right"><span class="badge badge-info">1,234</span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Default Config</th>
                                                <th>Init Script</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><textarea name="config"><?=$website['config']?></textarea></td>
                                                <td><input type="text" name="init" value="<?=$website['init']?>"></td>
                                            </tr>
                                        </tbody>
                                       
                                    </table>
				    <!--<a href="#" onclick="$(this).next('textarea').toggle(); return false;">View config</a>
				    <textarea name="config-<?=$index?>" style="display:none; width:95%; height: 250px;"><?=$website['config']?></textarea>-->
                                </div>
                            </div>
                            <!-- /block -->
                        </div>

		</div>
		<input type="submit" name="update" value="Save All">
		</form>

<script src="assets/scripts.js"></script>
          
    		
