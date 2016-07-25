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
    	$idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		$clientManager = new ClientManager($pdo);
        $companieManager = new CompanyManager($pdo);
        $projet = "";
		if((isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId())
		and (isset($_GET['codeClient']) and (bool)$clientManager->getCodeClient($_GET['codeClient']) )){
			$idProjet = $_GET['idProjet'];
			$codeClient = $_GET['codeClient'];
			$projet = $projetManager->getProjetById($idProjet);
			$client = $clientManager->getClientByCode($codeClient);
            $companies = $companieManager->getCompanys();
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
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
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
	                         <?php 
	                         if( isset($_SESSION['contrat-action-message'])
                             and isset($_SESSION['contrat-type-message']) ){
                                 $message = $_SESSION['contrat-action-message'];
                                 $typeMessage = $_SESSION['contrat-type-message'];
                             ?>
	                         	<div class="alert alert-<?= $typeMessage ?>">
									<button class="close" data-dismiss="alert"></button>
									<?= $message ?>		
								</div>
	                         <?php } 
	                         	unset($_SESSION['contrat-action-message']);
                                unset($_SESSION['contrat-type-message']);
	                         ?>
                           <div class="portlet box blue">
                                  <div class="portlet-title">
                                     <h4><strong>Etape 2 : </strong> Informations Contrat</h4>
                                  </div>
                                <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="controller/ContratActionController.php" method="POST" id="contratForm" class="horizontal-form" enctype="multipart/form-data">
                                    <!--div class="row-fluid">
                                    	<div class="span12">
                                    		<img src="assets/img/form_wizard_client_contrat_2.png">
                                    	</div>
                                    </div-->
                                    <div class="row-fluid">
                                    	<div class="span12">
                                    		<div class="progress progress-striped progress-success">
												<div style="width: 100%;" class="bar"></div>
											</div>
                                    	</div>
                                    </div>
                                    <legend>Création du Contrat pour le Client : <strong><?= $client->nom() ?></strong></legend>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="numero">Numéro du contrat</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="numero" name="numero" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="dateCreation">Date de création</label>
                                             <div class="controls">
                                                <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                    <input name="dateCreation" id="dateCreation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                 </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label">Type du bien</label>
                                             <div class="controls">
                                                <label class="radio">
                                                 <input type="radio" class="typeBien" name="typeBien" value="localCommercial" />
                                                 Locaux
                                                </label>
                                                <label class="radio">
                                                 <input type="radio" class="typeBien" name="typeBien" value="appartement" />
                                                 Appartement
                                                </label>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3 hidenBlock">
                                          <div class="control-group">
                                             <div class="controls">
                                                <label class="control-label" for="" id="nomBienLabel"></label>
                                                <select class="m-wrap" name="bien" id="bien">
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="prixNegocie">Prix négocié</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="prixNegocie" name="prixNegocie" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                        <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="avance">Avance</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="avance" name="avance" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="dureePaiement">Durée de paiement</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="dureePaiement" name="dureePaiement" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="nombreMois">Nombre de mois</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="nombreMois" name="nombreMois" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                    	<div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="echeance">Echéance</label>
                                             <div class="controls">
                                             	<input required="required" type="text" id="echeance" name="echeance" class="m-wrap">
                                             </div>
                                          </div>
                                        </div>
                                        <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="modePaiement">Mode de paiement</label>
                                             <div class="controls">
                                                <div class="controls">
                                                    <select class="m-wrap" name="modePaiement" id="modePaiement">
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
                                        <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label">N° Opération</label>
                                             <div class="controls">
                                                <input type="text" name="numeroCheque" class="m-wrap">
                                             </div>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="prixNegocieArabe">مبلغ البيع المتفق عليه</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="prixNegocieArabe" name="prixNegocieArabe" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                        <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="avanceArabe">التسبيق</label>
                                             <div class="controls">
                                                <input required="required" type="text" id="avanceArabe" name="avanceArabe" class="m-wrap">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span3">
                                          <div class="control-group">
                                            <label class="control-label">الشركة</label>
                                            <div class="controls">
                                                <select name="societeArabe">
                                                    <?php
                                                    foreach ( $companies as $company ) {
                                                    ?>
                                                    <option value="<?= $company->id() ?>"><?= $company->nomArabe() ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span3">
                                           <div class="control-group">
                                                <label class="control-label">وضعية الشقة/المحل التجاري</label>
                                                <div class="controls">
                                                    <select name="etatBienArabe">
                                                        <option value="الأشغال الأساسية للبناء">الأشغال الأساسية للبناء</option>
                                                        <option value="Finition">الأشغال النهائية للبناء</option>
                                                    </select>    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">الواجهة</label>
                                                <div class="controls">
                                                    <input type="text" required="required" id="facadeArabe" name="facadeArabe" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span3">
                                            <div class="control-group">
                                                <label class="control-label">بنود أخرى</label>
                                                <div class="controls">
                                                    <textarea style="height:100px; width:500px" name="articlesArabes"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row-fluid">
                                        <div class="span3">
                                          <div class="control-group">
                                            <label class="checkbox">
                                            <input type="checkbox" id="show-note-client" name="show-note-client" value="show-note-client" />
                                            Avec Modifications
                                            </label>
                                          </div>
                                        </div>
                                    </div>
                                    <!-- BEGIN NOTE CLIENT DIV -->
                                    <div class="row-fluid" id="note-client" style="display: none">
                                        <h4><strong>Modifications Client</strong></h4>
                                        <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="note">Note client</label>
                                             <div class="controls">
                                                <textarea id="note" name="note" class="m-wrap"></textarea>
                                             </div>
                                          </div>
                                        </div>
                                        <div class="span3">
                                          <div class="control-group">
                                             <label class="control-label" for="note">Image Note Client</label>
                                             <div class="controls">
                                                <input type="file" id="note-client-image" name="note-client-image" class="m-wrap" />
                                             </div>
                                          </div>
                                        </div>
                                    </div>
                                    <!-- END NOTE CLIENT DIV -->
                                    <hr>
                                    <div class="row-fluid">
                                        <div class="span3">
                                          <div class="control-group">
                                            <label class="checkbox">
                                            <input type="checkbox" id="show-cas-libre" name="show-cas-libre" value="show-cas-libre" />
                                            Renseigner plus de détails
                                            </label>
                                          </div>
                                        </div>
                                    </div>
                                    <!-- BEGIN CAS LIBRE DIV -->
                                    <div id="cas-libre" style="display: none">
                                        <h4><strong>Cas libre</strong> : Informations complémentaires</h4>
                                        <hr>
                                        <?php include('include/cas-libre.php'); ?>
                                    </div>
                                    <!-- END CAS LIBRE DIV -->
                                    <div class="form-actions">
                                        <input type="hidden" name="action" value="add">
                                    	<input type="hidden" id="idProjet" name="idProjet" value="<?= $idProjet ?>">
                                    	<input type="hidden" id="idClient" name="idClient" value="<?= $client->id() ?>">
                                    	<input type="hidden" id="codeClient" name="codeClient" value="<?= $codeClient ?>">
                                    	<a href="clients-add.php?idProjet=<?= $idProjet ?>" class="btn blue"><i class="m-icon-swapleft m-icon-white"></i>&nbsp;Retour</a>
                                       <button type="submit" class="btn green">Terminer <i class="icon-ok m-icon-white"></i></button>
                                    </div>
                                 </form>
                                 <?php
                                    unset($_SESSION['contrat-form-data']);
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
	<script type="text/javascript" src="assets/jquery-validation/jquery.validate.js"></script>
	<script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
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
			$('.hidenBlock').hide();
			App.init();
			//show-cas-libre
			$('#show-cas-libre').change(function(){
			    $("#cas-libre").toggle();
			});
			$('#show-note-client').change(function(){
                $("#note-client").toggle();
            });
		});
		$(document).ready(function() {
			$('.typeBien').change(function(){
				$('.hidenBlock').show();
				var typeBien = $(this).val();
				var idProjet = <?= $idProjet ?>;
				var data = 'typeBien='+typeBien+'&idProjet='+idProjet;
				$.ajax({
					type: "POST",
					url: "types-biens.php",
					data: data,
					cache: false,
					success: function(html){
						$('#bien').html(html);
						if(typeBien=="appartement"){
							$('#nomBienLabel').text("Les appartements");	
						}
						else{
							$('#nomBienLabel').text("Les locaux commerciaux");
						}
					}
				});
			});
			$('#nombreMois').change(function(){
				var dureePaiement = $('#dureePaiement').val();
				var prixNegocie = $('#prixNegocie').val();
				var avance = $('#avance').val();
				var nombreMois = $(this).val();
				var echeance = Math.round( ( prixNegocie - avance ) / ( dureePaiement / nombreMois ) );
				$('#echeance').val(echeance);
			});
			$("#contratForm").validate({
			     rules:{
			       prixNegocie: {
			           number: true,
			           required: true
			       },
			       avance: {
			           number: true,
			           required: true
			       },
			       nombreMois: {
			           number: true,
			           required: true
			       },
			       dureePaiement: {
			           number: true,
			           required: true
			       },
			       echeance: {
			           number: true,
			           required: true
			       }
			     },
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
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}
?>