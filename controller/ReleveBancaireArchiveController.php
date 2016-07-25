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
    if( isset($_SESSION['userMerlaTrav']) ){
        $relevesbancaires = $_SESSION['releve-bancaire-archive-print'];
        //classes managers  

ob_start();
?>
<style type="text/css">
    p, h1{
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
<page backtop="15mm" backbottom="20mm" backleft="10mm" backright="10mm">
    <!--img src="../assets/img/logo_company.png" style="width: 110px" /-->
    <h1>Archive des relevés bancaires</h1>
    <p>Imprimé le <?= date('d-m-Y') ?> | <?= date('h:i') ?> </p>
    <br>
    <table>
        <tr>
            <th style="width:15%;">DateOpe</th>
            <th style="width:15%;">DateVal</th>
            <th style="width:20%;">Libelle</th>
            <th style="width:10%;">Réf</th>
            <th style="width:15%;">Débit</th>
            <th style="width:15%;">Crédit</th>
            <th style="width:10%;">Projet</th>
        </tr>
        <?php
        foreach($relevesbancaires as $releve){
        ?>      
        <tr>
            <td style="width:15%;"><?= $releve->dateOpe() ?></td>
            <td style="width:15%;"><?= $releve->dateVal() ?></td>
            <td style="width:20%;"><?= $releve->libelle() ?></td>
            <td style="width:10%;"><?= $releve->reference() ?></td>
            <td style="width:15%;"><?= number_format($releve->debit(), 2, ',', ' ' ) ?></td>
            <td style="width:15%;"><?= number_format($releve->credit(), 2, ',', ' ') ?></td>
            <td style="width:10%;"><?= $releve->projet() ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
    </table>
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;">STE GROUPE ANNAHDA LIL IAAMAR SARL – Quartier Ouled Brahim N°B-1 en face Lycée Nador Jadid (Anaanaa), Nador. 
        <br>Tél : 05 36 33 10 31 - Fax : 05 36 33 10 32 </p>
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
    header("Location:index.php");
}
?>