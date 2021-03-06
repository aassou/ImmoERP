<?php
    require('../app/classLoad.php'); 
    require('../db/PDOFactory.php');;
    //classes loading end
    session_start();
    if( isset($_SESSION['userImmoERPV2']) ){
        //post preocessing
        $companyID = htmlentities($_GET['companyID']);
        $mois      = htmlentities($_GET['mois']);
        $annee     = htmlentities($_GET['annee']);
        //classManagers
        $companyManager        = new CompanyManager(PDOFactory::getMysqlConnection());
        $projetManager         = new ProjetManager(PDOFactory::getMysqlConnection());
        $fournisseurManager    = new FournisseurManager(PDOFactory::getMysqlConnection());
        $commandeManager       = new CommandeManager(PDOFactory::getMysqlConnection());
        $commandeDetailManager = new CommandeDetailManager(PDOFactory::getMysqlConnection());
        //objs and vars
        $company              = $companyManager->getCompanyById($companyID);
        $commandeDetailNumber = 0;
        $titreLivraison       = "Détail de la commande";
        $commande             = "Vide";
        $fournisseur          = "Vide";
        $nomProjet            = "Non mentionné";
        $idProjet             = "";
        $fournisseurs         = $fournisseurManager->getFournisseurs();
        $projets              = $projetManager->getProjetsByCompanyID($companyID);
        if( isset($_GET['codeCommande']) ){
            $commande    = $commandeManager->getCommandeByCode($_GET['codeCommande']);
            $fournisseur = $fournisseurManager->getFournisseurById($commande->idFournisseur());
            if ( $commande->idProjet() != 0 ) {
                $nomProjet = $projetManager->getProjetById($commande->idProjet())->nom();
                $idProjet  = $projetManager->getProjetById($commande->idProjet())->id();    
            } 
            else {
                $nomProjet = "Non mentionné";
                $idProjet  = "";    
            }
            
            $commandeDetail = $commandeDetailManager->getCommandesDetailByIdCommande($commande->id());
            $nombreArticle  = $commandeDetailManager->getNombreArticleCommandeByIdCommande($commande->id());
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
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
                            Gestion des commandes
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="company-choice.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-sitemap"></i>
                                <a href="company-dashboard.php?companyID=<?= $company->id() ?>">Société <?= $company->nom() ?></a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-shopping-cart"></i>
                                <a href="commande-group.php?companyID=<?= $companyID ?>">Gestion des commandes</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="commande-mois-annee.php?mois=<?= $mois ?>&annee=<?= $annee ?>&companyID=<?= $companyID ?>"><?= $mois ?>/<?= $annee ?></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li><a><strong>Détails de Commande</strong></a></li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN ALERT MESSAGES -->
                         <?php 
                         if( isset($_SESSION['commande-detail-action-message']) 
                         and isset($_SESSION['commande-detail-type-message']) ){ 
                             $message = $_SESSION['commande-detail-action-message'];
                             $typeMessage = $_SESSION['commande-detail-type-message'];
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['commande-detail-action-message']);
                            unset($_SESSION['commande-detail-type-message']);
                         ?>
                         <!-- END  ALERT MESSAGES -->
                        <?php
                        $updateLink = "";
                        if ( 
                            $_SESSION['userImmoERPV2']->profil() == "admin" ||
                            $_SESSION['userImmoERPV2']->profil() == "user" 
                            ) {
                            $updateLink = "#updateCommande";    
                        }
                        ?>
                        <div class="portlet">
                            <!-- BEGIN PORTLET BODY -->
                            <div class="portlet-body">
                                <!-- BEGIN Livraison Form -->
                                <div class="row-fluid">
                                    <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                           <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 245px">
                                               <strong>N° Commande : <?= $commande->numeroCommande() ?></strong>
                                           </a>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                            <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 245px">
                                                <strong>Nombre Articles : <?= $nombreArticle ?></strong>
                                            </a>   
                                         </div>
                                      </div>
                                   </div>
                                    <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                            <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 245px">
                                                <strong>Date Commande : <?= date('d/m/Y', strtotime($commande->dateCommande())) ?></strong>
                                            </a>
                                         </div>
                                      </div>
                                   </div>
                                    <div class="span3">
                                      <div class="control-group">
                                         <div class="controls">
                                            <a class="btn" href="<?= $updateLink ?>" data-toggle="modal" style="width: 245px">
                                                <strong>Projet : <?= $nomProjet ?></strong>
                                            </a>   
                                         </div>
                                      </div>
                                   </div>
                                </div>
                            <!-- END Livraison Form -->
                            <!-- updateLivraison box begin-->
                            <div id="updateCommande" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <form id="update-livraison-form" class="form-horizontal" action="../controller/CommandeActionController.php" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Modifier les informations de la commande </h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="control-group">
                                            <label class="control-label">Fournisseur</label>
                                            <div class="controls">
                                                <select name="idFournisseur">
                                                    <option value="<?= $fournisseur->id() ?>"><?= $fournisseur->nom() ?></option>
                                                    <option disabled="disabled">------------</option>
                                                    <?php foreach($fournisseurs as $fourn){ ?>
                                                    <option value="<?= $fourn->id() ?>"><?= $fourn->nom() ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Projet</label>
                                            <div class="controls">
                                                <select name="idProjet">
                                                    <option value="<?= $idProjet ?>"><?= $nomProjet ?></option>
                                                    <option disabled="disabled">------------</option>
                                                    <option value="0">Non mentionnée</option>
                                                    <?php foreach($projets as $pro){ ?>
                                                    <option value="<?= $pro->id() ?>"><?= $pro->nom() ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Date Commande</label>
                                            <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                <input name="dateCommande" id="dateCommande" class="m-wrap m-ctrl-small date-picker" type="text" value="<?=$commande->dateCommande() ?>" />
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                             </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">N° Commande</label>
                                            <div class="controls">
                                                <input required="required" id="numeroCommande" type="text" name="numeroCommande" value="<?= $commande->numeroCommande() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Désignation</label>
                                            <div class="controls">
                                                <input id="designation" type="text" name="designation" value="<?= $commande->designation() ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="control-group">  
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="source" value="commande-details" />
                                            <input type="hidden" name="companyID" value="<?= $companyID ?>" />
                                            <input type="hidden" name="mois" value="<?= $mois ?>" />
                                            <input type="hidden" name="annee" value="<?= $annee ?>" />
                                            <input type="hidden" name="codeCommande" value="<?= $commande->codeLivraison() ?>" />
                                            <input type="hidden" name="idCommande" value="<?= $commande->id() ?>" />
                                            <div class="controls">    
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- addLivraison box end -->
                            <!-- BEGIN Ajouter Article Link -->
                            <a target="_blank" href="../controller/CommandePrintController.php?idCommande=<?= $commande->id() ?>&companyID=<?= $companyID ?>" class="get-down btn blue pull-right">
                                <i class="icon-print"></i>&nbsp;Bon de Commande
                            </a>
                            <?php  
                            if ( 
                                $_SESSION['userImmoERPV2']->profil() == "admin" || 
                                $_SESSION['userImmoERPV2']->profil() == "user" 
                                ) {
                            ?>
                            <a class="btn green" href="#addArticle" data-toggle="modal" data-id="">
                                Ajouter un article <i class="icon-plus "></i>
                            </a>
                            <?php  
                            }
                            ?>
                            <!-- END Ajouter Article Link -->
                            <!-- BEGIN addArticle Box -->
                            <div id="addArticle" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <form id="add-detail-commande-form" class="form-horizontal" action="../controller/CommandeDetailActionController.php" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Ajouter un article</h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="control-group">
                                            <label class="control-label">Reference</label>
                                            <div class="controls">
                                                <input type="text" name="reference" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Libelle</label>
                                            <div class="controls">
                                                <input required="required" type="text" id="libelle" name="libelle" value="" />
                                            </div>  
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Quantité</label>
                                            <div class="controls">
                                                <input required="required" type="text" id="quantite" name="quantite" value="" />
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="control-group">  
                                            <input type="hidden" name="action" value="add" />
                                            <input type="hidden" name="companyID" value="<?= $companyID ?>" />
                                            <input type="hidden" name="mois" value="<?= $mois ?>" />
                                            <input type="hidden" name="annee" value="<?= $annee ?>" />
                                            <input type="hidden" name="idCommande" value="<?= $commande->id() ?>" />
                                            <input type="hidden" name="codeCommande" value="<?= $commande->codeLivraison() ?>" />
                                            <div class="controls">  
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- END addArticle BOX -->
                            <br><br>
                            <!-- BEGIN LivraisonDetail TABLE -->
                            <?php
                            if( 1 ){
                            ?>
                            <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <?php  
                                if ( 
                                    $_SESSION['userImmoERPV2']->profil() == "admin" ||
                                    $_SESSION['userImmoERPV2']->profil() == "user" 
                                    ) {
                                ?>
                                <th style="width: 10%">Actions</th>
                                <?php  
                                }
                                ?>
                                <th style="width: 30%">Reference</th>
                                <th style="width: 30%">Libelle</th>
                                <th style="width: 30%">Quantité</th>
                            </tr>
                            <?php
                            foreach($commandeDetail as $detail){
                            ?>
                            <tr>
                                <?php  
                                if ( 
                                    $_SESSION['userImmoERPV2']->profil() == "admin" ||
                                    $_SESSION['userImmoERPV2']->profil() == "user" 
                                    ) {
                                ?>
                                <td>
                                    <a class="btn mini green" href="#updateCommandeDetail<?= $detail->id();?>" data-toggle="modal" data-id="<? $detail->id(); ?>">
                                        <i class="icon-refresh "></i>
                                    </a>
                                    <a class="btn mini red" href="#deleteCommandeDetail<?= $detail->id();?>" data-toggle="modal" data-id="<? $detail->id(); ?>">
                                        <i class="icon-remove "></i>
                                    </a>
                                </td>
                                <?php  
                                }
                                ?>
                                <td>
                                    <?= $detail->reference() ?>
                                </td>
                                <td>
                                    <?= $detail->libelle() ?>
                                </td>
                                <td>
                                    <?= $detail->quantite() ?>
                                </td>
                            </tr>
                            <!-- BEGIN  updateCommandeDetail BOX -->
                            <div id="updateCommandeDetail<?= $detail->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <form id="update-detail-commande-form" class="form-horizontal" action="../controller/CommandeDetailActionController.php" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Modifier Article </h3>
                                    </div>
                                    <div class="modal-body">
                                        <div class="control-group">
                                            <label class="control-label" for="reference">Reference</label>
                                            <div class="controls">
                                                <input name="reference" class="m-wrap" type="text" value="<?= $detail->reference() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="libelle">Libelle</label>
                                            <div class="controls">
                                                <input required="required" id="libelle" name="libelle" class="m-wrap" type="text" value="<?= $detail->libelle() ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="quantite">Quantité</label>
                                            <div class="controls">
                                                <input required="required" id="quantite" name="quantite" class="m-wrap" type="text" value="<?= $detail->quantite() ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="control-group">
                                            <input type="hidden" name="action" value="update" />
                                            <input type="hidden" name="companyID" value="<?= $companyID ?>" />
                                            <input type="hidden" name="mois" value="<?= $mois ?>" />
                                            <input type="hidden" name="annee" value="<?= $annee ?>" />
                                            <input type="hidden" name="idCommandeDetail" value="<?= $detail->id() ?>" />
                                            <input type="hidden" name="codeCommande" value="<?= $commande->codeLivraison() ?>" />
                                            <div class="controls">  
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- END  update LivraisonDetail   BOX -->
                            <!-- BEGIN  delete LivraisonDetail BOX -->
                            <div id="deleteCommandeDetail<?= $detail->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <form class="form-horizontal loginFrm" action="../controller/CommandeDetailActionController.php" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Supprimer Article</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p class="dangerous-action">Êtes-vous sûr de vouloir supprimer cet article <strong><?= $detail->libelle() ?></strong> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="control-group">
                                            <input type="hidden" name="action" value="delete" />
                                            <input type="hidden" name="companyID" value="<?= $companyID ?>" />
                                            <input type="hidden" name="mois" value="<?= $mois ?>" />
                                            <input type="hidden" name="annee" value="<?= $annee ?>" />
                                            <input type="hidden" name="idCommandeDetail" value="<?= $detail->id() ?>" />
                                            <input type="hidden" name="codeCommande" value="<?= $commande->codeLivraison() ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- END delete LivraisonDetail BOX -->
                            <?php
                            }//end foreach
                            ?>
                            </table>
                            <?php
                            }//end if
                            ?>
                            <!-- END LivraisonDetail TABLE -->
                            </div>
                            <!-- END  PORTLET BODY  -->
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
            //App.setPage("table_editable");
            App.init();
        });
        $("#add-detail-commande-form").validate({
            rules:{
                quantite:{
                    number: true,
                    required:true
                },
                reference:{
                    required:true
                }
            },
            errorClass: "error-class",
            validClass: "alid-class"
        });
        $("#update-detail-commande-form").validate({
            rules:{
                quantite:{
                    number: true,
                    required:true
                },
                reference:{
                    required:true
                }
            },
            errorClass: "error-class",
            validClass: "valid-class"
        });
    </script>
</body>
<!-- END BODY -->
</html>
<?php
}
/*else if(isset($_SESSION['userImmoERPV2']) and $_SESSION->profil()!="admin"){
    header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}
?>