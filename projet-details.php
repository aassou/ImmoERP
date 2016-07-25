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
    include ('lib/pagination.php');
    //classes loading end
    session_start();
    if( isset($_SESSION['userMerlaTrav']) ) {
        //les sources
        $idProjet = $_GET['idProjet'];
        $projetsManager = new ProjetManager($pdo);
        $projet = $projetsManager->getProjetById($idProjet);
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
                            Gestion des projets - Projet : <strong><?= $projet->nom() ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-briefcase"></i>
                                <a href="projets.php">Gestion des projets</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li><a>Projet <strong><?= $projet->nom() ?></strong></a></li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php if(isset($_SESSION['user-delete-success'])){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['user-delete-success'] ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['user-delete-success']);
                         ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="tab-pane" id="tab_1_4">
                            <div class="row-fluid portfolio-block" id="<?= $projet->id() ?>">
                                <div class="span2 portfolio-text">
                                    <div class="portfolio-text-info">
                                        <a class="btn big blue"><?= $projet->nom() ?></a>
                                    </div>
                                </div>
                                <div class="span10" style="overflow:hidden;">
                                    <div class="portfolio-info">
                                        <a href="terrain.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width black">Terrain</a>
                                        <a href="appartements.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width brown">Appartements</a>
                                        <a href="locaux.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width purple">Les locaux commerciaux</a>
                                    </div>
                                    <div class="portfolio-info">
                                        <?php
                                        if ( 
                                            $_SESSION['userMerlaTrav']->profil()=="admin" 
                                            || $_SESSION['userMerlaTrav']->profil()=="consultant" 
                                        ) {
                                        ?>
                                        <a href="projet-charges-grouped.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width dark-red">Charges du Projet</a>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ( 
                                            $_SESSION['userMerlaTrav']->profil()=="admin" ||
                                            $_SESSION['userMerlaTrav']->profil()=="manager"
                                            ) {
                                        ?>
                                        <a href="clients-add.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width red">Créer Clients et Contrats</a>
                                        <?php
                                        }
                                        ?>
                                        <a href="contrats-list.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width green">Listes Clients et Contrats</a>
                                    </div>
                                    <div class="portfolio-info">
                                        <a href="contrats-desistes-list.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width yellow">Contrats Désistés</a>
                                        <a href="projet-contrat-employe.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width">Contrats employés</a>
                                        <a href="suivi-projets.php?idProjet=<?= $projet->id() ?>" class="btn btn-fixed-width dark-cyan">Statistiques</a>
                                    </div>
                                    <!--div class="portfolio-info">
                                        <a class="btn brown arabic" href="contrats-travail.php?idProjet=<?= $projet->id() ?>" class="btn">تنظيم عقود العمل</a>
                                    </div-->
                                </div>
                            </div>
                            <br><br>     
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
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
    <script src="assets/js/app.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            //App.setPage("table_editable");
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