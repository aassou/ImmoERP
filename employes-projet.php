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
    	$idProjet = 0;
		$projetManager = new ProjetManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];	
		}
		$employeManager = new EmployeProjetManager($pdo);
		$employes = "";
		//test the employeSociete object number: if exists get terrain else do nothing
		$employeNumber = $employeManager->getEmployeProjetNumberByIdProjet($idProjet);
		if($employeNumber!=0){
			$employeProjetPerPage = 10;
	        $pageNumber = ceil($employeNumber/$employeProjetPerPage);
	        $p = 1;
	        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
	            $p = $_GET['p'];
	        }
	        else{
	            $p = 1;
	        }
	        $begin = ($p - 1) * $employeProjetPerPage;
	        $pagination = paginate('employes-projet.php', '?p=', $pageNumber, $p);
			$employesProjet = $employeManager->getEmployesProjetByIdProjetByLimits($idProjet, $begin, $employeProjetPerPage);	
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
							Gestion des employés du projet <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong> 
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
								<a>Gestion des employés par projet</a>
							</li>
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
								<a href="projet-list.php#<?= $idProjet ?>" class="btn icn-only green"><i class="m-icon-swapleft m-icon-white"></i> Retour vers Liste des projets</a>
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
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter un nouvel employé </h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/EmployeProjetAddController.php" method="POST" class="horizontal-form" enctype="multipart/form-data">
                                    <div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="nom">Nom</label>
                                             <div class="controls">
                                                <input type="text" id="nom" name="nom" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="cin">CIN</label>
                                             <div class="controls">
                                                <input type="text" id="cin" name="cin" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="etatCivile">Etat Civile</label>
                                             <div class="controls">
                                                <select name="etatCivile" class="m-wrap">
                                             		<option value="Célibataire">Célibataire</option>
                                             		<option value="Marié">Marié</option>
                                             		<option value="Divorcé">Divorcé</option>
                                             		<option value="Veuf">Veuf</option>
                                             	</select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                    	<div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dateDebut">Date début</label>
                                             <div class="controls">
    											<div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateDebut" id="dateDebut" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dateSortie">Date Sortie</label>
                                             <div class="controls">
    											<div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateSortie" id="dateSortie" class="m-wrap m-ctrl-small date-picker" type="text" value="" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    	<div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="photo">Photo</label>
                                             <div class="controls">
                                                <input type="file" id="photo" name="photo" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="telephone">Téléphone</label>
                                             <div class="controls">
                                             	<input type="text" id="telephone" name="telephone" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4">
                                          <div class="control-group">
                                             <label class="control-label" for="email">Email</label>
                                             <div class="controls">
                                             	<input type="text" id="email" name="email" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" id="idProjet" name="idProjet" value="<?= $idProjet ?>" class="m-wrap span12">
                                    	<button type="submit" class="btn black">Enregistrer <i class="icon-save"></i></button>
                                    	<button type="reset" class="btn red">Annuler</button>
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
                         <?php if(isset($_SESSION['pieces-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-delete-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['pieces-delete-success']);
                         ?>
						<div class="portlet">
							<div class="portlet-title">
								<h4>Liste des employés</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Nom</th>
											<th class="hidden-phone">CIN</th>
											<th class="hidden-phone">Etat civile</th>
											<th>Téléphone</th>
											<th class="hidden-phone">Modifier</th>
											<th class="hidden-phone">Supprimer</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($employeNumber != 0){
										foreach($employesProjet as $employe){
										?>		
										<tr>
											<td><a href="employe-projet-profile.php?idEmploye=<?= $employe->id() ?>"><?= $employe->nom() ?></a></td>
											<td class="hidden-phone"><?= $employe->cin() ?></td>
											<td class="hidden-phone"><?= $employe->etatCivile() ?></td>
											<td><?= $employe->telephone() ?></td>
											<td class="hidden-phone">
												<a href="#updateEmploye<?php echo $employe->id();?>" data-toggle="modal" data-id="<?php echo $employe->id(); ?>">
													Modifier
												</a>
											</td>
											<td class="hidden-phone">
												<a href="#deleteEmploye<?php echo $employe->id();?>" data-toggle="modal" data-id="<?php echo $employe->id(); ?>">
													Supprimer
												</a>
											</td>
										</tr>
										<!-- add file box begin-->
										<div id="addPieces<?php echo $employe->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Ajouter des pièces pour cet employé</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/TerrainPiecesAddController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir ajouter des pièces pour l'employé <strong><?= $employe->nom() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label">Nom Pièce</label>
														<input type="text" name="nom" />
														<label class="right-label">Lien</label>
														<input type="file" name="url" />
														<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
														<label class="right-label"></label>
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- add files box end -->	
										<!-- update box begin-->
										<div id="updateEmploye<?= $employe->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Infos Employé</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/EmployeProjetUpdateController.php?param=1" method="post" enctype="multipart/form-data">
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
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
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
										<!-- delete box begin-->
										<div id="deleteEmploye<?= $employe->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Employé</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/EmployeProjetDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cet employé <strong><?= $employe->nom() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
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
									if($employeNumber != 0){
										echo $pagination;	
									}
									?>
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