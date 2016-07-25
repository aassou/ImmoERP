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
    	//les services
    	$clients = "";
    	$clientManager = new ClientManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$contratsManager = new ContratManager($pdo);
        $compteBancaireManager = new CompteBancaireManager($pdo);
		$operationManager = new OperationManager($pdo); 
		$locauxManager = new LocauxManager($pdo);
		$appartementManager = new AppartementManager($pdo);
        if(isset($_SESSION['searchClientResult'])){
            $clients = $_SESSION['searchClientResult'];
            $comptesBancaires = $compteBancaireManager->getCompteBancaires();
        }
        
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="en"> <!--<![endif]-->
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
    							Liste des clients trouvés
    						</h3>
    						<ul class="breadcrumb">
    							<li>
    								<i class="icon-home"></i>
    								<a href="dashboard.php">Accueil</a> 
    								<i class="icon-angle-right"></i>
    							</li>
    							<li>
    								<i class="icon-search"></i>
    								<a>Rechercher Clients</a>
    							</li>
    						</ul>
    						<!-- END PAGE TITLE & BREADCRUMB-->
    					</div>
    				</div>
    				<!-- END PAGE HEADER-->
    				<!-- BEGIN PAGE CONTENT-->
    				<div class="row-fluid">
    					<div class="span12">
    						<!--a href="recherches.php" class="btn big yellow">
    							<i class="m-icon-big-swapleft m-icon-white"></i> 
    							Page recherches
    							<i class="icon-search"></i>
    						</a-->
    						<!--div class="tab-pane active" id="tab_1">
                               <div class="portlet box blue">
                                  <div class="portlet-title">
                                     <h4><i class="icon-search"></i>Chercher un client</h4>
                                     <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="javascript:;" class="remove"></a>
                                     </div>
                                  </div>
                                  <div class="portlet-body form">
                                     <?php if(isset($_SESSION['client-search-error'])){ ?>
                                     	<div class="alert alert-error">
        									<button class="close" data-dismiss="alert"></button>
        									<?= $_SESSION['client-search-error'] ?>		
        								</div>
                                     <?php } 
                                     	unset($_SESSION['client-search-error']);
                                     ?>
                                     <form action="controller/SearchClientController.php" method="POST" class="horizontal-form">
                                        <div class="row-fluid">
                                           <div class="span6 ">
                                              <div class="control-group">
                                                 <label class="control-label">Recherche par</label>
    				                              <div class="controls">
    				                                 <label class="radio">
    				                                 <input type="radio" name="searchOption" value="searchByName" checked />
    				                                 Nom
    				                                 </label>
    				                                 <label class="radio">
    				                                 <input type="radio" name="searchOption" value="searchByCIN" />
    				                                 CIN
    				                                 </label>  
    				                              </div>
                                              </div>
                                           </div>
                                           </span>
                                           <div class="span6 ">
                                              <div class="control-group autocomplet_container">
                                                 <label class="control-label" for="nomClient">Tapez votre recherche</label>
                                                 <div class="controls">
                                                    <input type="text" id="nomClient" name="search" class="m-wrap span12" onkeyup="autocompletClient()">
                                                    <ul id="clientList"></ul>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                        <div class="form-actions">
                                           <button type="submit" class="btn green"><i class="icon-search"></i>Lancer la recherche</button>
                                        </div>
                                     </form> 
                                  </div>
                               </div>
                            </div-->
    						<!-- BEGIN EXAMPLE TABLE PORTLET-->
    						<div class="portlet box light-grey">
                                <div class="portlet-title">
                                    <h4>Liste des clients</h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="reload"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
    								<div class="clearfix">
    								</div>
    								<?php if((bool)$clients){ ?>
    										<?php foreach ($clients as $client){ 
    											$contrats = $contratsManager->getContratsActifsByIdClient($client->id());	
    										?>
    										<?php if((bool)$contrats){ ?>
    										    <h3><?= $client->nom()?></h3>
    										<table class="table table-striped table-bordered table-hover" id="sample_1">
    											<thead>
    												<tr>
    													<th style="width:5%">Actions</th>
                                                        <th style="width:15%">Client</th>
                                                        <th style="width:15%" class="hidden-phone">Bien</th>
                                                        <th style="width:15%">Date Contrat</th>
                                                        <th style="width:10%" class="hidden-phone">Prix</th>
                                                        <th style="width:10%" class="hidden-phone">Réglements</th>
                                                        <th style="width:10%" class="hidden-phone">Reste</th>
                                                        <th style="width:10%" class="hidden-phone">Status</th>
    												</tr>
    											</thead>
    											<tbody>
    												<?php foreach ($contrats as $contrat) {
    													$operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
                                                        $sommeOperations = $operationManager->sommeOperations($contrat->id());
                                                        $bien = "";
                                                        $typeBien = "";
                                                        $etage = "";
                                                        if($contrat->typeBien()=="appartement"){
                                                            $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                            $typeBien = "Appartement";
                                                            $etage = "Etage ".$bien->niveau();
                                                        }
                                                        else{
                                                            $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                            $typeBien = "Local commercial";
                                                            $etage = "";
                                                        }
    												?>	
    												<tr class="odd gradeX">
                                                        <td>
                                                            <div class="btn-group">
                                                                <a class="btn black mini dropdown-toggle" href="#" data-toggle="dropdown">
                                                                    Choisir 
                                                                    <i class="icon-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a target="_blank" href="contrat.php?codeContrat=<?= $contrat->code() ?>">
                                                                            Consulter Contrat
                                                                        </a>
                                                                        <?php
                                                                        if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                                        ?>
                                                                        <a href="#addReglement<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                                            Nouveau réglement
                                                                        </a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <a target="_blank" href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>">
                                                                            Imprimer Contrat
                                                                        </a>
                                                                        <a target="_blank" href="controller/ClientFichePrintController.php?idContrat=<?= $contrat->id() ?>">
                                                                            Imprimer Fiche Client
                                                                        </a>
                                                                        <?php
                                                                        if( $_SESSION['userMerlaTrav']->profil() == "admin" ){ 
                                                                        if( $contrat->status()=="actif" ){
                                                                        ?>
                                                                        <a style="color:red" href="#desisterContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                                            Désister
                                                                        </a>
                                                                        <?php 
                                                                        }
                                                                        else{
                                                                        ?>  
                                                                        <a href="#activerContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                                            Activer
                                                                        </a>    
                                                                        <?php   
                                                                        }//if status actif or not
                                                                        }//if profil is admin
                                                                        ?>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td><?= $clientManager->getClientById($contrat->idClient())->nom() ?></td>
                                                        <td class="hidden-phone"><?= $typeBien ?> - <?= $bien->nom() ?> - <?= $etage ?></td>
                                                        <td class="hidden-phone"><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></td>
                                                        <td class="hidden-phone"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
                                                        <td class="hidden-phone"><?= number_format($sommeOperations, 2, ',', ' ') ?></td>
                                                        <td class="hidden-phone"><?= number_format($contrat->prixVente()-$sommeOperations, 2, ',', ' ') ?></td>
                                                        </td>
                                                        <td class="hidden-phone">
                                                            <?php if($contrat->status()=="actif"){
                                                                $status = "<a class=\"btn mini green\">Actif</a>";  
                                                            }
                                                            else{
                                                                $status = "<a class=\"btn mini black\">Désisté</a>";    
                                                            }
                                                            echo $status;
                                                            ?>  
                                                        </td>
                                                        <?php 
                                                        if(isset($_SESSION['print-quittance']) and $operationsNumber>=1){ ?>
                                                            <td>
                                                                <a class="btn mini blue" href="controller/OperationPrintController.php?idOperation=<?= $operationManager->getLastIdByIdContrat($contrat->id()) ?>"> 
                                                                    <i class="m-icon-white icon-print"></i> Imprimer
                                                                </a>
                                                            </td>
                                                        <?php 
                                                        }
                                                        unset($_SESSION['print-quittance']); 
                                                        ?>
                                                    </tr>
                                                    <!-- desistement box begin-->
                                                    <div id="desisterContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                            <h3>Désister le contrat </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal loginFrm" action="controller/ContratActionController.php" method="post">
                                                                <p>Êtes-vous sûr de vouloir désister le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
                                                                <div class="control-group">
                                                                    <input type="hidden" name="action" value="desister" />
                                                                    <input type="hidden" name="source" value="clients-search" />
                                                                    <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- desistement box end -->
                                                    <!-- addReglement box begin-->
                                                    <div id="addReglement<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                            <h3>Nouveau réglement </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                                <div class="control-group">
                                                                     <label class="control-label" for="code">Date opération</label>
                                                                     <div class="controls">
                                                                        <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                                         </div>
                                                                     </div>
                                                                </div>
                                                                <div class="control-group">
                                                                     <label class="control-label" for="code">Date réglement</label>
                                                                     <div class="controls">
                                                                        <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                                            <input name="dateReglement" id="dateReglement" class="m-wrap m-ctrl-small date-picker" type="text" value="" />
                                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                                         </div>
                                                                     </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">Montant</label>
                                                                    <div class="controls">
                                                                        <input type="text" required="required" id="montant" name="montant" />
                                                                    </div>
                                                                </div>
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
                                                                <div class="control-group">
                                                                    <label class="control-label">Compte Bancaire</label>
                                                                    <div class="controls">
                                                                        <select name="compteBancaire" id="compteBancaire">
                                                                            <?php
                                                                            foreach ($comptesBancaires as $compte) {
                                                                            ?>
                                                                                <option value="<?= $compte->numero() ?>"><?= $compte->numero() ?></option>
                                                                            <?php  
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">Numéro Opération</label>
                                                                    <div class="controls">
                                                                        <input type="text" required="required" name="numeroOperation" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">Observation</label>
                                                                    <div class="controls">
                                                                        <textarea type="text" name="observation"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <div class="controls">
                                                                        <input type="hidden" name="action" value="add" />
                                                                        <input type="hidden" name="source" value="clients-search" />
                                                                        <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- addReglement box end -->
                                                    <!-- activation box begin-->
                                                    <div id="activerContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                            <h3>Activer le contrat </h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal loginFrm" action="controller/ContratActionController.php" method="post">
                                                                <p>Êtes-vous sûr de vouloir activer le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
                                                                <div class="control-group">
                                                                    <input type="hidden" name="action" value="activer" />
                                                                    <input type="hidden" name="source" value="clients-search" />
                                                                    <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- activation box end -->
    												<?php 
    												}//end foreach contrats
    										}//end foreach clients ?>
    											</tbody>
    										</table>
    										<?php 
    										}//end if contrats ?>
    								<?php } 
    									else{
    								?>		
    								<div class="alert alert-error">
        									<button class="close" data-dismiss="alert"></button>
        									Aucun résultat trouvé.
        								</div>
    								<?php		
    									}
    								?>
    							</div>
    						</div>
    						<br><br><br><br><br><br>
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
    	<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    	<script src="assets/js/app.js"></script>
    	<script type="text/javascript" src="script.js"></script>		
    	<script>
    		jQuery(document).ready(function() {			
    			// initiate layout and plugins
    			App.setPage("table_managed");
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