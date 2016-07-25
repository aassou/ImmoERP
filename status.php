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
                        <h3 class="page-title">
                            Les états
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a>Liste des états</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--      BEGIN TILES      -->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="tiles">
                            <a href="contrat-status.php">
                            <div class="tile bg-dark-red">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-group"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Etats clients
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="operations-status-group.php">
                            <div class="tile bg-blue">
                                <div class="tile-body">
                                    <i class="icon-money"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Etats paiments
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="properties-status.php">
                            <div class="tile bg-green">
                                <div class="tile-body">
                                    <i class="icon-home"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Etats Immobilier
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="clients-synthese.php">
                            <div class="tile bg-cyan">
                                <div class="tile-body">
                                    <i class="icon-search"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Synthèse clients
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="clients-modification.php">
                            <div class="tile bg-grey">
                                <div class="tile-body">
                                    <i class="icon-pencil"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Modifications Clients
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="contrats-desistes.php">
                            <div class="tile bg-red">
                                <div class="tile-body">
                                    <i class="icon-file"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Contrats Désistés
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!--      BEGIN TILES      -->
                <!-- BEGIN DASHBOARD STATS -->
                <!--h4 class="breadcrumb"><i class="icon-table"></i> Bilans et Statistiques Pour Cette Semaine</h4>
                <div class="row-fluid">
                    <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                        <div class="dashboard-stat yellow">
                            <div class="visual">
                                <i class="icon-signal"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?= $operationsNumberWeek ?>    
                                </div>
                                <div class="desc">                                  
                                    Paiements Clients
                                </div>
                            </div>                  
                        </div>
                    </div>
                    <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                        <div class="dashboard-stat green">
                            <div class="visual">
                                <i class="icon-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">+<?= $livraisonsNumberWeek ?></div>
                                <div class="desc">Livraisons</div>
                            </div>                  
                        </div>
                    </div>
                    <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                        <div class="dashboard-stat blue">
                            <div class="visual">
                                <i class="icon-group"></i>
                            </div>
                            <div class="details">
                                <div class="number">+<?= $clientNumberWeek ?></div>
                                <div class="desc">Clients</div>
                            </div>          
                        </div>
                    </div>  
                    <div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                        <a class="more" href="caisse.php">
                        <div class="dashboard-stat purple">
                            <div class="visual">
                                <i class="icon-money"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?= number_format($caisseEntreesManager->getTotalCaisseEntrees()-$caisseSortiesManager->getTotalCaisseSorties(), '2', ',', ' ') ?>
                                </div>
                                <div class="desc">DH en caisse</div>
                            </div>                  
                        </div>
                        </a>
                    </div>  
                </div-->
                <!-- END DASHBOARD STATS -->
                <!-- END PAGE HEADER-->
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
            App.setPage("sliders");  // set current page
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