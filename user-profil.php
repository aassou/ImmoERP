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
    if(isset($_SESSION['userMerlaTrav']) ){
    	//les sources
    	$usersManager = new UserManager($pdo);
		$users = $usersManager->getUsers(); 
        
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
							Gestion des utilisateurs
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-user"></i>
								<a>Gestion de mon compte</a>
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
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Informations du compte</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['password-update-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['password-update-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['password-update-success']);
                                 ?>
                                 <?php if(isset($_SESSION['password-update-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['password-update-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['password-update-error']);
                                 ?>
                                 <form class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="login">Login</label>
                                             <div class="controls">
                                                <input disabled="disabled" type="text" id="login" name="login" class="m-wrap span12" value="<?= $_SESSION['userMerlaTrav']->login() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="profil">Profil</label>
                                             <div class="controls">
                                                <input disabled="disabled" type="text" id="profil" name="profil" class="m-wrap span12" value="<?= $_SESSION['userMerlaTrav']->profil() ?>">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="password">Mot de passe</label>
                                             <div class="controls">
                                                <input disabled="disabled" type="password" id="password" name="password" class="m-wrap span12" value="hahahaha">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="dateCreation">Date de création</label>
                                             <div class="controls">
                                                <input disabled="disabled" type="text" id="dateCreation" name="dateCreation" class="m-wrap span12" value="<?= date('Y-m-d', strtotime($_SESSION['userMerlaTrav']->created())) ?>">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <a href="#updatePassword" data-toggle="modal" class="btn red">Modifier mon mot de passe</a>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                                 <!-- update password box begin-->
									<div id="updatePassword" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3>Modification du mot de passe</h3>
										</div>
										<div class="modal-body">
											<form class="form-horizontal loginFrm" action="controller/UserUpdatePasswordController.php" method="post">
												<p>Êtes-vous sûr de vouloir modifier votre mot de passe ?</p>
												<div class="control-group">
													<label class="right-label">Ancien mot de passe</label>
													<input type="password" name="oldPassword" />
													<label class="right-label">Nouveau mot de passe</label>
													<input type="password" name="newPassword1" />
													<label class="right-label">Retapez nouveau mot de passe</label>
													<input type="password" name="newPassword2" />
												</div>
												<div class="control-group">
													<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
													<button type="submit" class="btn red" aria-hidden="true">Oui</button>
												</div>
											</form>
										</div>
									</div>
									<!-- update password box end -->
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
else{
    header('Location:index.php');    
}
?>