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
    if(isset($_SESSION['userMerlaTrav']) ){
        //classes managers
        $appartementManager = new AppartementManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $usersManager = new UserManager($pdo);
        $projetManager = new ProjetManager($pdo);
        $contratManager = new ContratManager($pdo);
        $clientManager = new ClientManager($pdo);
        $chargeManager = new ChargeManager($pdo);
        $chargeCommunManager = new ChargeCommunManager($pdo);
        $livraisonsManager = new LivraisonManager($pdo);
        $livraisonDetailManager = new LivraisonDetailManager($pdo);
        $fournisseursManager = new FournisseurManager($pdo);
        $reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
        $caisseEntreesManager = new CaisseEntreesManager($pdo);
        $caisseSortiesManager = new CaisseSortiesManager($pdo);
        $operationsManager = new OperationManager($pdo);
        //classes and vars
        //$idProjet = $_GET['idProjet'];
        //$projet = $projetManager->getProjetById($idProjet);
        //Container 1 : Statistiques
        $chiffreAffaireTheorique = 
        ceil($appartementManager->getTotalPrixAppartements() + $locauxManager->getTotalPrixLocaux());
        
        //get contacts ids and get sum of client operations
        $idsContrats = $contratManager->getContratActifIds();
        $sommeOperationsClients = 0;
        $sommePrixVente = 0;
        foreach($idsContrats as $id){
            $sommeOperationsClients += $operationsManager->sommeOperations($id);
            $sommePrixVente += $contratManager->getContratById($id)->prixVente();
        }
        $sommeApportsClients = ($sommeOperationsClients);
        $reliquat = $sommePrixVente - $sommeOperationsClients; 
        $sommeCharges = 
        $chargeCommunManager->getTotal() + $chargeManager->getTotal();
        $sommeCharges = ceil($sommeCharges);
        
        //Container 2 : Statistiques
        $sommeLivraisons = 0;
        $idsLivraisons = $livraisonsManager->getLivraisonIds();
        foreach ( $idsLivraisons as $id ) {
            $sommeLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($id);
        }
        $sommeReglements = ceil($reglementsFournisseurManager->sommeReglementFournisseur());
        $sommeLivraison = ceil($livraisonsManager->getTotalLivraisons());
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
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <h3 class="page-title">
                            Statistiques globales de la société Annahda
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a>Statistiques Globales - <strong>Société Annahda</strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!--      BEGIN TILES      -->
                <div class="row-fluid">
                    <div class="span12">
                        <h4><i class="icon-bar-chart"></i> Statistiques des projets de la société Annahda</h4>
                        <hr class="line">
                        <div id="container1" style="width:100%; height:400px;"></div>
                    </div>
                    <div class="span12">
                        <hr class="line">
                        <div id="container2" style="width:100%; height:400px;"></div>
                    </div>
                </div>
                <!--      BEGIN TILES      -->
                <!-- BEGIN DASHBOARD STATS -->
                <!--h4><i class="icon-table"></i> Statistiques de la caisse</h4>
                <hr class="line">
                <div class="row-fluid">
                    <div id="container3" style="width:100%; height:400px;"></div>
                </div-->
                <!--h4><i class="icon-table"></i> Statistiques de la société</h4>
                <hr class="line">
                <div class="row-fluid">
                    <div id="container3" style="width:100%; height:400px;"></div>
                </div-->
                <!-- END DASHBOARD STATS -->
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
    <!------------------------- BEGIN HIGHCHARTS  --------------------------->
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <!--script src="http://code.highcharts.com/themes/dark-unica.js"></script-->
    <script src="http://code.highcharts.com/modules/data.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script> 
        $(function() {
            Highcharts.setOptions({
                credits: {
                      enabled: false
                },
                lang: {
                    downloadPDF: 'PDF',
                    printChart: 'Imprimer Statistiques',
                    downloadPNG: null,
                    downloadJPEG: null,
                    downloadSVG: null,
                }   
            });
            $('#container1').highcharts({
                chart: {
                    type: 'column'
                },
                exporting: {
                    filename:'StatistiquesProjet-CA-Charges'
                },   
                title: {
                    text: 'Chiffre d\'affaires et charges'
                },
                xAxis: {
                    categories: ['Entrées-Sorties']
                },
                yAxis: {
                    title: {
                        text: 'Montants en Millions de DH'
                    }
                },
                series: [
                {
                    name: 'Valeur des biens avant vente',
                    data: [<?= json_encode($chiffreAffaireTheorique) ?>]
                },
                {
                    name: 'Valeur des biens vendus',
                    data: [<?= json_encode($sommePrixVente) ?>]
                },
                {
                    name: 'Les charges',
                    data: [<?= json_encode($sommeCharges) ?>]
                },
                {
                    name: 'Bénéfice',
                    data: [<?= json_encode($sommePrixVente - $sommeCharges) ?>]
                },
                {
                    name: 'Réglements Clients',
                    data: [<?= json_encode($sommeApportsClients) ?>]
                }, 
                {
                    name: 'Reliquat Réglements',
                    data: [<?= json_encode($reliquat) ?>]
                }
                ]
            });
        });
    </script>
    <script> 
        $(function() {
            Highcharts.setOptions({
                credits: {
                      enabled: false
                },
                lang: {
                    downloadPDF: 'PDF',
                    printChart: 'Imprimer Statistiques',
                    downloadPNG: null,
                    downloadJPEG: null,
                    downloadSVG: null,
                }
            });
            $('#container2').highcharts({
                chart: {
                    type: 'column'
                },
                exporting: {
                    filename:'StatistiquesLivraisonsReglementsFournisseurs'
                },   
                title: {
                    text: 'Livraisons et réglements des fournisseurs'
                },
                xAxis: {
                    categories: ['Entrées-Sorties']
                },
                yAxis: {
                    title: {
                        text: 'Montants en Millions de DH'
                    }
                },
                series: [
                {
                    name: 'Réglements Fournisseurs',
                    data: [<?= json_encode($sommeReglements) ?>]
                },
                {
                    name: 'Livraison Fournisseurs',
                    data: [<?= json_encode($sommeLivraisons) ?>]
                },
                {
                    name: 'Reliquat',
                    data: [<?= json_encode($sommeLivraisons - $sommeReglements) ?>]
                }
                ]
            });
        });
    </script>
    <!--script>
        $(function() {
            Highcharts.setOptions({
                lang: {
                    downloadPDF: 'PDF',
                    printChart: 'Imprimer Statistiques',
                    downloadPNG: null,
                    downloadJPEG: null,
                    downloadSVG: null
                }   
            });
            $('#container3').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Entrées/Sorties de la caisse'
                },
                xAxis: {
                    categories: ['Projet1', 'Projet2', 'Projet3']
                },
                yAxis: {
                    title: {
                        text: 'Statistiques'
                    }
                },
                series: [{
                    name: 'Apports Clients',
                    data: [40, 100, 50]
                }, {
                    name: 'Réglements Fournisseurs',
                    data: [20, 70, 10]
                }, {
                    name: 'Fonds Projets',
                    data: [80, 90, 60]
                }]
            });
        });
    </script-->
    <!--script>
        $(function() {
            Highcharts.setOptions({
                lang: {
                    downloadPDF: 'PDF',
                    printChart: 'Imprimer Statistiques',
                    downloadPNG: null,
                    downloadJPEG: null,
                    downloadSVG: null
                }   
            });
            $('#container3').highcharts({
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'Activité de la société'
                },
                xAxis: {
                    categories: ['Projet1', 'Projet2', 'Projet3']
                },
                yAxis: {
                    title: {
                        text: 'Statistiques'
                    }
                },
                series: [{
                    name: 'Apports Clients',
                    data: [40, 100, 50]
                }, {
                    name: 'Réglements Fournisseurs',
                    data: [20, 70, 10]
                }, {
                    name: 'Fonds Projets',
                    data: [80, 90, 60]
                }]
            });
        });
    </script-->
    <!------------------------- END HIGHCHARTS  --------------------------->
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