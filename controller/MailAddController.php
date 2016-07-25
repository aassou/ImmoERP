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
    if(!empty($_POST['mail'])){
        $content = htmlentities($_POST['mail']);
        $sender = $_SESSION['userMerlaTrav']->login();
        $created = date("Y-m-d H:i:s");
        $mail = new Mail(array('content' => $content, 'sender' => $sender,'created' => $created));
        $mailManager = new MailManager($pdo);
        $mailManager->add($mail);
    }
    else{
        $_SESSION['mail-add-error'] = "Vous devez tapez un message !";
    }
    header('Location:../messages.php');