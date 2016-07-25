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
        //classes managers
        $releveBancaireManager = new ReleveBancaireManager($pdo);
        $chargesCommunsManager = new ChargeCommunManager($pdo);
        $typeChargeCommunManager = new TypeChargeCommunManager($pdo);
        $typeChargeProjetManager = new TypeChargeManager($pdo);
        $projetManager = new ProjetManager($pdo);
        $compteBancaireManager = new CompteBancaireManager($pdo);
        //obj and vars
        $typeChargesCommuns = $typeChargeCommunManager->getTypeCharges();
        $typeChargesProjets = $typeChargeProjetManager->getTypeCharges();
        $projets = $projetManager->getProjets();
        $releveBancaires = $releveBancaireManager->getLastRow();
        //print_r($releveBancaires);
        $comptesBancaires = $compteBancaireManager->getCompteBancaires();
        $debit = $releveBancaireManager->getTotalDebit();
        $credit = $releveBancaireManager->getTotalCredit();
        $solde = $credit - $debit;
        $_SESSION['releve-bancaire-archive-print'] = $releveBancaires;
        if ( isset($_SESSION['releve-bancaire-archive']) ) {
            $releveBancaires = $_SESSION['releve-bancaire-archive'];
            $_SESSION['releve-bancaire-archive-print'] = $releveBancaires;    
            unset($_SESSION['releve-bancaire-archive']);
        }
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
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/style_responsive.css" rel="stylesheet" />
    <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
    <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
        <?php 
        include("include/top-menu.php"); 
        $alerts = $alertManager->getAlerts();
        ?>   
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
                            Archive des Relevés Bancaires 
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-envelope"></i>
                                <a>Archive des Relevés Bancaires <?php //date('h:i'); ?></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <!-- BEGIN PORTLET-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php
                         if( isset($_SESSION['releveBancaire-action-message'])
                         and isset($_SESSION['releveBancaire-type-message']) ){ 
                            $message = $_SESSION['releveBancaire-action-message'];
                            $typeMessage = $_SESSION['releveBancaire-type-message'];    
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['releveBancaire-action-message']);
                            unset($_SESSION['releveBancaire-type-message']);
                         ?>
                        <div class="portlet">
                            <div class="portlet-title line">
                                <h4><i class="icon-envelope"></i>Trouver un relevé bancaire</h4>
                                <!--div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div-->
                            </div>
                            <div class="portlet-body" id="chats">
                                <form action="controller/ReleveBancaireActionController.php" method="POST" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Compte bancaire</label>
                                        <div class="controls">
                                            <select name="idCompteBancaire" class="m-wrap" >
                                                <?php foreach($comptesBancaires as $compte){ ?>
                                                <option value="<?= $compte->id() ?>"><?= $compte->numero() ?></option>
                                                <?php } ?>    
                                            </select>    
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Dates</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateFrom" id="dateFrom" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" /> - 
                                            <input name="dateTo" id="dateTo" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                         </div>
                                    </div>
                                    <div class="btn-cont"> 
                                        <input type="hidden" name="action" value="search-archive" />
                                        <input type="hidden" name="source" value="releve-bancaire-archive" />
                                        <button type="submit" class="btn blue icn-only"><i class="icon-search icon-white"></i>&nbsp;Chercher</button>
                                    </div>
                                </form>
                                <!-- deleteReleveActuel box begin-->
                                <div id="deleteReleveActuel" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Supprimer Relevé Actuel</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal loginFrm" action="controller/ReleveBancaireActionController.php" method="post">
                                            <p>Êtes-vous sûr de vouloir supprimer ce relevé actuel ?</p>
                                            <div class="control-group">
                                                <label class="right-label"></label>
                                                <input type="hidden" name="action" value="deleteReleveActuel" />
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- deleteReleveActuel box end -->     
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN RELEVE PORTLET-->               
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Les Relevés Bancaires</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group pull-right">
                                        <a target="_blank" class="btn green" href="controller/ReleveBancaireArchiveController.php"><i class="icon-print"></i>&nbsp;Imprimer</a>
                                        <!--button class="btn dropdown-toggle" data-toggle="dropdown">Outils <i class="icon-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Print</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Export to Excel</a></li>
                                        </ul-->
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th style="width:10%;">DateOpe</th>
                                            <th style="width:10%;">DateVal</th>
                                            <th style="width:20%;">Libelle</th>
                                            <th style="width:10%;">Reference</th>
                                            <th style="width:15%;">Débit</th>
                                            <th style="width:15%;">Crédit</th>
                                            <th style="width:10%;">Projet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($releveBancaires as $releve){
                                            $numeroCompte = $compteBancaireManager->getCompteBancaireById($releve->idCompteBancaire())->numero();
                                        ?>
                                        <tr class="odd gradeX">
                                            <td class="hidden"></td>
                                            <td><?= $releve->dateOpe() ?></td>
                                            <td><?= $releve->dateVal() ?></td>
                                            <td><?= $releve->libelle() ?></td>
                                            <td><?= $releve->reference() ?></td>
                                            <td><?= number_format($releve->debit(), 2, ',', ' ' ) ?></td>
                                            <td><?= number_format($releve->credit(), 2, ',', ' ') ?></td>
                                            <td><?= $releve->projet() ?></td>
                                        </tr>
                                        <!-- updateReleve box begin-->
                                        <div id="update<?= $releve->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier les informations du relevé </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/ReleveBancaireActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Compte bancaire</label>
                                                        <div class="controls">
                                                            <select name="idCompteBancaire" class="m-wrap" >
                                                                <option value="<?= $releve->idCompteBancaire() ?>"><?= $numeroCompte ?></option>
                                                                <option disabled="disabled">----------------------</option>
                                                                <?php foreach($comptesBancaires as $compte){ ?>
                                                                <option value="<?= $compte->id() ?>"><?= $compte->numero() ?></option>
                                                                <?php } ?>    
                                                            </select>    
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">DateOpe</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateOpe" id="dateOpe" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $releve->dateOpe() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">DateVal</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateVal" id="dateVal" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $releve->dateVal() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Libelle</label>
                                                        <div class="controls">
                                                            <textarea class="textarea-width" rows="3" name="libelle"><?= $releve->libelle() ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Reference</label>
                                                        <div class="controls">
                                                            <input type="text" name="reference" value="<?= $releve->reference() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Débit</label>
                                                        <div class="controls">
                                                            <input type="text" name="debit" value="<?= $releve->debit() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Crédit</label>
                                                        <div class="controls">
                                                            <input type="text" name="credit" value="<?= $releve->credit() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Projet</label>
                                                        <div class="controls">
                                                            <input type="text" name="projet" value="<?= $releve->projet() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="idReleveBancaire" value="<?= $releve->id() ?>" />
                                                        <input type="hidden" name="action" value="update" />
                                                        <div class="controls">  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateReleve box end -->
                                        <!-- processFournisseur box begin-->
                                        <div id="processFournisseur<?= $releve->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Affecter opération débit au système</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/ReleveBancaireActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Destination</label>
                                                        <div class="controls">
                                                            <select name="destinations" class="destinations">
                                                                <option value="ChargesCommuns">Charges communs</option>
                                                                <option value="ChargesProjets">Charges Projets</option>
                                                                <option value="Ignorer">Ignorer</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="chargesCommunsElements">
                                                        <div class="control-group">
                                                            <label class="control-label">Type Charge Commun</label>
                                                            <div class="controls">
                                                                <select name="typeChargesCommuns">
                                                                    <?php foreach( $typeChargesCommuns as $type ) { ?>    
                                                                    <option value="<?= $type->id() ?>"><?= $type->nom() ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Société</label>
                                                            <div class="controls">
                                                                <input type="text" name="societe" value="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chargesProjetsElements" style="">
                                                        <div class="control-group">
                                                            <label class="control-label">Type Charge Projet</label>
                                                            <div class="controls">
                                                                <select name="typeChargesProjet">
                                                                    <?php foreach( $typeChargesProjets as $type ) { ?>    
                                                                    <option value="<?= $type->id() ?>"><?= $type->nom() ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Projet</label>
                                                            <div class="controls">
                                                                <select name="projet">
                                                                    <?php foreach( $projets as $projet ) { ?>    
                                                                    <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Société</label>
                                                            <div class="controls">
                                                                <input type="text" name="societe2" value="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="idReleveBancaire" value="<?= $releve->id() ?>" />
                                                        <input type="hidden" name="montant" value="<?= $releve->debit() ?>" />
                                                        <input type="hidden" name="dateOperation" value="<?= $releve->dateOpe() ?>" />
                                                        <input type="hidden" name="designation" value="<?= $releve->libelle() ?>" />
                                                        <input type="hidden" name="action" value="process-fournisseur" />
                                                        <div class="controls">  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- processFournisseur box end -->
                                        <!-- processClient box begin-->
                                        <div id="processClient<?= $releve->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Affecter opération crédit au système</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/ReleveBancaireActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Action</label>
                                                        <div class="controls">
                                                            <select name="projet-contrat" class="projet-contrat span12">
                                                                <option value="Ignorer">Séléctionnez un projet ou Ignorer ?</option>
                                                                <?php foreach( $projets as $projet ) { ?>    
                                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Contrat client</label>
                                                        <div class="controls">
                                                            <select name="contrat-client" class="contrat-client span12">
                                                                <option value="">Séléctionnez un contrat ou Ignorer ?</option>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Compte Bancaire</label>
                                                        <div class="controls">
                                                            <select name="compte-bancaire" class="span12">
                                                                <?php foreach( $comptesBancaires as $compte ) { ?>    
                                                                <option value="<?= $compte->numero() ?>"><?= $compte->numero() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Numéro Opération</label>
                                                        <div class="controls">
                                                            <input type="text" name="numero-operation" class="span12" />
                                                        </div>
                                                    </div>
                                                    <strong>Synthèse client</strong>
                                                    <br />
                                                    <div class="tab-pane ">
                                                        <div class="controls controls-row">
                                                            <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="DateOpé" />
                                                            <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="DateRég" />
                                                            <input disabled="disabled" class="span4 m-wrap input-bold-text" type="text" value="Montant" />
                                                            <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="Compte" />
                                                            <input disabled="disabled" class="span2 m-wrap input-bold-text" type="text" value="Chèque" />
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane synthese-client">
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="idReleveBancaire" value="<?= $releve->id() ?>" />
                                                        <input type="hidden" name="montant" value="<?= $releve->credit() ?>" />
                                                        <input type="hidden" name="dateOperation" value="<?= $releve->dateOpe() ?>" />
                                                        <input type="hidden" name="dateReglement" value="<?= $releve->dateVal() ?>" />
                                                        <input type="hidden" name="observation" value="<?= $releve->libelle() ?>" />
                                                        <input type="hidden" name="reference" value="<?= $releve->reference() ?>" />
                                                        <input type="hidden" name="action" value="process-client" />
                                                        <div class="controls">  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- processClient box end -->
                                        <!-- delete box begin-->
                                        <div id="delete<?= $releve->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer Relevé</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReleveBancaireActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="idReleveBancaire" value="<?= $releve->id() ?>" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- delete box end -->     
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>             
                        <!-- END RELEVE PORTLET-->
                    </div>
                </div>
                <!-- END PORTLET-->
                <!-- END PAGE CONTENT-->
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
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        //processFournisseur begin
        $(".chargesProjetsElements").hide();
        $('.destinations').on('change',function(){
            if ( $(this).val() === "ChargesCommuns" ) {
                $(".chargesCommunsElements").show();
                $(".chargesProjetsElements").hide();
            }
            else if ( $(this).val() === "ChargesProjets" ) {
                $(".chargesProjetsElements").show();
                $(".chargesCommunsElements").hide();
            }
            else {
                $(".chargesCommunsElements").hide();
                $(".chargesProjetsElements").hide();    
            }
            
        }); 
        //processFournisseur end
        //processClient begin
        $('.projet-contrat').change(function(){
            var idProjet = $(this).val();
            var data = 'idProjet='+idProjet;
            $.ajax({
                type: "POST",
                url: "projets-contrats.php",
                data: data,
                cache: false,
                success: function(html){
                    $('.contrat-client').html(html);
                }
            });
        });
        //synthese client
        $('.contrat-client').change(function(){
            var idContrat = $(this).val();
            var data = 'idContrat='+idContrat;
            $.ajax({
                type: "POST",
                url: "synthese-client.php",
                data: data,
                cache: false,
                success: function(html){
                    $('.synthese-client').html(html);
                }
            });
        });
        //processClient end
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