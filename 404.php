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
    if(isset($_SESSION['userMerlaTrav']) ){
        
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
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
        <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
                                Page non trouvé
                            </h3>
                            <ul class="breadcrumb">
                                <li>
                                    <i class="icon-home"></i>
                                    <a href="dashboard.php">Accueil</a> 
                                    <i class="icon-angle-right"></i>
                                </li>
                                <li>
                                    <i class="icon-search"></i>
                                    <a>Erreur</a>
                                </li>
                            </ul>
                            <!-- END PAGE TITLE & BREADCRUMB-->
                        </div>
                    </div>
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="row-fluid page-404">
                                <div class="span5 number">
                                    404
                                </div>
                                <div class="span7 details">
                                    <h3>Désolé, celle ci est une page d'erreur.</h3>
                                    <p>
                                        Cette page soit qu'elle n'existe pas, ou il y a une erreur dans le système.<br />
                                        Contactez l'administrateur si c'est une erreur.
                                    </p>
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
        <!-- ie8 fixes -->
        <!--[if lt IE 9]>
        <script src="assets/js/excanvas.js"></script>
        <script src="assets/js/respond.js"></script>
        <![endif]-->    
        <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
        <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
        <script src="assets/js/app.js"></script>
        <script type="text/javascript" src="script.js"></script>        
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
else{
    header('Location:index.php');    
}
?>