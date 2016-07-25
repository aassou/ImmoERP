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
								<i class="icon-wrench"></i>
								<a href="configuration.php">Paramètrages</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Gestion des utilisateurs</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<?php if(isset($_SESSION['user-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['user-delete-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['user-delete-success']);
                         ?>
                         <?php if(isset($_SESSION['user-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['user-update-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['user-update-success']);
                         ?>
						<div class="tab-pane active" id="tab_1">
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-edit"></i>Ajouter un utilisateur</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <?php if(isset($_SESSION['user-add-success'])){ ?>
                                 	<div class="alert alert-success">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['user-add-success'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['user-add-success']);
                                 ?>
                                 <?php if(isset($_SESSION['user-add-error'])){ ?>
                                 	<div class="alert alert-error">
    									<button class="close" data-dismiss="alert"></button>
    									<?= $_SESSION['user-add-error'] ?>		
    								</div>
                                 <?php } 
                                 	unset($_SESSION['user-add-error']);
                                 ?>
                                 <form action="controller/UserAddController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span2 ">
                                          <div class="control-group">
                                             <label class="control-label" for="login">Login</label>
                                             <div class="controls">
                                                <input type="text" id="login" name="login" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="password">Mot de passe</label>
                                             <div class="controls">
                                                <input type="password" id="password" name="password" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="password2">Retapez mot de passe</label>
                                             <div class="controls">
                                                <input type="password" id="password2" name="rpassword" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="profil">Profil</label>
                                             <div class="controls">
                                             	<select name="profil" class="m-wrap">
                                             		<option value="user">Utilisateur</option>
                                             		<option value="consultant">Consultant</option>
                                             		<option value="manager">Manager</option>
                                             		<option value="admin">Administrateur</option>
                                             	</select>   
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn green"><i class="icon-ok"></i> Ajouter</button>
                                       <button type="reset" class="btn">Annuler</button>
                                    </div>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Les utilisateurs</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
									<thead>
										<tr>
											<th>Login</th>
											<th>Profile</th>
											<th class="hidden-phone">Date de création</th>
											<th>Status</th>
											<th class="hidden-phone">Changer status</th>
											<th class="hidden-phone">Modifier Profil</th>
											<th class="hidden-phone">Supprimer</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($users as $user) {
												$status = '<span class="label label-important">Inactif</span>';
												$classStatus = 'btn mini green';
												$message = "Activer";
												if($user->status()==1){
													$status = '<span class="label label-success">Actif</span>';
													$classStatus = 'btn mini red';
													$message = "Désactiver";	
												}	
										?>	
										<tr class="">
											<td><?= $user->login()?></td>
											<td><?= $user->profil()?></td>
											<td class="hidden-phone"><?= date('d-m-Y', strtotime($user->created())) ?></td>
											<td><?= $status ?></td>
											<td class="hidden-phone">
												<a href="controller/UserChangeStatusController.php?idUser=<?php echo $user->id();?>" class="<?= $classStatus ?>" data-toggle="modal" data-id="<?php echo $user->id(); ?>">
													<?= $message ?>	
												</a>
											</td>
											<td class="hidden-phone">
												<a href="#update<?php echo $user->id();?>" data-toggle="modal" data-id="<?php echo $user->id(); ?>">
													Modifier
												</a>
											</td>
											<td class="hidden-phone">
												<a href="#delete<?php echo $user->id();?>" data-toggle="modal" data-id="<?php echo $user->id(); ?>">
													Supprimer
												</a>
											</td>
										</tr>
										<!-- edit box begin-->
										<div id="update<?php echo $user->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier le Profil Utilisateur</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/UserUpdateController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier le profil de <strong><?= $user->login() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label">Profil</label>
														<div class="controls">
			                                             	<select name="profil" class="m-wrap">
			                                             		<option value="<?= $user->profil() ?>"><?= ucfirst($user->profil()) ?></option>
			                                             		<option disabled="disabled">-----------------</option>
			                                             		<option value="user">Utilisateur</option>
			                                             		<option value="consultant">Consultant</option>
			                                             		<option value="manager">Manager</option>
			                                             		<option value="admin">Administrateur</option>
			                                             	</select>   
			                                             </div>
														<input type="hidden" name="idUser" value="<?= $user->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- edit box end -->
										<!-- delete box begin-->
										<div id="delete<?php echo $user->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer l'utilisateur</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/UserDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idUser" value="<?= $user->id() ?>" />
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
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()!="admin"){
	header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}
?>