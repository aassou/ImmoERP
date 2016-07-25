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
    if( isset($_SESSION['userMerlaTrav']) ){
    	//les sources
		$projetManager = new ProjetManager($pdo);
		$caisseEntreesManager = new CaisseEntreesManager($pdo);
		$projets = $projetManager->getProjets();
		$entrees = "";
		//test the employeSociete object number: if exists get terrain else do nothing
		$entreesNumber = $caisseEntreesManager->getCaisseEntreesNumber();
		if($entreesNumber!=0){
			$entreesPerPage = 10;
	        $pageNumber = ceil($entreesNumber/$entreesPerPage);
	        $p = 1;
	        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
	            $p = $_GET['p'];
	        }
	        else{
	            $p = 1;
	        }
	        $begin = ($p - 1) * $entreesPerPage;
	        $pagination = paginate('caisse-entrees.php', '?p=', $pageNumber, $p);
			$entrees = $caisseEntreesManager->getCaisseEntreesByLimits($begin, $entreesPerPage);	
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
							Gestion de la caisse - Les entrées
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
								<i class="icon-money"></i>
								<a>Gestion de la caisse</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Les entrées</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<a class="btn green big pull-left" href="caisse.php">
						<i class="m-icon-big-swapleft m-icon-white"></i>
						Retour vers La caisse									
					</a>
					<a class="btn black big pull-right hidden-phone" href="controller/CaisseEntreesPrintBilanController.php">
						<i class="icon-print"></i>
						Imprimer Bilan des Entrées									
					</a>
				</div>
				<br>
				<div class="row-fluid">
					<div class="span12">
						<div class="tab-pane active" id="tab_1">
							<?php if(isset($_SESSION['entrees-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['entrees-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['entrees-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['entrees-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['entrees-add-error'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['entrees-add-error']);
	                         ?>
	                         <?php if(isset($_SESSION['entrees-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['entrees-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['entrees-update-success']);
	                         ?>
	                         <?php if(isset($_SESSION['entrees-update-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['entrees-update-error'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['entrees-update-error']);
	                         ?>
	                         <?php if(isset($_SESSION['entrees-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['entrees-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['entrees-delete-success']);
	                         ?>
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-signin"></i>Liste des Entreés de la Caisse</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <!-- BEGIN FORM-->
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th style="width: 10%">N°</th>
											<th>Montant</th>
											<th class="hidden-phone">Date opération</th>
											<th>Désignation</th>
											<th class="hidden-phone">Saisie par</th>
											<th class="hidden-phone">Modifier</th>
											<th class="hidden-phone">Supprimer</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($entreesNumber != 0){
										foreach($entrees as $entree){
										?>		
										<tr>
											<td><a><?= $entree->id() ?></a></td>
											<td>
												<?= number_format($entree->montant(), 2, ',', ' ') ?>
											</td>
											<td class="hidden-phone"><?= date('d/m/Y', strtotime($entree->dateOperation())) ?></td>
											<td><?= $entree->designation() ?></td>
											<td class="hidden-phone"><?= $entree->utilisateur() ?></td>
											<td class="hidden-phone">
												<a href="#updateCaisse<?= $entree->id();?>" data-toggle="modal" data-id="<?= $entree->id(); ?>">
													Modifier
												</a>
											</td>
											<td class="hidden-phone">
												<a href="#deleteCaisse<?= $entree->id() ?>" data-toggle="modal" data-id="<?= $entree->id() ?>">
													Supprimer
												</a>
											</td>
										</tr>	
										<!-- updateCaisse box begin-->
										<div id="updateCaisse<?= $entree->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier les informations de l'entrée de caisse </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/CaisseEntreesUpdateController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier l'entrée de caisse <strong>N°<?= $entree->id() ?></strong>  ?</p>
													<div class="control-group">
														<label class="control-label">Date Opération</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $entree->dateOperation() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $entree->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Désignation</label>
														<div class="controls">
															<input type="text" name="designation" value="<?= $entree->designation() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idEntree" value="<?= $entree->id() ?>" />
														<input type="hidden" name="user" value="<?= $_SESSION['userMerlaTrav']->login() ?>" />
														<div class="controls">	
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateCaisse box end -->			
										<!-- delete box begin-->
										<div id="deleteCaisse<?= $entree->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer l'entrée de la caisse </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/CaisseEntreesDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cette entrée de caisse <strong>N°<?= $entree->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idEntree" value="<?= $entree->id() ?>" />
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
									if($entreesNumber != 0){
										echo $pagination;	
									}
									?>
								</table>
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th style="width: 15%">Total</th>
											<td style="width: 15%;color: black">
												<?php
												if($entreesNumber != 0){
													echo '<strong>'.number_format($caisseEntreesManager->getTotalCaisseEntrees(), 2, ',', ' ').'&nbsp;DH</strong>';	
												}
												?>
											</td>
										</tr>
									</thead>
								</table>
								<!--a class="btn blue big">
									Total = 
									<?= number_format($caisseEntreesManager->getTotalCaisseEntrees(), 2, ',', ' ') ?>
								</a-->
								<!--a class="btn black big pull-right hidden-phone" href="controller/CaisseEntreesPrintBilanController.php">
									<i class="icon-print"></i>
									Imprimer Bilan des Entrées									
								</a-->
                              </div>
                           </div>
							<!-- END Charges TABLE PORTLET-->
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
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