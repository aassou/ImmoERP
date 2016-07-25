<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');  
    //classes loading end
    session_start();
    if( isset($_SESSION['userMerlaTrav'])){
        //classes managers  
        $chargeManager = new ChargeCommunManager($pdo);
        $typeChargeManager = new TypeChargeCommunManager($pdo);
        $criteria = htmlentities($_POST['criteria']);
        $resumeDetail = ""; 
        if( $criteria=="parDate" ) {
            $dateFrom = htmlentities($_POST['dateFrom']);
            $dateTo = htmlentities($_POST['dateTo']); 
            $type = htmlentities($_POST['type']);
            if( $type == "Toutes" ) {
                $charges = $chargeManager->getChargesByDates($dateFrom, $dateTo);
                $totalCharges = number_format($chargeManager->getTotalByDates($dateFrom, $dateTo), 2, ',', ' ');
                $titreDocument = "Liste des charges communs entre : ".date('d/m/Y', strtotime($dateFrom)).' - '.date('d/m/Y', strtotime($dateTo));   
            }
            else {
                $charges = $chargeManager->getChargesByDatesByType($dateFrom, $dateTo, $type);
                $totalCharges = number_format($chargeManager->getTotalByDatesByType($dateFrom, $dateTo, $type), 2, ',', ' ');
                $titreDocument = "Liste des charges communs ".$typeChargeManager->getTypeChargeById($type)->nom()." entre : ".date('d/m/Y', strtotime($dateFrom)).' - '.date('d/m/Y', strtotime($dateTo));
            }
        }
        else if ( $criteria=="toutesCharges" ) {
            $charges = $chargeManager->getCharges();
            $totalCharges = number_format($chargeManager->getTotal(), 2, ',', ' ');
            $titreDocument = "Liste de toutes les charges communs";   
            if ( isset($_POST['type']) and (isset($_POST['source']) and $_POST['source'] == "charges-communs-type") ) {
                $type = htmlentities($_POST['type']);
                $charges = $chargeManager->getChargesByType($type);
                $totalCharges = number_format($chargeManager->getTotalByType($type), 2, ',', ' ');
                $titreDocument = "Liste des charges communs de ".$typeChargeManager->getTypeChargeById($type)->nom();
            }
            if ( isset($_POST['source']) and $_POST['source'] == "charges-communs-grouped" ) {
                $resumeDetail = htmlentities($_POST['resume-detaile']);
                if ( $resumeDetail == "resume" ) {
                    $charges = $chargeManager->getChargesByGroup();    
                }
            }
        } 

ob_start();
?>
<style type="text/css">
    p, h1, h2, h4{
        text-align: center;
        font-family : Arial;
        font-weight: 100;
        margin-bottom: 0px;
    }
    h2{
        font-size: 20px;
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
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1><?= $titreDocument ?> </h1>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br>
    <table>
        <tr>
            <th style="width:25%">Type</th>
            <th style="width:15%">Date</th>
            <th style="width:25%">Désignation</th>
            <th style="width:20%">Société</th>
            <th style="width:15%">Montant</th>
        </tr>
        <?php
        foreach($charges as $charge){
        ?>      
        <tr>
            <td style="width:25%"><?= $typeChargeManager->getTypeChargeById($charge->type())->nom() ?></td>
            <td style="width:15%"><?= date('d/m/Y', strtotime($charge->dateOperation())) ?></td>
            <td style="width:25%"><?= $charge->designation() ?></td>
            <td style="width:20%"><?= $charge->societe() ?></td>
            <td style="width:15%"><?= number_format($charge->montant(), 2, ',', ' ') ?>&nbsp;DH</td>
        </tr>   
        <?php
        }//end of loop
        ?>
        <tr>
            <td style="width:25%"></td>
            <td style="width:15%"></td>
            <td style="width:25%"></td>
            <td style="width:20%"></td>
            <th style="width:15%">Total</th>
        </tr>
        <tr>
            <td style="width:25%"></td>
            <td style="width:15%"></td>
            <td style="width:25%"></td>
            <td style="width:20%"></td>
            <td style="width:15%"><strong><?= $totalCharges ?>&nbsp;DH</strong></td>
        </tr>
    </table>
    
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE Annahda SARL : Au capital de 200 000,00 DH – siège social XXXXXXXXXX, Nador. 
        <br>Tél XXXXX / XXXXX IF : XXXXX   RC : XXXXX  Patente XXXXX</p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "ListeChargesCommuns-".date('Ymdhi').'.pdf';
        $pdf->Output($fileName);
    }
    catch(HTML2PDF_exception $e){
        die($e->getMessage());
    }
}
else{
    header("Location:index.php");
}
?>
