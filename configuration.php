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
                            Paramètrages
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-wrench"></i>
                                <a>Paramètrages</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--      BEGIN TILES      -->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="tiles">
                            <a href="companies.php">
                            <div class="tile bg-red">
                                <div class="tile-body">
                                    <i class="icon-sitemap"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Sociétés
                                    </div>
                                    <div class="number">
                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="users.php">
                            <div class="tile bg-green">
                                <div class="tile-body">
                                    <i class="icon-user"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Utilisateurs
                                    </div>
                                    <div class="number">
                                        
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="type-charges.php">
                            <div class="tile bg-cyan">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-bar-chart"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Type Charges
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="type-charges-communs.php">
                            <div class="tile bg-dark-cyan">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-bar-chart"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Type Charges Communs
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="employes-contrats.php">
                            <div class="tile bg-brown">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-legal"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Employés
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="fournisseurs.php">
                            <div class="tile bg-blue">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-truck"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Fournisseurs
                                    </div>
                                    <!--div class="number">
                                        <?php //$livraisonsNumber ?>
                                    </div-->
                                </div>
                            </div>
                            </a>
                            <a href="clients-list.php">
                            <div class="tile bg-dark-red">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-group"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Clients
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="operations-status-archive-group.php">
                            <div class="tile bg-purple">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-money"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Archive des paiements
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="compte-bancaire.php">
                            <div class="tile bg-yellow">
                                <div class="tile-body">
                                    <i class="icon-credit-card"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Compte Bancaire
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="releve-bancaire-archive.php">
                            <div class="tile bg-dark-blue">
                                <div class="tile-body">
                                    <i class="icon-envelope"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Archive Relevés Bancaires
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="history-group.php">
                            <div class="tile bg-grey">
                                <div class="tile-body">
                                    <i class="icon-calendar"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Historique
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
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