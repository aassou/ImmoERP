<?php
    require('../app/classLoad.php');
    require('../db/PDOFactory.php');;  
    //classes loading end
    session_start();
    if ( isset($_SESSION['userImmoERPV2']) ) {
        //classManagers
        $companyManager               = new CompanyManager(PDOFactory::getMysqlConnection());
        $projetManager                = new ProjetManager(PDOFactory::getMysqlConnection());
        $fournisseurManager           = new FournisseurManager(PDOFactory::getMysqlConnection());
        $livraisonManager             = new LivraisonManager(PDOFactory::getMysqlConnection());
        $livraisonDetailManager       = new LivraisonDetailManager(PDOFactory::getMysqlConnection());
        $reglementsFournisseurManager = new ReglementFournisseurManager(PDOFactory::getMysqlConnection());
        //classes and vars
        $companyID     = $_GET['companyID'];
        $idFournisseur = 0;
        $company       = $companyManager->getCompanyById($companyID);
        $projets       = $projetManager->getProjetsByCompanyID($companyID);
        $fournisseurs  = $fournisseurManager->getFournisseurs();
        $projet        = $projetManager->getProjetsByCompanyID($companyID);
        $livraisonNumber = 0;
        $totalReglement = 0;
        $totalLivraison = 0;
        $titreLivraison ="Liste de toutes les livraisons";
        $hrefLivraisonBilanPrintController = "controller/LivraisonBilanPrintController.php?companyID=$companyID";
        $livraisonListDeleteLink = "";
        if( isset($_GET['idFournisseur']) and !empty($_GET['idProjet']) and 
        $fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']>=1)){
            $fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
            $idProjet = $_GET['idProjet'];
            $livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseurByProjet($fournisseur, $idProjet);
            if($livraisonNumber != 0){
                /*$livraisonPerPage = 10;
                $pageNumber = ceil($livraisonNumber/$livraisonPerPage);
                $p = 1;
                if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
                    $p = $_GET['p'];
                }
                else{
                    $p = 1;
                }*/
                $livraisonListDeleteLink = "?idFournisseur=".$_GET['idFournisseur']."&idProjet=".$_GET['idProjet']."&p=".$p;
                $begin = ($p - 1) * $livraisonPerPage;
                $pagination = paginate('livraisons2.php?idFournisseur='.$_GET['idFournisseur'].'&idProjet='.$_GET['idProjet'], '&p=', $pageNumber, $p);
                $livraisons = $livraisonManager->getLivraisonsByIdFournisseurByProjetByLimits($fournisseur, $idProjet, $begin, $livraisonPerPage);
                $titreLivraison = "Liste des livraisons du fournisseur <strong>"
                .$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong> / Projet: <strong>"
                .$projetManager->getProjetById($idProjet)->nom()."</strong>";   
                $totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseurByProjet($fournisseur, $idProjet);
                //get the sum of livraisons details using livraisons ids (idProjet and idFournisseur)
                $livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseurIdProjet($fournisseur, $idProjet);
                $sommeDetailsLivraisons = 0;
                foreach($livraisonsIds as $idl){
                    $sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
                }
                $totalLivraison = 
                $livraisonManager->getTotalLivraisonsIdFournisseurProjet($fournisseur, $idProjet) +
                $sommeDetailsLivraisons;
                $hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php?idFournisseur=".$fournisseur."&idProjet=".$idProjet;
            }
        }
        else if( isset($_GET['idFournisseur']) and isset($_GET['mois']) and isset($_GET['annee']) ){
            $idFournisseur = $_GET['idFournisseur'];
            $mois = $_GET['mois'];
            $annee = $_GET['annee'];
            $fournisseur = $fournisseurManager->getFournisseurById($idFournisseur);
            $livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($idFournisseur);
            if($livraisonNumber != 0){
                /*$livraisonPerPage = 100;
                $pageNumber = ceil($livraisonNumber/$livraisonPerPage);
                $p = 1;
                if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
                    $p = $_GET['p'];
                }
                else{
                    $p = 1;
                }*/
                $livraisonListDeleteLink = "?idFournisseur=".$_GET['idFournisseur'];
                //$begin = ($p - 1) * $livraisonPerPage;
                //$pagination = paginate('livraisons-fournisseur.php?idFournisseur='.$_GET['idFournisseur'], '&p=', $pageNumber, $p);
                //$livraisons = $livraisonManager->getLivraisonsByIdFournisseurByLimits($idFournisseur, $begin, $livraisonPerPage);
                $livraisons = $livraisonManager->getLivraisonsByIdFournisseurByMoisByAnnee($idFournisseur, $mois, $annee);
                $titreLivraison ="Liste des livraisons du fournisseur <strong>".$fournisseurManager->getFournisseurById($idFournisseur)->nom()."</strong>";
                //get the sum of livraisons details using livraisons ids (idFournisseur)
                $livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseur($idFournisseur);
                $sommeDetailsLivraisons = 0;
                foreach($livraisonsIds as $idl){
                    $sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
                }   
                $totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($idFournisseur, $companyID);
                $totalLivraison = 
                $livraisonManager->getTotalLivraisonsIdFournisseur($idFournisseur)+
                $sommeDetailsLivraisons;
                $hrefLivraisonBilanPrintController = "controller/LivraisonBilanPrintController.php?idFournisseur=".$idFournisseur;
            }
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
                            Gestion des livraisons
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="company-choice.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-sitemap"></i>
                                <a href="company-dashboard.php?companyID=<?= $companyID ?>">Société <?= $company->nom() ?></a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-truck"></i>
                                <a href="livraisons-group.php?companyID=<?= $companyID ?>">Gestion des livraisons</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="livraisons-fournisseur-mois.php?companyID=<?= $companyID ?>&idFournisseur=<?= $idFournisseur ?>"><?= ucfirst($fournisseurManager->getFournisseurById($idFournisseur)->nom()) ?> 
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
                        <?php
                         if( isset($_SESSION['livraison-action-message'])
                         and isset($_SESSION['livraison-type-message']) ){ 
                            $message = $_SESSION['livraison-action-message'];
                            $typeMessage = $_SESSION['livraison-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['livraison-action-message']);
                            unset($_SESSION['livraison-type-message']);
                         ?>
                         <?php
                         if( isset($_SESSION['reglement-action-message'])
                         and isset($_SESSION['reglement-type-message']) ){ 
                            $message = $_SESSION['reglement-action-message'];
                            $typeMessage = $_SESSION['reglement-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['reglement-action-message']);
                            unset($_SESSION['reglement-type-message']);
                         ?>
                        <?php
                            if ( 
                                $_SESSION['userImmoERPV2']->profil() == "admin" ||
                                $_SESSION['userImmoERPV2']->profil() == "manager" ||
                                $_SESSION['userImmoERPV2']->profil() == "user"
                                ) {
                        ?>
                        <div>
                            <div class="pull-left">
                                <a href="#addReglement" data-toggle="modal" class="btn black">
                                    Ajouter Nouveau Réglement <i class="icon-plus-sign "></i>
                                </a>
                            </div>
                            <div class="pull-right get-down">
                                <a href="#addLivraison" data-toggle="modal" class="btn green">
                                    Ajouter Nouvelle Livraison <i class="icon-plus-sign "></i>
                                </a>
                            </div>
                        </div>
                        <?php  
                        }
                        ?>
                        <!-- addLivraison box begin-->
                        <div id="addLivraison" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <form id="addLivraisonForm" class="form-horizontal" action="../controller/LivraisonActionController.php" method="post">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Nouvelle livraison - <strong><?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->nom() ?></strong></h3>
                                </div>
                                <div class="modal-body">
                                    <div class="control-group">
                                        <label class="control-label">Fournisseur</label>
                                        <div class="controls">
                                            <select name="idFournisseur">
                                                <option selected="selected" value="<?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->id() ?>">
                                                    <?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->nom() ?>
                                                </option>
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
                                        <label class="control-label">Date Livraison</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input required="required" name="dateLivraison" id="dateLivraison" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">N° BL</label>
                                        <div class="controls">
                                            <input required="required" id="libelle" type="text" name="libelle" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Désignation</label>
                                        <div class="controls">
                                            <input id="designation" type="text" name="designation" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="control-group">  
                                        <input type="hidden" name="action" value="add" />
                                        <input type="hidden" name="source" value="livraisons-fournisseur-mois-list" />
                                        <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                        <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />
                                        <input type="hidden" name="companyID" value="<?= $companyID ?>" />  
                                        <div class="controls">    
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- addLivraison box end -->
                        <!-- addReglement box begin-->
                        <div id="addReglement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <form id="addReglementForm" class="form-horizontal" action="../controller/ReglementFournisseurActionController.php" method="post">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Nouveau réglement - <strong><?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->nom() ?></strong></h3>
                                </div>
                                <div class="modal-body">
                                    <div class="control-group">
                                        <label class="control-label">Fournisseur</label>
                                        <div class="controls">
                                            <select name="idFournisseur">
                                                <option selected="selected" value="<?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->id() ?>">
                                                    <?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->nom() ?>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Désignation</label>
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
                                        <label class="control-label">Date Réglement</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Montant</label>
                                        <div class="controls">
                                            <input required="required" id="montant" type="text" name="montant" value="" />
                                        </div>  
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Mode de paiement</label>
                                        <div class="controls">
                                            <select id="modePaiement" name="modePaiement" style="width: 220px" class="m-wrap">
                                                <option value="Especes">Especes</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Versement">Versement</option>
                                                <option value="Virement">Virement</option>
                                                <option value="LetterDeChange">Lettre De Change</option>
                                                <option value="Remise">Remise</option>
                                            </select>
                                        </div>  
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">Numéro Operation</label>
                                             <div class="controls">
                                                <input type="text" required="required" id="numeroOperation" name="numeroCheque">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="control-group">
                                        <input type="hidden" name="action" value="add" />
                                        <input type="hidden" name="source" value="livraisons-fournisseur-mois-list" />
                                        <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                        <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />  
                                        <input type="hidden" name="idFournisseur" value="<?= $_GET['idFournisseur'] ?>" />
                                        <input type="hidden" name="companyID" value="<?= $companyID ?>" />  
                                        <div class="controls">
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- addReglement box end -->
                        <!-- printCharge box begin-->
                        <div id="printBilanFournisseur" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <form  target="_blank" class="form-horizontal" action="../controller/BilanFournisseurPrintController.php" method="post" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3><i class="icon-print"></i>&nbsp;Bilan de <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong></h3>
                                </div>
                                <div class="modal-body">
                                    <div class="control-group">
                                      <label class="control-label">Imprimer</label>
                                      <div class="controls">
                                         <label class="radio">
                                             <div class="radio" id="toutes">
                                                 <span>
                                                     <input type="radio" class="criteriaPrint" name="criteria" value="toutesLivraison" style="opacity: 0;">
                                                 </span>
                                             </div> Bilan complet
                                         </label>
                                         <label class="radio">
                                             <div class="radio" id="date">
                                                 <span class="checked">
                                                     <input type="radio" class="criteriaPrint" name="criteria" value="parChoix" checked="" style="opacity: 0;">
                                                 </span>
                                             </div> Par Choix
                                         </label>  
                                      </div>
                                   </div>
                                   <div id="showChoice">
                                        <div class="control-group">
                                            <label class="control-label">Date</label>
                                            <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                               <input style="width:100px" name="dateFrom" id="dateFrom" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                               &nbsp;-&nbsp;
                                               <input style="width:100px" name="dateTo" id="dateTo" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label"></label>
                                          <div class="controls">
                                             <label class="checkbox">
                                                 <div class="checkbox">
                                                     <span>
                                                         <input type="checkbox" name="livraisons" value="livraison" checked="checked" style="opacity: 0;">
                                                     </span>Livraisons
                                                 </div>
                                             </label>
                                             <label class="checkbox">
                                                 <div class="checkbox">
                                                     <span class="checked">
                                                         <input type="checkbox" name="reglements" value="reglements" style="opacity: 0;">
                                                     </span>Réglements
                                                 </div> 
                                             </label>  
                                          </div>
                                       </div>
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="control-group">
                                        <input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />
                                        <input type="hidden" name="societe" value="1" />
                                        <input type="hidden" name="companyID" value="<?= $companyID ?>" />
                                        <div class="controls">
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- printCharge box end -->
                        <!-- updateStatusLivraison box begin-->
                        <div id="updateStatusLivraison" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <form class="form-horizontal" action="../controller/LivraisonActionController.php" method="post">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Modifier Status des BLs </h3>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    foreach ( $livraisons as $livraison ) {
                                    ?> 
                                    <div class="control-group">
                                       <label class="control-label"></label>
                                        <div class="controls">
                                          <label class="checkbox line">
                                          <div class="checker" id="uniform-undefined">
                                              <span class="">
                                                  <input type="checkbox" name="bl[]" value="<?= $livraison->id() ?>" style="opacity: 0;">
                                              </span>
                                          </div>
                                          <?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?> | BL <?= $livraison->libelle() ?> | <?= ($livraison->status()==0)?"Non payé":"Payé"; ?>   
                                          </label>
                                       </div>   
                                    </div>
                                    <?php    
                                    }
                                    ?>
                                    <div class="control-group">
                                        <label class="control-label">Status</label>
                                        <div class="controls">
                                            <select name="status">
                                                <option value="0">Non payé</option>
                                                <option value="1">Payé</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="control-group">
                                        <input type="hidden" name="action" value="updateStatus" />
                                        <input type="hidden" name="idFournisseur" value="<?= $_GET['idFournisseur'] ?>" />
                                        <input type="hidden" name="source" value="livraisons-fournisseur-mois-list" />
                                        <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                        <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />
                                        <input type="hidden" name="companyID" value="<?= $companyID ?>" />  
                                        <div class="controls">  
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- updateStatusLivraison box end -->     
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Livraison de <?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    
                                    <div class="btn-group pull-right">
                                        <a href="#printBilanFournisseur" class="btn blue" data-toggle="modal">
                                            <i class="icon-print"></i>&nbsp;Imprimer Bilan
                                        </a>
                                    </div>
                                    <div class="btn-group pull-left">
                                        <a href="#updateStatusLivraison" class="btn purple pull-left" data-toggle="modal">
                                            <i class="icon-check"></i>&nbsp;Modifier Status BL
                                        </a>
                                    </div>
                                </div>
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%">Actions</th>
                                            <th style="width: 15%">N° BL</th>
                                            <th style="width: 20%">Projet</th>
                                            <th style="width: 15%">Date Livraison</th>
                                            <th style="width: 15%">Articles</th>
                                            <th style="width: 10%">Total</th>
                                            <th style="width: 10%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--form action="LivraisonListDeleteController.php<?= $livraisonListDeleteLink ?>" method="post">
                                            <button type="submit" class="btn red">Supprimer les livraisons sélectionnées</button>
                                            <br-->                                          
                                        <?php
                                        $grandTotal = 0;
                                        if($livraisonNumber != 0){
                                        foreach($livraisons as $livraison){
                                            $grandTotal += $livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
                                            $nomProjet = "Plusieurs Projets";
                                            if ( $livraison->idProjet() != 0 ) {
                                                $nomProjet = $projetManager->getProjetById($livraison->idProjet())->nom();
                                            }
                                            else {
                                                $nomProjet = "Plusieurs Projets";
                                            }
                                            $status = '<a style="width:50px" class="btn mini red">Non Payé</a>';
                                            if ( $livraison->status() != 0 ) {
                                                $status = '<a style="width:50px" class="btn mini green">Payé</a>';
                                            } 
                                        ?>      
                                        <tr class="livraisons">
                                            <td>                             
                                                <?php
                                                if ( 
                                                    $_SESSION['userImmoERPV2']->profil() == "admin" ||
                                                    $_SESSION['userImmoERPV2']->profil() == "manager" 
                                                    ) {
                                                ?>                               
                                                <a class="btn mini green" href="#updateLivraison<?= $livraison->id();?>" data-toggle="modal" data-id="<?= $livraison->id(); ?>" title="Modifier">
                                                    <i class="icon-refresh"></i>
                                                </a>
                                                <a class="btn mini red" href="#deleteLivraison<?= $livraison->id() ?>" data-toggle="modal" data-id="<?= $livraison->id() ?>" title="Supprimer" >
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <?php
                                                }
                                                ?>
                                                <a class="btn mini" href="livraisons-details.php?codeLivraison=<?= $livraison->code() ?>&mois=<?= $_GET['mois'] ?>&annee=<?= $_GET['annee'] ?>&companyID=<?= $companyID ?>" title="Voir Détail Livraison" >
                                                    <i class="icon-eye-open"></i>
                                                </a>
                                            </td>
                                            <td><?= $livraison->libelle() ?></td>
                                            <td><?= $nomProjet ?></td>
                                            <td><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
                                            <td>
                                                <?= $livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id()); ?>
                                            </td>
                                            <td>
                                                <?= number_format($livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id()), 2, ',', ' '); ?>
                                            </td>
                                            <td><?= $status ?></td>
                                        </tr>
                                        <!-- updateLivraison box begin-->
                                        <div id="updateLivraison<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <form class="form-horizontal" action="../controller/LivraisonActionController.php" method="post">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h3>Modifier les informations de la livraison </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="control-group">
                                                        <label class="control-label">Fournisseur</label>
                                                        <div class="controls">
                                                            <select name="idFournisseur">
                                                                <option value="<?= $livraison->idFournisseur() ?>"><?= $fournisseurManager->getFournisseurById($livraison->idFournisseur())->nom() ?></option>
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
                                                                <option value="<?= $livraison->idProjet() ?>"><?= $nomProjet ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">Plusieurs Projets</option>
                                                                <?php foreach($projets as $projet){ ?>
                                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Date Livraison</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateLivraison" id="dateLivraison" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $livraison->dateLivraison() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">N° BL</label>
                                                        <div class="controls">
                                                            <input required="required" type="text" name="libelle" value="<?= $livraison->libelle() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Désignation</label>
                                                        <div class="controls">
                                                            <input id="designation" type="text" name="designation" value="<?= $livraison->designation() ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="control-group">  
                                                        <input type="hidden" name="action" value="update" />
                                                        <input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
                                                        <input type="hidden" name="idFournisseur" value="<?= $_GET['idFournisseur'] ?>" />
                                                        <input type="hidden" name="source" value="livraisons-fournisseur-mois-list" />
                                                        <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                                        <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />
                                                        <input type="hidden" name="companyID" value="<?= $companyID ?>" />
                                                        <div class="controls">    
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- updateLivraison box end -->            
                                        <!-- delete box begin-->
                                        <div id="deleteLivraison<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <form class="form-horizontal loginFrm" action="../controller/LivraisonActionController.php" method="post">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h3>Supprimer la livraison </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Êtes-vous sûr de vouloir supprimer la livraison <strong>N°<?= $livraison->id() ?></strong> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="control-group">
                                                    <label class="right-label"></label>
                                                    <input type="hidden" name="action" value="delete" />
                                                    <input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
                                                    <input type="hidden" name="idFournisseur" value="<?= $_GET['idFournisseur'] ?>" />
                                                    <input type="hidden" name="mois" value="<?= $_GET['mois'] ?>" />
                                                    <input type="hidden" name="annee" value="<?= $_GET['annee'] ?>" />  
                                                    <input type="hidden" name="companyID" value="<?= $companyID ?>" />
                                                        <div class="controls">  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>    
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- delete box end --> 
                                        <?php
                                        }//end of loop
                                        }//end of if
                                        ?>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <tbody>
                                        <tr>
                                            <th style="width: 65%"></th>
                                            <th style="width: 15%">Grand Total</th>
                                            <th style="width: 20%"><a><?= number_format($grandTotal, '2', ',', ' ') ?></a>&nbsp;DH</th>
                                        </tr>
                                    </tbody>
                                </table>    
                                <!--table class="table table-striped table-bordered table-advance table-hover">
                                    <tbody>
                                        <tr>
                                            <th style="width: 15%"><strong>Σ Total Livraisons</strong></th>
                                            <th style="width: 15%"><strong><a id="totalLivraison"><?php //number_format($totalLivraison, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                            <th style="width: 15%"><strong>Σ Total Réglements</strong></th>
                                            <th style="width: 15%"><strong><a><?php //number_format($totalReglement, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                            <th style="width: 15%"><strong>Σ Solde</strong></th>
                                            <th style="width: 15%"><strong><a><?php //number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                        </tr>
                                    </tbody>
                                </table-->
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
        $('.livraisons').show();
        $('#nomProjet').keyup(function(){
           $('.livraisons').hide();
           var txt = $('#nomProjet').val();
           $('.livraisons').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        });
        $('.criteriaPrint').on('change',function(){
            if( $(this).val()==="toutesLivraison" ) {
            $("#showChoice").hide()
            }
            else{
            $("#showChoice").show()
            }
        });
        $("#addLivraisonForm").validate({
            rules:{
                libelle:{
                    required:true
                }
            },
            errorClass: "error-class",
            validClass: "alid-class"
        });
        $("#addReglementForm").validate({
            rules:{
                montant:{
                    number: true,
                    required:true
                },
                numeroOperation:{
                    number: true,
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