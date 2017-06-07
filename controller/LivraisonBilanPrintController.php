<?php
    require('../app/classLoad.php'); 
    require('../db/PDOFactory.php');;  
    //classes loading end
    session_start();
    if( isset($_SESSION['userImmoERPV2']) ){
        //class managers
        $companyManager               = new CompanyManager(PDOFactory::getMysqlConnection());
        $projetManager                = new ProjetManager(PDOFactory::getMysqlConnection());
		$fournisseurManager           = new FournisseurManager(PDOFactory::getMysqlConnection());
		$livraisonManager             = new LivraisonManager(PDOFactory::getMysqlConnection());
        $livraisonDetailManager       = new LivraisonDetailManager(PDOFactory::getMysqlConnection());
		$reglementsFournisseurManager = new ReglementFournisseurManager(PDOFactory::getMysqlConnection());
        //obj vars and tests
        $companyID            = $_GET['companyID'];
        $company              = $companyManager->getCompanyById($companyID);
        $totalReglements = 0;
        //start processing
		if ( 
		  isset($_GET['idFournisseur']) 
		  and isset($_GET['idProjet']) 
		  and $fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']) >= 1 
          ) 
		  {
		    $idProjet        = $_GET['idProjet'];
			$fournisseur     = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
            $livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseurByProjet($fournisseur, $idProjet);
            
			if ( $livraisonNumber != 0 )
			{
				$livraisons     = $livraisonManager->getLivraisonsByIdFournisseurByProjet($fournisseur, $idProjet);
				$titreLivraison = "Bilan des livraisons du fournisseur <strong>"
				.$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong> / Projet: <strong>"
				.$projetManager->getProjetById($idProjet)->nom()."</strong>";	
				$totalLivraison = $livraisonManager->getTotalLivraisonsIdFournisseurProjet($fournisseur, $idProjet);
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseurByProjet($fournisseur, $idProjet);
			}
		}
		else if ( 
		  isset($_GET['idFournisseur']) 
		  and $fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']) >= 1 
          )
		  {
		    $idFournisseur        = htmlentities($_GET['idFournisseur']);  
			$fournisseur          = $fournisseurManager->getOneFournisseurBySearch($idFournisseur);
			$livraisonNumber      = $livraisonManager->getLivraisonsNumberByIdFournisseur($idFournisseur);
            
			if ( $livraisonNumber != 0 ) 
			{
			    $titreLivraison = "Bilan des livraisons du fournisseur <strong>".$fournisseurManager->getFournisseurById($idFournisseur)->nom()."</strong>";
				$livraisons     = $livraisonManager->getLivraisonsByIdFournisseur($idFournisseur, $companyID);
				$totalLivraison = $livraisonManager->getTotalLivraisonsIdFournisseur($idFournisseur);
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($idFournisseur, $companyID);
			}
		}
		else 
		{
			$livraisonNumber = $livraisonManager->getLivraisonNumber($companyID);
            
			if ( $livraisonNumber != 0 ) 
			{
			    $titreLivraison = "Bilan de toutes les livraisons";
				$livraisons     = $livraisonManager->getLivraisonsByCompany($companyID);
				$totalLivraison = $livraisonManager->getTotalLivraisons($companyID);
				$totalReglement = $reglementsFournisseurManager->getTotalReglement($companyID);	
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
    <h3>Société <?= $company->nom() ?></h3>
    <h3><?= $titreLivraison ?></h3>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <table>
		<tr>
			<th style="width: 25%">Date livraison</th>
			<th style="width: 25%">Libelle</th>
			<!--th style="width: 35%">Désignation</th-->
			<th style="width: 25%">Quantité</th>
			<!--th style="width: 10%">Prix.Uni</th-->
			<th style="width: 25%">Total</th>
		</tr>
		<?php
		$totalDetailsLivraisons = 0;
		$grandTotalLivraisons   = 0;
		foreach($livraisons as $livraison){
            $totalDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
            //$grandTotalLivraisons += $totalDetailsLivraisons;
		?>		
		<tr>
			<td><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
			<td><?= $livraison->libelle() ?></td>
			<!--td><?= $livraison->designation() ?></td-->
			<td><?= $livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id()); ?></td>
			<!--td><?= number_format($livraison->prixUnitaire(), 2, ',', ' ') ?></td-->
			<td><?= number_format($livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id()), 2, ',', ' '); ?></td>
		</tr>	
		<?php
		}//end of loop
		$grandTotalLivraisons = $totalDetailsLivraisons;
		?>
	</table>
	<br />
	<table>
		<tr>
			<th style="width: 15%"><strong>Livraisons</strong></th>
			<td style="width: 20%">
				<strong><?= number_format($grandTotalLivraisons, 2, ',', ' ') ?>DH</strong>
			</td>
			<th style="width: 15%"><strong>Réglements</strong></th>
			<td style="width: 20%">
				<strong><?= number_format($totalReglement, 2, ',', ' ') ?>DH</strong>
			</td>
			<th style="width: 10%"><strong>Solde</strong></th>
			<td style="width: 20%">
				<strong><?= number_format($grandTotalLivraisons-$totalReglement, 2, ',', ' ') ?>DH</strong>
			</td>
		</tr>
	</table> 
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
    header("Location:../index.php");
}
?>