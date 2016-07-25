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
    if( isset($_SESSION['userMerlaTrav']) ) {
    	if( isset($_GET['idProjet']) ){
    	   $idProjet = $_GET['idProjet'];   
    	}
        //destroy contrat-form-data session
        if ( isset($_SESSION['contrat-form-data']) ) {
            unset($_SESSION['contrat-form-data']);
        }
    	$projetManager = new ProjetManager($pdo);
		$clientManager = new ClientManager($pdo);
		$contratManager = new ContratManager($pdo);
		$operationManager = new OperationManager($pdo);
        $compteBancaireManager = new CompteBancaireManager($pdo);
        $contratCasLibreManager = new ContratCasLibreManager($pdo);
        $reglementPrevuManager = new ReglementPrevuManager($pdo);
        $companieManager = new CompanyManager($pdo);
        
		if(isset($_GET['codeContrat']) and (bool)$contratManager->getCodeContrat($_GET['codeContrat']) ){
			$codeContrat = $_GET['codeContrat'];
            $comptesBancaires = $compteBancaireManager->getCompteBancaires();
			$contrat = $contratManager->getContratByCode($codeContrat);
            $companies = $companieManager->getCompanys();
            //ContratCasLibre Elements
            $contratCasLibreNumber = 
            $contratCasLibreManager->getContratCasLibreNumberByCodeContrat($codeContrat);
            $contratCasLibreElements = "";
            $contratCasLibreTitle = "";
            if ( $contratCasLibreNumber > 0 ) {
                $contratCasLibreTitle = "<h4>Informations Supplémentaires</h4>";
                $contratCasLibreElements = 
                $contratCasLibreManager->getContratCasLibresByCodeContrat($codeContrat);
            }
            //ReglementPrevu Elements
            $reglementPrevuNumber = 
            $reglementPrevuManager->getReglementNumberByCodeContrat($codeContrat);
            $reglementPrevuElements = "";
            $reglementPrevuTitle = "";
            if ( $reglementPrevuNumber > 0 ) {
                $reglementPrevuTitle = "<h4>Dates des réglements prévus</h4>";
                $reglementPrevuElements =     
                $reglementPrevuManager->getReglementPrevuByCodeContrat($codeContrat);
            }
            
			$projet = $projetManager->getProjetById($contrat->idProjet());
			$client = $clientManager->getClientById($contrat->idClient());
			$sommeOperations = $operationManager->sommeOperations($contrat->id());
			$biens = "";
			$niveau = "";
			if($contrat->typeBien()=="appartement"){
				$appartementManager = new AppartementManager($pdo);
				$biens = $appartementManager->getAppartementById($contrat->idBien());
				$niveau = $biens->niveau();
			}
			else if($contrat->typeBien()=="localCommercial"){
				$locauxManager = new LocauxManager($pdo);
				$biens = $locauxManager->getLocauxById($contrat->idBien());
			}
			$operations = "";
			//test the locaux object number: if exists get operations else do nothing
			$operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
			if($operationsNumber != 0){
				$operations = $operationManager->getOperationsByIdContrat($contrat->id());	
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
							Résumé Contrat Client - Projet : <strong><?= $projet->nom() ?></strong>
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
							<li>
                                <a href="projet-details.php?idProjet=<?= $projet->id() ?>">Projet <strong><?= $projet->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
							<li>
							    <a href="contrats-list.php?idProjet=<?= $projet->id() ?>">Liste des contrats clients</a>
							    <i class="icon-angle-right"></i>
							</li>
							<li>
                                <a>Résumé contrat</a>
                            </li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<?php if(isset($_GET['codeContrat']) and 
						(bool)$contratManager->getCodeContrat($_GET['codeContrat']) ){
	                     //progress bar processing
	                     //contrat progress with avance : 
	                     //$statistiquesResult = ceil((($operationManager->sommeOperations($contrat->id())  +$contrat->avance() )/$contrat->prixVente())*100);
	                     //contrat progress without avance : 
	                     $statistiquesResult = ceil((($operationManager->sommeOperations($contrat->id()) )/$contrat->prixVente())*100);
						 $statusBar = "";
						 if( $statistiquesResult>0 and $statistiquesResult<25 ){
						 	$statusBar = "progress-danger";
						 }
						 else if( $statistiquesResult>=25 and $statistiquesResult<50 ){
						 	$statusBar = "progress-warning";
						 }
						 else if( $statistiquesResult>=50 and $statistiquesResult<75 ){
						 	$statusBar = "progress-success";
						 }
	                     ?>
	                    <h3>Résumé du Contrat&nbsp;&nbsp;
	                    	<a class="btn blue" href="controller/ContratClientSituationPrintController.php?codeContrat=<?= $contrat->code() ?>">
	                    		<i class="icon-print"></i>&nbsp;Version Imprimable
	                    	</a>
	                    	<a class="btn green pull-right" href="controller/ContratArabePrintController.php?idContrat=<?= $contrat->id() ?>">
	                    	<!--a class="btn green pull-right" href="controller/ContratClientSituationPrintController.php?codeContrat=<?= $contrat->code() ?>"-->
                                <i class="icon-print"></i>&nbsp;Imprimer Contrat
                            </a>
	                    </h3>
	                    
	                    <h4 style="text-align: center">Avancement du contrat</h4>
	                    <div class="progress <?= $statusBar ?>">
    						<div class="bar" style="width: <?= $statistiquesResult ?>%;"><?= $statistiquesResult ?>%</div>
						</div>
		                 <?php 
		                 if( isset($_SESSION['contrat-action-message']) 
                            and isset($_SESSION['contrat-type-message']) ) {
                                $message = $_SESSION['contrat-action-message'];
                                $typeMessage = $_SESSION['contrat-type-message'];
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php 
                         } 
                         unset($_SESSION['contrat-action-message']);
                         unset($_SESSION['contrat-type-message']);
                         ?>
                         <?php 
                         if( isset($_SESSION['client-action-message']) 
                         and isset($_SESSION['client-type-message']) ) {
                            $message = $_SESSION['client-action-message'];
                            $typeMessage = $_SESSION['client-type-message'];
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php 
                         } 
                         unset($_SESSION['client-action-message']);
                         unset($_SESSION['client-type-message']);
                         ?>
                       <div class="span5">
						<div class="portlet sale-summary">
							<div class="portlet-title">
								<h4>Informations du client</h4>
								<?php
                                if( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                ?>
								<a href="#updateClient<?= $client->id() ?>" class="pull-right btn red hidden-phone" data-toggle="modal" data-id="<?= $client->id(); ?>">
									Modifier <i class="icon-refresh icon-white"></i>
								</a>
								<?php
                                }
                                ?>
								<br><br>	
							</div>
							<ul class="unstyled">
								<li>
									<span class="sale-info">Client</span> 
									<span class="sale-num"><?= $client->nom() ?></span>
								</li>
								<li>
									<span class="sale-info">CIN</span> 
									<span class="sale-num"><?= $client->cin() ?></span>
								</li>
								<li>
									<span class="sale-info">Téléphone 1</span> 
									<span class="sale-num"><?= $client->telephone1() ?></span>
								</li>
								<li>
									<span class="sale-info">Téléphone 2</span> 
									<span class="sale-num"><?= $client->telephone2() ?></span>
								</li>
								<li>
									<span class="sale-info">Adresse</span> 
									<span class="sale-num"><?= $client->adresse() ?></span>
								</li>
								<li>
									<span class="sale-info"><i class="icon-envelope"></i></span> 
									<span class="sale-num"><a href="mailto:<?= $client->email() ?>"><?= $client->email() ?></a></span>
								</li>
							</ul>
						</div>
					 </div>
					 <div class="span6">
						<div class="portlet sale-summary">
							<div class="portlet-title">
								<h4>Informations du contrat</h4>
								<?php
                                if( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                ?>
								<a href="#updateContrat<?= $contrat->id() ?>" class="pull-right btn red hidden-phone" data-toggle="modal" data-id="<?= $contrat->id(); ?>">
									Modifier <i class="icon-refresh icon-white"></i>
								</a>
								<?php
                                }
                                ?>
								<br><br>
							</div>
							<ul class="unstyled">
								<li>
									<span class="sale-info">Type</span> 
									<span class="sale-num">
									<?php 
										if($contrat->typeBien()=="localCommercial"){
											echo "Local commercial"; 
										} 
										else{
											echo "Appartement";
										} 
									?>
									</span>
								</li>
								<li>
									<span class="sale-info">Code du Bien</span> 
									<span class="sale-num"><?= $biens->nom() ?></span>
								</li>
								<li>
									<span class="sale-info">Superficie</span> 
									<span class="sale-num"><?= $biens->superficie() ?>&nbsp;m<sup>2</sup></span>
								</li>
								<li>
                                    <span class="sale-info">Date création</span> 
                                    <span class="sale-num"><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></span>
                                </li>
								<?php if($contrat->typeBien()=="appartement"){ ?>
								<li>
									<span class="sale-info">Niveau</span> 
									<span class="sale-num"><?= $niveau ?></span>
								</li>
								<?php } ?>
								<li>
									<span class="sale-info">Prix de Vente</span> 
									<span class="sale-num"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?>&nbsp;DH</span>
								</li>
								<li>
                                    <span class="sale-info">Avance</span> 
                                    <span class="sale-num"><?= number_format($contrat->avance(), 2, ',', ' ') ?>&nbsp;DH</span>
                                </li>
                                <li>
                                    <span class="sale-info">Durée Paiement</span> 
                                    <span class="sale-num"><?= $contrat->dureePaiement() ?>&nbsp;Mois</span>
                                </li>
                                <li>
                                    <span class="sale-info">Nombre Mois</span> 
                                    <span class="sale-num"><?= $contrat->nombreMois() ?>&nbsp;Mois</span>
                                </li>
                                <li>
                                    <span class="sale-info">Echéance</span> 
                                    <span class="sale-num"><?= number_format($contrat->echeance(), 2, ',', ' ') ?>&nbsp;DH</span>
                                </li>
								<li>
									<?php
									//if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
									?>
									<span class="sale-info">Réglements</span> 
									<span class="sale-num">
										<?= number_format($sommeOperations, 2, ',', ' ') ?>&nbsp;DH
									</span>
									<?php
									//}
									?>
								</li>
								<li>
									<span class="sale-info">Reste</span> 
									<span class="sale-num">
										<?= number_format($contrat->prixVente()-($sommeOperations), 2, ',', ' ') ?>&nbsp;DH
									</span>
								</li>
								<li>
                                    <span class="sale-info">Note</span> 
                                    <span class="sale-num">
                                        <?= $contrat->note() ?>
                                    </span>
                                </li>
                                <li>
                                    <span class="sale-info">Image Note</span> 
                                    <span class="sale-num">
                                        <a class="fancybox-button btn mini" data-rel="fancybox-button" title="Image Note" href="<?= $contrat->imageNote() ?>">
                                            <i class="icon-zoom-in"></i>    
                                        </a>
                                        <a title="Modifier Image Note" class="btn mini black" href="#updateImageNote<?= $contrat->id();?>" data-toggle="modal" data-id="<?= $contrat->id(); ?>">
                                            <i class=" icon-refresh"></i>   
                                        </a>
                                    </span>
                                </li>
							</ul>
							<!--a href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>" class="btn big blue">
									<i class="icon-print"></i> Contrat Client
								</a>
							<a href="controller/QuittanceAvancePrintController.php?idContrat=<?= $contrat->id() ?>" class="btn big black">
									<i class="icon-print"></i> Quittance Avance
								</a-->
						</div>
					 </div>
					 <!-- updateImageNote box begin-->
                    <div id="updateImageNote<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Modifier l'image de note client </h3>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal loginFrm" action="controller/ContratActionController.php" method="post" enctype="multipart/form-data">
                                <p>Êtes-vous sûr de vouloir modifier l'image de cette note ?</p>
                                <div class="control-group">
                                    <label class="right-label"></label>
                                    <div class="control-group">
                                        <label class="control-label">Image Note</label>
                                        <div class="controls">
                                            <input type="file" name="note-client-image" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="action" value="updateImageNote" />
                                    <input type="hidden" name="source" value="contrat" />
                                    <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                    <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                    <input type="hidden" name="idProjet" value="<?= $contrat->idProjet() ?>" />
                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- updateImageNote box end -->       
					<!-- addReglement box begin-->
                    <div id="addReglement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Nouveau réglement </h3>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post" enctype="multipart/form-data">
                                <div class="control-group">
                                     <label class="control-label" for="code">Date opération</label>
                                     <div class="controls">
                                        <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                     </div>
                                </div>
                                <div class="control-group">
                                     <label class="control-label" for="code">Date réglement</label>
                                     <div class="controls">
                                        <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                     </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Montant</label>
                                    <div class="controls">
                                        <input style="width:150px" type="text" required="required" id="montant" name="montant" />
                                        <select id="currency" name="currency" style="width:80px">
                                            <option value="DH">DH</option>
                                            <option value="Euro">Euro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group" style="display: none" id="tauxDeChange">
                                    <label class="control-label">Taux de change</label>
                                    <div class="controls">
                                        <input type="text" name="tauxDeChange" />
                                    </div>
                                </div>
                                <div class="control-group">
                                     <label class="control-label" for="modePaiement">Mode de paiement</label>
                                     <div class="controls">
                                        <select name="modePaiement" id="modePaiement">
                                            <option value="Especes">Espèces</option>
                                            <option value="Cheque">Chèque</option>
                                            <option value="Versement">Versement</option>
                                            <option value="Virement">Virement</option>
                                            <option value="Lettre de change">Lettre de change</option>
                                            <option value="Remise">Remise</option>
                                        </select>
                                     </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Compte Bancaire</label>
                                    <div class="controls">
                                        <select name="compteBancaire" id="compteBancaire">
                                            <?php
                                            foreach ($comptesBancaires as $compte) {
                                            ?>
                                                <option value="<?= $compte->numero() ?>"><?= $compte->numero() ?></option>
                                            <?php  
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Numéro Opération</label>
                                    <div class="controls">
                                        <input type="text" required="required" name="numeroOperation" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Pièce de réglement</label>
                                    <div class="controls">
                                        <input type="file" name="urlCheque" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Observation</label>
                                    <div class="controls">
                                        <textarea type="text" name="observation"></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <input type="hidden" name="action" value="add" />
                                    <input type="hidden" name="source" value="contrat" />
                                    <input type="hidden" name="codeContrat" value="<?= $contrat->code() ?>" />
                                    <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                    <input type="hidden" name="idProjet" value="<?= $contrat->idProjet() ?>" />
                                    <div class="controls">
                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- addReglement box end -->
                    <!-- CONTRAT CAS LIBRE BEGIN -->
                    <a class="btn red get-down" href="#addCasLibre" data-toggle="modal"><i class="icon-plus-sign"></i> Cas Libre</a>
                    <?php 
                    if ( $contratCasLibreNumber > 0 ) { 
                    ?>
                    <div class="portlet box light-grey" id="contratCasLibre">
                        <div class="portlet-title">
                            <h4><?= $contratCasLibreTitle; ?></h4>
                            <div class="tools">
                                <a href="javascript:;" class="reload"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="clearfix">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <?php
                                            //if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                            ?>
                                            <th style="width: 10%">Actions</th>
                                            <?php
                                            //}
                                            ?>
                                            <th style="width: 20%">Date</th>
                                            <th style="width: 20%">Montant</th>
                                            <th style="width: 30%">Obsérvation</th>
                                            <th style="width: 20%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalMontantsCasLibre = 0;
                                        foreach ( $contratCasLibreElements as $element ) {
                                            $status = "";    
                                            $totalMontantsCasLibre += $element->montant();
                                            if ( $element->status() == 0 ) {
                                                //comparing dates
                                                $now = date('Y-m-d');
                                                $now = new DateTime($now);
                                                $now = $now->format('Ymd');
                                                $dateCasLibre = $element->date();
                                                $dateCasLibre = new DateTime($dateCasLibre);
                                                $dateCasLibre = $dateCasLibre->format('Ymd');
                                                if ( $dateCasLibre > $now ) {
                                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                        $status = '<a href="#updateStatusContratCasLibre'.$element->id().'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini green">Normal</a>';    
                                                    }   
                                                    else{
                                                        $status = '<a class="btn mini green">Normal</a>';
                                                    }
                                                }
                                                else if ( $dateCasLibre < $now ) {
                                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                        $status = '<a href="#updateStatusContratCasLibre'.$element->id().'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini red blink_me">En retard</a>';
                                                    }
                                                    else {
                                                        $status = '<a class="btn mini red blink_me">En retard</a>';
                                                    }    
                                                }
                                                else {
                                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                        $status = '<a href="#updateStatusContratCasLibre'.$element->id().'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini purple">En cours</a>';
                                                    }
                                                    else {
                                                        $status = '<a class="btn mini purple">En retard</a>';
                                                    }   
                                                } 
                                            }
                                            else if( $element->status() == 1 ) {
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                    $status = '<a href="#updateStatusContratCasLibre'.$element->id().'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini blue">Réglé</a>';
                                                }
                                                else {
                                                    $status = '<a class="btn mini blue">Réglé</a>';
                                                }     
                                            }
                                        ?>
                                        <!-- updateStatusContratCasLibre box begin -->
                                        <div id="updateStatusContratCasLibre<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratCasLibreActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                                            <input type="hidden" name="idContratCasLibre" value="<?= $element->id() ?>" />
                                                            <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusContratCasLibre box end -->
                                        <!-- updateContratCasLibre box begin -->
                                        <div id="updateContratCasLibre<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier Informations</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratCasLibreActionController.php" method="post">
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                                <input name="date" id="date" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $element->date() ?>" />
                                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" name="montant" class="m-wrap" value="<?= $element->montant() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">
                                                            <input type="text" name="observation" class="m-wrap" value="<?= $element->observation() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="update" />
                                                            <input type="hidden" name="source" value="contrat" />
                                                            <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                                            <input type="hidden" name="idContratCasLibre" value="<?= $element->id() ?>" />
                                                            <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateContratCasLibre box end -->
                                        <!-- deleteContratCasLibre box begin -->
                                        <div id="deleteContratCasLibre<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer cette ligne</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratCasLibreActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer cette ligne ?</p>
                                                    <div class="control-group">
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="source" value="contrat" />
                                                        <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                                        <input type="hidden" name="idContratCasLibre" value="<?= $element->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- deleteContratCasLibre box end -->
                                        <tr>
                                            <?php
                                            //if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                            ?>
                                            <td>
                                                <a href="#deleteContratCasLibre<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn mini red">
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <a href="#updateContratCasLibre<?= $element->id() ?>" data-toggle="modal" data-id="<?= $element->id() ?>" class="btn mini green">
                                                    <i class="icon-refresh"></i>
                                                </a>
                                            </td>
                                            <?php
                                            //}
                                            ?>
                                            <td><?= date('d/m/Y', strtotime($element->date())) ?></td>
                                            <td><?= number_format($element->montant(), 2, ' ', ',') ?></td>
                                            <td><?= $element->observation() ?></td>
                                            <td><?= $status ?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th>Total des montants</th>
                                            <td></td>
                                            <?php
                                            //this is used to the style of table
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                            ?>
                                            <td></td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th><?= number_format($totalMontantsCasLibre, 2, ',', ' ') ?>&nbsp;DH</th>
                                            <td></td>
                                            <?php
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                            ?>
                                            <td></td>
                                            <?php
                                            }
                                            ?>
                                        </tr>  
                                    </tbody>
                                </table>
                            </div>
                        </div>       
                    </div>    
                    <?php 
                    } 
                    //We wanna add "Cas Libre" to this contract if it doesn't contain one
                    //else {
                    ?>
                        <!--a class="btn red get-down" href="#addCasLibre" data-toggle="modal"><i class="icon-plus-sign"></i> Cas Libre</a-->
                    <?php
                    //} 
                    ?>
                    <!-- addCasLibre box begin-->
                    <div id="addCasLibre" class="modal modal-big hide fade in" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="false" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h3>Ajouter un cas libre pour ce contrat </h3>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" action="controller/ContratCasLibreActionController.php" method="post">
                                <?php include('include/cas-libre-modal.php'); ?>
                        </div>
                        <div class="modal-footer">
                                <div class="row-fluid">
                                    <div class="control-group">
                                        <input type="hidden" name="action" value="addCasLibre">
                                        <input type="hidden" name="source" value="contrat">
                                        <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>">
                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- addCasLibre box end -->
                    <!-- CONTRAT CAS LIBRE END -->
                    <!-- DATES REGLEMENTS PREVU BEGIN -->
                    <?php 
                    if ( $reglementPrevuNumber > 0 ) { 
                    ?>
                    <div class="portlet box light-grey" id="reglementsPrevus">
                        <div class="portlet-title">
                            <h4><?= $reglementPrevuTitle; ?></h4>
                            <div class="tools">
                                <a href="javascript:;" class="reload"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="clearfix">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%">Date Prévu de réglement</th>
                                            <th style="width: 20%">Echéance</th>
                                            <th style="width: 20%">Status du réglement</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalEcheance = 0;
                                        foreach ( $reglementPrevuElements as $element ) {
                                            $status = "";    
                                            $totalEcheance += $contrat->echeance();
                                            if ( $element->status() == 0 ) {
                                                //comparing dates
                                                $now = date('Y-m-d');
                                                $now = new DateTime($now);
                                                $now = $now->format('Ymd');
                                                $datePrevu = $element->datePrevu();
                                                $datePrevu = new DateTime($datePrevu);
                                                $datePrevu = $datePrevu->format('Ymd');
                                                if ( $datePrevu > $now ) {
                                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                        $status = '<a href="#updateStatusReglementPrevu'.$element->id().'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini">Normal</a>';    
                                                    }
                                                    else{
                                                        $status = '<a class="btn mini">Normal</a>';
                                                    }   
                                                }
                                                else if ( $datePrevu < $now ) {
                                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                        $status = '<a href="#updateStatusReglementPrevu'.$element->id().'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini red blink_me">En retards</a>';
                                                    }
                                                    else {
                                                        $status = '<a class="btn mini red blink_me">En retards</a>';
                                                    }
                                                }
                                            }
                                            else if( $element->status() == 1 ) {
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                    $status = '<a href="#updateStatusReglementPrevu'.$element->id().'" data-toggle="modal" data-id="'.$element->id().'" class="btn mini blue">Réglé</a>';
                                                }
                                                else {
                                                    $status = '<a class="btn mini blue">Réglé</a>';
                                                }    
                                            }
                                        ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($element->datePrevu())) ?></td>
                                            <td><?= number_format($contrat->echeance(), 2, ',', ' ') ?></td>
                                            <td><?= $status ?></td>
                                        </tr>
                                        <!-- updateStatusReglementPrevu box begin-->
                                        <div id="updateStatusReglementPrevu<?= $element->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier status</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ReglementPrevuActionController.php" method="post">
                                                    <div class="control-group">
                                                        <p>Êtes-vous sûr de vouloir changer le status de la date prévu ?</p>
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $element->status() ?>"><?php if($element->status()==0){echo 'En cours';}else{echo 'Réglé';} ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <option value="0">En cours</option>
                                                                <option value="1">Réglé</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">    
                                                            <input type="hidden" name="action" value="updateStatus">
                                                            <input type="hidden" name="source" value="contrat">
                                                            <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                                            <input type="hidden" name="idReglementPrevu" value="<?= $element->id() ?>" />
                                                            <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        <div class="controls">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateStatusReglementPrevu box end -->
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <th>Total des échéances</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><?= number_format($totalEcheance, 2, ',', ' ') ?>&nbsp;DH</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>       
                    </div>    
                    <?php 
                    } 
                    ?>
                    <!-- DATES REGLEMENTS PREVU END -->
					<div class="portlet box light-grey" id="detailsReglements">
                        <div class="portlet-title">
                            <h4>Détails des réglements client</h4>
                            <div class="tools">
                                <a href="javascript:;" class="reload"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="clearfix">
                                <?php 
                                 if( isset($_SESSION['operation-action-message']) 
                                 and isset($_SESSION['operation-type-message']) ){
                                    $message = $_SESSION['operation-action-message'];
                                    $typeMessage = $_SESSION['operation-type-message'];
                                 ?>
                                    <div class="alert alert-<?= $typeMessage ?>">
                                        <button class="close" data-dismiss="alert"></button>
                                        <?= $message ?>     
                                    </div>
                                 <?php 
                                 } 
                                 unset($_SESSION['operation-action-message']);
                                 unset($_SESSION['operation-type-message']);
                                ?>
                                <?php
                                if( 
                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                    $_SESSION['userMerlaTrav']->profil() == "manager" 
                                ) {
                                ?>
                                <div class="btn-group">
                                    <a class="btn blue pull-right" href="#addReglement" data-toggle="modal">
                                        Nouveau Réglement&nbsp;<i class="icon-plus-sign"></i>
                                    </a>
                                </div>
                                <?php
                                }
                                ?>
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
									    <th style="width: 20%">Actions</th>
									    <th style="width: 15%">Pieces</th>
										<th style="width: 10%">Date.Opé/Rég</th>
										<!--th style="width: 10%">Date.Rég</th-->
										<th style="width: 10%">ModePaiement</th>
										<th style="width: 10%">Compte</th>
										<th style="width: 5%">N°.Opér</th>
										<th style="width: 10%">Montant</th>
										<th style="width: 10%">Observation</th>
										<th style="width: 10%">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($operationsNumber != 0){
									foreach($operations as $operation){
									    $status = "";
                                        $action = "";
                                        if ( $operation->status() == 0 ) {
                                            $action = '<a class="btn grey mini"><i class="icon-off"></i></a>'; 
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $status = '<a class="btn red mini" href="#validateOperation'.$operation->id().'" data-toggle="modal" data-id="'.$operation->id().'">Non validé</a>';  
                                            } 
                                            else{
                                                $status = '<a class="btn red mini">Non validé</a>';
                                            } 
                                        } 
                                        else if ( $operation->status() == 1 ) {
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $status = '<a class="btn blue mini" href="#cancelOperation'.$operation->id().'" data-toggle="modal" data-id="'.$operation->id().'">Validé</a>';
                                                $action = '<a class="btn green mini" href="#hideOperation'.$operation->id().'" data-toggle="modal" data-id="'.$operation->id().'"><i class="icon-off"></i></a>';   
                                            }
                                            else {
                                                $status = '<a class="btn blue mini">Validé</a>';
                                                $action = '<a class="btn grey mini"><i class="icon-off"></i></a>'; 
                                            }
                                        } 
									?>		
									<tr class="odd gradeX">
									    <td>
									        <a title="Imprimer Quittance" class="btn mini blue" href="controller/QuittanceArabePrintController.php?idOperation=<?= $operation->id() ?>"><i class="m-icon-white icon-print"></i></a>
    									    <?php
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                            ?>
    									       <a title="Modifier Réglement" class="btn green mini" href="#updateOperation<?= $operation->id();?>" data-toggle="modal" data-id="<?= $operation->id(); ?>"><i class="icon-refresh"></i></a>
    									       <a title="Supprimer Réglement" class="btn red mini" href="#deleteOperation<?= $operation->id();?>" data-toggle="modal" data-id="<?= $operation->id(); ?>"><i class="icon-remove"></i></a>
    									    <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a class="fancybox-button btn mini" data-rel="fancybox-button" title="Copie Pièce" href="<?= $operation->url() ?>">
                                                <i class="icon-zoom-in"></i>    
                                            </a>
                                            <a title="Modifier Pièce" class="btn mini black" href="#updatePiece<?= $operation->id();?>" data-toggle="modal" data-id="<?= $operation->id(); ?>">
                                                <i class=" icon-refresh"></i>   
                                            </a>
                                        </td>
										<td><?= date('d/m/Y', strtotime($operation->date())).'-'.date('d/m/Y', strtotime($operation->dateReglement())) ?></td>
										
										<td><?= $operation->modePaiement() ?></td>
										<td><?= $operation->compteBancaire() ?></td>
										<td><?= $operation->numeroCheque() ?></td>
										<td><?= number_format($operation->montant(), 2, ',', ' ') ?>&nbsp;DH</td>
										<td><?= $operation->observation() ?></td>
										<td><?= $status ?></td>
									</tr>
									<!-- updatePiece box begin-->
                                    <div id="updatePiece<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Modifier la pièce de réglement </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post" enctype="multipart/form-data">
                                                <p>Êtes-vous sûr de vouloir modifier la pièce de réglement ?</p>
                                                <div class="control-group">
                                                    <label class="right-label"></label>
                                                    <div class="control-group">
                                                        <label class="control-label">Pièce de réglement</label>
                                                        <div class="controls">
                                                            <input type="file" name="urlPiece" />
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="action" value="updatePiece" />
                                                    <input type="hidden" name="source" value="contrat" />
                                                    <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <input type="hidden" name="idProjet" value="<?= $contrat->idProjet() ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- updateCopiePiece box end -->      	
									<!-- validateOperation box begin-->
                                    <div id="validateOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Valider Paiement Client </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="validate">
                                                    <input type="hidden" name="source" value="contrat">
                                                    <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>">
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn blue" aria-hidden="true">Oui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- validateOperation box end -->
                                    <!-- cancelOperation box begin-->
                                    <div id="cancelOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Annuler Paiement Client </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="cancel">
                                                    <input type="hidden" name="source" value="contrat">
                                                    <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>">
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- cancelOperation box end -->
									<!-- update box begin-->
                                    <div id="updateOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Modifier Infos Opérations</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="controller/OperationActionController.php" method="post">
                                                <p>Êtes-vous sûr de vouloir modifier les informations de cette opération ?</p>
                                                <div class="control-group">
                                                     <label class="control-label" for="code">Date opération</label>
                                                     <div class="controls">
                                                        <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $operation->date('Y-m-d') ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                     </div>
                                                </div>
                                                <div class="control-group">
                                                     <label class="control-label" for="code">Date réglement</label>
                                                     <div class="controls">
                                                        <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $operation->dateReglement() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                     </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Montant</label>
                                                    <div class="controls">
                                                        <input type="text" name="montant" value="<?= $operation->montant() ?>" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                     <label class="control-label" for="modePaiement">Mode de paiement</label>
                                                     <div class="controls">
                                                        <div class="controls">
                                                            <select name="modePaiement" id="modePaiement">
                                                                <option value="<?= $operation->modePaiement() ?>"><?= $operation->modePaiement() ?></option>
                                                                <option disabled="disabled">----------------</option>
                                                                <option value="Especes">Espèces</option>
                                                                <option value="Cheque">Chèque</option>
                                                                <option value="Versement">Versement</option>
                                                                <option value="Virement">Virement</option>
                                                                <option value="Lettre de change">Lettre de change</option>
                                                                <option value="Remise">Remise</option>
                                                            </select>
                                                        </div>
                                                     </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Compte Bancaire</label>
                                                    <div class="controls">
                                                        <select name="compteBancaire" id="compteBancaire">
                                                            <option value="<?= $operation->compteBancaire() ?>"><?= $operation->compteBancaire() ?></option>
                                                            <option disabled="disabled">----------------------</option>
                                                            <?php
                                                            foreach ($comptesBancaires as $compte) {
                                                            ?>
                                                                <option value="<?= $compte->numero() ?>"><?= $compte->numero() ?></option>
                                                            <?php  
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Numéro Opération</label>
                                                    <div class="controls">
                                                        <input type="text" required="required" name="numeroOperation" value="<?= $operation->numeroCheque() ?>" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Observation</label>
                                                    <div class="controls">
                                                        <textarea type="text" name="observation"><?= $operation->observation() ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="hidden" name="source" value="contrat">
                                                    <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                    <div class="controls">  
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- update box end --> 
                                    <!-- delete box begin-->
                                    <div id="deleteOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Supprimer Réglement Client </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                <p>Êtes-vous sûr de vouloir supprimer ce réglement ?</p>
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="source" value="contrat">
                                                    <input type="hidden" name="codeContrat" value="<?= $codeContrat ?>" />
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- delete box end --> 
									<?php
									}//end of loop
									}//end of if
									?>
									<!--tr>
										<td><a><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></a></td>											
										<?php
										if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
										?> 
											<td><?= number_format($contrat->avance(), 2, ',', ' ')." DH";?></td>
										<?php
										}
										?>
										<td class="hidden-phone">
											<a class="btn mini blue" href="controller/QuittanceAvancePrintController.php?idContrat=<?= $contrat->id() ?>"> 
												<i class="m-icon-white icon-print"></i> Imprimer
											</a>
										</td>
										<td class="hidden-phone"><?= $contrat->modePaiement() ?></td>
									</tr-->
								</tbody>
							</table>
                            <table class="table table-striped table-bordered  table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 30%"><strong>Total des réglements</strong></th>
                                    <th style="width: 25%"><a><strong><?= $operationManager->sommeOperations($contrat->id(), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
                                    <th style="width: 20%"><strong>Reste à payé</strong></th>
                                    <th style="width: 25%"><a><strong><?= number_format($contrat->prixVente()-$operationManager->sommeOperations($contrat->id()), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
                                </tr>
                            </tbody>
                        </table>
						</div>
						<br /><br />
					 </div>
				   </div>
				</div>
				<!-- updateClient box begin-->
				<div id="updateClient<?= $client->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h3>Modifier les informations du client </h3>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="controller/ClientActionController.php" method="post">
							<p>Êtes-vous sûr de vouloir modifier les infos du client <strong><?= $client->nom() ?></strong> ?</p>
							<div class="control-group">
								<label class="control-label">Nom</label>
								<div class="controls">
									<input type="text" name="nom" value="<?= $client->nom() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">CIN</label>
								<div class="controls">
									<input type="text" name="cin" value="<?= $client->cin() ?>" />
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label">Adresse</label>
								<div class="controls">
									<input type="text" name="adresse" value="<?= $client->adresse() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Téléphone 1</label>
								<div class="controls">
									<input type="text" name="telephone1" value="<?= $client->telephone1() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Téléphone 2</label>
								<div class="controls">
									<input type="text" name="telephone2" value="<?= $client->telephone2() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Email</label>
								<div class="controls">
									<input type="text" name="email" value="<?= $client->email() ?>" />
								</div>	
							</div>
							<div class="control-group">
                                <label class="control-label">الاسم</label>
                                <div class="controls">
                                    <input type="text" name="nomArabe" value="<?= $client->nomArabe() ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">العنوان</label>
                                <div class="controls">
                                    <input type="text" name="adresseArabe" value="<?= $client->adresseArabe() ?>" />
                                </div>  
                            </div>
							<div class="control-group">
							    <input type="hidden" name="action" value="update" />
							    <input type="hidden" name="source" value="contrat" />
								<input type="hidden" name="idClient" value="<?= $client->id() ?>" />
								<input type="hidden" name="codeContrat" value="<?= $contrat->code() ?>" />
								<div class="controls">	
									<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
									<button type="submit" class="btn red" aria-hidden="true">Oui</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- updateClient box end -->
				<!-- updateContrat box begin-->
				<div id="updateContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h3>Modifier les informations du contrat </h3>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="controller/ContratActionController.php" method="post">
							<p>Êtes-vous sûr de vouloir modifier le contrat <strong>N°<?= $contrat->id() ?></strong>  ?</p>
							<div class="control-group">
                                <label class="control-label">Numéro Contrat</label>
                                <div class="controls">
                                    <input type="text" name="numero" value="<?= $contrat->numero() ?>" />
                                </div>
                            </div>  
							<div class="control-group">
								<label class="control-label">Date Création</label>
								<div class="controls">
									<input type="text" required="required" name="dateCreation" value="<?= $contrat->dateCreation() ?>" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Prix Vente</label>
								<div class="controls">
									<input type="text" required="required" id="prixVente" name="prixVente" value="<?= $contrat->prixVente() ?>" />
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label">Avance</label>
								<div class="controls">
									<input type="text" required="required" id="avance" name="avance" value="<?= $contrat->avance() ?>" />
								</div>
							</div>
							<div class="control-group">
                                <label class="control-label">Durée de paiement</label>
                                <div class="controls">
                                    <input type="text" required="required" id="dureePaiement" name="dureePaiement" value="<?= $contrat->dureePaiement() ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nombre Mois</label>
                                <div class="controls">
                                    <input type="text" required="required" id="nombreMois" name="nombreMois" value="<?= $contrat->nombreMois() ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Echéance</label>
                                <div class="controls">
                                    <input type="text" id="echeance" name="echeance" value="<?= $contrat->echeance() ?>" />
                                </div>
                            </div>
							<div class="control-group">
								<label class="control-label">Mode de paiement</label>
								<div class="controls">
									<select name="modePaiement">
										<option value="<?= $contrat->modePaiement() ?>"><?= $contrat->modePaiement() ?></option>
										<option disabled="disabled">-----------</option>
										<option value="Especes">Espèces</option>
										<option value="Cheque">Chèque</option>
										<option value="Versement">Versement</option>
										<option value="Virement">Virement</option>
										<option value="Lettre de change">Lettre de change</option>
									</select>
								</div>
							</div>
							<div class="control-group">
                                <label class="control-label">Numéro Opération</label>
                                <div class="controls">
                                    <input type="text" name="numeroCheque" value="<?= $contrat->numeroCheque() ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Note Client</label>
                                <div class="controls">
                                    <textarea name="note"><?= $contrat->note() ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">مبلغ البيع المتفق عليه</label>
                                <div class="controls">
                                    <input type="text" name="prixVenteArabe" value="<?= $contrat->prixVenteArabe() ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">التسبيق</label>
                                <div class="controls">
                                    <input type="text" name="avanceArabe" value="<?= $contrat->avanceArabe() ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">الشركة</label>
                                <div class="controls">
                                    <select name="societeArabe">
                                        <option value="<?= $contrat->societeArabe() ?>"><?= $companieManager->getCompanyById($contrat->societeArabe())->nomArabe() ?></option>
                                        <option disabled="disabled">------------------------</option>
                                        <?php
                                        foreach ( $companies as $company ) {
                                        ?>
                                        <option value="<?= $company->id() ?>"><?= $company->nomArabe() ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">وضعية الشقة/المحل التجاري</label>
                                <div class="controls">
                                    <select name="etatBienArabe">
                                        <?php if ( $contrat->etatBienArabe()=="Finition" ) { ?>
                                        <option value="Finition">الأشغال النهائية للبناء</option>    
                                        <?php } ?>
                                        <?php if ( $contrat->etatBienArabe()=="GrosOeuvre" ) { ?>
                                        <option value="GrosOeuvre">الأشغال الأساسية للبناء</option>    
                                        <?php } ?>
                                        <option disabled="disabled">---------------------</option>
                                        <option value="GrosOeuvre">الأشغال الأساسية للبناء</option>
                                        <option value="Finition">الأشغال النهائية للبناء</option>
                                    </select>    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">الواجهة</label>
                                <div class="controls">
                                    <input type="text" required="required" id="facadeArabe" name="facadeArabe" value="<?= $contrat->facadeArabe() ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">بنود أخرى</label>
                                <div class="controls">
                                    <textarea name="articlesArabes"><?= $contrat->articlesArabes() ?></textarea>
                                </div>
                            </div>
							<div class="control-group">
                             	<div class="alert alert-error">
									<strong>Remarque</strong> : Ne toucher à cette zone sauf si vous voulez changer le bien.		
								</div>
                            	<label class="control-label">Changer Type du bien ?</label>
                            	<div class="controls">
                                	<label class="radio">
                                 	<input type="radio" class="typeBien" name="typeBien" value="localCommercial" />
                                 	Local commercial
                                	</label>
                                	<label class="radio">
                                 	<input type="radio" class="typeBien" name="typeBien" value="appartement" />
                                 	Appartement
                                	</label>
                             	</div>
                          	</div>
                          	<div class="control-group hidenBlock">
                          		<label class="control-label" for="" id="nomBienLabel"></label>
                             	<div class="controls">
                             		<select class="m-wrap" name="bien" id="bien">
                             		</select>
                            	</div>
                          	</div>
							<div class="control-group">
							    <input type="hidden" name="action" value="update" />
							    <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
								<input type="hidden" name="codeContrat" value="<?= $contrat->code() ?>" />
								<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
								<div class="controls">	
									<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
									<button type="submit" class="btn red" aria-hidden="true">Oui</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- updateContrat box end -->		
				<?php 
				}
				else{
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert"></button>
					<strong>Erreur système : </strong>Ce projet n'existe pas sur votre système. Pour plus d'informations consulter votre administrateur.		
				</div>
				<?php
				}
				?>
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
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
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
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_managed");
			$('.hidenBlock').hide();
			App.init();
		});
	</script>
	<script>
		$(document).ready(function() {
		    $('#currency').on('change',function(){
                if( $(this).val()!=="DH"){
                    $("#tauxDeChange").show()
                }
                else{
                    $("#tauxDeChange").hide()
                }
            });
			$('.typeBien').change(function(){
				$('.hidenBlock').show();
				var typeBien = $(this).val();
				var idProjet = <?= $projet->id() ?>;
				var data = 'typeBien='+typeBien+'&idProjet='+idProjet;
				$.ajax({
					type: "POST",
					url: "types-biens.php",
					data: data,
					cache: false,
					success: function(html){
						$('#bien').html(html);
						if(typeBien=="appartement"){
							$('#nomBienLabel').text("Appartements");	
						}
						else{
							$('#nomBienLabel').text("Locaux commerciaux");
						}
					}
				});
			});
			$('#nombreMois').change(function(){
                var dureePaiement = $('#dureePaiement').val();
                var prixNegocie = $('#prixVente').val();
                var avance = $('#avance').val();
                var nombreMois = $(this).val();
                var echeance = Math.round( ( prixNegocie - avance ) / ( dureePaiement / nombreMois ) );
                $('#echeance').val(echeance);
            });
		});
		function blinker() {
            $('.blink_me').fadeOut(500);
            $('.blink_me').fadeIn(500);
        }
        
        setInterval(blinker, 1500);
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