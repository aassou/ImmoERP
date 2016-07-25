<?php
    session_start();
	if(isset($_SESSION['userMerlaTrav'])){
		header('Location:dashboard.php');
	}
	else{
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
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style_responsive.css" rel="stylesheet" />
  <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
  <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="assets/img/big-logo-new.png" alt="" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" action="controller/UserSignInController.php" method="POST">
      <h3 class="form-title">Accéder à votre compte</h3>
      <div class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span><strong>Login</strong> et <strong>Mot de passe</strong> non saisies.</span>
      </div>
      <?php
      	if(isset($_SESSION['signin-error'])){
      ?>			
		  <div class="alert alert-error">
	        <button class="close" data-dismiss="alert"></button>
	        <span><?php echo $_SESSION['signin-error']; ?></span>
	      </div>
      <?php
		}
		unset($_SESSION['signin-error']);
	  ?>	
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Login</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Login" name="login"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Mot de passe</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Mot de passe" name="password"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <input type="submit" class="btn green pull-right" value="Se connecter">            
      </div>
      <div class="forget-password">
        <h4><a href="signup.php" class="" id="forget-password">Créer un nouveau compte</a></h4>
      </div>
    </form>
    <!-- END LOGIN FORM -->
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    2015 &copy; AnnahdaERP. Management Application.
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.3.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>  
  <script src="assets/uniform/jquery.uniform.min.js"></script> 
  <script src="assets/js/jquery.blockui.js"></script>
  <script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
}
?>