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
		$projetManager = new ProjetManager($pdo);
        $caisseManager = new CaisseManager($pdo);
        $caisseEntreesManager = new CaisseEntreesManager($pdo);
        $caisseSortiesManager = new CaisseSortiesManager($pdo);
		$projets = $projetManager->getProjets();	
	    $caisses =$caisseManager->getCaisses();
        $totalCaisse = 
        $caisseManager->getTotalCaisseByType('Entree') - $caisseManager->getTotalCaisseByType('Sortie');
        $totalEntrees = $caisseManager->getTotalCaisseByType('Entree');
        $totalSorties = $caisseManager->getTotalCaisseByType('Sortie');
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
							Gestion de la caisse
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-money"></i>
								<a>Gestion de la caisse - Société Annahda</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<?php 
						if( isset($_SESSION['caisse-action-message'])
                        and isset($_SESSION['caisse-type-message']) ){
                            $message = $_SESSION['caisse-action-message']; 
                            $typeMessage = $_SESSION['caisse-type-message'];
                        ?>
                     	<div class="alert alert-<?= $typeMessage ?>">
							<button class="close" data-dismiss="alert"></button>
							<?= $message ?>		
						</div>
                         <?php } 
                         	unset($_SESSION['caisse-action-message']);
                            unset($_SESSION['caisse-type-message']);
                         ?>
                        <!-- addCaisse box begin -->
                        <div id="addCaisse" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <h3>Ajouter une opération à la caisse</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addCaisseForm" class="form-horizontal" action="controller/CaisseActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Type Opération</label>
                                        <div class="controls">
                                            <select name="type">
                                                <option value="Entree">Entree</option>
                                                <option value="Sortie">Sortie</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date Opération</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Montant</label>
                                        <div class="controls">
                                            <input required="required" id="montant" type="text" name="montant" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Destination</label>
                                        <div class="controls">
                                            <select name="destination">
                                                <option value="Bureau">Bureau</option>
                                                <?php foreach($projets as $projet){ ?>
                                                <option value="<?= $projet->nom() ?>"><?= $projet->nom() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Designation</label>
                                        <div class="controls">
                                            <input id="designation" type="text" name="designation" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">  
                                            <input type="hidden" name="action" value="add">    
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addCaisse box end -->  
                        <!-- printBilanCaisse box begin -->
                        <div id="printCaisseBilan" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Imprimer Bilan de la Caisse </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/CaissePrintController.php" method="post" enctype="multipart/form-data">
                                    <p><strong>Séléctionner les opérations de caisse à imprimer</strong></p>
                                    <div class="control-group">
                                      <label class="control-label">Imprimer</label>
                                      <div class="controls">
                                         <label class="radio">
                                             <div class="radio" id="toutes">
                                                 <span>
                                                     <input type="radio" class="criteriaPrint" name="criteria" value="toutesCaisse" style="opacity: 0;">
                                                 </span>
                                             </div> Toute la liste
                                         </label>
                                         <label class="radio">
                                             <div class="radio" id="date">
                                                 <span class="checked">
                                                     <input type="radio" class="criteriaPrint" name="criteria" value="parDate" checked="" style="opacity: 0;">
                                                 </span>
                                             </div> Par Choix
                                         </label>  
                                      </div>
                                   </div>
                                   <div id="showDateRange">
                                    <div class="control-group">
                                        <label class="control-label">Date</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                           <input style="width:100px" name="dateFrom" id="dateFrom" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                           &nbsp;-&nbsp;
                                           <input style="width:100px" name="dateTo" id="dateTo" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Type Opération</label>
                                        <div class="controls">
                                            <select class="m-wrap" name="type">
                                                <option value="Toutes">Toutes les opérations</option>
                                                <option value="Entree">Entrées</option>
                                                <option value="Sortie">Sorties</option>
                                            </select>
                                        </div>
                                    </div>
                                   </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="societe" value="1" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- printBilanCaisse box end -->
                       <table class="table table-striped table-bordered table-advance table-hover">
                            <tbody>
                                <tr>
                                    <th style="width: 15%"><strong>Total des entrées</strong></th>
                                    <th style="width: 18%"><a><strong><?= number_format($totalEntrees, 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
                                    <th style="width: 15%"><strong>Total des sorties</strong></th>
                                    <th style="width: 18%"><a><strong><?= number_format($totalSorties, 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
                                    <th style="width: 15%"><strong>Solde de caisse</strong></th>
                                    <th style="width: 19%"><a><strong><?= number_format($totalCaisse, 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
                                </tr>
                            </tbody>
                        </table>
                       <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>La caisse</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <?php
                                    if ( 
                                        $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                        $_SESSION['userMerlaTrav']->profil() == "manager" 
                                        ) {
                                    ?>
                                    <div class="btn-group pull-left">
                                        <a class="btn blue" href="#addCaisse" data-toggle="modal">
                                            <i class="icon-plus-sign"></i>
                                             Ajouter
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="btn-group pull-right">
                                        <a class="btn green" href="#printCaisseBilan" data-toggle="modal">
                                            <i class="icon-print"></i>
                                             Bilan de Caisse
                                        </a>
                                    </div>
                                    <!--div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Print</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Export to Excel</a></li>
                                        </ul>
                                    </div-->
                                </div>
                                <!--div class="scroller" data-height="500px" data-always-visible="1"--><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <?php
                                            if ( 
                                                $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                $_SESSION['userMerlaTrav']->profil() == "manager" 
                                                ) {
                                            ?>
                                            <th style="width:10%">Actions</th>
                                            <?php
                                            }
                                            ?>
                                            <th style="width:15%">Date Opération</th>
                                            <!--th style="width:10%">Montant</th-->
                                            <th style="width:10%">Crédit</th>
                                            <th style="width:10%">Débit</th>
                                            <th style="width:10%">Destination</th>
                                            <th style="width:45%">Designation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($caisses as $caisse){
                                        ?>      
                                        <tr class="odd gradeX">
                                            <?php
                                            if ( 
                                                $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                $_SESSION['userMerlaTrav']->profil() == "manager" 
                                                ) {
                                            ?>
                                            <td>
                                                <a class="btn mini red" href="#deleteCaisse<?= $caisse->id() ?>" data-toggle="modal" data-id="<?= $caisse->id() ?>"><i class="icon-remove"></i></a>
                                                <a class="btn mini green" href="#updateCaisse<?= $caisse->id() ?>" data-toggle="modal" data-id="<?= $caisse->id() ?>"><i class="icon-refresh"></i></a>    
                                            </td>
                                            <?php
                                            }
                                            ?>
                                            <!--td><?= $caisse->type() ?></td-->
                                            <td><?= date('d/m/Y', strtotime($caisse->dateOperation())) ?></td>
                                            <?php
                                            if ( $caisse->type() == "Entree" ) {
                                            ?>
                                            <td><?= number_format($caisse->montant(), 2, ',', ' ') ?></td>
                                            <td></td>
                                            <?php  
                                            }
                                            else {
                                            ?>
                                            <td></td>
                                            <td><?= number_format($caisse->montant(), 2, ',', ' ') ?></td>
                                            <?php
                                            }
                                            ?>
                                            <td><?= $caisse->destination() ?></td>
                                            <td><?= $caisse->designation() ?></td>
                                        </tr>
                                        <!-- updateCaisse box begin -->
                                        <div id="updateCaisse<?= $caisse->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <h3>Modifier une opération de caisse</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="addCaisseForm" action="controller/CaisseActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Type Opération</label>
                                                        <div class="controls">
                                                            <select name="type">
                                                                <option value="<?= $caisse->type() ?>"><?= $caisse->type() ?></option>
                                                                <option disabled="disabled">-----------------</option>
                                                                <option value="Entree">Entree</option>
                                                                <option value="Sortie">Sortie</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Date Opération</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $caisse->dateOperation() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Montant</label>
                                                        <div class="controls">
                                                            <input required="required" id="montant" type="text" name="montant" value="<?= $caisse->montant() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Destination</label>
                                                        <div class="controls">
                                                            <select name="destination">
                                                                <option value="<?= $caisse->destination() ?>"><?= $caisse->destination() ?></option>
                                                                <option disabled="disabled">-----------------</option>
                                                                <?php foreach($projets as $projet){ ?>
                                                                <option value="<?= $projet->nom() ?>"><?= $projet->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Designation</label>
                                                        <div class="controls">
                                                            <input id="designation" type="text" name="designation" value="<?= $caisse->designation() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <div class="controls">  
                                                            <input type="hidden" name="action" value="update">
                                                            <input type="hidden" name="idCaisse" value="<?= $caisse->id() ?>">    
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateCaisse box end -->  
                                        <!-- delete box begin-->
                                        <div id="deleteCaisse<?= $caisse->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer la ligne</h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/CaisseActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer cette ligne ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="idCaisse" value="<?= $caisse->id() ?>" />
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
                                    </tbody>
                                </table>
                                </div><!-- END DIV SCROLLER -->
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
			App.setPage("table_managed");
			App.init();
			$('.criteriaPrint').on('change',function(){
                if( $(this).val()==="toutesCaisse"){
                $("#showDateRange").hide()
                }
                else{
                $("#showDateRange").show()
                }
            });
		});
	</script>
</body>
<!-- END BODY -->
</html>
<?php
}
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
	header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}
?>