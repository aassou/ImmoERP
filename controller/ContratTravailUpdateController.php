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
    
    //post input processing
    $idProjet = htmlentities($_POST['idProjet']);
    if( !empty($_POST['nom'])){
        $nom = htmlentities($_POST['nom']);    
        $cin = htmlentities($_POST['cin']);
		$adresse = htmlentities($_POST['adresse']);
		$dateNaissance = htmlentities($_POST['dateNaissance']);
		$dateContrat = htmlentities($_POST['dateContrat']);
		$matiere = htmlentities($_POST['matiere']);
		$prix = htmlentities($_POST['prix']);
		$mesure = htmlentities($_POST['mesure']);
		$prixTotal = htmlentities($_POST['prixTotal']);
		$idContrat = htmlentities($_POST['idContrat']);
		
        
        $contrat = new ContratTravail(array('id' => $idContrat, 'nom' => $nom, 'cin' => $cin,
        'dateNaissance' => $dateNaissance, 'dateContrat' => $dateContrat,
		'adresse' => $adresse, 'matiere' => $matiere, 'prix' => $prix, 'mesure' => $mesure,
		'prixTotal' => $prixTotal));
        $contratTravailManager = new ContratTravailManager($pdo);
        $contratTravailManager->update($contrat);
        $_SESSION['contrat-update-success']="<strong>تم تعديل العقد بنجاح</strong>";
    }
    else{
        $_SESSION['contrat-update-error'] = "<strong> خطأ في التسجيل</strong>"."يجب ادخال  الاسم ";
    }
	header('Location:../contrats-travail.php?idProjet='.$idProjet);
    