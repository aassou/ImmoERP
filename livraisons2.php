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
    if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin"){
    	//classManagers
    	$projetManager = new ProjetManager($pdo);
		$fournisseurManager = new FournisseurManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		$livraisonDetailManager = new LivraisonDetailManager($pdo);
		$reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
		//classes and vars
		$projets = $projetManager->getProjets();
		$fournisseurs = $fournisseurManager->getFournisseurs();
		$projet = $projetManager->getProjets();
		$livraisonNumber = 0;
		$totalReglement = 0;
		$totalLivraison = 0;
		$titreLivraison ="Liste de toutes les livraisons";
		$hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php";
		$livraisonListDeleteLink = "";
		if( isset($_GET['idFournisseur']) and !empty($_GET['idProjet']) and 
		$fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']>=1)){
			$fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
			$idProjet = $_GET['idProjet'];
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseurByProjet($fournisseur, $idProjet);
			if($livraisonNumber != 0){
				$livraisonPerPage = 10;
		        $pageNumber = ceil($livraisonNumber/$livraisonPerPage);
		        $p = 1;
		        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
		            $p = $_GET['p'];
		        }
		        else{
		            $p = 1;
		        }
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
		else if( isset($_GET['idFournisseur']) and 
		$fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']>=1)){
			$fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($fournisseur);
			if($livraisonNumber != 0){
				$livraisonPerPage = 10;
		        $pageNumber = ceil($livraisonNumber/$livraisonPerPage);
		        $p = 1;
		        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
		            $p = $_GET['p'];
		        }
		        else{
		            $p = 1;
		        }
				$livraisonListDeleteLink = "?idFournisseur=".$_GET['idFournisseur']."&p=".$p;
		        $begin = ($p - 1) * $livraisonPerPage;
		        $pagination = paginate('livraisons2.php?idFournisseur='.$_GET['idFournisseur'], '&p=', $pageNumber, $p);
				$livraisons = $livraisonManager->getLivraisonsByIdFournisseurByLimits($fournisseur, $begin, $livraisonPerPage);
				$titreLivraison ="Liste des livraisons du fournisseur <strong>".$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong>";
				//get the sum of livraisons details using livraisons ids (idFournisseur)
				$livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseur($fournisseur);
				$sommeDetailsLivraisons = 0;
				foreach($livraisonsIds as $idl){
					$sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
				}	
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($fournisseur);
				$totalLivraison = 
				$livraisonManager->getTotalLivraisonsIdFournisseur($fournisseur)+
				$sommeDetailsLivraisons;
				$hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php?idFournisseur=".$fournisseur;
			}
		}
		else {
			$livraisonNumber = $livraisonManager->getLivraisonNumber();
			if($livraisonNumber != 0){
				$livraisonPerPage = 10;
		        $pageNumber = ceil($livraisonNumber/$livraisonPerPage);
		        $p = 1;
		        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
		            $p = $_GET['p'];
		        }
		        else{
		            $p = 1;
		        }
				$livraisonListDeleteLink = "&p=".$p;
		        $begin = ($p - 1) * $livraisonPerPage;
		        $pagination = paginate('livraisons2.php', '?p=', $pageNumber, $p);
				$livraisons = $livraisonManager->getLivraisonsByLimit($begin, $livraisonPerPage);
				$titreLivraison ="Liste de toutes les livraisons";
				$totalReglement = $reglementsFournisseurManager->getTotalReglement();
				$totalLivraison = 
				$livraisonManager->getTotalLivraisons() + $livraisonDetailManager->getTotalLivraison();	
				$hrefLivraisonBilanPrintController = "controller/Livraison2BilanPrintController.php";
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
	<title>AnnahdaERP - Management Application</title>
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
								<a href="dashboard.php">Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-truck"></i>
								<a>Gestion des livraisons</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid add-portfolio">
							<div class="pull-left">
								<!--a href="livraison-add.php" class="btn icn-only blue"-->
								<a href="#addFournisseur" data-toggle="modal" class="btn blue">
									Ajouter Nouveau Fournisseur <i class="icon-plus-sign "></i>
								</a>
							</div>
							<div class="pull-right">
								<a href="#addLivraison" data-toggle="modal" class="btn green">
									Ajouter Nouvelle Livraison <i class="icon-plus-sign "></i>
								</a>
								<a href="#addReglement" data-toggle="modal" class="btn black">
									Ajouter Nouveau Régelement <i class="icon-plus-sign "></i>
								</a>
							</div>
						</div>
						<!-- addFournisseur box begin-->
						<div id="addFournisseur" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter un nouveau fournisseur </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/FournisseurAddController.php?p=1" method="post">
									<div class="control-group">
										<label class="control-label">Nom</label>
										<div class="controls">
											<input type="text" name="nom" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Adresse</label>
										<div class="controls">
											<input type="text" name="adresse" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Tél.1</label>
										<div class="controls">
											<input type="text" name="telephone1" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Tél.2</label>
										<div class="controls">
											<input type="text" name="telephone2" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Fax</label>
										<div class="controls">
											<input type="text" name="fax" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Email</label>
										<div class="controls">
											<input type="text" name="email" value="" />
										</div>	
									</div>
									<div class="control-group">
										<div class="controls">	
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addFournisseur box end -->
						<!-- addLivraison box begin-->
						<div id="addLivraison" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter une nouvelle livraison </h3>
							</div>
							<div class="modal-body">
								<form id="addLivraisonForm" class="form-horizontal" action="controller/LivraisonActionController.php" method="post">
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
                                            	<?php foreach($projets as $projet){ ?>
                                            	<option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                            	<?php } ?>
                                            </select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Date Livraison</label>
										<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
		                                    <input name="dateLivraison" id="dateLivraison" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
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
										<div class="controls">	
										    <input type="hidden" name="action" value="add">    
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addLivraison box end -->
						<!-- addReglement box begin-->
						<div id="addReglement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter un nouveau réglement </h3>
							</div>
							<div class="modal-body">
								<form id="addReglementForm" class="form-horizontal" action="controller/ReglementFournisseurAddController.php?p=99" method="post">
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
											<input required="required" id="montant" type="number" name="montant" value="" />
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
												<option value="Remise">Remise</option>
											</select>
										</div>	
									</div>
									<div class="row-fluid">
                                    	<div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">Numéro Operation</label>
                                             <div class="controls">
                                                <input type="text" required="required" id="numeroOperation" name="numeroCheque" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
									<div class="control-group">
										<div class="controls">	
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addReglement box end -->
						<div class="row-fluid">
							<form action="" method="get">
							    <div class="input-box autocomplet_container">
									<input class="m-wrap" name="recherche" id="nomFournisseur" type="text" onkeyup="autocompletFournisseur()" placeholder="Chercher un fournisseur...">
										<ul id="fournisseurList"></ul>
									</input>
									<input class="m-wrap" name="projet" id="nomProjet" type="text" onkeyup="autocompletProjet()" placeholder="Projet">
										<ul id="projetList"></ul>
									</input>
									<input name="idFournisseur" id="idFournisseur" type="hidden" />
									<input name="idProjet" id="idProjet" type="hidden" />
									<button type="submit" class="btn red"><i class="icon-search"></i></button>
									<a target="_blank" href="<?= $hrefLivraisonBilanPrintController ?>" class="btn blue pull-right"><i class="icon-print"></i>&nbsp;Imprimer Bilan</a>
							    </div>
							</form>
						</div>
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
						<div class="portlet">
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Fournisseur</th>
											<th>N° BL</th>
											<th class="hidden-phone">Projet</th>
											<th class="hidden-phone">Date Livraison</th>
											<th class="hidden-phone">Nombre d'articles</th>
											<th class="hidden-phone">Total</th>
										</tr>
									</thead>
									<tbody>
										<!--form action="LivraisonListDeleteController.php<?= $livraisonListDeleteLink ?>" method="post">
											<button type="submit" class="btn red">Supprimer les livraisons sélectionnées</button>
											<br-->											
										<?php
										if($livraisonNumber != 0){
										foreach($livraisons as $livraison){
										?>		
										<tr>
											<td>
												<div class="btn-group">
														<!--input type="checkbox" name="deleteFournisseurList[]" value="<?= $livraison->id() ?>">
													</form-->
												    <a style="width: 100px" class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $fournisseurManager->getFournisseurById($livraison->idFournisseur())->nom() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a target="_blank" href="livraisons-details.php?codeLivraison=<?= $livraison->code() ?>">
												        		Détails de Livraison
												        	</a>
												        	<a target="_blank" href="fournisseurs-reglements.php?idFournisseur=<?= $livraison->idFournisseur() ?>">
												        		Détails Réglements
												        	</a>																
												        	<a href="#updateLivraison<?= $livraison->id();?>" data-toggle="modal" data-id="<?= $livraison->id(); ?>">
																Modifier
															</a>
															<a href="#deleteLivraison<?= $livraison->id() ?>" data-toggle="modal" data-id="<?= $livraison->id() ?>">
																Supprimer
															</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td><?= $livraison->libelle() ?></td>
											<td><?= $projetManager->getProjetById($livraison->idProjet())->nom() ?></td>
											<td><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
											<td>
												<?= $livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id()); ?>
											</td>
											<td>
												<?= number_format($livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id()), 2, ',', ' '); ?>
											</td>
										</tr>
										<!-- add file box begin-->
										<div id="addPieces<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Ajouter des pièces pour cette livraison</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/LivraisonPiecesAddController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir ajouter des pièces pour cette livraison ?</p>
													<div class="control-group">
														<label class="right-label">Nom Pièce</label>
														<input type="text" name="nom" />
														<label class="right-label">Lien</label>
														<input type="file" name="url" />
														<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
														<label class="right-label"></label>
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- add files box end -->
										<!-- updateLivraison box begin-->
										<div id="updateLivraison<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier les informations de la livraison </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/LivraisonActionController.php?p=99" method="post">
													<p>Êtes-vous sûr de vouloir modifier la livraison <strong>N°<?= $livraison->id() ?></strong>  ?</p>
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
                                                                <option value="<?= $livraison->idProjet() ?>"><?= $projetManager->getProjetById($livraison->idProjet())->nom() ?></option>
                                                                <option disabled="disabled">-----------</option>
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
															<input type="text" name="libelle" value="<?= $livraison->libelle() ?>" />
														</div>
													</div>
													<div class="control-group">
														<div class="controls">	
														    <input type="hidden" name="action" value="update" />
														    <input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateLivraison box end -->			
										<!-- delete box begin-->
										<div id="deleteLivraison<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer la livraison </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/Livraison2DeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer la livraison <strong>N°<?= $livraison->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
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
									</tbody>
									<?php
									if($livraisonNumber != 0){
										echo $pagination;	
									}
									?>
								</table>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th><strong>Total Livraisons</strong></th>
											<td><strong><a><?= number_format($totalLivraison, 2, ',', ' ') ?></a>&nbsp;DH</strong></td>
										</tr>
										<tr>
											<th><strong>Total Réglements</strong></th>
											<td><strong><a><?= number_format($totalReglement, 2, ',', ' ') ?></a>&nbsp;DH</strong></td>
										</tr>
										<tr>
											<th><strong>Solde</strong></th>
											<td><strong><a><?= number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?></a>&nbsp;DH</strong></td>
										</tr>		
									</thead>
								</table>	
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
		2015 &copy; AnnahdaERP. Management Application.
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
            validClass: "alid-class"
        });
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}
?>