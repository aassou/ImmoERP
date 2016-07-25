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
        //classes
        $projetManager = new ProjetManager($pdo);
        $clientManager = new ClientManager($pdo);
        $contratManager = new ContratManager($pdo);
        $operationManager = new OperationManager($pdo);
        $compteBancaireManager = new CompteBancaireManager($pdo);
        //objs
        $operations =$operationManager->getOpenOperationsGroupByMonth();
        $operationsNonValidees = $operationManager->getOperationsNonValidees();
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
                            Les états des paiements clients
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a href="status.php">Les états</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-money"></i>
                                <a href="operations-status-group.php">Les états des paiements clients</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="portlet box light-grey" id="detailsReglements">
                        <div class="portlet-title">
                            <h4>Liste des paiements validés</h4>
                            <div class="tools">
                                <a href="javascript:;" class="reload"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="clearfix">
                                <?php 
                                 if( isset($_SESSION['operation-action-message']) 
                                 and isset($_SESSION['operation-type-message']) ){
                                    $message = $_SESSION['operation-action-message'];
                                    $typeMessage = $_SESSION['operation-type-message'];
                                 ?>
                                    <div class="alert alert-<?= $typeMessage ?>">
                                        <button class="close" data-dismiss="alert"></button>
                                        <?= $message ?>     
                                    </div>
                                 <?php 
                                 } 
                                 unset($_SESSION['operation-action-message']);
                                 unset($_SESSION['operation-type-message']);
                                ?>
                                <!--div class="btn-group">
                                    <a class="btn blue pull-right" href="#addReglement" data-toggle="modal">
                                        Nouveau Réglement&nbsp;<i class="icon-plus-sign"></i>
                                    </a>
                                </div-->
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
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                    <tr>
                                        <th class="hidden" style="width: 0%">Actions</th>
                                        <th style="width: 20%">Client</th>
                                        <th style="width: 10%">Projet</th>
                                        <th style="width: 10%">Date.Opé</th>
                                        <th style="width: 10%">Date.Rég</th>
                                        <th style="width: 10%">ModePaiment</th>
                                        <th style="width: 10%">Compte</th>
                                        <th style="width: 10%">N°.Opé</th>
                                        <th style="width: 10%">Montant</th>
                                        <th style="width: 10%">Status</th>
                                        <!--th style="width: 10%">Quittance</th-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($operationsNonValidees as $operation){
                                        $status = "";
                                        $action = "";
                                        $idContrat = $operation->idContrat();
                                        $contrat = $contratManager->getContratById($idContrat);
                                        $nomProjet = $projetManager->getProjetById($contrat->idProjet())->nom();
                                        $nomClient = $contratManager->getClientNameByIdContract($operation->idContrat());
                                        if ( $operation->status() == 0 ) {
                                            $action = '<a class="btn grey mini"><i class="icon-off"></i></a>'; 
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $status = '<a class="btn red mini" href="#validateOperation'.$operation->id().'" data-toggle="modal" data-id="'.$operation->id().'"><i class="icon-pause"></i>&nbsp;Non validé</a>';  
                                            } 
                                            else{
                                                $status = '<a class="btn red mini"><i class="icon-pause"></i>&nbsp;Non validé</a>';
                                            } 
                                        } 
                                        else if ( $operation->status() == 1 ) {
                                            if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) {
                                                $status = '<a class="btn blue mini" href="#cancelOperation'.$operation->id().'" data-toggle="modal" data-id="'.$operation->id().'"><i class="icon-ok"></i>&nbsp;Validé</a>';
                                                $action = '<a class="btn green mini" href="#hideOperation'.$operation->id().'" data-toggle="modal" data-id="'.$operation->id().'"><i class="icon-off"></i></a>';   
                                            }
                                            else {
                                                $status = '<a class="btn blue mini"><i class="icon-ok"></i>&nbsp;Validé</a>';
                                                $action = '<a class="btn grey mini"><i class="icon-off"></i></a>'; 
                                            }
                                        }
                                    ?>      
                                    <tr class="odd gradeX">
                                        <td class="hidden"><?= $action ?></td>
                                        <td><?= $nomClient ?></td>
                                        <td><?= $nomProjet ?></td>
                                        <td><?= date('d/m/Y', strtotime($operation->date())) ?></td>
                                        <td><?= date('d/m/Y', strtotime($operation->dateReglement())) ?></td>
                                        <td><?= $operation->modePaiement() ?></td>
                                        <td><?= $operation->compteBancaire() ?></td>
                                        <td><?= $operation->numeroCheque() ?></td>
                                        <td><?= number_format($operation->montant(), 2, ',', ' ') ?>&nbsp;DH</td>
                                        <td><?= $status ?></td>
                                        <!--td><a class="btn mini blue" href="controller/QuittanceArabePrintController.php?idOperation=<?= $operation->id() ?>"><i class="m-icon-white icon-print"></i> Imprimer</a></td-->
                                    </tr>   
                                    <!-- validateOperation box begin-->
                                    <div id="validateOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Valider Paiement Client </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="validate" />
                                                    <input type="hidden" name="source" value="operations-status-group" />
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn blue" aria-hidden="true">Oui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- validateOperation box end -->
                                    <!-- cancelOperation box begin-->
                                    <div id="cancelOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Annuler Paiement Client </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="cancel" />
                                                    <input type="hidden" name="source" value="operations-status" />
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- cancelOperation box end -->
                                    <!-- hideOperation box begin-->
                                    <div id="hideOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Retirer Paiement Client </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="hide" />
                                                    <input type="hidden" name="source" value="operations-status" />
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn green" aria-hidden="true">Oui</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- hideOperation box end -->  
                                    <!-- delete box begin-->
                                    <div id="deleteOperation<?= $operation->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3>Supprimer Réglement Client </h3>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal loginFrm" action="controller/OperationActionController.php" method="post">
                                                <p>Êtes-vous sûr de vouloir supprimer ce réglement ?</p>
                                                <div class="control-group">
                                                    <input type="hidden" name="action" value="delete" />
                                                    <input type="hidden" name="idOperation" value="<?= $operation->id() ?>" />
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
                        </div>
                     </div>
                       <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Archive des paiements clients validés</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
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
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width:100%">Mois/Année</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($operations as $operation){
                                        ?>      
                                        <tr class="odd gradeX">
                                            <?php
                                            $mois = date('m', strtotime($operation->dateReglement()));
                                            $annee = date('Y', strtotime($operation->dateReglement()));
                                            ?>
                                            <td>
                                                <a class="btn mini" href="operations-status.php?mois=<?= $mois ?>&annee=<?= $annee ?>">
                                                    <strong><?= date('m/Y', strtotime($operation->dateReglement())) ?></strong>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                                </div>
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