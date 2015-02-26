				<div class="row-fluid">
                        <div class="span12">
                            <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Modules</div>
                                    <div class="pull-right"><span class="badge badge-info"><?=count($CloudMngr->all_modules)?></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
										<?php
											foreach($CloudMngr->all_modules as $module){
												$mod = $CloudMngr->module($module);
										?>
											<tr>
                                                <td><?=$mod->getDisplayName()?></td>
                                                <td><?=$mod->getModuleType()?></td>
                                                <td><?=((in_array($module, $CloudMngr->active_modules))?" Active":" Disabled")?></td>
                                            </tr>
										<?php
											}
										?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
                        
                    </div>

