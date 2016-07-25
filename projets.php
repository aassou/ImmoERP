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
    if ( isset($_SESSION['userMerlaTrav']) ) {
        //les sources
        $projetsManager = new ProjetManager($pdo);
        $projetNumber = $projetsManager->getProjetsNumber();
        $projets = $projetsManager->getProjets();
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
                            Gestion des projets
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-briefcase"></i>
                                <a>Gestion des projets</a>
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
                        if(isset($_SESSION['projet-action-message']) and isset($_SESSION['projet-type-message'])){
                            $message = $_SESSION['projet-action-message'];
                            $typeMessage = $_SESSION['projet-type-message'];
                        ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php 
                         } 
                         unset($_SESSION['projet-action-message']);
                         unset($_SESSION['projet-type-message']);
                         ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="tab-pane" id="tab_1_4">
                            <div class="row-fluid add-portfolio">
                                <div class="pull-left get-down">
                                    <span><?= $projetNumber ?> Projets en Total</span>
                                </div>
                                <?php
                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                ?>
                                <div class="pull-right">
                                    <a href="#addProjet" class="btn icn-only green" data-toggle="modal">Ajouter Nouveau Projet <i class="icon-plus-sign m-icon-white"></i></a>                                  
                                </div>
                                <?php  
                                }
                                ?>
                            </div>
                            <!-- addProjet box begin-->
                            <div id="addProjet" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Ajouter Nouveau Projet</h3>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="controller/ProjetActionController.php" method="post">
                                        <div class="control-group">
                                            <label class="control-label">Nom</label>
                                            <div class="controls">
                                                <input type="text" name="nom" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Titre</label>
                                            <div class="controls">
                                                <input type="text" name="titre" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Budget</label>
                                            <div class="controls">
                                                <input type="text" name="budget" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Superficie</label>
                                            <div class="controls">
                                                <input type="text" name="superficie" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Adresse</label>
                                            <div class="controls">
                                                <textarea type="text" name="adresse"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Description</label>
                                            <div class="controls">
                                                <textarea type="text" name="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">اسم المشروع</label>
                                            <div class="controls">
                                                <input type="text" name="nomArabe" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">عنوان المشروع</label>
                                            <div class="controls">
                                                <input type="text" name="adresseArabe" />
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
                            <!-- addProjet box end -->
                            <!--end add-portfolio-->
                            <?php
                            foreach($projets as $projet){
                            ?>
                            <div class="row'fluid">
                                <div class="btn-group span4 projets">
                                    <a style="width: 250px"  class="btn big blue dropdown-toggle" data-toggle="dropdown" href="#">
                                    <strong><?= $projet->nom() ?></strong> <i class="icon-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="projet-details.php?idProjet=<?= $projet->id() ?>">Gestion du projet</a></li>
                                        <?php
                                        if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                        ?>
                                        <li><a href="#updateProjet<?= $projet->id() ?>" data-toggle="modal" data-id="<?= $projet->id(); ?>">Modifier</a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- updateProjet box begin-->
                            <div id="updateProjet<?= $projet->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Modifier Projet <?= $projet->nom() ?></h3>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="controller/ProjetActionController.php" method="post">
                                        <p>Êtes-vous sûr de vouloir modifier ce projet ?</p>
                                        <div class="control-group">
                                            <label class="control-label">Nom</label>
                                            <div class="controls">
                                                <input type="text" name="nom" value="<?= $projet->nom() ?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Titre</label>
                                            <div class="controls">
                                                <input type="text" name="titre" value="<?= $projet->titre() ?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Budget</label>
                                            <div class="controls">
                                                <input type="text" name="budget" value="<?= $projet->budget() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Superficie</label>
                                            <div class="controls">
                                                <input type="text" name="superficie" value="<?= $projet->superficie() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Adresse</label>
                                            <div class="controls">
                                                <textarea type="text" name="adresse"><?= $projet->adresse() ?></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Description</label>
                                            <div class="controls">
                                                <textarea type="text" name="description"><?= $projet->description() ?></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">اسم المشروع</label>
                                            <div class="controls">
                                                <input type="text" name="nomArabe" value="<?= $projet->nomArabe() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">عنوان المشروع</label>
                                            <div class="controls">
                                                <input type="text" name="adresseArabe" value="<?= $projet->adresseArabe() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />  
                                                <input type="hidden" name="action" value="update" />  
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- updateProjet box end -->
                            <?php }//end foreach loop for projets elements ?>
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
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()!="admin"){
    header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}
?>