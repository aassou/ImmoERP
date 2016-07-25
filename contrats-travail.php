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
    	//classManagers
    	$projetManager = new ProjetManager($pdo);
		$contratsTravailManager = new ContratTravailManager($pdo);
		$contratNumber = 0;
		//classes and vars
		$projets = $projetManager->getProjets();
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];
			$projet = $projetManager->getProjetById($idProjet);
			$contratNumber = $contratsTravailManager->getContratsTravailNumberByIdProjet($idProjet);
			if($contratNumber != 0){
				$contratPerPage = 10;
		        $pageNumber = ceil($contratNumber/$contratPerPage);
		        $p = 1;
		        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
		            $p = $_GET['p'];
		        }
		        else{
		            $p = 1;
		        }
		        $begin = ($p - 1) * $contratPerPage;
		        $pagination = paginate('contrats-travail.php?idProjet='.$idProjet, '&p=', $pageNumber, $p);
				$contrats = $contratsTravailManager->getContratTravailsByIdProjetsByLimits($idProjet, $begin, $contratPerPage);	
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
							تنظيم عقود العمل 
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-truck"></i>
								<a>Gestion des projets</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>تنظيم عقود العمل</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid add-portfolio">
							<!--div class="pull-left">
								<a href="#addFournisseur" data-toggle="modal" class="btn blue">
									Ajouter Nouveau Fournisseur <i class="icon-plus-sign "></i>
								</a>
							</div-->
							<div class="pull-right">
								<a href="#addContrat" data-toggle="modal" class="btn green arabic-medium">
									تسجيل عقد عمل جديد <i class="icon-plus-sign "></i>
								</a>
								<!--a href="#addReglement" data-toggle="modal" class="btn black">
									Ajouter Nouveau Régelement <i class="icon-plus-sign "></i>
								</a-->
							</div>
						</div>
						<!-- addContrat box begin-->
						<div id="addContrat" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>تسجيل عقد عمل جديد</h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/ContratTravailAddController.php" method="post">
									<div class="control-group">
										<label class="control-label">الاسم</label>
										<div class="controls">
											<input type="text" name="nom" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">تاريخ الميلاد</label>
										<div class="controls">
											<input type="text" name="dateNaissance" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">بطاقة التعريف</label>
										<div class="controls">
											<input type="text" name="cin" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">العنوان</label>
										<div class="controls">
											<input type="text" name="adresse" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">الحرفة</label>
										<div class="controls">
											<input type="text" name="matiere" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">تاريخ العقد</label>
										<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
		                                    <input name="dateContrat" id="dateContrat" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
		                                    <span class="add-on"><i class="icon-calendar"></i></span>
		                                 </div>
									</div>
									<div class="control-group">
										<label class="control-label">الثمن</label>
										<div class="controls">
											<input type="text" name="prix" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">القياس</label>
										<div class="controls">
											<input type="text" name="mesure" value="" />
										</div>	
									</div>
									<div class="control-group">
										<label class="control-label">المجموع</label>
										<div class="controls">
											<input type="text" name="prixTotal" value="" />
										</div>	
									</div>
									<div class="control-group">
										<div class="controls">	
											<input type="hidden" name="idProjet" value="<?= $idProjet ?>">
											<button class="btn" data-dismiss="modal"aria-hidden="true">الغاء</button>
											<button type="submit" class="btn red" aria-hidden="true">تسجيل</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addContrat box end -->
						<!--div class="row-fluid">
							<form action="" method="post">
							    <div class="input-box autocomplet_container">
									<input class="m-wrap" name="recherche" id="nomFournisseur" type="text" onkeyup="autocompletFournisseur()" placeholder="Chercher un fournisseur...">
										<ul id="fournisseurList"></ul>
									</input>
									<input class="m-wrap" name="projet" id="nomProjet" type="text" onkeyup="autocompletProjet()" placeholder="Projet">
										<ul id="projetList"></ul>
									</input>
									<input name="idFournisseur" id="idFournisseur" type="hidden" />
									<input name="idProjet" id="idProjet" type="hidden" />
									<button type="submit" class="btn red"><i class="icon-search"></i></button>
							    </div>
							</form>
						</div-->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['contrat-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-add-success']);
						 ?>
						 <?php if(isset($_SESSION['contrat-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-add-error']);
						 ?>
						 <?php if(isset($_SESSION['contrat-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-update-success']);
						 ?>
						 <?php if(isset($_SESSION['contrat-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-update-error']);
						 ?>
						  <?php if(isset($_SESSION['contrat-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-delete-success']);
						 ?>
						 <?php if(isset($_SESSION['contrat-reglement-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-reglement-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-reglement-add-success']);
						 ?>
						 <?php if(isset($_SESSION['contrat-reglement-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-reglement-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-reglement-add-error']);
						 ?>
						<div class="portlet">
							<div class="portlet-title">
								<h4>عقود العمل</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th class="hidden-phone">المجموع</th>
											<th class="hidden-phone">القياس</th>
											<th class="hidden-phone">الثمن</th>
											<th class="hidden-phone">تاريخ العقد</th>
											<th class="hidden-phone">الحرفة</th>
											<th class="hidden-phone">الاسم</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($contratNumber != 0){
										foreach($contrats as $contrat){
										?>		
										<tr>
											<td class="hidden-phone"><?= number_format($contrat->prixTotal(), 2, ',', ' ') ?></td>
											<td class="hidden-phone"><?= $contrat->mesure() ?></td>
											<td class="hidden-phone"><?= number_format($contrat->prix(), 2, ',', ' ') ?></td>
											<td class="hidden-phone"><?= date('d/m/Y', strtotime($contrat->dateContrat())) ?></td>
											<td class="hidden-phone"><?= $contrat->matiere() ?></td>
											<td>
												<div class="btn-group">
												    <a style="width: 100px" class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $contrat->nom() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a href="#addReglement<?= $contrat->id();?>" data-toggle="modal" data-id="<?= $contrat->id(); ?>">
												        		دفعة مالية
												        	</a>																
												        	<a href="#updateContrat<?= $contrat->id();?>" data-toggle="modal" data-id="<?= $contrat->id(); ?>">
																تعديل
															</a>
															<a href="#deleteContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
																حذف
															</a>
												        </li>
												    </ul>
												</div>
											</td>
										</tr>
										<!-- addReglement box begin-->
										<div id="addReglement<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>اضافة دفعة مالية جديدة</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ContratTravailReglementAddController.php" method="post">
													<p>متأكد من هذه العملية</p>
													<div class="control-group">
														<label class="control-label">المبلغ</label>
														<div class="controls">
															<input type="text" name="montant" value="" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">تاريخ الأداء</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $contrat->dateContrat() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">الملاحظة</label>
														<div class="controls">
															<input type="text" name="motif" value="" />
														</div>
													</div>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idContratTravail" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">الغاء</button>
														<button type="submit" class="btn red" aria-hidden="true">تسجيل</button>
													</div>
												</form>
											</div>
										</div>
										<!-- addReglement box end -->	
										<!-- updateContrat box begin-->
										<div id="updateContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>تعديل معطيات العقد </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ContratTravailUpdateController.php" method="post">
													<div class="control-group">
														<label class="control-label">الاسم</label>
														<div class="controls">
															<input type="text" name="nom" value="<?= $contrat->nom() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">تاريخ الميلاد</label>
														<div class="controls">
															<input type="text" name="dateNaissance" value="<?= $contrat->dateNaissance() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">بطاقة التعريف</label>
														<div class="controls">
															<input type="text" name="cin" value="<?= $contrat->cin() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">العنوان</label>
														<div class="controls">
															<input type="text" name="adresse" value="<?= $contrat->adresse() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">الحرفة</label>
														<div class="controls">
															<input type="text" name="matiere" value="<?= $contrat->matiere() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">تاريخ العقد</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateContrat" id="dateContrat" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $contrat->dateContrat() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">الثمن</label>
														<div class="controls">
															<input type="text" name="prix" value="<?= $contrat->prix() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">القياس</label>
														<div class="controls">
															<input type="text" name="mesure" value="<?= $contrat->mesure() ?>" />
														</div>	
													</div>
													<div class="control-group">
														<label class="control-label">المجموع</label>
														<div class="controls">
															<input type="text" name="prixTotal" value="<?= $contrat->prixTotal() ?>" />
														</div>	
													</div>
													<div class="control-group">
														<div class="controls">	
															<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">الغاء</button>
															<button type="submit" class="btn red" aria-hidden="true">تعديل</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateContrat box end -->			
										<!-- deleteContrat box begin-->
										<div id="deleteContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>حذف العقد</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ContratTravailDeleteController.php" method="post">
													<p>متأكد من هذه العملية</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">الغاء</button>
														<button type="submit" class="btn red" aria-hidden="true">حذف</button>
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
									if($contratNumber != 0){
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
	<script type="text/javascript" src="script.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
		});
		$('#modePaiement').on('change',function(){
	        if( $(this).val()==="Cheque"){
	        $("#numeroCheque").show()
	        }
	        else{
	        $("#numeroCheque").hide()
	        }
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