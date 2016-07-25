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
    	$fournisseurManager = new FournisseurManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		$idFournisseur = 0;
    	if( isset($_GET['idFournisseur']) and 
    	($_GET['idFournisseur']>0 and $_GET['idFournisseur']<=$fournisseurManager->getLastId()) ){
    		$idFournisseur = $_GET['idFournisseur'];
    		$reglementsManager = new ReglementFournisseurManager($pdo);
			$reglementNumber = $reglementsManager->getReglementsNumberByIdFournisseurOnly($idFournisseur);
			if($reglementNumber!=0){
				$reglementPerPage = 10;
		        $pageNumber = ceil($reglementNumber/$reglementPerPage);
		        $p = 1;
		        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
		            $p = $_GET['p'];
		        }
		        else{
		            $p = 1;
		        }
		        $begin = ($p - 1) * $reglementPerPage;
		        $pagination = paginate('fournisseurs-reglements.php?idFournisseur='.$idFournisseur, '&p=', $pageNumber, $p);
				$reglements = $reglementsManager->getReglementFournisseursByIdFournisseurByLimits($idFournisseur, $begin, $reglementPerPage);
				$total = $reglementsManager->getTotalReglementByIdFournisseur($idFournisseur);
			}
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($idFournisseur);
			if($livraisonNumber!=0){	
				$totalLivraison = $livraisonManager->getTotalLivraisonsIdFournisseur($idFournisseur);
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
	<div class="page-container row-fluid">
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
							Gestion des réglements des fournisseurs
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-briefcase"></i>
								<a>Gestion des projets</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Gestion des réglements fournisseurs</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<?php if($idFournisseur!=0){ ?>
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
							<div class="row-fluid add-portfolio">
								<div class="pull-left">
									<a href="fournisseurs.php" class="btn icn-only green">
										<i class="m-icon-swapleft m-icon-white"></i> 
										Retour vers Liste des fournisseurs
									</a>
								</div>
								<div class="pull-right">
									<a href="projet-list.php" class="btn icn-only green"> 
										Aller vers Liste des projets 
										<i class="m-icon-swapright m-icon-white"></i>
									</a>
									<a href="#addReglement" data-toggle="modal" class="btn black">
										Ajouter Nouveau Régelement 
										<i class="icon-plus-sign "></i>
									</a>
								</div>
								<!-- addReglement box begin-->
								<div id="addReglement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Ajouter un nouveau réglement </h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="controller/ReglementFournisseurAddController.php" method="post">
											<div class="control-group">
												<label class="control-label">Projet</label>
												<div class="controls">
													<select name="idProjet" style="width: 150px" class="m-wrap">
	                                                	<?php foreach($projetManager->getProjets() as $projet){ ?>
	                                                	<option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
	                                                	<?php } ?>
	                                                </select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Date Réglement</label>
												<div class="controls">
													<input type="text" name="dateReglement" value="<?= date('Y-m-d') ?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Montant</label>
												<div class="controls">
													<input type="text" name="montant" value="" />
												</div>	
											</div>
											<div class="control-group">
												<label class="control-label">Mode de paiement</label>
												<div class="controls">
													<select id="modePaiement" name="modePaiement" style="width: 150px" class="m-wrap">
														<option value="Especes">Especes</option>
														<option value="Cheque">Cheque</option>
														<option value="Versement">Versement</option>
														<option value="Virement">Virement</option>
													</select>
												</div>	
											</div>
											<div class="row-fluid" id="numeroCheque" style="display: none">
		                                    	<div class="span6">
		                                          <div class="control-group">
		                                             <label class="control-label">N°Chèque</label>
		                                             <div class="controls">
		                                                <input type="text" name="numeroCheque" class="m-wrap">
		                                             </div>
		                                          </div>
		                                       </div>
		                                    </div>
											<div class="control-group">
												<div class="controls">
													<input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />	
													<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
													<button type="submit" class="btn red" aria-hidden="true">Oui</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- addReglement box end -->
							</div>
							<?php if(isset($_SESSION['reglement-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['reglement-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['reglement-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['reglement-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['reglement-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['reglement-update-success']);
	                         ?>
	                         <?php if(isset($_SESSION['reglement-add-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['reglement-add-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['reglement-add-error']);
	                         ?>
	                         <?php if(isset($_SESSION['reglement-update-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['reglement-update-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['reglement-update-error']);
	                         ?>
                           <!--div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4>
                                 	<i class="icon-edit"></i>
                                 	Ajouter un nouvel réglement pour le fournisseur : <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong>
                                 	</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <!--form action="controller/ReglementFournisseurAddController.php" method="POST" class="horizontal-form">
                               		<div class="row-fluid">
                               			<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="dateReglement">Date réglement</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input style="width: 100px;" name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                 </div>
                                             </div>
                                          </div>
                                       </div>
                               			<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label">Projet</label>
                                             <div class="controls">
                                                <select name="idProjet" style="width: 150px" class="m-wrap">
                                                	<?php foreach($projetManager->getProjets() as $projet){ ?>
                                                	<option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                	<?php } ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="montant">Montant</label>
                                             <div class="controls">
                                                <input type="text" id="montant" name="montant" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="modePaiement">Mode de paiement</label>
                                             <div class="controls">
                                                <div class="controls">
													<select id="modePaiement" name="modePaiement" style="width: 150px" class="m-wrap">
														<option value="Especes">Especes</option>
														<option value="Cheque">Cheque</option>
														<option value="Versement">Versement</option>
														<option value="Virement">Virement</option>
													</select>
												</div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid" id="numeroCheque" style="display: none">
                                    	<div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">N°Chèque</label>
                                             <div class="controls">
                                                <input type="text" name="numeroCheque" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />
                                    	<button type="submit" class="btn black">Enregistrer <i class="icon-save"></i></button>
                                    	<button type="reset" class="btn red">Annuler</button>
                                    </div>
                                 </form-->
                                 <!-- END FORM--> 
                              <!--/div>
                           </div-->
                        </div>
					</div>
				</div>
				<?php if(isset($_SESSION['reglement-delete-success'])){ ?>
             	<div class="alert alert-success">
					<button class="close" data-dismiss="alert"></button>
					<?= $_SESSION['reglement-delete-success'] ?>		
				</div>
	             <?php } 
	             	unset($_SESSION['reglement-delete-success']);
	             ?>
				<div class="row-fluid"> 
					<div class="span12">
						<!-- BEGIN Terrain TABLE PORTLET-->
						<div class="portlet" id="listFournisseurs">
							<div class="portlet-title">
								<h4>Liste des réglement du fournisseur : <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong></h4>
	                       		<a target="_blank" class="btn blue big" href="controller/ReglementFournisseurPrintController.php?idFournisseur=<?= $idFournisseur ?>">
									<i class="icon-print"></i>
									Imprimer Bilan									
								</a>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th class="hidden-phone">Date réglement</th>
											<th>Montant</th>
											<th class="hidden-phone">Mode Paiement</th>
											<th>Projet</th>
											<th class="hidden-phone">Modifier</th>
											<th class="hidden-phone">Supprimer</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($reglementNumber != 0){
										foreach($reglements as $reglement){
										?>		
										<tr>
											<td class="hidden-phone"><a><?= date('d-m-Y', strtotime($reglement->dateReglement())) ?></a></td>
											<td><?= number_format($reglement->montant(), 2, ',', ' ') ?></td>
											<td class="hidden-phone">
												<?= $reglement->modePaiement() ?>
												<?php if($reglement->modePaiement()=="Cheque"){
												?>
												 	- <a href="#updateNumeroCheque<?= $reglement->id() ?>" data-toggle="modal" data-id="<?= $reglement->id() ?>">
												 		N° : <?= $reglement->numeroCheque() ?>
												 	</a>
												<?php
												} 
												?>
											</td>
											<td><?= $projetManager->getProjetById($reglement->idProjet())->nom() ?></td>
											<td class="hidden-phone">
												<a href="#update<?= $reglement->id() ?>" data-toggle="modal" data-id="<?= $reglement->id() ?>">
													Modifier
												</a>
											</td>
											<td class="hidden-phone">
												<a href="#delete<?= $reglement->id() ?>" data-toggle="modal" data-id="<?= $reglement->id() ?>">
													Supprimer
												</a>
											</td>
										</tr>
										<!-- update box begin-->
										<div id="updateNumeroCheque<?= $reglement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Numero Chèque</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ReglementFournisseurUpdateChequeController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier le numero de chèque ?</p>
															Numero Chèque
															<input type="text" name="numeroCheque" value="<?= $reglement->numeroCheque() ?>" />
													<div class="control-group">
														<input type="hidden" name="idReglement" value="<?= $reglement->id() ?>" />
														<input type="hidden" name="idFournisseur" value="<?= $reglement->idFournisseur() ?>" />
														<div class="controls">	
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateNumeroCheque box end -->
										<!-- update box begin-->
										<div id="update<?= $reglement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Infos Opérations</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ReglementFournisseurUpdateController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier les informations de ce réglement ?</p>
													<div class="control-group">
														<label class="control-label">Date réglement</label>
														<div class="controls">
															<input type="text" name="dateReglement" value="<?= $reglement->dateReglement() ?>" />
														</div>
													</div>
			                                          <div class="control-group">
			                                             <label class="control-label">Projet</label>
			                                             <div class="controls">
			                                                <select name="idProjet" style="width: 200px" class="m-wrap">
			                                                	<option value="<?= $reglement->idProjet() ?>"><?= $projetManager->getProjetById($reglement->idProjet())->nom() ?></option>
                                                				<option disabled="disabled">------------------------</option>
			                                                	<?php foreach($projetManager->getProjets() as $projet){ ?>
			                                                	<option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
			                                                	<?php } ?>
			                                                </select>
			                                             </div>
			                                          </div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $reglement->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
			                                             <label class="control-label" for="modePaiement">Mode de paiement</label>
			                                             <div class="controls">
			                                                <div class="controls">
																<select id="modePaiement" name="modePaiement" style="width: 200px" class="m-wrap">
																	<option value="<?= $reglement->modePaiement() ?>"><?= $reglement->modePaiement() ?></option>
																	<option disabled="disabled">------------------------</option>
																	<option value="Especes">Especes</option>
																	<option value="Cheque">Cheque</option>
																	<option value="Versement">Versement</option>
																	<option value="Virement">Virement</option>
																</select>
															</div>
			                                             </div>
			                                          </div>
													<div class="control-group">
														<input type="hidden" name="idReglement" value="<?= $reglement->id() ?>" />
														<input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />
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
										<div id="delete<?= $reglement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer réglement fournisseur </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ReglementFournisseurDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer ce réglement ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idReglement" value="<?= $reglement->id() ?>" />
														<input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />
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
									if($reglementNumber != 0){
										echo $pagination;	
									}
									?>
								</table>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th><strong>Total Livraisons</strong></th>
											<td>
												<strong>
													<a>
														<?php //number_format($totalLivraison, 2, ',', ' ') ?>
														<?php if($livraisonNumber!=0){
						                       					echo number_format($totalLivraison, 2, ',', ' '); 
																}
															else{
																echo 0;
															}  
														?> 
													</a>
													&nbsp;DH
												</strong>
											</td>
										</tr>
										<tr>
											<th><strong>Total Réglements</strong></th>
											<td>
												<strong>
													<a>
														<?php //number_format($totalReglement, 2, ',', ' ') ?>
														<?php if($reglementNumber!=0){
						                       					echo number_format($total, 2, ',', ' '); 
																}
															else{
																echo 0;
															}  
														?>
													</a>
													&nbsp;DH
												</strong>
											</td>
										</tr>
										<tr>
											<th><strong>Σ Livraisons - Σ Réglements</strong></th>
											<td>
												<strong>
													<a>
						                       			<?php if($livraisonNumber!=0 and $reglementNumber==0){
						                       					echo number_format($totalLivraison, 2, ',', ' '); 
																}
															else if($livraisonNumber!=0 and $reglementNumber!=0){
																echo number_format($totalLivraison-$total, 2, ',', ' ');
															}
															else{
																echo 0;
															}  
														?>
													</a>
													&nbsp;DH
												</strong>
											</td>
										</tr>		
									</thead>
								</table>	
							</div>
						</div>
						<!--div class="pull-left hidden-phone">
                       		<a class="btn red big">
                       			Total des réglements = 
                       			<?php if($reglementNumber!=0){
                       					echo number_format($total, 2, ',', ' '); 
										}
									else{
										echo 0;
									}  
								?>
                       		</a>
                       		<a class="btn green big">
                       			Total des livraisons =
                       			<?php if($livraisonNumber!=0){
                       					echo number_format($totalLivraison, 2, ',', ' '); 
										}
									else{
										echo 0;
									}  
								?> 
                       		</a>
                       		<a class="btn blue big">
                       			Σ Livraisons - Σ Réglements =
                       			<?php if($livraisonNumber!=0 and $reglementNumber==0){
                       					echo number_format($totalLivraison, 2, ',', ' '); 
										}
									else if($livraisonNumber!=0 and $reglementNumber!=0){
										echo number_format($totalLivraison-$total, 2, ',', ' ');
									}
									else{
										echo 0;
									}  
								?>
							</a> 
                       	</div-->
                       	<!--div class="hidden-desktop">
                       		<a class="btn red big span4">
                       			Total réglements = 
                       			<?php if($reglementNumber!=0){
                       					echo number_format($total, 2, ',', ' '); 
										}
									else{
										echo 0;
									}  
								?>
                       		</a>
                       		<br><br>
                       		<a class="btn green big span4">
                       			Total BL = 
                       			<?php if($livraisonNumber!=0){
                       					echo number_format($totalLivraison, 2, ',', ' '); 
										}
									else{
										echo 0;
									}  
								?> 
                       		</a>
                       		<br><br>
                       		<a class="btn blue big span4">
                       			BL - Réglements= 
                       			<?php if($livraisonNumber!=0 and $reglementNumber==0){
                       					echo number_format($totalLivraison, 2, ',', ' '); 
										}
									else if($livraisonNumber!=0 and $reglementNumber!=0){
										echo number_format($totalLivraison-$total, 2, ',', ' ');
									}
									else{
										echo 0;
									}  
								?>
                       		</a>
                       	</div-->
						<!-- END Terrain TABLE PORTLET-->
					</div>
				</div>
				<?php }
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
		2015 &copy; MerlaTravERP. Management Application.
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
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
		});
		$('#modePaiement').on('change',function(){
	        if( $(this).val()==="Cheque"){
	        $("#numeroCheque").show()
	        }
	        else{
	        $("#numeroCheque").hide()
	        }
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