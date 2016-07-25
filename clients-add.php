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
    if( 
        isset($_SESSION['userMerlaTrav']) and 
        (
            $_SESSION['userMerlaTrav']->profil()=="admin" or
            $_SESSION['userMerlaTrav']->profil()=="manager"    
        ) 
    ){
    	//les sources
    	$idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];
			$projet = $projetManager->getProjetById($idProjet);
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
							Création Contrat Client - Projet : <strong><?= $projet->nom() ?></strong>
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
                            <li><a>Création Contrat Client</a></li>
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
	                         <?php if( isset($_SESSION['client-action-message'])
                                    and isset($_SESSION['client-type-message']) ){
                                        $message = $_SESSION['client-action-message'];
                                        $typeMessage = $_SESSION['client-type-message']; 
	                             
	                         ?>
	                         	<div class="alert alert-<?= $typeMessage ?>">
									<button class="close" data-dismiss="alert"></button>
									<?= $message ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['client-action-message']);
                                unset($_SESSION['client-type-message']);
	                         ?>
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><strong>Etape 1 : </strong> Informations Client</h4>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/ClientActionController.php" method="POST" id="clientForm" class="horizontal-form">
                                    <div class="row-fluid">
                                    	<div class="span12">
                                    		<div class="progress progress-striped progress-success">
												<div style="width: 50%;" class="bar"></div>
											</div>
                                    	</div>
                                    </div>
                                    <?php
                                    $nom = "";
                                    $nomArabe = "";
                                    $cin = "";
                                    $adresse = "";
                                    $adresseArabe = "";
                                    $telephone1 = "";
                                    $telephone2 = "";
                                    $email = "";
                                    $idClient = "";
                                    if( isset($_SESSION['myFormData']) ){
                                        $nom = $_SESSION['myFormData']['nom'] ;
                                        $nomArabe = $_SESSION['myFormData']['nomArabe'] ;
                                        $cin = $_SESSION['myFormData']['cin'] ;
                                        $adresse = $_SESSION['myFormData']['adresse'];
                                        $adresseArabe = $_SESSION['myFormData']['adresseArabe'];
                                        $telephone1 = $_SESSION['myFormData']['telephone1'];
                                        $telephone2 = $_SESSION['myFormData']['telephone2'];
                                        $email = $_SESSION['myFormData']['email'];
                                        $idClient = $_SESSION['myFormData']['idClient'];
                                    }
                                    ?>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="nomArabe">الاسم</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="nomClientArabe" name="nomArabe" value="<?= $nomArabe ?>" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="adresseArabe">العنوان</label>
                                             <div class="controls">
                                                <input type="text" id="adresseArabe" name="adresseArabe" value="<?= $adresseArabe ?>" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group autocomplet_container">
                                             <label class="control-label" for="nom">Nom</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="nomClient" name="nom" value="<?= $nom ?>" class="m-wrap span12" onkeyup="autocompletClient()">
                                                <ul id="clientList"></ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="cin">CIN</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="cin" name="cin" value="<?= $cin ?>" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="adresse">Adresse</label>
                                             <div class="controls">
                                                <input type="text" id="adresse" name="adresse" value="<?= $adresse ?>" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    	<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="telephone1">Téléphone 1</label>
                                             <div class="controls">
                                                <input type="text" id="telephone1" name="telephone1" value="<?= $telephone1 ?>" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    	<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="telephone2">Téléphone 2</label>
                                             <div class="controls">
                                                <input type="text" id="telephone2" name="telephone2" value="<?= $telephone2 ?>" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="email">Email</label>
                                             <div class="controls">
                                                <input type="email" id="email" name="email" value="<?= $email ?>" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="hidden" name="action" value="add">
                                    	<input type="hidden" id="idProjet" name="idProjet" value="<?= $idProjet ?>">
                                    	<input type="hidden" id="idClient" name="idClient" value="<?= $idClient ?>">
                                       	<button type="submit" class="btn blue">Continuer <i class="m-icon-swapright m-icon-white"></i></button>
                                    </div>
                                 </form>
                                 <?php
                                    unset($_SESSION['myFormData']);
                                 ?>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
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
		2015 &copy; ImmoERP. Management Application.
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
	<script type="text/javascript" src="assets/jquery-validation/jquery.validate.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
	<script src="assets/js/app.js"></script>
	<script type="text/javascript" src="script.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
			$("#clientForm").validate({
			     errorClass: "error-class",
                 validClass: "valid-class"
			});
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil() != "admin"){
	header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}
?>