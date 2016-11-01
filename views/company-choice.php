<?php
    require('../app/classLoad.php'); 
    require('../db/PDOFactory.php');;  
    require('/include/tiles-colors.php');
    
    session_start();
    if ( isset($_SESSION['userImmoERPV2']) and $_SESSION['userImmoERPV2']->profil() == "admin" ) {
        
        $companyManager = new CompanyManager(PDOFactory::getMysqlConnection());
        $companies = $companyManager->getCompanys();
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
                        <?php 
                        if ( isset($_SESSION['user-action-message']) 
                        and isset($_SESSION['user-type-message'])) {
                            $message = $_SESSION['user-action-message'];
                            $typeMessage = $_SESSION['user-type-message'];
                        ?>
                            <div style="text-align: center" class="alert alert-<?= $typeMessage ?>">
                                <?= $message ?>      
                            </div>
                        <?php } 
                            unset($_SESSION['user-action-message']);
                            unset($_SESSION['user-type-message']);
                        ?>
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <h3 class="page-title">
                            Accueil
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a><strong>Accueil</strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php 
                        if ( isset($_SESSION['company-action-message']) 
                        and isset($_SESSION['company-type-message'])) {
                            $message = $_SESSION['company-action-message'];
                            $typeMessage = $_SESSION['company-type-message'];
                        ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>      
                            </div>
                        <?php } 
                           unset($_SESSION['company-action-message']);
                           unset($_SESSION['company-type-message']);
                        ?>
                        <div class="btn-group pull-left get-down">
                            <a style="font-size: 18px" class="btn big" href="#addCompany" data-toggle="modal">
                                <i class="icon-plus-sign"></i>
                                Créer Nouvelle Société
                            </a>
                        </div>
                        <!-- addCompany box begin-->
                        <div id="addCompany" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter Nouvelle Société</h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="../controller/CompanyActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Nom</label>
                                        <div class="controls">
                                            <input required="required" type="text" name="nom" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Adresse</label>
                                        <div class="controls">
                                            <input type="text" name="adresse" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Directeur</label>
                                        <div class="controls">
                                            <input type="text" name="directeur" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">الاسم</label>
                                        <div class="controls">
                                            <input required="required" type="text" name="nomArabe" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">العنوان</label>
                                        <div class="controls">
                                            <input type="text" name="adresseArabe" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="action" value="add" />  
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addCompany box end -->
                    </div>    
                </div>    
                <div class="row-fluid">
                    <div class="span12">
                        <div class="tiles">
                            <?php
                            foreach ( $companies as $company ) {
                            ?>
                            <a href="company-dashboard.php?companyID=<?= $company->id() ?>">
                            <div class="tile double <?= $colors[array_rand($colors)] ?>">
                                <div class="tile-body">
                                    <i class="icon-sitemap"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name-company">
                                        <?= $company->nom(); ?>
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <?php
                            }
                            ?>
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
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script type="text/javascript" src="script.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        $('.employes').show();
        $('#employe').keyup(function(){
            $('.employes').hide();
           var txt = $('#employe').val();
           $('.employes').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        });
        $('#nature').keyup(function(){
            $('.employes').hide();
           var txt = $('#nature').val();
           $('.employes').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
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
