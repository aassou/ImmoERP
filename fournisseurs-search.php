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
    	//les services
    	$clients = "";
    	$fournisseurManager = new FournisseurManager($pdo);
		$livraisonsManager = new LivraisonManager($pdo);
        if(isset($_SESSION['searchFournisseurResult'])){
            $fournisseurs = $_SESSION['searchFournisseurResult'];
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
							Les recherches
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-search"></i>
								<a>Rechercher</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Fournisseurs</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<a href="recherches.php" class="btn big yellow">
							<i class="m-icon-big-swapleft m-icon-white"></i> 
							Page recherches
							<i class="icon-search"></i>
						</a>
						<br><br>
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-search"></i>Chercher fournisseur</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['fournisseur-search-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['fournisseur-search-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['fournisseur-search-error']);
                                 ?>
                                 <form action="controller/SearchFournisseurController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="nomFournisseur">Nom du fournisseur</label>
                                             <div class="controls">
                                                <input type="text" id="nomFournisseur" name="searchFournisseur" class="m-wrap span12" onkeyup="autocompletFournisseur()">
                                                <ul id="fournisseurList"></ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-search"></i>Lancer la recherche</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box green">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Les fournisseurs</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
								</div>
								<?php if((bool)$fournisseurs){ ?>
										<?php foreach ($fournisseurs as $fournisseur){ 
											$livraisons = $livraisonsManager->getLivraisonsByIdFournisseur($fournisseur->id());	
										?>	
										<h3><?= $fournisseur->nom()?></h3>
										<?php if((bool)$livraisons){ ?>
										<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
											<thead>
												<tr>
													<th>N°Livraison</th>
													<th class="hidden-phone">Date</th>
													<th>Désignation</th>
													<th>Total</th>
													<th class="hidden-phone">Documents</th>
													<th class="hidden-phone">Documents</th>
													<th class="hidden-phone">Supprimer</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($livraisons as $livraison) {
												?>	
												<tr class="">
													<td>
														<a class="btn" target="_blank" href="livraison.php?codeLivraison=<?= $livraison->code() ?>">
															<?= $livraison->id() ?> <i class="icon-eye-open"></i>
														</a>
													</td>
													<td class="hidden-phone" style="width: 15%"><?= $livraison->dateLivraison() ?></td>
													<td><?= $livraison->designation() ?></td>
													<td><?= $livraison->quantite()*$livraison->prixUnitaire() ?></td>
													<td class="hidden-phone">
														<a href="#addPieces<?= $livraison->id() ?>" class="btn mini purple" data-toggle="modal" data-id="<?= $livraison->id() ?>">
															<i class="icon-plus-sign"></i> 
															Ajouter
														</a>
													</td>
													<td class="hidden-phone">
														<a target="_blank" href="livraison-pieces.php?idProjet=<?= $livraison->idProjet() ?>&idLivraison=<?= $livraison->id() ?>" class="btn mini yellow" data-toggle="modal" data-id="<?= $livraison->id() ?>">
															<i class="icon-folder-open"></i> 
															Gérer
														</a>
													</td>
													<td class="hidden-phone">
														<a href="#deleteLivraison<?= $livraison->id() ?>" data-toggle="modal" data-id="<?= $livraison->id() ?>">
															Supprimer
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
												}//end foreach contrats
										}//end foreach clients ?>
											</tbody>
										</table>
										<br>
										<?php 
										}//end if contrats ?>
								<?php } 
									else{
								?>		
								<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									Aucun résultat trouvé.
    								</div>
								<?php		
									}
								?>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
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
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>