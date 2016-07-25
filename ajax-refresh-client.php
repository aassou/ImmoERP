<?php
include('config.php');
$keyword = '%'.$_POST['keyword'].'%';
$sql = "SELECT * FROM t_client WHERE nom LIKE (:keyword) ORDER BY id ASC LIMIT 0, 10";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$nom = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['nom']);
	// add new option
	echo '<li onclick="setItemClient(\''.str_replace("'", "\'", $rs['nom']).'\', \''.$rs['cin'].
	'\', \''.$rs['telephone1'].'\', \''.$rs['telephone2'].'\', \''.$rs['adresse'].'\'
	, \''.$rs['email'].'\', \''.$rs['id'].'\', \''.$rs['nomArabe'].'\', \''.$rs['adresseArabe'].'\')">'.$nom.'</li>';
}
?>
