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
        $historyManager = new HistoryManager($pdo);
        $dateBegin = htmlentities($_POST['dateBegin']);
        $dateEnd = htmlentities($_POST['dateEnd']);
        $histories = $historyManager->getHistorysByDate($dateBegin, $dateEnd);

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
            font-size: 12px;
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
    <h1>Historique des actions</h1>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <br>
    <table>
        <tr>
            <th style="width:20%">Cible</th>
            <th style="width:13%">Action</th>
            <th style="width:12%">Date</th>
            <th style="width:15%">Par</th>
            <th style="width:40%">Description</th>
        </tr>
        <?php
        foreach($histories as $history){
        ?>      
        <tr>
            <td style="width:20%"><?= $history->target() ?></td>
            <td style="width:13%"><?= $history->action() ?></td>
            <td style="width:12%"><?= date('d/m/Y', strtotime($history->created())) ?></td>
            <td style="width:15%"><?= $history->createdBy() ?></td>
            <td style="width:40%"><?= $history->description() ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
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
        $fileName = "Historique-".date('Ymdhi').'.pdf';
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
