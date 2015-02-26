
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">CloudMngr Control Panel</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> <?=ucfirst($_SESSION['admin'])?> <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="?logout=1">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <?
                            echo $CloudMngr->display()->getMenu("dashboard"); 
                            echo $CloudMngr->display()->getMenu("regions"); 
                            echo $CloudMngr->display()->getMenu("groups"); 
                            echo $CloudMngr->display()->getMenu("modules"); 
                            echo $CloudMngr->display()->getExtraMenus();
                            ?>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                
                
                <!--/span-->
                <div class="span12" id="content">
