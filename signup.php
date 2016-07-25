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
    <img src="assets/img/big-logo.png" alt="" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" action="controller/UserSignUpController.php" method="POST">
      <h3 class="form-title">Créer nouveau compte</h3>
      <?php
      	if(isset($_SESSION['signup-error'])){
      ?>			
		  <div class="alert alert-error">
	        <button class="close" data-dismiss="alert"></button>
	        <span><?php echo $_SESSION['signup-error']; ?></span>
	      </div>
      <?php
		}
		unset($_SESSION['signup-error']);
	  ?>
	  <?php
      	if(isset($_SESSION['signup-success'])){
      ?>			
		  <div class="alert alert-success">
	        <button class="close" data-dismiss="alert"></button>
	        <span><?php echo $_SESSION['signup-success']; ?></span>
	      </div>
      <?php
		}
		unset($_SESSION['signup-success']);
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
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Retaper Mot de passe</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-ok"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Retaper mot de passe" name="rpassword"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <a href="index.php" class="btn">
        <i class="m-icon-swapleft"></i> Retour
        </a>
        <input type="submit" class="btn green pull-right" value="S'inscrire">            
      </div>
    </form>
    <!-- END LOGIN FORM -->
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    2015 &copy; MerlaTravERP. Management Application.
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