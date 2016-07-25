<?php
include('config.php');
include('model/ReglementPrevu.php');
include('model/ReglementPrevuManager.php');
$prixNegocie = htmlentities($_POST['prixNegocie']);
$numero = htmlentities($_POST['numero']);
$typeBien = htmlentities($_POST['typeBien']);
$idBien = htmlentities($_POST['bien']);
$dateCreation = htmlentities($_POST['dateCreation']);
$avance = htmlentities($_POST['avance']);
$modePaiement = htmlentities($_POST['modePaiement']);
$dureePaiement = htmlentities($_POST['dureePaiement']);
$nombreMois = htmlentities($_POST['nombreMois']);
$echeance = htmlentities($_POST['echeance']);
$note = htmlentities($_POST['note']);
$idClient = htmlentities($_POST['idClient']);
$codeContrat = uniqid().date('YmdHis');
$created = date('Y-m-d h:i:s');
$createdBy = "abdou";

$reglementPrevuManager = new ReglementPrevuManager($pdo);

$condition = ceil( floatval($dureePaiement)/floatval($nombreMois) );
for ( $i=1; $i <= $condition; $i++ ) {
    $monthsNumber = "+".$nombreMois*$i." months";
    $datePrevu = date('Y-m-d', strtotime($monthsNumber, strtotime($dateCreation)));
    //echo $monthsNumber.'<br>';
    //echo $datePrevu.'<br>';
    //echo $nombreMois.'<br>';
    //echo $dateCreation.'<br>';
    $reglementPrevuManager->add(
        new ReglementPrevu(
            array(
                'datePrevu' => $datePrevu,
                'codeContrat' => $codeContrat,
                'status' => 0,
                'created' => $created,
                'createdBy' =>$createdBy
            )
        )
    );
}
