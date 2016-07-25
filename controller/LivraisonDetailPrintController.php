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
        $livraisonManager = "";
        $livraisonDetailManager = "";
        $reglementsFournisseurManager = "";
        //get societe value
        $societe = $_GET['societe'];
        if ( $societe == 1 ) {
            $livraisonManager = new LivraisonManager($pdo);
            $livraisonDetailManager = new LivraisonDetailManager($pdo);
            $reglementsFournisseurManager = new ReglementFournisseurManager($pdo);    
        }
        else if ( $societe == 2 ) {
            $livraisonManager = new LivraisonIaazaManager($pdo);
            $livraisonDetailManager = new LivraisonDetailIaazaManager($pdo);
            $reglementsFournisseurManager = new ReglementFournisseurIaazaManager($pdo);
        }
		//classes and vars
		$livraisonDetailNumber = 0;
		$totalReglement = 0;
		$totalLivraison = 0;
		$titreLivraison ="BL N° ";
		$livraison = "Vide";
		$fournisseur = "Vide";
		$projet = "Vide";
		if( isset($_GET['idLivraison']) ){
			$livraison = $livraisonManager->getLivraisonById($_GET['idLivraison']);
            $nomProjet = "Non mentionnée";
            if ( $livraison->idProjet() != 0 ) {
                $nomProjet = $projetManager->getProjetById($livraison->idProjet());   
            }
			$fournisseur = $fournisseurManager->getFournisseurById($livraison->idFournisseur());
			$livraisonDetail = $livraisonDetailManager->getLivraisonsDetailByIdLivraison($livraison->id());
			$totalLivraisonDetail = 
			$livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
			$nombreArticle = 
			$livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id());
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
    <h3><?= $titreLivraison.$livraison->libelle()." - Fournisseur : ".$fournisseur->nom()." - Projet : ".$nomProjet ?></h3>
    <h4>Date Livraison : <?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?> | Nombre d'articles : <?= $nombreArticle ?></h4>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <table>
		<tr>
			<th style="width: 25%">Désignation</th>
			<th style="width: 25%">Quantité</th>
			<th style="width: 25%">Prix.Uni</th>
			<th style="width: 25%">Total</th>
		</tr>
		<?php
		foreach($livraisonDetail as $livraison){
		?>		
		<tr>
			<td><?= $livraison->designation() ?></td>
			<td><?= $livraison->quantite() ?></td>
			<td><?= number_format($livraison->prixUnitaire(), 2, ',', ' ') ?></td>
			<td><?= number_format($livraison->prixUnitaire()*$livraison->quantite(), 2, ',', ' ') ?></td>
		</tr>	
		<?php
		}//end of loop
		?>
		<tr>
            <td></td>
            <td></td>
            <td></td>
            <th>Grand Total</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><?= number_format($totalLivraisonDetail, 2, ',', ' ') ?></td>
        </tr>
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
		$fileName = "DetailsLivraison-".date('Ymdhi').'.pdf';
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