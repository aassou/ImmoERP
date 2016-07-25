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
    	$projetManager = new ProjetManager($pdo);
		$fournisseurManager = new FournisseurManager($pdo);
		$livraisonManager = new LivraisonManager($pdo);
		$reglementFournisseurManager = new ReglementFournisseurManager($pdo);
		if( isset($_GET['idProjet']) and ( $_GET['idProjet']>0 and $_GET['idProjet']<=$projetManager->getLastId() ) ){
			$idProjet = $_GET['idProjet'];
			$projet = $projetManager->getProjetById($idProjet);
			$fournisseurs = $livraisonManager->getFournisseursByIdProjet($idProjet);
			$idFounisseurs = $reglementFournisseurManager->getIdFournisseurs($idProjet);
			$printUrl = "";
			//test the user choice 
			if(isset($_GET['fournisseur']) and strcmp($_GET['fournisseur'], "Tous")!=0){
				$choice = htmlentities($_GET['fournisseur']);
				$reglementNumber = $reglementFournisseurManager->getReglementsNumberByIdFournisseur($idProjet, $choice);
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
			        $pagination = paginate('fournisseur-reglement.php?idProjet='.$idProjet.'&fournisseur='.$_GET['fournisseur'], '&p=', $pageNumber, $p);
					$reglements = $reglementFournisseurManager->getReglementFournisseurByLimits($idProjet, $choice, $begin, $reglementPerPage);
					$total = $reglementFournisseurManager->getTotalReglementFournisseur($idProjet, $choice);
					$printUrl = "controller/ReglementFournisseurPrintController.php?idProjet=".$idProjet.'&fournisseur='.$choice;			
				}
			}
			else{
				$reglementNumber = $reglementFournisseurManager->getReglementNumberTous($idProjet);
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
			        $pagination = paginate('fournisseur-reglement.php?idProjet='.$idProjet, '&p=', $pageNumber, $p);
					$reglements = $reglementFournisseurManager->getReglementTousByLimits($idProjet, $begin, $reglementPerPage);
					$total = $reglementFournisseurManager->getTotalReglementTous($idProjet);
					$printUrl = "controller/ReglementFournisseurPrintController.php?idProjet=".$idProjet.'&fournisseur=Tous';
				}
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
				<?php if($idProjet!=0){ ?>
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
							<div class="row-fluid add-portfolio">
								<div class="pull-left">
									<a href="projet-list.php" class="btn icn-only green">
										<i class="m-icon-swapleft m-icon-white"></i> 
										Retour vers Liste des projets
									</a>
								</div>
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
	                         <?php if(isset($_SESSION['reglement-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['reglement-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['reglement-delete-success']);
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
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4>
                                 	<i class="icon-edit"></i>
                                 	Ajouter un nouvel réglement fournisseur pour le projet : <strong><?= $projet->nom() ?></strong>
                                 	</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/ReglementFournisseurAddController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                          <div class="control-group">
                                             <label class="control-label" for="montant">Fournisseur</label>
                                             <div class="controls">
                                             	<select id="fournisseur" name="fournisseur" class="span12 m-wrap">
                                             		<?php
                                             		foreach($fournisseurs as $fournisseur){
                                             		?>	
                                             		<option value="<?= $fournisseur->id() ?>">
                                             			<?= $fournisseur->nom() ?> - Total des livraisons : 
                                             			<?= $livraisonManager->getSommeLivraisonsByIdProjetAndIdFournisseur($idProjet, $fournisseur->id()) ?>
                                             			- Payé : 
                                             			<?= $reglementFournisseurManager->sommeReglementFournisseurByIdProjetAndIdFournisseur($idProjet, $fournisseur->id()) ?>
                                             			- Reste : <?= ($livraisonManager->getSommeLivraisonsByIdProjetAndIdFournisseur($idProjet, $fournisseur->id())-$reglementFournisseurManager->sommeReglementFournisseurByIdProjetAndIdFournisseur($idProjet, $fournisseur->id())) ?>  
                                             		</option>
                                             		<?php
                                             		}
                                             		?>			
                                             	</select>   
                                             </div>
                                          </div>
                                    </div>
                               		<div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dateReglement">Date réglement</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                 </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="montant">Montant</label>
                                             <div class="controls">
                                                <input type="text" id="montant" name="montant" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" id="idProjet" name="idProjet" value="<?= $idProjet ?>" class="m-wrap span12">
                                    	<button type="reset" class="btn red">Annuler</button>
                                       	<button type="submit" class="btn black">Ajouter <i class="icon-plus-sign"></i></button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
					</div>
				</div>
				<div class="row-fluid"> 
					<div class="span12">
						<!-- BEGIN Terrain TABLE PORTLET-->
						<div class="portlet">
							<div class="portlet-title">
								<h4>Liste des réglement du programme : <strong><?= $projet->nom() ?></strong></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<form action="fournisseur-reglement.php" method="get">
                                 	<div class="row-fluid">
                                 		<div class="span2">
                                          <div class="control-group">
                                             <div class="controls">
                                                <label class="control-label">Choisir une option</label>
                                             </div>
                                          </div>
	                                 	</div>	
	                                 	<div class="span4">
                                          <div class="control-group">
                                             <div class="controls">
                                        		<select name="fournisseur">
													<option value="Tous">Tous les réglements</option>
													<?php foreach($idFounisseurs as $id){ ?>
													<option value="<?= $id ?>">
														<?= $fournisseurManager->getFournisseurById($id)->nom() ?>
													</option>
													<?php } ?>
												</select>        
                                             </div>
                                          </div>
	                                 	</div>
	                                 	<div class="span2">
                                          <div class="control-group">
                                             <div class="controls">
                                                <input type="submit" class="btn black" value="Séléctionner" />
                                                <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                             </div>
                                          </div>
	                                 	</div>
	                                 </div>
                                 </form>	
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th class="hidden-phone">Date réglement</th>
											<th>Montant</th>
											<th>Fournisseur</th>
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
											<td class="hidden-phone"><a><?= $reglement->dateReglement() ?></a></td>
											<td><?= $reglement->montant() ?></td>
											<td><?= $fournisseurManager->getFournisseurById($reglement->idFournisseur())->nom() ?></td>
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
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $reglement->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idReglement" value="<?= $reglement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
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
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
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
							</div>
						</div>
						<div class="pull-left">
                       		<a class="btn blue big">Total des sorties : <?= $total ?></a>
                       	</div>
                       	<div class="pull-right hidden-phone">
							<a class="btn black big" href="<?= $printUrl ?>">
								<i class="icon-print"></i>
								Imprimer Bilan des Sorties									
							</a>
						</div>
                       	<br><br><br><br>
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