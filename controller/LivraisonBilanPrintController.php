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
		$livraisonManager = new LivraisonManager($pdo);
		$reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
		if( isset($_GET['idFournisseur']) and isset($_GET['idProjet']) and 
		$fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']>=1)){
			$fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
			$idProjet = $_GET['idProjet'];
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseurByProjet($fournisseur, $idProjet);
			if($livraisonNumber != 0){
				$livraisons = $livraisonManager->getLivraisonsByIdFournisseurByProjet($fournisseur, $idProjet);
				$titreLivraison = "Bilan des livraisons du fournisseur <strong>"
				.$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong> / Projet: <strong>"
				.$projetManager->getProjetById($idProjet)->nom()."</strong>";	
				$totalLivraison = $livraisonManager->getTotalLivraisonsIdFournisseurProjet($fournisseur, $idProjet);
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseurByProjet($fournisseur, $idProjet);
			}
		}
		else if( isset($_GET['idFournisseur']) and
		$fournisseurManager->getOneFournisseurBySearch($_GET['idFournisseur']>=1)){
			$fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_GET['idFournisseur']));
			$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($fournisseur);
			if($livraisonNumber != 0){
				$livraisons = $livraisonManager->getLivraisonsByIdFournisseur($fournisseur);
				$titreLivraison ="Bilan des livraisons du fournisseur <strong>".$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong>";
				$totalLivraison = $livraisonManager->getTotalLivraisonsIdFournisseur($fournisseur);
				$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($fournisseur);
			}
		}
		else {
			$livraisonNumber = $livraisonManager->getLivraisonNumber();
			if($livraisonNumber != 0){
				$livraisons = $livraisonManager->getLivraisons();
				$titreLivraison ="Bilan de toutes les livraisons";
				$totalLivraison = $livraisonManager->getTotalLivraisons();
				$totalReglement = $reglementsFournisseurManager->getTotalReglement();	
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
    <h3><?= $titreLivraison ?></h3>
    <p>Imprimé le <?= date('d/m/Y') ?> | <?= date('h:i') ?> </p>
    <table>
		<tr>
			<th style="width: 20%">Date livraison</th>
			<th style="width: 15%">Libelle</th>
			<th style="width: 35%">Désignation</th>
			<th style="width: 10%">Quantité</th>
			<th style="width: 10%">Prix.Uni</th>
			<th style="width: 10%">Total</th>
		</tr>
		<?php
		foreach($livraisons as $livraison){
		?>		
		<tr>
			<td><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
			<td><?= $livraison->libelle() ?></td>
			<td><?= $livraison->designation() ?></td>
			<td><?= $livraison->quantite() ?></td>
			<td><?= number_format($livraison->prixUnitaire(), 2, ',', ' ') ?></td>
			<td><?= number_format($livraison->prixUnitaire()*$livraison->quantite(), 2, ',', ' ') ?></td>
		</tr>	
		<?php
		}//end of loop
		?>
	</table>
	<br />
	<table>
		<tr>
			<th style="width: 60%"><strong>Total Livraisons</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalLivraison, 2, ',', ' ') ?> 
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
		<tr>
			<th style="width: 60%"><strong>Total Réglements</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalReglement, 2, ',', ' ') ?> 
					</a>
					&nbsp;DH
				</strong>
			</td>
		</tr>
		<tr>
			<th style="width: 60%"><strong>Solde</strong></th>
			<td style="width: 40%">
				<strong>
					<a>
						<?= number_format($totalLivraison-$totalReglement, 2, ',', ' ') ?> 
					</a>
					&nbsp;DH
				</strong>
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
    header("Location:index.php");
}
?>