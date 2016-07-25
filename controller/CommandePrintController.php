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
        $projetManager = new ProjetManager($pdo);
        $fournisseurManager = new FournisseurManager($pdo);
        $commandeManager = "";
        $commandeDetailManager = "";
        //get societe value
        $societe = $_GET['societe'];
        if ( $societe == 2 ) {
            $commandeManager = new CommandeManager($pdo);
            $commandeDetailManager = new CommandeDetailManager($pdo);    
        }
        else if ( $societe == 1 ) {
            $commandeManager = new CommandeAnnahdaManager($pdo);
            $commandeDetailManager = new CommandeDetailAnnahdaManager($pdo);
        }
        //classes and vars
        $livraisonDetailNumber = 0;
        $totalReglement = 0;
        $totalLivraison = 0;
        $titreLivraison ="Commande N°";
        $commande = "Vide";
        $fournisseur = "Vide";
        $projet = "Vide";
        if( isset($_GET['idCommande']) ){
            $commande = $commandeManager->getCommandeById($_GET['idCommande']);
            $nomProjet = "Non mentionnée";
            if ( $commande->idProjet() != 0 ) {
                $nomProjet = $projetManager->getProjetById($commande->idProjet());   
            }
            $fournisseur = $fournisseurManager->getFournisseurById($commande->idFournisseur());
            $commandeDetail = $commandeDetailManager->getCommandesDetailByIdCommande($commande->id());
            $nombreArticle = 
            $commandeDetailManager->getNombreArticleCommandeByIdCommande($commande->id());
        }
ob_start();
?>
<style type="text/css">
    p, h1, h2, h3, h4{
        text-align: center;
        text-decoration: underline;
    }
    .detailLivraison{
        text-decoration: none;
        text-align: center;
        font-size: 16px;
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
    <h4><?= $titreLivraison.$commande->numeroCommande()." - Fournisseur : ".$fournisseur->nom() ?></h4>
    <h4>Date Commande : <?= date('d/m/Y', strtotime($commande->dateCommande())) ?> | Nombre d'articles : <?= $nombreArticle ?></h4>
    <table>
        <tr>
            <th style="width: 40%">Référence</th>
            <th style="width: 40%">Libelle</th>
            <th style="width: 20%">Quantité</th>
        </tr>
        <?php
        foreach($commandeDetail as $detail){
        ?>      
        <tr>
            <td><?= $detail->reference() ?></td>
            <td><?= $detail->libelle() ?></td>
            <td><?= $detail->quantite() ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
    </table>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;"></p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('L', 'A5', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "BonCommande-".date('Ymdhi').'.pdf';
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