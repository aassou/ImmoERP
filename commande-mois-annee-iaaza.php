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
        //classManagers
        $projetManager = new ProjetManager($pdo);
        $fournisseurManager = new FournisseurManager($pdo);
        $commandeManager = new CommandeManager($pdo);
        $commandeDetailManager = new CommandeDetailManager($pdo);
        //classes and vars
        $commandes = "";
        $projets = $projetManager->getProjets();
        $fournisseurs = $fournisseurManager->getFournisseurs();
        $projet = $projetManager->getProjets();
        $livraisonListDeleteLink = "";
        if( isset($_GET['mois']) and isset($_GET['annee']) ){
            $mois = $_GET['mois'];
            $annee = $_GET['annee'];
            $commandes = $commandeManager->getCommandesByMonthYear($mois, $annee);
        }       
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
                            Gestion des commandes - Société Iaaza</strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-truck"></i>
                                <a href="commande-group-iaaza.php">Gestion des commandes <strong>Société Iaaza</strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <strong><?= $_GET['mois'] ?>/<?= $_GET['annee'] ?></strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- addCommande box begin-->
                        <div id="addCommande" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Nouvelle Commande</h3>
                            </div>
                            <div class="modal-body">
                                <form id="addCommandeForm" class="form-horizontal" action="controller/CommandeActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Fournisseur</label>
                                        <div class="controls">
                                            <select name="idFournisseur">
                                                <?php foreach($fournisseurs as $fournisseur){ ?>
                                                <option value="<?= $fournisseur->id() ?>"><?= $fournisseur->nom() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Projet</label>
                                        <div class="controls">
                                            <select name="idProjet">
                                                <option value="0">Plusieurs Projets</option>
                                                <?php foreach($projets as $projet){ ?>
                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date Commande</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input required="required" name="dateCommande" id="dateCommande" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">N° Commande</label>
                                        <div class="controls">
                                            <input required="required" id="numeroCommande" type="text" name="numeroCommande" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Désignation</label>
                                        <div class="controls">
                                            <input id="designation" type="text" name="designation" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">  
                                            <input type="hidden" name="action" value="add" />
                                            <input type="hidden" name="source" value="commande-mois-annee-iaaza" />
                                            <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                            <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />    
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addLivraison box end -->
                        
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <?php
                         if( isset($_SESSION['commande-action-message'])
                         and isset($_SESSION['commande-type-message']) ){ 
                            $message = $_SESSION['commande-action-message'];
                            $typeMessage = $_SESSION['commande-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['commande-action-message']);
                            unset($_SESSION['commande-type-message']);
                         ?>
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Liste des commandes</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group pull-left">
                                        <a class="btn blue" href="#addCommande" data-toggle="modal">
                                            <i class="icon-plus-sign"></i>
                                             Nouvelle Commande
                                        </a>
                                    </div>
                                    <!--div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Print</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Export to Excel</a></li>
                                        </ul>
                                    </div-->
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%">Actions</th>
                                            <th style="width: 15%">N° Commande</th>
                                            <th style="width: 20%">Projet</th>
                                            <th style="width: 20%">Fournisseur</th>
                                            <th style="width: 15%">Date commande</th>
                                            <th style="width: 15%">Articles</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                      
                                        <?php
                                        foreach($commandes as $commande){
                                            $nomProjet = "Plusieurs Projets";
                                            if ( $commande->idProjet() != 0 ) {
                                                $nomProjet = $projetManager->getProjetById($commande->idProjet())->nom();
                                            }
                                            else {
                                                $nomProjet = "Non mentionné";
                                            }
                                            $nomFournisseur = $fournisseurManager->getFournisseurById($commande->idFournisseur())->nom();
                                        ?>      
                                        <tr>
                                            <td>                             
                                                <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager" 
                                                    ) {
                                                ?>                               
                                                <a class="btn mini green" href="#updateCommande<?= $commande->id();?>" data-toggle="modal" data-id="<?= $commande->id(); ?>" title="Modifier">
                                                    <i class="icon-refresh"></i>
                                                </a>
                                                <a class="btn mini red" href="#deleteCommande<?= $commande->id() ?>" data-toggle="modal" data-id="<?= $commande->id() ?>" title="Supprimer" >
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <?php
                                                }
                                                ?>
                                                <a class="btn mini" href="commande-details-iaaza.php?codeCommande=<?= $commande->codeLivraison() ?>&mois=<?= $_GET['mois'] ?>&annee=<?= $_GET['annee'] ?>" title="Voir Détail Commande" >
                                                    <i class="icon-eye-open"></i>
                                                </a>
                                                <a class="btn mini blue" href="controller/CommandePrintController.php?idCommande=<?= $commande->id() ?>&societe=2" title="Imprimer Bon Commande" >
                                                    <i class="icon-print"></i>
                                                </a>
                                            </td>
                                            <td><?= $commande->numeroCommande() ?></td>
                                            <td><?= $nomProjet ?></td>
                                            <td><?= $nomFournisseur ?></td>
                                            <td><?= date('d/m/Y', strtotime($commande->dateCommande())) ?></td>
                                            <td>
                                                <?= $commandeDetailManager->getNombreArticleCommandeByIdCommande($commande->id()); ?>
                                            </td>
                                        </tr>
                                        <!-- updateCommande box begin-->
                                        <div id="updateCommande<?= $commande->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier les informations de la commande </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/CommandeActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir modifier la commande <strong>N°<?= $commande->numeroCommande() ?></strong>  ?</p>
                                                    <div class="control-group">
                                                        <label class="control-label">Fournisseur</label>
                                                        <div class="controls">
                                                            <select name="idFournisseur">
                                                                <option value="<?= $commande->idFournisseur() ?>"><?= $fournisseurManager->getFournisseurById($commande->idFournisseur())->nom() ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <?php foreach($fournisseurs as $fournisseur){ ?>
                                                                <option value="<?= $fournisseur->id() ?>"><?= $fournisseur->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Projet</label>
                                                        <div class="controls">
                                                            <select name="idProjet">
                                                                <option value="<?= $commande->idProjet() ?>"><?= $nomProjet ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">Non mentionné</option>
                                                                <?php foreach($projets as $projet){ ?>
                                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Date Commande</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateCommande" id="dateCommande" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $commande->dateCommande() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">N° Commande</label>
                                                        <div class="controls">
                                                            <input required="required" type="text" name="numeroCommande" value="<?= $commande->numeroCommande() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Désignation</label>
                                                        <div class="controls">
                                                            <input id="designation" type="text" name="designation" value="<?= $commande->designation() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">  
                                                            <input type="hidden" name="action" value="update" />
                                                            <input type="hidden" name="idCommande" value="<?= $commande->id() ?>" />
                                                            <input type="hidden" name="codeCommande" value="<?= $commande->codeLivraison() ?>" />
                                                            <input type="hidden" name="source" value="commande-mois-annee-iaaza" />
                                                            <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                                            <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateCommande box end -->            
                                        <!-- delete box begin-->
                                        <div id="deleteCommande<?= $commande->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer la commande </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/CommandeActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer la commande <strong>N°<?= $commande->numeroCommande() ?></strong> ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="idCommande" value="<?= $commande->id() ?>" />
                                                        <input type="hidden" name="codeCommande" value="<?= $commande->codeLivraison() ?>" />
                                                        <input type="hidden" name="source" value="commande-mois-annee-iaaza" />
                                                        <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                                        <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />  
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- delete box end --> 
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                                </div><!-- END DIV SCROLLER -->    
                            </div>
                        </div>
                        <!-- END Terrain TABLE PORTLET-->
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
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
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
    <script type="text/javascript" src="script.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        $("#addCommandeForm").validate({
            rules:{
                numeroCommande:{
                    required:true
                }
            },
            errorClass: "error-class",
            validClass: "alid-class"
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