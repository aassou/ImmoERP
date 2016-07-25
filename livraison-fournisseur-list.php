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
    	$idFournisseur = 0;
    	$fournisseurManager = new FournisseurManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		if(isset($_GET['idFournisseur']) and ($_GET['idFournisseur'])>0 and $_GET['idFournisseur']<=$fournisseurManager->getLastId()){
			$idFournisseur = $_GET['idFournisseur'];
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($idFournisseur);
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
		        $begin = ($p - 1) * $livraisonPerPage;
		        $pagination = paginate('livraison-fournisseur-list.php?idFournisseur='.$idFournisseur, '&p=', $pageNumber, $p);
				$livraisons = $livraisonManager->getLivraisonsByIdFournisseurByLimit($idFournisseur, $begin, $livraisonPerPage);	
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
							Gestion des livraisons
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-truck"></i>
								<a>Gestion des fournisseurs</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Liste des Livraisons du fournisseur</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid add-portfolio">
							<div class="pull-left">
								<a href="fournisseurs.php" class="btn icn-only green"><i class="m-icon-swapleft m-icon-white"></i> Retour vers Liste des fournisseurs</a>
							</div>
							<?php
							if($idFournisseur!=0){
							?>
							<div class="pull-right">
								<a href="livraison-add.php?idFournisseur=<?= $idFournisseur ?>" class="btn icn-only green">Ajouter Nouvelle Livraison <i class="icon-plus-sign "></i></a>
							</div>
							<?php
							}
							?>
						</div>
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['pieces-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['pieces-add-success']);
						 ?>
						<?php if(isset($_SESSION['pieces-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['pieces-add-error']);
						 ?>
						 <?php if(isset($_SESSION['livraison-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-delete-success']);
						 ?>
						<div class="portlet">
							<div class="portlet-title">
								<h4>Liste des livraisons du fournisseur : <strong><?= $fournisseurManager->getFournisseurById($idFournisseur)->nom() ?></strong></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Fournisseur</th>
											<th class="hidden-phone">Date Livraison</th>
											<th class="hidden-phone">Libelle</th>
											<th>Designat°</th>
											<th class="hidden-phone">Quantité</th>
											<th class="hidden-phone">Prix.Un</th>
											<th>Total</th>
											<th class="hidden-phone">Docs</th>
											<th class="hidden-phone">Docs</th>
											<th class="hidden-phone">Suppri</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($livraisonNumber != 0){
										foreach($livraisons as $livraison){
										?>		
										<tr>
											<td>
												<a href="livraison.php?codeLivraison=<?= $livraison->code() ?>"><?= $fournisseurManager->getFournisseurById($livraison->idFournisseur())->nom() ?></a>
											</td>
											<td class="hidden-phone"><?= $livraison->dateLivraison() ?></td>
											<td class="hidden-phone"><?= $livraison->libelle() ?></td>
											<td><?= $livraison->designation() ?></td>
											<td class="hidden-phone"><?= $livraison->quantite() ?></td>
											<td class="hidden-phone"><?= $livraison->prixUnitaire() ?></td>
											<td><?= $livraison->prixUnitaire()*$livraison->quantite() ?></td>
											<td class="hidden-phone">
												<a href="#addPieces<?= $livraison->id() ?>" class="btn mini purple" data-toggle="modal" data-id="<?= $livraison->id() ?>"> 
													Ajouter
												</a>
											</td>
											<td class="hidden-phone">
												<a href="livraison-pieces.php?idProjet=<?= $livraison->idProjet() ?>&idLivraison=<?= $livraison->id() ?>" class="btn mini yellow" data-toggle="modal" data-id="<?= $livraison->id() ?>">
													Gérer
												</a>
											</td>
											<td class="hidden-phone">
												<a href="#deleteLivraison<?= $livraison->id() ?>" data-toggle="modal" data-id="<?= $livraison->id() ?>">
													Suppri
												</a>
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
														<input type="hidden" name="idProjet" value="<?= $livraison->idProjet() ?>" />
														<label class="right-label"></label>
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- add files box end -->	
										<!-- delete box begin-->
										<div id="deleteLivraison<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer la livraison </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/LivraisonDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer la livraison <strong>N°<?= $livraison->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $livraison->idProjet() ?>" />
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
							</div>
						</div>
						<!-- END Terrain TABLE PORTLET-->
					</div>
				</div>
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