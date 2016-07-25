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
    if ( isset($_SESSION['userMerlaTrav']) ) {
    	//classes managers
		$usersManager = new UserManager($pdo);
		$mailsManager = new MailManager($pdo);
		$notesClientsManager = new NotesClientManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$contratManager = new ContratManager($pdo);
		$clientManager = new ClientManager($pdo);
		$livraisonsManager = new LivraisonManager($pdo);
		$fournisseursManager = new FournisseurManager($pdo);
        $caisseManager = new CaisseManager($pdo);
        $caisseIaazaManager = new CaisseIaazaManager($pdo);
		$operationsManager = new OperationManager($pdo);
        $compteBancaire = new CompteBancaireManager($pdo);
		//classes and vars
		//users number
		$soldeCaisseAnnahda = $caisseManager->getTotalCaisseByType("Entree") - $caisseManager->getTotalCaisseByType("Sortie");
        $soldeCaisseIaaza = $caisseIaazaManager->getTotalCaisseByType("Entree") - $caisseIaazaManager->getTotalCaisseByType("Sortie");
		$projetNumber = ($projetManager->getProjetsNumber());
		$usersNumber = $usersManager->getUsersNumber();
		$fournisseurNumber = $fournisseursManager->getFournisseurNumbers();
		$mailsNumberToday = $mailsManager->getMailsNumberToday();
		$mailsToday = $mailsManager->getMailsToday();
		$clientWeek = $clientManager->getClientsWeek();
		$clientNumberWeek = $clientManager->getClientsNumberWeek();
		$livraisonsNumber = $livraisonsManager->getLivraisonNumber();
		$livraisonsWeek = $livraisonsManager->getLivraisonsWeek();
		$livraisonsNumberWeek = $livraisonsManager->getLivraisonsNumberWeek();
		$operationsNumberWeek = $operationsManager->getOperationNumberWeek()
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="UTF-8" />
	<title>ImmoERP - Management Application</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/metro.css" rel="stylesheet" />
	<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style_responsive.css" rel="stylesheet" />
	<link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
	<link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
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
						<h3 class="page-title">
							Accueil
						</h3>
					</div>
				</div>
				<!--      BEGIN TILES      -->
				<div class="row-fluid">
					<div class="span12">
						<h4 class="breadcrumb"><i class="icon-hand-right"></i> Société Iaaza</h4>
						<div class="tiles">
						    <a href="caisse-group-iaaza.php">
                            <div class="tile bg-yellow">
                                <div class="tile-body">
                                    <i class="icon-money"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        La caisse
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="commande-group-iaaza.php">
                            <div class="tile bg-red">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-shopping-cart"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Les commandes
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="livraisons-group-iaaza.php">
                            <div class="tile bg-blue">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-truck"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Les livraisons
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div><!--  Tiles Iaaza End -->
                    </div>
                </div>    
                
                <?php
                if ( 
                    $_SESSION['userMerlaTrav']->profil() == "admin"
                    || $_SESSION['userMerlaTrav']->profil() == "manager" 
                    || $_SESSION['userMerlaTrav']->profil() == "consultant" 
                ) {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <h4 class="breadcrumb"><i class="icon-hand-right"></i> Société Annahda</h4>
                        <div class="tiles">
						    <a href="caisse-group.php">
                            <div class="tile bg-purple">
                                <div class="tile-body">
                                    <i class="icon-money"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        La caisse
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="livraisons-group.php">
                            <div class="tile bg-cyan">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-truck"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Les livraisons
                                    </div>
                                </div>
                            </div>
                            </a>
							<a href="projets.php">
							<div class="tile bg-green">
								<div class="tile-body">
									<i class="icon-briefcase"></i>
								</div>
								<div class="tile-object">
									<div class="name">
										Les projets
									</div>
									<div class="number">
										<?= $projetNumber ?>
									</div>
								</div>
							</div>
							</a>
							<a href="status.php">
                            <div class="tile bg-yellow">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-tasks"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Les états
                                    </div>
                                </div>
                            </div>
                            </a>
                            <?php
                            if ( 
                                $_SESSION['userMerlaTrav']->profil() == "admin" 
                            ) {
                            ?>
							<a href="charges-communs-grouped.php">
                            <div class="tile bg-grey">
                                <div class="tile-body">
                                    <i class="icon-signal"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Charges communs
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="releve-bancaire.php">
                            <div class="tile bg-blue">
                                <div class="tile-body">
                                    <i class="icon-envelope-alt"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Relevé Bancaire
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
                            <a href="suivi-company.php">
                            <div class="tile bg-brown">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-bar-chart"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Statistiques Globales
                                    </div>
                                </div>
                            </div>
                            </a>
							<a href="configuration.php">
							<div class="tile bg-dark-red">
								<div class="corner"></div>
								<div class="tile-body">
									<i class="icon-wrench"></i>
								</div>
								<div class="tile-object">
									<div class="name">
										Paramétrages
									</div>
								</div>
							</div>
							</a>
							<?php
							}
                            ?>
						</div>
					</div>
				</div>
				<!--      BEGIN TILES      -->
				<!-- BEGIN DASHBOARD STATS -->
				<h4 class="breadcrumb"><i class="icon-table"></i> Bilans et Statistiques Pour Cette Semaine</h4>
				<div class="row-fluid">
					<div class="span2 responsive" data-tablet="span2" data-desktop="span2">
						<div class="dashboard-stat red">
							<div class="visual">
								<i class="icon-signal"></i>
							</div>
							<div class="details">
								<div class="number">
									<?= $operationsNumberWeek ?>	
								</div>
								<div class="desc">									
									Régl.Cli
								</div>
							</div>					
						</div>
					</div>
					<div class="span2 responsive" data-tablet="span2" data-desktop="span2">
						<div class="dashboard-stat green">
							<div class="visual">
								<i class="icon-shopping-cart"></i>
							</div>
							<div class="details">
								<div class="number">+<?= $livraisonsNumberWeek ?></div>
								<div class="desc">Livraisns</div>
							</div>					
						</div>
					</div>
					<div class="span2 responsive" data-tablet="span2" data-desktop="span2">
						<div class="dashboard-stat blue">
							<div class="visual">
								<i class="icon-group"></i>
							</div>
							<div class="details">
								<div class="number">+<?= $clientNumberWeek ?></div>
								<div class="desc">Clients</div>
							</div>			
						</div>
					</div>	
					<div class="span3 responsive" data-tablet="span3" data-desktop="span3">
						<a class="more" href="caisse.php">
						<div class="dashboard-stat purple">
							<div class="visual">
								<i class="icon-money"></i>
							</div>
							<div class="details">
								<div class="number">
									<?= number_format($soldeCaisseAnnahda, '2', ',', ' ') ?>
								</div>
								<div class="desc">Caisse Annahda</div>
							</div>					
						</div>
						</a>
					</div>
					<div class="span3 responsive" data-tablet="span3" data-desktop="span3">
                        <a class="more" href="caisse-iaaza.php">
                        <div class="dashboard-stat yellow">
                            <div class="visual">
                                <i class="icon-money"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?= number_format($soldeCaisseIaaza, '2', ',', ' ') ?>
                                </div>
                                <div class="desc">Caisse Iaaza</div>
                            </div>                  
                        </div>
                        </a>
                    </div>	
				</div>
				<!-- END DASHBOARD STATS -->
				<!-- BEGIN DASHBOARD FEEDS -->
				<!-- ------------------------------------------------------ -->
				<div class="row-fluid">
				<div class="span12">
					<!-- BEGIN PORTLET-->
					<div class="portlet paddingless">
						<div>
							<h4 class="breadcrumb"><i class="icon-bell"></i>&nbsp;Nouveautés</h4>
						</div>
						<div class="portlet-body">
							<!--BEGIN TABS-->
							<div class="tabbable tabbable-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1_1" data-toggle="tab">Les livraisons de la semaine</a></li>
									<li><a href="#tab_1_2" data-toggle="tab">Les clients de la semaine</a></li>
									<li><a href="#tab_1_3" data-toggle="tab">Notes des clients</a></li>
									<!--li><a href="#tab_1_4" data-toggle="tab">Les messages d'aujourd'hui</a></li-->
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1_1">
										<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
											<ul class="feeds">
												<?php
												foreach($livraisonsWeek as $livraison){
												    $projetName = "Non mentionné";
												    if ( $livraison->idProjet() != 0 ) {
												        $projetName = $projetManager->getProjetById($livraison->idProjet())->nom();    
												    } 
                                                    else {
                                                        $projetName = "Non mentionné";
                                                    }
												    
												?>
												<li>
													<div class="col1">
														<div class="cont">
															<div class="cont-col1">
																<div class="desc">	
																	<strong>Fournisseur</strong> : <?= $fournisseursManager->getFournisseurById($livraison->idFournisseur())->nom() ?><br>
																	<strong>Projet</strong> : <?= $projetName; ?><br>
																	<a href="livraisons-details.php?codeLivraison=<?= $livraison->code() ?>" target="_blank">
																		<strong>Livraison</strong> : <?= $livraison->id() ?>
																	</a>
																</div>
															</div>
														</div>
													</div>
													<div class="col2">
														<div class="date">
															<?= $livraison->dateLivraison() ?>
														</div>
													</div>
												</li>
												<hr>
												<?php 
												}
												?>
											</ul>
										</div>
									</div>
									<div class="tab-pane" id="tab_1_2">
										<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
											<ul class="feeds">
												<?php
												foreach($clientWeek as $client){
													$contrats = $contratManager->getContratsByIdClient($client->id());
												?>
												<li>
													<div class="col1">
														<div class="cont">
															<div class="cont-col1">
																<div class="desc">	
																	<strong>Client</strong> : <?= $client->nom() ?><br>
																	<?php
																	foreach($contrats as $contrat){
																	?>
																	<a href="contrat.php?codeContrat=<?= $contrat->code() ?>" target="_blank">
																		<strong>Contrat</strong> : <?= $contrat->id() ?>
																	</a><br>
																	<strong>Projet</strong> : <?= $projetName = $projetManager->getProjetById($contrat->idProjet())->nom(); ?>
																	<br>
																	<?php
																	}
																	?>
																</div>
															</div>
														</div>
													</div>
													<div class="col2">
														<div class="date">
															<?= date('d/m/Y', strtotime($client->created())) ?>
														</div>
													</div>
												</li>
												<hr>
												<?php 
												}
												?>
											</ul>
										</div>
									</div>
									<div class="tab-pane" id="tab_1_3">
										<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
											<ul class="feeds">
												<?php
												$notesClient = $notesClientsManager->getNotes();
												foreach($notesClient as $notes){
													$contrat = $contratManager->getContratByCode($notes->codeContrat());
													$projetName = $projetManager->getProjetById($notes->idProjet())->nom();
													$client = $clientManager->getClientById($contrat->idClient());
													if( str_word_count($notes->note())>0 ){
												?>
												<li>
													<div class="col1">
														<div class="cont">
															<div class="cont-col1">
																<div class="label label-success">								
																	<i class="icon-bell"></i>
																</div>
															</div>
															<div class="cont-col2">
																<div class="desc">	
																	<strong>Note</strong> : <?= $notes->note() ?><br>
																	<strong>Client</strong> : <?= $client->nom() ?><br>
																	<a href="contrat.php?codeContrat=<?= $notes->codeContrat() ?>" target="_blank">
																		<strong>Contrat</strong> : <?= $contrat->id() ?>
																	</a><br> 
																	<strong>Projet</strong> : <?= $projetName ?>
																</div>
															</div>
														</div>
													</div>
													<div class="col2">
														<div class="date">
															<?= $notes->created() ?>
														</div>
													</div>
												</li>
												<hr>
												<?php 
												}//end if
												}
												?>
											</ul>
										</div>
									</div>
									<!--div class="tab-pane" id="tab_1_4">
										<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
											<?php
											//foreach($mailsToday as $mail){
											?>
											<div class="row-fluid">
												<div class="span6 user-info">
													<img alt="" src="assets/img/avatar.png" />
													<div class="details">
														<div>
															<a href="#"><?php //echo $mail->sender() ?></a> 
														</div>
														<div>
															<strong>Message : </strong><?php //echo $mail->content() ?><br>
															<strong>Envoyé Aujourd'hui à : </strong><?php //echo date('h:i', strtotime($mail->created())) ?>
														</div>
													</div>
												</div>
											</div>
											<hr>
											<?php
											//}
											?>
										</div>
									</div-->
								</div>
							</div>
							<!--END TABS-->
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
				</div>
				<?php
                }
                ?>
				<!-- ------------------------------------------------------ -->
				<!-- END DASHBOARD FEEDS -->
				<!-- END PAGE HEADER-->
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
	<script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
	<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script src="assets/jquery-knob/js/jquery.knob.js"></script>
	<script src="assets/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("sliders");  // set current page
			App.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>