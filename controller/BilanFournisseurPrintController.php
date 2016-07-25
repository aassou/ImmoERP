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
        //class manager
        $projetManager = new ProjetManager($pdo);
        $fournisseurManager = new FournisseurManager($pdo);
        $livraisonManager = "";
        $livraisonDetailManager = "";
        $reglementsFournisseurManager = "";
        $titreSociete = "";
        
        $societe = htmlentities($_POST['societe']);
        
        if ( $societe == 1 ) {
            $livraisonManager = new LivraisonManager($pdo);
            $livraisonDetailManager = new LivraisonDetailManager($pdo);
            $reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
            $titreSociete = "Société Annahda";
        }
        else if ( $societe == 2 ) {
            $livraisonManager = new LivraisonIaazaManager($pdo);
            $livraisonDetailManager = new LivraisonDetailIaazaManager($pdo);
            $reglementsFournisseurManager = new ReglementFournisseurIaazaManager($pdo);
            $titreSociete = "Société Iaaza";
        }
        //classes and vars
        $idFournisseur = $_POST['idFournisseur'];
        $fournisseur = $fournisseurManager->getFournisseurById($idFournisseur);
        $reglements = "";
        $reglementsNumber = 0;
        $livraisons = "";
        $livraisonNumber = 0;
        $totalReglement = 0;
        $totalLivraison = 0;
        $titreLivraison = "";
        if ( isset($_POST['criteria']) and $_POST['criteria'] == "toutesLivraison" ) {
            $livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($idFournisseur);
            if( $livraisonNumber != 0 ) {
                $livraisons = $livraisonManager->getLivraisonsByIdFournisseur($idFournisseur);
                $titreLivraison ="Bilan complet du fournisseur <strong>".$fournisseurManager->getFournisseurById($idFournisseur)->nom()."</strong>";
                //get the sum of livraisons details using livraisons ids (idFournisseur)
                //$livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseur($idFournisseur);
                $sommeDetailsLivraisons = 0;
                //foreach($livraisonsIds as $idl){
                foreach($livraisons as $l){
                    $sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($l->id());
                }   
                $totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($idFournisseur);
                $totalLivraison = $sommeDetailsLivraisons;
            }
            $reglementsNumber = $reglementsFournisseurManager->getReglementsNumberByIdFournisseur($idFournisseur);
            if ( $reglementsNumber != 0 ) {
                $reglements = $reglementsFournisseurManager->getReglementFournisseursByIdFournisseur($idFournisseur);   
            }
        }
        else if ( isset($_POST['criteria']) and $_POST['criteria'] == "parChoix" ) { 
            $dateFrom = htmlentities($_POST['dateFrom']);
            $dateTo = htmlentities($_POST['dateTo']);
            $titreLivraison = "Bilan Fournisseur <strong>".$fournisseurManager->getFournisseurById($idFournisseur)->nom()."</strong>";
            $titreLivraison .= " ".date('d/m/Y', strtotime($dateFrom))." - ".date('d/m/Y', strtotime($dateTo));
            if ( isset($_POST['reglements']) ) {
                $reglements = 
                $reglementsFournisseurManager->getReglementFournisseurByIdFournisseurByDates($idFournisseur, $dateFrom, $dateTo);
                $totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseurByDates($idFournisseur, $dateFrom, $dateTo);
            }
            if ( isset($_POST['livraisons']) and $_POST['livraisons'] == 1 ) {
                $livraisons = 
                $livraisonManager->getLivraisonsByIdFournisseurByDates($idFournisseur, $dateFrom, $dateTo);
                $sommeDetailsLivraisons = 0;
                foreach($livraisons as $l){
                    $sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($l->id());
                }   
                $totalLivraison = $sommeDetailsLivraisons;
            }
            else if ( isset($_POST['livraisons']) and $_POST['livraisons'] == 0 ) {
                $livraisons = 
                $livraisonManager->getLivraisonsNonPayeByIdFournisseurByDates($idFournisseur, $dateFrom, $dateTo);
                $sommeDetailsLivraisons = 0;
                foreach($livraisons as $l){
                    $sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($l->id());
                }   
                $totalLivraison = $sommeDetailsLivraisons;
            } 
        }       

