<?php
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav'])){
        //classes managers
        $usersManager = new UserManager($pdo);
        $mailManager = new MailManager($pdo);
        //classes and vars
        //users number
        $users = $usersManager->getUsers();
        //$mails = $mailManager->getMails();
        
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>ImmoERP - Management Application</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/metro.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/style_responsive.css" rel="stylesheet" />
    <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
    <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <?php 
        include("include/top-menu.php"); 
        $myTasks = $taskManager->getTasksByUser($_SESSION['userMerlaTrav']->login());
        $tasksAffectedByMeToOther = 
        $taskManager->getTasksAffectedByMeToOther($_SESSION['userMerlaTrav']->login());
        ?>   
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->    
    <div class="page-container row-fluid sidebar-closed">
        <!-- BEGIN SIDEBAR -->
        <?php include("include/sidebar.php"); ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <div class="page-content">
            <!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <h3 class="page-title">
                            Gestion des tâches
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-tasks"></i>
                                <a>Liste des tâches</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <!-- BEGIN PORTLET-->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Liste des tâches</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width :10%">Actions</th>
                                            <th style="width :10%">Affetcé pour</th>
                                            <th style="width :20%">Date affectation</th>
                                            <th style="width :50%">Tâche</th>
                                            <th style="width :10%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($tasksAffectedByMeToOther as $task){
                                            if ( $task->status() == 0 ) {
                                                $status = '<a class="btn mini red">En cours</a>';
                                                $statusName = "En cours";
                                            }
                                            else if ( $task->status() == 1 ) {
                                                $status = '<a class="btn mini green">Validée</a>';
                                                $statusName = "Validée";
                                            }
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <a href="#updateTask<?= $task->id() ?>" data-toggle="modal" data-id="<?= $task->id() ?>" class="btn mini green"><i class="icon-refresh"></i></a>
                                                <a href="#deleteTask<?= $task->id() ?>" data-toggle="modal" data-id="<?= $task->id() ?>" class="btn mini red"><i class="icon-remove"></i></a>
                                            </td>
                                            <td><?= $task->user() ?></td>
                                            <td><?= date('d/m/Y - H\hi\m', strtotime($task->created())) ?></td>
                                            <td><?= $task->content() ?></td>
                                            <td><?= $status ?></td>
                                            <!-- updateTask Box Begin -->
                                            <div id="updateTask<?= $task->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h3>Effacer la tâche</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="controller/TaskActionController.php" method="post">
                                                        <div class="control-group">
                                                            <label class="control-label" for="user">Tâche pour</label>
                                                            <div class="controls">
                                                                <select name="user" id="user">
                                                                    <option value="<?= $task->user() ?>"><?= $task->user() ?></option>
                                                                    <option disabled="disabled">--------------</option>
                                                                    <?php 
                                                                    foreach ( $users as $user ) {
                                                                        if ( $user->login() != $_SESSION['userMerlaTrav']->login() ) { 
                                                                    ?>
                                                                            <option value="<?= $user->login() ?>"><?= $user->login() ?></option>
                                                                    <?php 
                                                                        }//end if 
                                                                    }//end foreach    
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="user">Détails tâche</label>
                                                            <div class="controls">  
                                                                <textarea name="content" /><?= $task->content() ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="user">Status</label>
                                                            <div class="controls">
                                                                <select name="status">
                                                                    <option value="<?= $task->status() ?>"><?= $statusName ?></option>
                                                                    <option disabled="disabled">--------------</option>
                                                                    <option value="0">En cours</option>
                                                                    <option value="1">Validée</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="controls">  
                                                                <input type="hidden" name="action" value="update" />
                                                                <input type="hidden" name="idTask" value="<?= $task->id() ?>" />
                                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- updateTask Box End -->
                                            <!-- deleteTask Box Begin -->
                                            <div id="deleteTask<?= $task->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h3>Effacer la tâche</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" action="controller/TaskActionController.php" method="post">
                                                        <p>Êtes-vous sûr de vouloir effacer cette tâche ?</p>
                                                        <div class="control-group">
                                                            <div class="controls">  
                                                                <input type="hidden" name="action" value="delete" />
                                                                <input type="hidden" name="idTask" value="<?= $task->id() ?>" />
                                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- deleteTask Box End -->
                                        </tr>     
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="portlet">
                            <div class="portlet-title line">
                                <h4><i class="icon-tasks"></i>Affecter des tâches</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body" id="chats">
                                <div class="chat-form">
                                    <form action="controller/TaskActionController.php" method="POST">
                                        <div class="control-group">
                                                <label class="control-label" for="user">Tâche pour</label>
                                                <div class="controls">
                                                    <select name="user" id="user">
                                                        <?php 
                                                        foreach ( $users as $user ) {
                                                            if ( $user->login() != $_SESSION['userMerlaTrav']->login() ) { 
                                                        ?>
                                                                <option value="<?= $user->login() ?>"><?= $user->login() ?></option>
                                                        <?php 
                                                            }//end if 
                                                        }//end foreach    
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="input-cont">   
                                            <input class="m-wrap" type="text" name="content" placeholder="Tapez votre tâche ..." />
                                        </div>
                                        <div class="btn-cont"> 
                                            <input type="hidden" name="action" value="add" />
                                            <span class="arrow"></span>
                                            <button type="submit" class="btn blue icn-only"><i class="icon-ok icon-white"></i></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="scroller" data-height="500px" data-always-visible="1" id="messages" data-rail-visible1="1">
                                    <?php
                                     if( isset($_SESSION['task-action-message'])
                                     and isset($_SESSION['task-type-message']) ){ 
                                        $message = $_SESSION['task-action-message'];
                                        $typeMessage = $_SESSION['task-type-message'];    
                                     ?>
                                        <div class="alert alert-<?= $typeMessage ?>">
                                            <button class="close" data-dismiss="alert"></button>
                                            <?= $message ?>     
                                        </div>
                                     <?php } 
                                        unset($_SESSION['task-action-message']);
                                        unset($_SESSION['task-type-message']);
                                     ?>
                                    <br>
                                    <!--a href="#deleteValideTasks" data-toggle="modal" class="btn green get-down">
                                        Effacer les tâches validées
                                    </a-->
                                    <!-- DeleteValideTasks Box Begin -->
                                    <div id="deleteValideTasks" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Effacer les tâches validées</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="" method="post">
                                                <div class="control-group">
                                                    <div class="controls">  
                                                        <input type="hidden" name="action" value="deleteValideTasks" />
                                                        <input type="hidden" name="user" value="<?= $_SESSION['userMerlaTrav']->login() ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn green" aria-hidden="true">Oui</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- DeleteValideTasks Box End -->
                                    <ul class="chats">
                                        <?php 
                                        foreach($myTasks as $task){
                                        $status = "";    
                                        $classInOrOut = "out";    
                                        $avatar = "assets/img/red-user-icon.png";
                                        if($task->createdBy() == $_SESSION['userMerlaTrav']->login()){
                                            $classInOrOut = "in";
                                            $avatar = "assets/img/green-user-icon.png";
                                        }   
                                        if ( $task->status() == 0 ) {
                                            $classInOrOut = "out";
                                            $status = '<a data-toggle="modal" data-id="'.$task->id().'" class="btn mini red" href="#validateTask'.$task->id().'">En cours</a>';
                                        }
                                        else if ( $task->status() == 1 ) {
                                            $classInOrOut = "in";
                                            $status = '<a data-toggle="modal" data-id="'.$task->id().'" class="btn mini green" href="#invalidateTask'.$task->id().'">Validée</a>';
                                        }
                                        ?>
                                        <li class="<?= $classInOrOut ?>">
                                            <!--img class="avatar" alt="" src="<?= $avatar ?>" /-->
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <strong>Tâche affectée par =&gt; </strong>
                                                <a href="#" class="name"><strong><?= strtoupper($task->createdBy()) ?></strong></a>
                                                <span class="datetime">
                                                    <?php 
                                                    if(date('Y-m-d', strtotime($task->created()))==date("Y-m-d")){echo "Ajourd'hui";}
                                                    else{echo date('d-m-Y',strtotime($task->created()));}  
                                                    echo " à ".date('H:i', strtotime($task->created())); ?>
                                                </span><?= $status ?>
                                                <span class="body get-down medium-font">
                                                <?= $task->content() ?>
                                                </span>
                                            </div>
                                        </li>
                                        <!-- Validate Task Box Begin -->
                                        <div id="validateTask<?= $task->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Valider la tâche</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/TaskActionController.php" method="post">
                                                    <div class="control-group">
                                                        <div class="controls">  
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="status" value="1" />
                                                            <input type="hidden" name="idTask" value="<?= $task->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn green" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Validate Task Box End -->
                                        <!-- Invalidate Task Box Begin -->
                                        <div id="invalidateTask<?= $task->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Invalider la tâche</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/TaskActionController.php" method="post">
                                                    <div class="control-group">
                                                        <div class="controls">  
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="status" value="0" />
                                                            <input type="hidden" name="idTask" value="<?= $task->id() ?>" />
                                                            <button class="btn" data-dismiss="modal" aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Invalidate Task Box End -->   
                                        <?php 
                                        }  
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->
                <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->  
        </div>
        <!-- END PAGE -->       
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        2015 &copy; ImmoERP. Management Application.
        <div class="span pull-right">
            <span class="go-top"><i class="icon-angle-up"></i></span>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS -->
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <script src="assets/js/jquery-1.8.3.min.js"></script>           
    <script src="assets/breakpoints/breakpoints.js"></script>           
    <script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>  
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.blockui.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>    
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
    <script src="assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="assets/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->
    <script src="assets/js/app.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");  // set current page
            App.init();
        });
    </script>
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>