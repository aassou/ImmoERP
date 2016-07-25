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
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin"){
    	$idProjet = 0;
		$nomProjet = "Projet non trouvé";
		$projetsManager = new ProjetManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet']>0 and $_GET['idProjet']<=$projetsManager->getLastId())){
			$idProjet = $_GET['idProjet'];
			$projet = $projetsManager->getProjetById($idProjet);
			$nomProjet = $projet->nom();
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
							Gestion des projets
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
							<li><a>Modification du projet</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
                         <?php if(isset($_SESSION['projet-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['projet-update-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['projet-update-success']);
                         ?>
                         <?php if(isset($_SESSION['projet-update-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['projet-update-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['projet-update-error']);
                         ?>
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Modification du projet : <strong><?= $nomProjet ?></strong></h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <?php
	                         	if($idProjet!=0){
	                         ?>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/ProjetUpdateController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="nomProjet">Nom du Projet</label>
                                             <div class="controls">
                                                <input type="text" id="nomProjet" name="nomProjet" class="m-wrap span12" value="<?= $projet->nom() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="budget">Budget</label>
                                             <div class="controls">
                                                <input type="text" id="budget" name="budget" class="m-wrap span12" value="<?= $projet->budget() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="superficie">Superficie</label>
                                             <div class="controls">
                                                <input type="text" id="superficie" name="superficie" class="m-wrap span12" value="<?= $projet->superficie() ?>">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="adresse">Adresse</label>
                                             <div class="controls">
                                             	<textarea name="adresse" class="large m-wrap" rows="3"><?= $projet->adresse() ?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="description">Description</label>
                                             <div class="controls">
    											<textarea name="description" class="large m-wrap" rows="3"><?= $projet->description() ?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                       <a href="projet-list.php" class="btn red"><i class="m-icon-swapleft m-icon-white"></i> Retour</a>
                                       <button type="submit" class="btn black">Modifier <i class="icon-ok"></i></button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                              <?php
                              }
							?>
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