ob_start();
?>
<style type="text/css">
    p, h1, h2, h3{
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
    <h3><?= $titreSociete ?></h3>
    <h3><?= $titreLivraison ?></h3>
    <p>Imprimé le <?= date('d/m/Y - h:i') ?> </p>
    <br>
    <h4>Récapitulatif</h4>
    <table>
        <tr>
            <th style="width: 34%"><strong>Total des Livraisons</strong></th>
            <th style="width: 33%"><strong>Total des Réglements</strong></th>
            <th style="width: 33%"><strong>Total des Soldes</strong></th>
        </tr>
        <tr>
            <td style="width: 34%"><strong><?= number_format($totalLivraison, 2, ',', ' ') ?>&nbsp;DH</strong></td>
            <td style="width: 33%"><strong><?= number_format($totalReglement, 2, ',', ' ') ?>&nbsp;DH</strong></td>
            <td style="width: 33%"><strong><?= number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?>&nbsp;DH</strong></td>
        </tr>
    </table>
    <br>
    <?php 
    if ( $livraisonNumber != 0 || isset($_POST['livraisons']) ) {
    ?>    
    <h4>Détails des livraisons</h4>
    <table>
        <tr>
            <th style="width: 20%">N°BL</th>
            <th style="width: 20%">Date Livraison</th>
            <th style="width: 20%">Articles</th>
            <th style="width: 20%">Projet</th>
            <th style="width: 20%">Total</th>
        </tr>
        <?php
        foreach( $livraisons as $livraison ) {
            $nomProjet = "";
            if ( $livraison->idProjet() == 0 ) {
                $nomProjet = "Non mentionné";
            }
            else {
                $nomProjet = $projetManager->getProjetById($livraison->idProjet())->nom();
            }
        ?>      
        <tr>
            <td><?= $livraison->libelle() ?></td>
            <td><?= date('d/m/Y', strtotime($livraison->dateLivraison())); ?></td>
            <td><?= $livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id()) ?></td>
            <td><?= $nomProjet ?></td>
            <td><?= number_format( $livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id()), 2, ',', ' '); ?></td>
        </tr>   
        <?php
        }//end of loop
        ?>
        <tr>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <th style="width: 20%">Grand Total</th>
        </tr>
        <tr>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"><?= number_format($totalLivraison, 2, ',', ' ') ?>&nbsp;DH</td>
        </tr>
    </table>
    <?php 
    }
    if ( $reglementsNumber != 0 || isset($_POST['reglements']) ) {
    ?>
    <h4>Détails des réglements</h4>
    <table>
        <tr>
            <th style="width: 20%">N°Opération</th>
            <th style="width: 20%">Date</th>
            <th style="width: 20%">Mode Paiement</th>
            <th style="width: 20%">Projet</th>
            <th style="width: 20%">Montant</th>
        </tr>
        <?php
        foreach( $reglements as $reglement ) {
            $designation = "";
            if ( $reglement->idProjet() == 0 ) {
                $designation = "Plusieurs Projets";    
            }
            else {
                $designation = $projetManager->getProjetById($reglement->idProjet())->nom();
            }
        ?>      
        <tr>
            <td style="width: 20%"><?= $reglement->numeroCheque() ?></td>
            <td style="width: 20%"><?= date('d/m/Y', strtotime($reglement->dateReglement())); ?></td>
            <td style="width: 20%"><?= $reglement->modePaiement() ?></td>
            <td style="width: 20%"><?= $designation ?></td>
            <td style="width: 20%"><?= number_format( $reglement->montant(), 2, ',', ' '); ?></td>          
        </tr>   
        <?php
        }//end of loop
        ?>
        <tr>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <th style="width: 20%">Grand Total</th>
        </tr>
        <tr>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"></td>
            <td style="width: 20%"><?= number_format($totalReglement, 2, ',', ' ') ?>&nbsp;DH</td>
        </tr>
    </table>
    <?php  
    }
    ?>
    <br><br>
    <page_footer>
    <hr/>
    <p style="text-align: center;font-size: 9pt;"></p>
    </page_footer>
</page>    
<?php
    $content = ob_get_clean();
    
    require('../lib/html2pdf/html2pdf.class.php');
    try{
        $pdf = new HTML2PDF('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($content);
        $fileName = "BilanLivraison-".date('Ymdhi').'.pdf';
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