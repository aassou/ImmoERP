<?php
    require('../db/PDOFactory.php'); 
    require('../db/PDOFactory.php');;  
    //classes loading end
    session_start();
    if( isset($_SESSION['userImmoERPV2']) ){
        //classes managers  
        $projetManager = new ProjetManager(PDOFactory::getMysqlConnection());
        $caisseManager = new CaisseManager(PDOFactory::getMysqlConnection());
        $companyManager = new CompanyManager(PDOFactory::getMysqlConnection());
        //objs and vars
        $companyID = htmlentities($_POST['companyID']);
        $projets = $projetManager->getProjets();
        $company = $companyManager->getCompanyById($companyID);
        $titre = $company->nom();
        $caisses = "";
        $titreDocument = "";
        $totalCaisse = 0;
        $criteria = htmlentities($_POST['criteria']);
        if( $criteria=="parDate" ) {
            $dateFrom = htmlentities($_POST['dateFrom']);
            $dateTo = htmlentities($_POST['dateTo']); 
            $type = htmlentities($_POST['type']);
            if( $type == "Toutes" ) {
                $caisses = $caisseManager->getCaissesByDates($dateFrom, $dateTo, $companyID);
                $titreDocument = "Liste des opérations entre : ".date('d/m/Y', strtotime($dateFrom)).' - '.date('d/m/Y', strtotime($dateTo));
                $totalCaisse = 
                $caisseManager->getTotalCaisseByTypeByDate('Entree', $dateFrom, $dateTo, $companyID) - $caisseManager->getTotalCaisseByTypeByDate('Sortie', $dateFrom, $dateTo, $companyID);   
            }
            else {
                $caisses = $caisseManager->getCaissesByDatesByType($dateFrom, $dateTo, $type, $companyID);
                $titreDocument = "Liste des opérations d'".$type." entre : ".date('d/m/Y', strtotime($dateFrom)).' - '.date('d/m/Y', strtotime($dateTo));
                $totalCaisse = 
                $caisseManager->getTotalCaisseByType($type, $dateFrom, $dateTo, $companyID);
            }
        }
        else if ( $criteria=="toutesCaisse" ) {
            $caisses = $caisseManager->getCaisses($companyID);
            $titreDocument = "Bilan de toutes les opérations de caisse";
            $totalCaisse = $caisseManager->getTotalCaisseByType('Entree', $companyID) - $caisseManager->getTotalCaisseByType('Sortie', $companyID);   
            /*if ( isset($_POST['type']) ) {
                $type = htmlentities($_POST['type']);
                $caisses = $caisseManager->getCaissesByType($type);
                $titreDocument = "Liste des opérations de type : ".$type;
            }*/
        }

ob_start();
?>
<style type="text/css">
    h1, h2{
        font-size: 16px;
    }
    p, h1, h2{
        text-align: center;
        text-decoration: underline;
    }
    table {
        border-collapse: collapse;
        width:100%;
    }
    
    table, th, td {
        border: 1px solid black;
    }
    td, th{
        padding : 5px;
    }
    
    th{
        background-color: grey;
    }
</style>
<page backtop="5mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1><?= $titre ?></h1>
    <h2><?= $titreDocument ?></h2>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <br>
    <table>
        <tr>
            <!--th style="width: 20%">Type</th-->
            <th style="width: 15%">DateOpé</th>
            <th style="width: 15%">Crédit</th>
            <th style="width: 15%">Débit</th>
            <th style="width: 35%">Désignation</th>
            <th style="width: 20%">Destination</th>
        </tr>
        <?php
        foreach($caisses as $caisse){
        ?>      
        <tr>
            <td style="width: 15%"><?= date('d/m/Y', strtotime($caisse->dateOperation())) ?></td>
            <?php
            if ( $caisse->type() == "Entree" ) {
            ?>
            <td style="width: 15%"><?= number_format($caisse->montant(), 2, ',', ' ') ?></td>
            <td style="width: 15%"></td>
            <?php  
            }
            else {
            ?>
            <td style="width: 15%"></td>
            <td style="width: 15%"><?= number_format($caisse->montant(), 2, ',', ' ') ?></td>
            <?php
            }
            ?>
            <td style="width: 35%"><?= $caisse->designation() ?></td>
            <td style="width: 20%"><?= $caisse->destination() ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
    </table>
    <table>
        <tr>
            <th style="width: 15%">Solde</th>
            <td style="width: 30%; padding-left: 80px;"><strong><?= number_format($totalCaisse, 2, ',', ' ') ?>&nbsp;DH</strong></td>
            <td style="width: 35%"></td>
            <td style="width: 20%"></td>
        </tr>
    </table>
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">Société <?= $company->nom() ?> - <?= $company->adresse() ?>  
        <br>Tél : </p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "BilanCaisse-".date('Ymdhi').'.pdf';
        $pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:../index.php");
}
?>