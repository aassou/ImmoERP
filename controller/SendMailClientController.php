<?php
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
    include('../lib/image-processing.php');
    require_once('../lib/tcpdf/tcpdf.php');
    //classes loading end
    session_start();
    $to = $_POST['email'];
    $client = $_POST['client'];
    $datePaiement = $_POST['datePaiement'];
    $subject = 'Rappel sur paiement de régelement';
    $message = 'Bonjour Chèr(e)'.$client.','."\n"."nous vous envoyons cet Email pour vous rappeler de votre paiement prévu date du : ".date('d/m/Y', strtotime($datePaiement))."\n"."Nous vous souhaitons une bonne journée.Groupe Annahda Lil Iaamar";
    $headers = 'From: annahda@gmail.com' . "\r\n";

    mail("aassou.abdelilah@gmail.com", $subject, $message, $headers);
    $actionMessage = "Opération Valide : Email envoyé avec succès.";
    $typeMessage = "success";
    $_SESSION['mail-action-message'] = $actionMessage;
    $_SESSION['mail-type-message'] = $typeMessage;
    header('Location:../contrat-status.php');
