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
    if( isset($_SESSION['userMerlaTrav']) 
    and ( $_SESSION['userMerlaTrav']->profil()=="admin" OR $_SESSION['userMerlaTrav']->profil()=="consultant" ) ){
        //les sources
        $idProjet = 0;
        $projetManager = new ProjetManager($pdo);
        $contratEmployeManager = new ContratEmployeManager($pdo);
        $contratDetaislManager = new ContratDetailsManager($pdo);
        $employesManager = new EmployeManager($pdo);
        if(isset($_GET['idContratEmploye']) and ($_GET['idContratEmploye'])>0 and $_GET['idContratEmploye']<=$contratEmployeManager->getLastId()){
            $idProjet = $_GET['idProjet'];
            $idContratEmploye = $_GET['idContratEmploye'];
            $projet = $projetManager->getProjetById($idProjet);
            $contratEmploye = $contratEmployeManager->getContratEmployeById($idContratEmploye);
            $employe = $employesManager->getEmployeById($contratEmploye->employe());
            $contratDetails = $contratDetaislManager->getContratDetailsByIdContratEmploye($idContratEmploye);
            $totalPaye = $contratDetaislManager->getContratDetailsTotalByIdContratEmploye($idContratEmploye);
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
                            Détails Contrat - Employé : <strong><?= strtoupper($employe->nom()) ?></strong> - Projet : <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong>
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
                                <a href="projet-details.php?idProjet=<?= $idProjet ?>">Projet <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="projet-contrat-employe.php?idProjet=<?= $idProjet ?>">Gestion des Contrats Employés</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Détails Contrats Employés <strong><?= strtoupper($employe->nom()) ?></strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- addContratEmploye box begin-->
                        <div id="addPaiement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Nouveau Paiement</h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/ContratDetailsActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Date Opération</label>
                                        <div class="controls">
                                            <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Montant</label>
                                        <div class="controls">
                                            <input type="text" name="montant" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Numéro Opération</label>
                                        <div class="controls">
                                            <input type="text" name="numeroCheque" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="action" value="add" />
                                            <input type="hidden" name="idContratEmploye" value="<?= $contratEmploye->id() ?>" />
                                            <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addPaiement box end -->
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <?php if(isset($_SESSION['contratEmploye-action-message'])){ ?>
                            <div class="alert alert-<?= $_SESSION['contratEmploye-type-message'] ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['contratEmploye-action-message'] ?>       
                            </div>
                         <?php } 
                            unset($_SESSION['contratEmploye-action-message']);
                         ?>
                        <div class="portlet box purple">
                            <div class="portlet-title">
                                <h4>Détails Contrat </h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <?php
                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                    ?>
                                    <div class="btn-group pull-left">
                                        <a href="#addPaiement" data-toggle="modal" class="btn icn-only green">
                                            Nouveau Paiement 
                                            <i class="icon-plus-sign"></i>
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="btn-group pull-right">
                                        <a href="controller/ContratDetailsPrintController.php?idContratEmploye=<?= $contratEmploye->id() ?>&idProjet=<?= $projet->id() ?>" class="btn icn-only blue">
                                            <i class="icon-print"></i> 
                                            Détails Contrat
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
                                <div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:15%">Date Opération</th>
                                            <th style="width:15%">Numéro Chèque</th>
                                            <th style="width:15%">Prix/Unité</th>
                                            <th style="width:15%">Nombre Unités</th>
                                            <th style="width:15%">Montant</th>
                                            <th style="width:15%"></th>
                                            <th style="width:10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($contratDetails as $contrat){
                                            $prixUnitaire = 
                                            $contratEmployeManager->getContratEmployeById($contrat->idContratEmploye())->prixUnitaire();
                                            $nombreUnites = 
                                            $contratEmployeManager->getContratEmployeById($contrat->idContratEmploye())->nombreUnites();
                                        ?>      
                                        <tr class="clients">
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
                                                        <?= date('d/m/Y', strtotime($contrat->dateOperation()) ) ?>
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a target="_blank" href="controller/QuittanceEmployePrintController.php?idContratDetail=<?= $contrat->id() ?>&idProjet=<?= $idProjet ?>">
                                                                Imprimer Quittance
                                                            </a>
                                                            <?php
                                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                            ?>
                                                            <a href="#updateContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                                Modifier
                                                            </a>
                                                            <a href="#deleteContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                                Supprimer
                                                            </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><?= $contrat->numeroCheque() ?></td>
                                            <td><?= number_format($prixUnitaire, 2, ',', ' ') ?></td>
                                            <td><?= $nombreUnites ?></td>
                                            <td><?= number_format($contrat->montant(), 2, ',', ' ') ?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <!-- updatePaiement box begin -->
                                        <div id="updateContrat<?= $contrat->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier Détails Contrat de  <?= $contratEmploye->employe() ?></h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratDetailsActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Date Opération</label>
                                                        <div class="controls">
                                                            <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                                <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $contrat->dateOperation() ?>" />
                                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                                            </div>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Montant</label>
                                                        <div class="controls">
                                                            <input type="text" name="montant" value="<?= $contrat->montant() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Numéro Chèque</label>
                                                        <div class="controls">
                                                            <input type="text" name="numeroCheque" value="<?= $contrat->numeroCheque() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="action" value="update" />
                                                        <input type="hidden" name="idContratDetails" value="<?= $contrat->id() ?>" />
                                                        <input type="hidden" name="idContratEmploye" value="<?= $contratEmploye->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updatePaiementContrat box end -->      
                                        <!-- delete box begin-->
                                        <div id="deleteContrat<?= $contrat->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer Paiement <?= $contratEmploye->employe() ?></h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratDetailsActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer contrat <strong><?= $contratEmploye->employe() ?></strong> ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="idContratDetails" value="<?= $contrat->id() ?>" />
                                                        <input type="hidden" name="idContratEmploye" value="<?= $contratEmploye->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
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
                                <table class="table">
                                    <thead style="background-color: #DDD">
                                        <tr>
                                            <th style="width:15%"></th>
                                            <th style="width:15%"></th>
                                            <th style="width:15%"></th>
                                            <th style="width:15%"></th>
                                            <th style="width:15%">Total Payé</th>
                                            <th style="width:15%">Total à Payer</th>
                                            <th style="width:10%">Reste</th>
                                        </tr>
                                    </thead>
                                    <tbody>     
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><?= number_format($totalPaye, 2, ',', ' ') ?></td>
                                            <td><?= number_format($contratEmploye->total(), 2, ',', ' ') ?></td>
                                            <td><?= number_format($contratEmploye->total()-$totalPaye, 2, ',', ' ') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div><!-- END SCROLL DIV -->
                            </div>
                        </div>
                        <!-- END Terrain TABLE PORTLET-->
                    </div>
                </div>
                <?php 
                }
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
    <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
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
    <script src="script.js"></script>       
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        $('.clients').show();
        $('#nomClient').keyup(function(){
            $('.clients').hide();
           var txt = $('#nomClient').val();
           $('.clients').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
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