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
    	//les sources
		$employeManager = new EmployeProjetManager($pdo);
		$employe = "";
		$idEmploye = 0;
		if( isset($_GET['idEmploye']) and 
		( $_GET['idEmploye']>0 and $_GET['idEmploye']<=$employeManager->getLastId() ) ){
			$idEmploye = htmlentities($_GET['idEmploye']);
			$employe = $employeManager->getEmployeProjetById($idEmploye);
			$salairesManager = new EmployeProjetSalaireManager($pdo);	
			$salaires = $salairesManager->getSalairesByIdEmploye($idEmploye);
			$congesManager = new EmployeProjetCongeManager($pdo);
			$conges = $congesManager->getCongesByIdEmploye($idEmploye);
			$projetManager = new ProjetManager($pdo);
			$projet = $projetManager->getProjetById($employe->idProjet());
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
							Fiche de l'employé
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-bar-chart"></i>
								<a>Gestion de la société</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-group"></i>
								<a>Employés de la société</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Fiche de l'employé</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid add-portfolio">
							<div class="pull-left">
								<a href="employes-projet.php?idProjet=<?= $projet->id() ?>" class="btn icn-only green"><i class="m-icon-swapleft m-icon-white"></i> Retour vers Liste des employés du projet <strong><?= $projet->nom() ?></strong></a>
							</div>
						</div>
						<div class="tab-pane active" id="tab_1">
							<?php if(isset($_SESSION['employe-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['employe-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['employe-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['employe-update-success']);
	                         ?>
	                         <?php if(isset($_SESSION['employe-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['employe-delete-success']);
	                         ?>
	                         <?php if(isset($_SESSION['employe-add-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['employe-add-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['employe-add-error']);
	                         ?>
	                         <?php if(isset($_SESSION['employe-update-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['employe-update-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['employe-update-error']);
	                         ?>
	                         <?php if(isset($_SESSION['salaire-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['salaire-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['salaire-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['salaire-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['salaire-add-error'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['salaire-add-error']);
	                         ?>
	                         <?php if(isset($_SESSION['salaire-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['salaire-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['salaire-update-success']);
	                         ?>
	                        <?php if(isset($_SESSION['salaire-update-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['salaire-update-error'] ?>		
							</div>
	                        <?php } 
	                        	unset($_SESSION['salaire-update-error']);
	                        ?>
	                        <?php if(isset($_SESSION['salaire-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['salaire-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['salaire-delete-success']);
	                         ?>
	                         <?php if(isset($_SESSION['conge-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['conge-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['conge-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['conge-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['conge-add-error'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['conge-add-error']);
	                         ?>
	                         <?php if(isset($_SESSION['conge-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['conge-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['conge-update-success']);
	                         ?>
	                         <?php if(isset($_SESSION['conge-update-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['conge-update-error'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['conge-update-error']);
	                         ?>
	                         <?php if(isset($_SESSION['conge-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['conge-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['conge-delete-success']);
	                         ?>
                        </div>
					</div>
				</div>
				<div class="row-fluid profile"> 
					<div class="span12">
						<!--BEGIN TABS-->
						<?php
						if( $idEmploye != 0 ){
						?>
						<div class="tabbable tabbable-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1_1" data-toggle="tab">Fiche de l'employé</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane row-fluid active" id="tab_1_1">
									<ul class="unstyled profile-nav span3">
										<li>
											<?php 
											if( str_word_count($employe->photo()) > 0 ){
											?>
											<img src="<?= $employe->photo() ?>" alt="" style="width: 200px; height: 200px;" />
											<?php
											} 
											else{
											?>
											<img src="assets/img/green-user-icon.png" alt="" style="width: 200px; height: 200px;" />
											<?php 
											}
											?>
										</li>
										<li>
											<a href="#updateEmploye<?php echo $employe->id();?>" data-toggle="modal" data-id="<?php echo $employe->id(); ?>">
												Modifier les informations
											</a>
										</li>
										<li>
											<a href="#addSalaireEmploye<?php echo $employe->id();?>" data-toggle="modal" data-id="<?php echo $employe->id(); ?>">
												Ajouter un salaire
											</a>
										</li>
										<li>
											<a href="#addCongeEmploye<?php echo $employe->id();?>" data-toggle="modal" data-id="<?php echo $employe->id(); ?>">
												Ajouter un congé
											</a>
										</li>
									</ul>
									<div class="span9">
										<div class="row-fluid">
											<div class="span8 profile-info">
												<h1><?= $employe->nom() ?></h1>
												<ul class="unstyled inline">
													<li><a>CIN</a> : <?= $employe->cin() ?></li>
													<li><a>Etat Civile</a> : <?= $employe->etatCivile() ?></li>
													<li><a>Date début</a> : <?= $employe->dateDebut() ?></li>
													<?php if( strcmp($employe->dateSortie(), '0000-00-00') != 0 ){ ?>
													<li><a>Date sortie</a> : <?= $employe->dateSortie() ?></li>
													<?php } ?>
													<li><a>Téléphone</a> : <?= $employe->telephone() ?></li>
													<?php if( str_word_count($employe->email()) > 0 ){ ?>
													<li><a>Email</a> : <?= $employe->email() ?></li>
													<?php } ?>
												</ul>
											</div>
											<!--end span8-->
										</div>
										<!--end row-fluid-->
										<div class="tabbable tabbable-custom tabbable-custom-profile">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#tab_1_11" data-toggle="tab">Bilan des salaires</a></li>
												<li class=""><a href="#tab_1_22" data-toggle="tab">Les congés</a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_11">
													<div class="portlet-body" style="display: block;">
														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th class="hidden-phone">Date</th>
																	<th>Prix/Jour</th>
																	<th>Nbre.Jours</th>
																	<th>Total</th>
																	<th>Modifier</th>
																	<th>Supprimer</th>
																</tr>
															</thead>
															<tbody>
																<?php
																foreach( $salaires as $salaire ){
																?>
																<tr>
																	<td class="hidden-phone"><?= date('d-m-Y', strtotime($salaire->dateOperation())) ?></td>
																	<td><a href="#"><?= number_format($salaire->salaire(), 2, ',', ' ') ?></a></td>
																	<td><a href="#"><?= $salaire->nombreJours() ?></a></td>
																	<td><a href="#"><?= number_format($salaire->salaire()*$salaire->nombreJours(), 2, ',', ' ') ?></a></td>
																	<td>
																		<a href="#updateSalaireEmploye<?php echo $salaire->id();?>" data-toggle="modal" data-id="<?php echo $salaire->id(); ?>">
																			Modifier
																		</a>
																	</td>
																	<td>
																		<a href="#deleteSalaireEmploye<?php echo $salaire->id();?>" data-toggle="modal" data-id="<?php echo $salaire->id(); ?>">
																			Supprimer
																		</a>
																	</td>
																</tr>
																<!-- update salaire box begin-->
																<div id="updateSalaireEmploye<?= $salaire->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																		<h3>Modifié Salaire Employé</h3>
																	</div>
																	<div class="modal-body">
																		<form class="form-horizontal" action="controller/EmployeProjetSalaireUpdateController.php" method="post" enctype="multipart/form-data">
																			<p>Êtes-vous sûr de vouloir modifier salaire pour l'employé <strong><?= $employe->nom() ?></strong> ?</p>
																			<div class="control-group">
																				<label class="control-label">Prix Journalier</label>
																				<div class="controls">
																					<input type="text" name="salaire" value="<?= $salaire->salaire() ?>" />
																				</div>
																			</div>
																			<div class="control-group">
																				<label class="control-label">Nombre Jours</label>
																				<div class="controls">
																					<input type="text" name="nombreJours" value="<?= $salaire->nombreJours() ?>" />
																				</div>
																			</div>	
																			<div class="control-group">
																				<label class="control-label">Date opération</label>
																				<div class="controls">
																					<input type="text" name="dateOperation" value="<?= $salaire->dateOperation() ?>" />
																				</div>
																			</div>
																			<div class="control-group">
																				<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
																				<input type="hidden" name="idSalaire" value="<?= $salaire->id() ?>" />
																				<div class="controls">	
																					<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																					<button type="submit" class="btn red" aria-hidden="true">Oui</button>
																				</div>
																			</div>
																		</form>
																	</div>
																</div>
																<!-- update salaire box end -->
																<!-- delete box begin-->
																<div id="deleteSalaireEmploye<?= $salaire->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																		<h3>Supprimer Salaire</h3>
																	</div>
																	<div class="modal-body">
																		<form class="form-horizontal loginFrm" action="controller/EmployeProjetSalaireDeleteController.php" method="post">
																			<p>Êtes-vous sûr de vouloir supprimer le salaire cet employé <strong><?= $employe->nom() ?></strong> ?</p>
																			<div class="control-group">
																				<label class="right-label"></label>
																				<input type="hidden" name="idSalaire" value="<?= $salaire->id() ?>" />
																				<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
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
														<a class="btn big blue">Total : <?= number_format($salairesManager->getTotalByIdEmploye($idEmploye), 2, ',', ' ') ?></a>
													</div>
												</div>
												<!--tab-pane-->
												<div class="tab-pane" id="tab_1_22">
													<div class="portlet-body" style="display: block;">
														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Date début</th>
																	<th class="hidden-phone">Date fin</th>
																	<th>Modifier</th>
																	<th>Supprimer</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach($conges as $conge){ ?>
																<tr>
																	<td><?= $conge->dateDebut() ?></td>
																	<td><?= $conge->dateFin() ?></td>
																	<td>
																		<a href="#updateCongeEmploye<?= $conge->id();?>" data-toggle="modal" data-id="<?= $conge->id(); ?>">
																			Modifier
																		</a>
																	</td>
																	<td>
																		<a href="#deleteCongeEmploye<?= $conge->id();?>" data-toggle="modal" data-id="<?= $conge->id(); ?>">
																			Supprimer
																		</a>
																	</td>
																</tr>
																<!-- update conge box begin-->
																<div id="updateCongeEmploye<?= $conge->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																		<h3>Modifié Congé Employé</h3>
																	</div>
																	<div class="modal-body">
																		<form class="form-horizontal" action="controller/EmployeProjetCongeUpdateController.php" method="post" enctype="multipart/form-data">
																			<p>Êtes-vous sûr de vouloir modifier congé pour l'employé <strong><?= $employe->nom() ?></strong> ?</p>
																			<div class="control-group">
																				<label class="control-label">Date début</label>
																				<div class="controls">
																					<input type="text" name="dateDebut" value="<?= $conge->dateDebut() ?>" />
																				</div>
																			</div>
																			<div class="control-group">
																				<label class="control-label">Date fin</label>
																				<div class="controls">
																					<input type="text" name="dateFin" value="<?= $conge->dateFin() ?>" />
																				</div>
																			</div>
																			<div class="control-group">
																				<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
																				<input type="hidden" name="idConge" value="<?= $conge->id() ?>" />
																				<div class="controls">	
																					<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																					<button type="submit" class="btn red" aria-hidden="true">Oui</button>
																				</div>
																			</div>
																		</form>
																	</div>
																</div>
																<!-- update conge box end -->
																<!-- delete box begin-->
																<div id="deleteCongeEmploye<?= $conge->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																		<h3>Supprimer Congé</h3>
																	</div>
																	<div class="modal-body">
																		<form class="form-horizontal loginFrm" action="controller/EmployeProjetCongeDeleteController.php" method="post">
																			<p>Êtes-vous sûr de vouloir supprimer le congé de cet employé <strong><?= $employe->nom() ?></strong> ?</p>
																			<div class="control-group">
																				<label class="right-label"></label>
																				<input type="hidden" name="idConge" value="<?= $conge->id() ?>" />
																				<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
																				<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																				<button type="submit" class="btn red" aria-hidden="true">Oui</button>
																			</div>
																		</form>
																	</div>
																</div>
																<!-- delete box end -->		
																<?php } ?>
															</tbody>
														</table>
													</div>
												</div>
												<!--tab-pane-->
											</div>
										</div>
									</div>
									<!--end span9-->
								</div>
								<!--end tab-pane-->
								<!-- update box begin-->
								<div id="updateEmploye<?= $employe->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Modifier Infos Employé</h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="controller/EmployeProjetUpdateController.php?param=2" method="post" enctype="multipart/form-data">
											<p>Êtes-vous sûr de vouloir modifier les infos de l'employé <strong><?= $employe->nom() ?></strong> ?</p>
											<div class="control-group">
												<label class="control-label">Nom</label>
												<div class="controls">
													<input type="text" name="nom" value="<?= $employe->nom() ?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">CIN</label>
												<div class="controls">
													<input type="text" name="cin" value="<?= $employe->cin() ?>" />
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label">Etat civile</label>
												<div class="controls">
													<select name="etatCivile" class="m-wrap">
														<option value="<?= $employe->etatCivile() ?>"><?= $employe->etatCivile() ?></option>
														<option disabled="disabled">-----------</option>
	                                             		<option value="Célibataire">Célibataire</option>
	                                             		<option value="Marié">Marié</option>
	                                             		<option value="Divorcé">Divorcé</option>
	                                             		<option value="Veuf">Veuf</option>
	                                             	</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Photo</label>
												<div class="controls">
													<input type="file" name="newPhoto" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Date début</label>
												<div class="controls">
													<input type="text" name="dateDebut" value="<?= $employe->dateDebut() ?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Date sortie</label>
												<div class="controls">
													<input type="text" name="dateSortie" value="<?= $employe->dateSortie() ?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Téléphone</label>
												<div class="controls">
													<input type="text" name="telephone" value="<?= $employe->telephone() ?>" />
												</div>	
											</div>
											<div class="control-group">
												<label class="control-label">Email</label>
												<div class="controls">
													<input type="text" name="email" value="<?= $employe->email() ?>" />
												</div>	
											</div>
											<div class="control-group">
												<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
												<input type="hidden" name="photo" value="<?= $employe->photo() ?>" />
												<div class="controls">	
													<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
													<button type="submit" class="btn red" aria-hidden="true">Oui</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- update box end -->	
								<!-- add salaire box begin-->
								<div id="addSalaireEmploye<?= $employe->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Ajouter Salaire Employé</h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="controller/EmployeProjetSalaireAddController.php" method="post" enctype="multipart/form-data">
											<p>Êtes-vous sûr de vouloir ajouter salaire pour l'employé <strong><?= $employe->nom() ?></strong> ?</p>
											<div class="control-group">
												<label class="control-label">Prix Journalier</label>
												<div class="controls">
													<input type="text" name="salaire" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Nombre Jours</label>
												<div class="controls">
													<input type="text" name="nombreJours" value="0" />
												</div>
											</div>	
											<div class="control-group">
												<label class="control-label">Date opération</label>
												<div class="controls">
													<input type="text" name="dateOperation" value="<?= date('Y-m-d') ?>" />
												</div>
											</div>
											<div class="control-group">
												<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
												<div class="controls">	
													<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
													<button type="submit" class="btn red" aria-hidden="true">Oui</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- add salaire box end -->
								<!-- add congé box begin-->
								<div id="addCongeEmploye<?= $employe->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Ajouter Congé Employé</h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="controller/EmployeProjetCongeAddController.php" method="post" enctype="multipart/form-data">
											<p>Êtes-vous sûr de vouloir ajouter congé pour l'employé <strong><?= $employe->nom() ?></strong> ?</p>
											<div class="control-group">
												<label class="control-label">Date début</label>
												<div class="controls">
													<input type="text" name="dateDebut" value="<?= date('Y-m-d') ?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Date fin</label>
												<div class="controls">
													<input type="text" name="dateFin" value="<?= date('Y-m-d') ?>" />
												</div>
											</div>	
											<div class="control-group">
												<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
												<div class="controls">	
													<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
													<button type="submit" class="btn red" aria-hidden="true">Oui</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<!-- add congé box end -->
							</div>
						</div>
						<!--END TABS-->
						<?php
						}
						else{
						?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Cet employé n'existe pas dans votre système.		
						</div>
						<?php	
						}
						?>
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