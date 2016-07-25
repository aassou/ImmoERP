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
    if ( isset($_SESSION['userMerlaTrav']) ){
    	//les sources
    	$projetManager = new ProjetManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		$appartement = "";
		$idLocaux = 0;
		$idProjet = $_GET['idProjet'];
        $projet = $projetManager->getProjetById($idProjet);
		if( isset($_GET['idLocaux']) and 
		( $_GET['idLocaux']>0 and $_GET['idLocaux']<=$locauxManager->getLastId() ) ){
			$idLocaux = htmlentities($_GET['idLocaux']);
			$locaux = $locauxManager->getLocauxById($idLocaux);
			$piecesManager = new PiecesLocauxManager($pdo);
			$piecesNumber = $piecesManager->getPiecesLocauxNumberByIdLocaux($idLocaux);
			if($piecesNumber != 0){
				$piecesLocaux = $piecesManager->getPiecesLocauxByIdLocaux($idLocaux);
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
							Fiche descriptif du local commercial
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
                                <a href="projet-details.php?idProjet=<?= $idProjet ?>">Projet <strong><?= $projet->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="locaux.php?idProjet=<?= $idProjet ?>">Gestion des locaux commerciaux</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Fiche descriptif</a>
                            </li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
							<?php if(isset($_SESSION['pieces-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['pieces-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['locaux-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['locaux-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['locaux-update-success']);
	                         ?>
	                         <?php if(isset($_SESSION['pieces-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['pieces-delete-success']);
	                         ?>
	                         <?php if(isset($_SESSION['pieces-add-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['pieces-add-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['pieces-add-error']);
	                         ?>
                        </div>
					</div>
				</div>
				<div class="row-fluid profile"> 
					<div class="span12">
						<!--BEGIN TABS-->
						<?php
						if( $idLocaux != 0 ){
						?>
						<div class="tabbable tabbable-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1_1" data-toggle="tab">Fiche du local commercial</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane row-fluid active" id="tab_1_1">
									<ul class="unstyled profile-nav span3">
										<li>
											<a href="controller/LocauxFichePrintController.php?idLocaux=<?= $locaux->id() ?>">
												Imprimer Fiche
											</a>
										</li>
										<li>
											<a href="#addPiece<?= $locaux->id();?>" data-toggle="modal" data-id="<?= $locaux->id(); ?>">
												Ajouter un document
											</a>
										</li>
									</ul>
									<div class="span9">
										<div class="row-fluid">
											<div class="span8 profile-info">
												<?php 
													if($locaux->status()=="Non"){
														echo '<a class="btn mini green">Disponible</a>';
													} 
													else{
														echo '<a class="btn mini red">Réservé</a>';
													}
												?>
												<br /><br />
												<h1>Code Local commercial : <?= strtoupper($locaux->nom()) ?></h1>
												<h4>Projet : <?= strtoupper($projetManager->getProjetById($idProjet)->nom()) ?></h4>
												<ul class="unstyled inline">
													<li>
														<?php
														if($locaux->mezzanine()=="Avec"){
															echo '<a class="btn mini blue">Avec Mezzanine</a>';
														} 
														else{
															echo '<a class="btn mini black">Sans Mezzanine</a>';
														}
														?>
													</li>
													<li><a>Supérifice</a> : <?= $locaux->superficie() ?></li>
													<li><a>Façade</a> : <?= $locaux->facade() ?></li>
													<li><a>Prix</a> : <?= number_format($locaux->prix(), 2, ',', ' ') ?> DH</li>
												</ul>
											</div>
											<!--end span8-->
										</div>
										<!--end row-fluid-->
									</div>
									<!--end span9-->
								</div>
								<!--end tab-pane-->
								<!-- update box begin-->
								<!-- update box begin-->
								<div id="updateLocaux<?= $locaux->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Modifier Infos Local commercial <strong><?= $locaux->nom() ?></strong></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="controller/LocauxUpdateController.php?p=2" method="post">
											<p>Êtes-vous sûr de vouloir modifier les informations du local commercial ?</p>
											<div class="control-group">
												<label class="right-label">Code</label>
												<input type="text" name="code" value="<?= $locaux->nom() ?>" />
												<label class="right-label">Supérficie</label>
												<input type="text" name="superficie" value="<?= $locaux->superficie() ?>" />
												<label class="right-label">Façade</label>
												<input type="text" name="facade" value="<?= $locaux->facade() ?>" />
												<label class="right-label">Prix</label>
												<input type="text" name="prix" value="<?= $locaux->prix() ?>" />
												<label class="right-label">Status</label>
												<?php
												$statusReserve = "";
												$statusNonReserve = "";
												if($locaux->status()=="Oui"){
													$statusReserve = "selected";
													$statusNonReserve = "";		
												}
												if($locaux->status()=="Oui"){
													$statusReserve = "";
													$statusNonReserve = "selected";		
												}
												?>
												<select name="status" class="m-wrap">
													<option value="Non" <?php echo $statusReserve; echo $statusNonReserve ?> >
														Non réservé
													</option>
                                     				<option value="Oui" <?php echo $statusReserve; echo $statusNonReserve ?> >
                                     					Réservé
                                     				</option>
												</select>
												<label class="right-label">Mezzanine</label>
												<?php
												$avecMezzanine = "";
												$sansMezzanine = "";
												if($locaux->mezzanine()=="Avec"){
													$avecMezzanine = "selected";
													$sansMezzanine = "";		
												}
												if($locaux->mezzanine()=="Sans"){
													$avecMezzanine = "";
													$sansMezzanine = "selected";		
												}
												?>
												<select name="cave" class="m-wrap">
													<option value="Sans" <?php echo $avecMezzanine; echo $sansMezzanine; ?> >
														Sans
													</option>
                                     				<option value="Avec" <?php echo $avecMezzanine; echo $sansMezzanine; ?> >
                                     					Avec
                                     				</option>
												</select>
												<input type="hidden" name="idLocaux" value="<?= $locaux->id() ?>" />
												<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
												<label class="right-label"></label>
												<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
												<button type="submit" class="btn red" aria-hidden="true">Oui</button>
											</div>
										</form>
									</div>
								</div>	
								<!-- update box end -->	
								<!-- add piece box begin-->
								<div id="addPiece<?= $locaux->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Ajouter Document Local commercial</h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="controller/LocauxPiecesAddController.php?p=2" method="post" enctype="multipart/form-data">
											<p>Êtes-vous sûr de vouloir ajouter un document pour le local <strong><?= $locaux->nom() ?></strong> ?</p>
											<div class="control-group">
												<!--label class="right-label">Nom Pièce</label>
												<input type="text" name="nom" /-->
												<label class="right-label">Lien</label>
												<input type="file" name="url" />
												<input type="hidden" name="idLocaux" value="<?= $locaux->id() ?>" />
												<input type="hidden" name="idProjet" value="<?= $locaux->idProjet() ?>" />
												<label class="right-label"></label>
												<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
												<button type="submit" class="btn red" aria-hidden="true">Oui</button>
											</div>
										</form>
									</div>
								</div>
								<!-- add piece box end -->
							</div>
						</div>
						<!--END TABS-->
						<div class="portlet">
							<div class="portlet-title">
								<h4>Liste des documents</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<?php
								if($piecesNumber != 0){
								foreach($piecesLocaux as $pieces){
								?>
								<div class="span3">
									<div class="item">
										<a class="fancybox-button" data-rel="fancybox-button" title="<?= $pieces->nom() ?>" href="<?= $pieces->url() ?>">
											<div class="zoom">
												<img style="height: 100px; width: 200px" src="<?= $pieces->url() ?>" alt="<?= $pieces->nom() ?>" />							
												<div class="zoom-icon"></div>
											</div>
										</a>
									</div>
									<a class="btn mini red" href="#deletePiece<?= $pieces->id() ?>" data-toggle="modal" data-id="<?= $pieces->id() ?>">
										Supprimer
									</a>
									<br><br>	
								</div>
								<!-- delete box begin-->
								<div id="deletePiece<?= $pieces->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3>Supprimer Pièce du local <strong><?= $locaux->nom() ?></strong></h3>
									</div>
									<div class="modal-body">
										<form class="form-horizontal loginFrm" action="controller/LocauxPiecesDeleteController.php?p=2" method="post">
											<p>Êtes-vous sûr de vouloir supprimer cette pièce ?</p>
											<div class="control-group">
												<label class="right-label"></label>
												<input type="hidden" name="idPieceLocaux" value="<?= $pieces->id() ?>" />
												<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
												<input type="hidden" name="idLocaux" value="<?= $idLocaux ?>" />
												<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
												<button type="submit" class="btn red" aria-hidden="true">Oui</button>
											</div>
										</form>
									</div>
								</div>
								<!-- delete box end -->
								<?php 
								}//end of loop : terrains
								}//end of if : terrainNumber
								?>
							</div>
						</div>
						<?php
						}
						else{
						?>
						<div class="alert alert-error">
							<button class="close" data-dismiss="alert"></button>
							Cet appartement n'existe pas dans votre système.		
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
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}
?>