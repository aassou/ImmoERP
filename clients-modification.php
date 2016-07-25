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
    if(isset($_SESSION['userMerlaTrav'])){
        //les sources
        $projetManager = new ProjetManager($pdo);
        $clientManager = new ClientManager($pdo);
        $companyManager = new CompanyManager($pdo);
        $contratManager = new ContratManager($pdo);
        $compteBancaireManager = new CompteBancaireManager($pdo);
        $operationManager = new OperationManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $comptesBancaires = $compteBancaireManager->getCompteBancaires();
        //obj and vars
        $contrats = $contratManager->getContratsToChange();
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
                            Gestion des modifications clients
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a href="status.php">Les états</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-user"></i>
                                <a>Modifications des clients</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <?php 
                        if( isset($_SESSION['contrat-action-message']) 
                        and isset($_SESSION['contrat-type-message'])) {
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
                        <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4>Liste des contrats clients à modifier</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group">
                                        <!--a class="btn blue pull-right" href="controller/ClientsSituationsPrintController.php?idProjet=<?php //$projet->id() ?>">
                                            <i class="icon-print"></i>
                                             Version Imprimable
                                        </a-->
                                    </div>
                                </div>
                                <!--div class="scroller" data-height="500px" data-always-visible="1"--><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">Actions</th>
                                            <th style="width:15%">Client</th>
                                            <th style="width:10%">Projet</th>
                                            <th style="width:20%" class="hidden-phone">Bien</th>
                                            <th style="width:10%">Date Contrat</th>
                                            <th style="width:25%" class="hidden-phone">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($contrats as $contrat){
                                            $revendreTitle = "";
                                            $montantRevente = 0;
                                            $operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
                                            $sommeOperations = $operationManager->sommeOperations($contrat->id());
                                            $bien = "";
                                            $typeBien = "";
                                            $etage = "";
                                            $projet = $projetManager->getProjetById($contrat->idProjet());
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
                                                <a class="btn mini green" target="_blank" title="Consulter Contrat" href="contrat.php?codeContrat=<?= $contrat->code() ?>">
                                                    <i class="icon-file"></i>    
                                                </a>
                                                <a class="btn mini blue" title="Imprimer Contrat" href="controller/ContratArabePrintController.php?idContrat=<?= $contrat->id() ?>">
                                                    <i class="icon-print"></i>
                                                </a>
                                                <a class="fancybox-button btn mini" data-rel="fancybox-button" title="Image Note" href="<?= $contrat->imageNote() ?>">
                                                    <i class="icon-zoom-in"></i>    
                                                </a>
                                                <a title="Modifier Image Note" class="btn mini black" href="#updateImageNote<?= $contrat->id();?>" data-toggle="modal" data-id="<?= $contrat->id(); ?>">
                                                    <i class=" icon-refresh"></i>   
                                                </a>
                                            </td>
                                            <td><?= $clientManager->getClientById($contrat->idClient())->nom() ?></td>
                                            <td class="hidden-phone"><?= $projet->nom() ?></td>
                                            <td class="hidden-phone"><?= $typeBien ?> - <?= $bien->nom() ?> - <?= $etage ?></td>
                                            <td class="hidden-phone"><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?></td>
                                            <td class="hidden-phone"><?= $contrat->note() ?></td>
                                        </tr>
                                        <!-- updateImageNote box begin-->
                                        <div id="updateImageNote<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier l'image de note client </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratActionController.php" method="post" enctype="multipart/form-data">
                                                    <p>Êtes-vous sûr de vouloir modifier l'image de cette note ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <div class="control-group">
                                                            <label class="control-label">Image Note</label>
                                                            <div class="controls">
                                                                <input type="file" name="note-client-image" />
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="action" value="updateImageNote" />
                                                        <input type="hidden" name="source" value="clients-modification" />
                                                        <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateImageNote box end -->
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                                </div><!-- END DIV SCROLLER -->
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
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="script.js"></script>       
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        $('.currency').on('change',function(){
            if( $(this).val()!=="DH"){
                $('.tauxDeChange').show()
            }
            else{
                $('.tauxDeChange').hide()
            }
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