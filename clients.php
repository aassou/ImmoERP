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
        $clientsManager = new ClientManager($pdo);
        $clientNumber = $clientsManager->getClientsNumber();
        if($clientNumber!=0){
            $clients = $clientsManager->getClients();     
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
                            Gestion des clients
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-user"></i>
                                <a>Gestion des clients</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                         <?php 
                         if ( isset($_SESSION['client-action-message'])
                         and isset($_SESSION['client-type-message']) ) {
                             $message = $_SESSION['client-action-message'];
                             $typeMessage = $_SESSION['client-type-message']; 
                         ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $message ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['client-action-message']);
                            unset($_SESSION['client-type-message']);
                         ?>
                         <div class="portlet box light-grey">
                            <div class="portlet-title">
                                <h4><i class="icon-globe"></i>Managed Table</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group">
                                        <button id="sample_editable_1_new" class="btn green">
                                        Add New <i class="icon-plus"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group pull-right">
                                        <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Print</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Export to Excel</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--div class="scroller" data-height="500px" data-always-visible="1"--><!-- BEGIN DIV SCROLLER -->
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                                            <th>Nom</th>
                                            <th class="hidden-480">CIN</th>
                                            <th class="hidden-480">Adresse</th>
                                            <th class="hidden-480">Tel1</th>
                                            <th class="hidden-480">Email</th>
                                            <th class="hidden-480">Date création</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($clients as $client){
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                            <td><?= $client->nom() ?></td>
                                            <td class="hidden-480"><?= $client->cin() ?></td>
                                            <td class="hidden-480"><?= $client->adresse() ?></td>
                                            <td class="hidden-480"><?= $client->telephone1() ?></td>
                                            <td class="hidden-480"><a href="mailto:<?= $client->email() ?>"><?= $client->email() ?></a></td>
                                            <td class="center hidden-480"><?= date('d/m/Y', strtotime($client->created())) ?></td>
                                            <td ><span class="label label-success">Approved</span></td>
                                        </tr>
                                                <!-- updateClient box begin-->
                                                <div id="update<?= $client->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h3>Modifier les informations du client </h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" action="controller/ClientActionController.php" method="post">
                                                            <p>Êtes-vous sûr de vouloir modifier les infos du client <strong><?= $client->nom() ?></strong> ?</p>
                                                            <div class="control-group">
                                                                <label class="control-label">Nom</label>
                                                                <div class="controls">
                                                                    <input type="text" name="nom" value="<?= $client->nom() ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">CIN</label>
                                                                <div class="controls">
                                                                    <input type="text" name="cin" value="<?= $client->cin() ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">الاسم</label>
                                                                <div class="controls">
                                                                    <input type="text" name="nomArabe" value="<?= $client->nomArabe() ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">العنوان</label>
                                                                <div class="controls">
                                                                    <input type="text" name="adresseArabe" value="<?= $client->adresseArabe() ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Adresse</label>
                                                                <div class="controls">
                                                                    <input type="text" name="adresse" value="<?= $client->adresse() ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Tél.1</label>
                                                                <div class="controls">
                                                                    <input type="text" name="telephone1" value="<?= $client->telephone1() ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Tél.2</label>
                                                                <div class="controls">
                                                                    <input type="text" name="telephone2" value="<?= $client->telephone2() ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Email</label>
                                                                <div class="controls">
                                                                    <input type="text" name="email" value="<?= $client->email() ?>" />
                                                                </div>  
                                                            </div>
                                                            <div class="control-group">
                                                                <input type="hidden" name="idClient" value="<?= $client->id() ?>" />
                                                                <input type="hidden" name="action" value="update" />
                                                                <input type="hidden" name="source" value="clients" />
                                                                <div class="controls">  
                                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- updateFournisseur box end -->
                                                <!-- delete box begin-->
                                                <div id="delete<?= $client->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h3>Supprimer Client</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal loginFrm" action="controller/ClientActionController.php" method="post">
                                                            <p>Êtes-vous sûr de vouloir supprimer ce client <?= $client->nom() ?> ?</p>
                                                            <div class="control-group">
                                                                <label class="right-label"></label>
                                                                <input type="hidden" name="idClient" value="<?= $client->id() ?>" />
                                                                <input type="hidden" name="action" value="delete" />
                                                                <input type="hidden" name="source" value="clients" />
                                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- delete box end -->       
                                            <?php 
                                                }
                                            //}
                                            ?>
                                        </tbody>
                                    </table>
                                <!--/div--><!-- END DIV SCROLLER -->
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
            App.setPage("table_managed");
            App.init();
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