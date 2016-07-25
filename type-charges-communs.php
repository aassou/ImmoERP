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
    include('lib/pagination.php');
    //classes loading end
    session_start();
    if ( isset($_SESSION['userMerlaTrav']) ) {
        $typeChargesManager = new TypeChargeCommunManager($pdo);
        $typesCharges = $typeChargesManager->getTypeCharges();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>ImmoERP - Management Application</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/metro.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/style_responsive.css" rel="stylesheet" />
    <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
    <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <?php include("include/top-menu.php"); ?>   
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
                            Gestion des types des charges communs
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-wrench"></i>
                                <a href="configuration.php">Paramètrages</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Types des charges communs</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                    <!-- CONTRAT CAS LIBRE BEGIN -->
                    <?php 
                    if(isset($_SESSION['typeCharge-action-message']) 
                    and isset($_SESSION['typeCharge-type-message'])){ 
                          $message = $_SESSION['typeCharge-action-message'];
                          $typeMessage = $_SESSION['typeCharge-type-message'];
                    ?>
                        <br><br>
                        <div class="alert alert-<?= $typeMessage ?>">
                            <button class="close" data-dismiss="alert"></button>
                            <?= $message ?>
                        </div>
                     <?php } 
                        unset($_SESSION['typeCharge-action-message']);
                        unset($_SESSION['typeCharge-type-message']);
                     ?>
                    <!-- addTypeCharge box begin-->
                    <div id="addTypeCharge" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Ajouter Nouveau Type Charge </h3>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" action="controller/TypeChargeCommunActionController.php" method="post">
                                <div class="control-group">
                                    <label class="control-label">Nom Type Charge</label>
                                    <div class="controls">
                                        <input type="text" name="nom" value="" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="hidden" name="action" value="add" />
                                        <input type="hidden" name="source" value="type-charges-communs" />    
                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- addTypeCharge box end -->
                    <div class="portlet box light-grey" id="history">
                        <div class="portlet-title">
                            <h4>Types des charges</h4>
                            <div class="tools">
                                <a href="javascript:;" class="reload"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="clearfix">
                                <div class="btn-group">
                                    <a class="btn blue pull-right" href="#addTypeCharge" data-toggle="modal">
                                        <i class="icon-plus-sign"></i>
                                         Type Charge
                                    </a>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Actions</th>
                                            <th style="width: 80%">Type Charge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ( $typesCharges as $type ) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="#" class="btn mini red"><i class="icon-remove"></i></a>
                                                <a href="#updateCharge<?= $type->id() ?>" data-toggle="modal" data-id="<?= $type->id() ?>" class="btn mini green"><i class="icon-refresh"></i></a>
                                            </td>
                                            <td><?= $type->nom() ?></td>
                                        </tr>
                                        <!-- updateCompte box begin-->
                                        <div id="updateCharge<?= $type->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier Type Charge</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/TypeChargeCommunActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Nom Type Charge</label>
                                                        <div class="controls">
                                                            <input type="text" name="nom" value="<?= $type->nom() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="hidden" name="idTypeCharge" value="<?= $type->id() ?>">
                                                            <input type="hidden" name="action" value="update" />
                                                            <input type="hidden" name="source" value="type-charges-communs" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateCompte box end -->   
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>       
                    </div>
                   </div>
                </div>
                <!-- END PAGE CONTENT -->
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
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>        
    <script src="assets/js/jquery.blockui.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>    
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->    
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="assets/js/app.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
    </script>
</body>
<!-- END BODY -->
</html>
<?php
}
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
    header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}

?>