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
        $livraisonManager = new LivraisonManager($pdo);
        $livraisonDetailManager = new LivraisonDetailManager($pdo);
        $reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
        //classes and vars
        $idFournisseur = 0;
        $projets = $projetManager->getProjets();
        $fournisseurs = $fournisseurManager->getFournisseurs();
        $projet = $projetManager->getProjets();
        $livraisonNumber = 0;
        $totalReglement = 0;
        $totalLivraison = 0;
        $titreLivraison ="Liste de toutes les livraisons";
        $hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php";
        $livraisonListDeleteLink = "";
        if( isset($_GET['idFournisseur'])){
            $idFournisseur = $_GET['idFournisseur'];
            $fournisseur = $fournisseurManager->getFournisseurById($idFournisseur);
            $livraisons = $livraisonManager->getLivraisonsByIdFournisseur($idFournisseur);
            $reglements = $reglementsFournisseurManager->getReglementFournisseursByIdFournisseur($idFournisseur);
            $titreLivraison ="Liste des réglements du fournisseur <strong>".$fournisseurManager->getFournisseurById($idFournisseur)->nom()."</strong>";
            //get the sum of livraisons details using livraisons ids (idFournisseur)
            $livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseur($idFournisseur);
            $sommeDetailsLivraisons = 0;
            foreach($livraisonsIds as $idl){
                $sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
            }   
            $totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($idFournisseur);
            $totalLivraison = 
            $livraisonManager->getTotalLivraisonsIdFournisseur($idFournisseur)+
            $sommeDetailsLivraisons;
            $hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php?idFournisseur=".$idFournisseur;
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
                            Détails des réglements - Fournisseur : <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-truck"></i>
                                <a href="livraisons-group.php">Gestion des livraisons <strong>Société Annahda</strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Détails des réglement - Fournisseur <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php
                        if ( 
                            $_SESSION['userMerlaTrav']->profil() == "admin" ||
                            $_SESSION['userMerlaTrav']->profil() == "manager" 
                            ) {
                        ?>
                        <div class="row-fluid add-portfolio">
                            <div class="pull-left">
                                <!--a href="#addFournisseur" data-toggle="modal" class="btn blue">
                                    Ajouter Nouveau Fournisseur <i class="icon-plus-sign "></i>
                                </a-->
                                <a href="#addReglement" data-toggle="modal" class="btn black">
                                    Ajouter Nouveau Réglement <i class="icon-plus-sign "></i>
                                </a>
                            </div>
                        </div>
                        <?php  
                        }
                        ?>
                        <!-- addReglement box begin-->
                        <div id="addReglement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Nouveau réglement - <strong><?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->nom() ?></strong></h3>
                            </div>
                            <div class="modal-body">
                                <form id="addReglementForm" class="form-horizontal" action="controller/ReglementFournisseurActionController.php" method="post">
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
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="action" value="add">
                                            <input type="hidden" name="source" value="reglements-fournisseur">  
                                            <input type="hidden" name="idFournisseur" value="<?= $_GET['idFournisseur'] ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addReglement box end -->
                        <!--div class="row-fluid">
                            <form action="" method="get">
                                <div class="input-box autocomplet_container">
                                    <input class="m-wrap" name="projet" id="nomProjet" type="text" placeholder="Recherche..." />
                                    <input class="m-wrap" name="projet" id="nomProjet" type="text" onkeyup="autocompletProjet()" placeholder="Projet">
                                        <ul id="projetList"></ul>
                                    </input>
                                    <input name="idFournisseur" id="idFournisseur" type="hidden" />
                                    <input name="idProjet" id="idProjet" type="hidden" />
                                    <button type="submit" class="btn red"><i class="icon-search"></i></button>
                                    <a href="#printBilanFournisseur" class="btn blue pull-right" data-toggle="modal">
                                        <i class="icon-print"></i>&nbsp;Imprimer Bilan
                                    </a>
                                </div>
                            </form>
                        </div-->
                        <!-- printCharge box begin-->
                        <div id="printBilanFournisseur" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3><i class="icon-print"></i>&nbsp;Bilan de <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong></h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/BilanFournisseurPrintController.php" method="post" enctype="multipart/form-data">
                                    <!--p><strong>Séléctionner les charges à imprimer</strong></p-->
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
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />
                                            <input type="hidden" name="societe" value="1" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- printCharge box end -->
                        <!-- BEGIN Terrain TABLE PORTLET-->
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
                        <!--table class="table table-striped table-bordered table-advance table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 15%"><strong>Σ Total Livraisons</strong></th>
                                    <th style="width: 15%"><strong><a><?php //number_format($totalLivraison, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                    <th style="width: 15%"><strong>Σ Total Réglements</strong></th>
                                    <th style="width: 15%"><strong><a><?php //number_format($totalReglement, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                    <th style="width: 15%"><strong>Σ Solde</strong></th>
                                    <th style="width: 15%"><strong><a><?php //number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?>&nbsp;DH</a></strong></th>
                                </tr>
                            </tbody>
                        </table-->
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Détails des réglements : <?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group">
                                        <a href="#printBilanFournisseur" class="btn blue" data-toggle="modal">
                                            <i class="icon-print"></i>&nbsp;Imprimer Bilan
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
                                            <?php
                                            if ( 
                                                $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                $_SESSION['userMerlaTrav']->profil() == "manager"  
                                                ) {
                                            ?>
                                            <th style="width: 10%">Actions</th>
                                            <?php
                                            }
                                            ?>
                                            <th style="width: 15%">Montant</th>
                                            <th style="width: 20%">Désignation</th>
                                            <th style="width: 15%">Date Réglement</th>
                                            <th style="width: 20%">Mode Paiement</th>
                                            <th style="width: 20%">Numéro Opération</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--form action="LivraisonListDeleteController.php<?= $livraisonListDeleteLink ?>" method="post">
                                            <button type="submit" class="btn red">Supprimer les livraisons sélectionnées</button>
                                            <br-->                                          
                                        <?php
                                        foreach($reglements as $reglement){
                                            $destination = "Plusieurs Projets";
                                            if ( $reglement->idProjet() != 0 ) {
                                                $destination = $projetManager->getProjetById($reglement->idProjet())->nom();
                                            }
                                            else {
                                                $destination = "Plusieurs Projets";
                                            }
                                        ?>      
                                        <tr class="livraisons">
                                            <?php
                                            if ( 
                                                $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                $_SESSION['userMerlaTrav']->profil() == "manager"  
                                                ) {
                                            ?>
                                            <td>                                                            
                                                <a class="btn mini green" href="#updateReglement<?= $reglement->id();?>" data-toggle="modal" data-id="<?= $reglement->id(); ?>" title="Modifier">
                                                    <i class="icon-refresh"></i>
                                                </a>
                                                <a class="btn mini red" href="#deleteReglement<?= $reglement->id() ?>" data-toggle="modal" data-id="<?= $reglement->id() ?>" title="Supprimer" >
                                                    <i class="icon-remove"></i>
                                                </a>
                                            </td>
                                            <?php
                                            }
                                            ?>
                                            <td><?= $reglement->montant() ?></td>
                                            <td><?= $destination ?></td>
                                            <td><?= date('d/m/Y', strtotime($reglement->dateReglement())) ?></td>
                                            <td><?= $reglement->modePaiement() ?></td>
                                            <td><?= $reglement->numeroCheque() ?></td>
                                        </tr>
                                        <!-- updateReglement box begin-->
                                        <div id="updateReglement<?= $reglement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier réglement - <strong><?= $fournisseurManager->getFournisseurById($_GET['idFournisseur'])->nom() ?></strong></h3>
                                            </div>
                                            <div class="modal-body">
                                                <form id="addReglementForm" class="form-horizontal" action="controller/ReglementFournisseurActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Fournisseur</label>
                                                        <div class="controls">
                                                            <select name="idFournisseur">
                                                                <option selected="selected" value="<?= $reglement->idFournisseur() ?>"><?= $fournisseurManager->getFournisseurById($reglement->idFournisseur())->nom() ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Désignation</label>
                                                        <div class="controls">
                                                            <select name="idProjet">
                                                                <option value="<?= $reglement->idProjet() ?>"><?= $destination ?></option>
                                                                <option disabled="disabled">----------------</option>
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
                                                            <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $reglement->dateReglement() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Montant</label>
                                                        <div class="controls">
                                                            <input required="required" id="montant" type="text" name="montant" value="<?= $reglement->montant() ?>" />
                                                        </div>  
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Mode de paiement</label>
                                                        <div class="controls">
                                                            <select id="modePaiement" name="modePaiement" style="width: 220px" class="m-wrap">
                                                                <option value="<?= $reglement->modePaiement() ?>"><?= $reglement->modePaiement() ?></option>
                                                                <option disabled="disabled">----------------</option>
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
                                                                <input type="text" id="numeroOperation" name="numeroCheque" value="<?= $reglement->numeroCheque() ?>">
                                                             </div>
                                                          </div>
                                                       </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="hidden" name="action" value="update">
                                                            <input type="hidden" name="source" value="reglements-fournisseur">  
                                                            <input type="hidden" name="idReglement" value="<?= $reglement->id() ?>" />
                                                            <input type="hidden" name="idFournisseur" value="<?= $reglement->idFournisseur() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateLivraison box end -->            
                                        <!-- delete box begin-->
                                        <div id="deleteReglement<?= $reglement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer le réglement</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReglementFournisseurActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer le réglement ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="idReglement" value="<?= $reglement->id() ?>" />
                                                        <input type="hidden" name="idFournisseur" value="<?= $reglement->idFournisseur() ?>" />
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
                                    <?php
                                    /*if($livraisonNumber != 0){
                                        echo $pagination;   
                                    }*/
                                    ?>
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
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
    header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}
?>