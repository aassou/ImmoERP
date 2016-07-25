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
    	$idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		$contratManager = new ContratManager($pdo);
		if( ( isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId() ) 
		and ( isset($_GET['idContrat']) and ($_GET['idContrat']>0 and $_GET['idContrat']<=$contratManager->getLastId() ) ) ){
			$idProjet = $_GET['idProjet'];
			$idContrat = $_GET['idContrat'];
			$projet = $projetManager->getProjetById($idProjet);
			$contrat = $contratManager->getContratById($idContrat);
			$operationManager = new OperationManager($pdo);
			$operations = "";
			//test the locaux object number: if exists get operations else do nothing
			$operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($idContrat);
			if($operationsNumber != 0){
				$operations = $operationManager->getOperationsByIdContrat($idContrat);	
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
							Gestion des Opérations de paiements
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
								<a>Gestion des contrats</a>
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a>Gestion des opérations de paiements</a>
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
									<a href="contrats-list.php?idProjet=<?= $idProjet ?>" class="btn icn-only green">
										<i class="m-icon-swapleft m-icon-white"></i> 
										Retour vers Liste des contrats du projet : <strong><?= $projet->nom() ?></strong>
									</a>
								</div>
								<div class="pull-right">
									<a href="projet-list.php" class="btn icn-only green">
										Aller vers Liste des projets <i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
							<?php if(isset($_SESSION['operation-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['operation-add-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['operation-add-success']);
	                         ?>
	                         <?php if(isset($_SESSION['operation-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['operation-update-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['operation-update-success']);
	                         ?>
	                         <?php if(isset($_SESSION['operation-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['operation-delete-success'] ?>		
							</div>
	                         <?php } 
	                         	unset($_SESSION['operation-delete-success']);
	                         ?>
	                         <?php if(isset($_SESSION['operation-add-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['operation-add-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['operation-add-error']);
	                         ?>
	                         <?php if(isset($_SESSION['operation-update-error'])){ ?>
	                         	<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<?= $_SESSION['operation-update-error'] ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['operation-update-error']);
	                         ?>
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4>
                                 	<i class="icon-edit"></i>
                                 	Nouvelle opération de paiement pour le contrat : <strong>N°<?= $idContrat ?></strong> 
                                 	du projet : <strong><?= $projet->nom() ?></strong>
                                 </h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/OperationAddController.php" method="POST" class="horizontal-form">
                                    <div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" for="code">Date opération</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
				                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
				                                    <span class="add-on"><i class="icon-calendar"></i></span>
				                                 </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 ">
                                          <div class="control-group">
                                             <label class="control-label" for="montant">Montant</label>
                                             <div class="controls">
                                                <input type="text" id="montant" name="montant" class="m-wrap span12">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="modePaiement">Mode de paiement</label>
                                             <div class="controls">
                                                <div class="controls">
													<select name="modePaiement" id="modePaiement">
														<option value="Especes">Espèces</option>
														<option value="Cheque">Chèque</option>
														<option value="Versement">Versement</option>
														<option value="Virement">Virement</option>
														<option value="Lettre de change">Lettre de change</option>
														<option value="Remise">Remise</option>
													</select>
												</div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid" id="numeroCheque" style="display: none">
                                    	<div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">N°Chèque</label>
                                             <div class="controls">
                                                <input type="text" name="numeroCheque" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                    	<input type="hidden" id="idContrat" name="idContrat" value="<?= $idContrat ?>" class="m-wrap span12">
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
						<div class="portlet">
							<div class="portlet-title">
								<h4>Liste des opérations du contrat : <strong>N°<?= $idContrat ?></strong></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th style="width: 15%">Date</th>
											<th>Montant</th>
											<!--th>Reste</th-->
											<th class="hidden-phone">Quittance</th>
											<th class="hidden-phone">Mode Paiement</th>
											<th class="hidden-phone">Modifier</th>
											<th class="hidden-phone">Supprimer</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($operationsNumber != 0){
										$montant = 0;
										$reste = $contrat->prixVente() - $operationManager->sommeOperations($contrat->id()) - $contrat->avance();
										foreach($operations as $operation){ 
											//$reste = $reste + $montant;
											//$montant = $montant + $operation->montant(); 
										?>		
										<tr>
											<td><a><?= date('d/m/Y', strtotime($operation->date())) ?></a></td>
											<td><?= number_format($operation->montant(), 2, ',', ' ') ?>&nbsp;DH</td>
											<td class="hidden-phone">
												<a class="btn mini blue" href="controller/OperationPrintController.php?idOperation=<?= $operation->id() ?>"> 
													<i class="m-icon-white icon-print"></i> Imprimer
												</a>
											</td>
											<td class="hidden-phone">
												<?= $operation->modePaiement() ?>
												<?php
												if($operation->modePaiement()=="Cheque" and 
												($operation->numeroCheque()!='0' and $operation->numeroCheque()!="NULL")){
												?>	
													<a href="#updateNumeroCheque<?= $operation->id() ?>" data-toggle="modal" data-id="<?= $operation->id() ?>">
														N°:&nbsp;<?= $operation->numeroCheque() ?>
													</a>
												<?php
												}
												?>	
											</td>
											<td class="hidden-phone">
												<a href="#update<?= $operation->id() ?>" data-toggle="modal" data-id="<?= $operation->id() ?>">
													Modifier
												</a>
											</td>
											<td class="hidden-phone">
												<a href="#delete<?= $operation->id() ?>" data-toggle="modal" data-id="<?= $operation->id() ?>">
													Supprimer
												</a>
											</td>
										</tr>
										<!-- updateNumeroCheque box begin-->
										<div id="updateNumeroCheque<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Infos Opérations</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/OperationUpdateNumeroChequeController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier le N° de chèque ?</p>
													<div class="control-group">
														<label class="control-label">Numéro Chèque</label>
														<div class="controls">
															<input type="text" name="numeroCheque" value="<?= $operation->numeroCheque() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
														<input type="hidden" name="idContrat" value="<?= $idContrat ?>" />
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
										<!-- update box begin-->
										<div id="update<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Infos Opérations</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/OperationUpdateController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier les informations de cette opération ?</p>
													<div class="control-group">
														<label class="control-label">Date opération</label>
														<div class="controls">
															<input type="text" name="dateOperation" value="<?= $operation->date() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $operation->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
														<input type="hidden" name="idContrat" value="<?= $idContrat ?>" />
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
										<div id="delete<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer opération de paiement </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/OperationDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cette opération ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
														<input type="hidden" name="idContrat" value="<?= $idContrat ?>" />
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
										?>
										<!--tr>
											<td><a><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></a></td>											
											<?php
											/*if($contrat->avance()!=0 or $contrat->avance()!='NULL' ){
											?> 
												<td><?= number_format($contrat->avance(), 2, ',', ' ')." DH";?></td>
												<td><?= number_format($contrat->prixVente()-$contrat->avance(), 2, ',', ' ')." DH";?></td>
											<?php
											}*/
											?>
											<td class="hidden-phone">
												<a class="btn mini blue" href="controller/QuittanceAvancePrintController.php?idContrat=<?= $contrat->id() ?>"> 
													<i class="m-icon-white icon-print"></i> Imprimer
												</a>
											</td>
											<td class="hidden-phone"><?= $contrat->modePaiement() ?></td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
										</tr-->
										<tr>
											<td></td>
											<td>
											</td>
											<td class="hidden-phone">
											</td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
										</tr>
										<tr>
											<td><strong>Σ&nbsp;Réglements</strong></td>
											<td>
												<strong>
													<?= number_format($operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?>
												</strong>		
											</td>
											<td class="hidden-phone">
												<!--strong>
													<?= number_format($contrat->prixVente()-($contrat->avance()+$operationManager->sommeOperations($contrat->id())), 2, ',', ' ')." DH";?>
												</strong-->
											</td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
										</tr>
										<tr>
											<td><strong>Reste</strong></td>
											<td>
												<!--strong>
													<?= number_format($contrat->avance()+$operationManager->sommeOperations($contrat->id()), 2, ',', ' ')." DH";?>
												</strong-->		
											</td>
											<td class="hidden-phone">
												<strong>
													<?= number_format($contrat->prixVente()-($operationManager->sommeOperations($contrat->id())), 2, ',', ' ')." DH";?>
												</strong>
											</td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
											<td class="hidden-phone"></td>
										</tr>
										<?php
										}//end of if
										?>
									</tbody>
								</table>
							</div>
						</div>
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