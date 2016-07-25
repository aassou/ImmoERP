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
        $alerts = $alertManager->getAlerts();
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
                            Gestion des Alertes
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bullhorn"></i>
                                <a>Liste des alertes</a>
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
                        <?php
                         if( isset($_SESSION['alert-action-message'])
                         and isset($_SESSION['alert-type-message']) ){ 
                            $message = $_SESSION['alert-action-message'];
                            $typeMessage = $_SESSION['alert-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['alert-action-message']);
                            unset($_SESSION['alert-type-message']);
                         ?>
                        <div class="portlet">
                            <div class="portlet-title line">
                                <h4><i class="icon-bullhorn"></i>Ajouter une alerte </h4>
                                <!--div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div-->
                            </div>
                            <div class="portlet-body" id="chats">
                                <div class="chat-form">
                                    <form action="controller/AlertActionController.php" method="POST">
                                        <div class="input-cont">   
                                            <input class="m-wrap" type="text" name="alert" placeholder="Description de l'alerte" />
                                        </div>
                                        <div class="btn-cont"> 
                                            <input type="hidden" name="action" value="add" />
                                            <span class="arrow"></span>
                                            <button type="submit" class="btn blue icn-only"><i class="icon-ok icon-white"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                        <?php
                        $statusClass = '';
                        $statusUpdate = 0;
                        $action = "";
                        $actionClass = "";
                        foreach($alerts as $alert){
                            if ( $alert->status() == 0 ) {
                                $statusClass = 'error';
                                $statusUpdate = 1;
                                $action = "Valider";
                                $actionClass = "green";
                            }
                            else if ( $alert->status() == 1 ) {
                                $statusClass = 'success';
                                $statusUpdate = 0;
                                $action = "Annuler";
                                $actionClass = "red";
                            }
                        ?>
                        <div class="span3 alert alert-block alert-<?= $statusClass ?> fade in">
                            <?php
                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                            ?>
                            <a href="#deleteAlert<?= $alert->id() ?>" class="close" data-toggle="modal" data-id="<?= $alert->id() ?>"></a>
                            <?php  
                            }
                            ?>
                            <h4 class="alert-heading">Alerte</h4>
                            <p>
                                <?= $alert->alert() ?>
                            </p>
                            <p>
                                <?php
                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                ?>
                                <!--a class="btn red" href="#">Do this</a--> 
                                <a class="btn <?= $actionClass ?>" href="#updateStatusAlert<?= $alert->id() ?>" data-toggle="modal" data-id="<?= $alert->id() ?>" ><?= $action ?></a>
                                <?php  
                                }
                                ?>
                            </p>
                        </div>
                        <!-- updateStatusAlert box begin-->
                        <div id="updateStatusAlert<?= $alert->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Modifier Status Alerte</h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal loginFrm" action="controller/AlertActionController.php" method="post">
                                    <p>Êtes-vous sûr de vouloir modifier le status de cette alerte ?</p>
                                    <div class="control-group">
                                        <label class="right-label"></label>
                                        <input type="hidden" name="action" value="updateStatus" />
                                        <input type="hidden" name="idAlert" value="<?= $alert->id() ?>" />
                                        <input type="hidden" name="status" value="<?= $statusUpdate ?>" />
                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                        <button type="submit" class="btn <?= $actionClass ?>" aria-hidden="true">Oui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- updateStatusAlert box end -->
                        <!-- delete box begin-->
                        <div id="deleteAlert<?= $alert->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Supprimer Alerte</h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal loginFrm" action="controller/AlertActionController.php" method="post">
                                    <p>Êtes-vous sûr de vouloir supprimer cette alerte ?</p>
                                    <div class="control-group">
                                        <label class="right-label"></label>
                                        <input type="hidden" name="action" value="delete" />
                                        <input type="hidden" name="idAlert" value="<?= $alert->id() ?>" />
                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- delete box end -->
                        <?php 
                        }
                        ?>
                        <!-- END INLINE NOTIFICATIONS PORTLET-->
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