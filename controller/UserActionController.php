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
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    //The History Component is used in all ActionControllers to mention a historical version of each action
    $historyManager = new HistoryManager($pdo);
    if( $action == "add" ) {
        if(empty($_POST['login']) || empty($_POST['password']) || empty($_POST['rpassword'])){
            $actionMessage = "<strong>Erreur Ajout Utilisateur</strong> : Tous les champs sont obligatoires";
            $typeMessage = "error";
        }
        else{
            $userManager = new UserManager($pdo);
            if($userManager->exists2($_POST['login'])){
                $actionMessage = "<strong>Erreur Ajout Utilisateur</strong> : Ce login existe déjà.";
                $typeMessage = "error";
            }
            else{
                $login = htmlspecialchars($_POST['login']);
                $password = htmlspecialchars($_POST['password']);
                $rpassword = htmlentities($_POST['rpassword']);
                $profil = htmlentities($_POST['profil']);
                if($password==$rpassword){
                    $user = new User(array('login'=>$login, 'password'=>$password, 'created'=>date('Y-m-d'), 'profil'=>$profil, 'status'=>1));
                    $userManager->add($user);
                    //add History data
                    $history = new History(array(
                        'action' => "Ajout",
                        'target' => "Table des utilisateurs ",
                        'description' => "Ajout d'un nouvel utilisateur",
                        'created' => $created,
                        'createdBy' => $createdBy
                    ));
                    //add it to db
                    $historyManager->add($history);
                    $actionMessage = "<strong>Opération Valide</strong> : Utilisateur Ajouté avec succès.";
                    $typeMessage = "success"; 
                }
                else{
                    $actionMessage = "<strong>Erreur Ajout Utilisateur</strong> : Les mots de passe doivent être identiques.";
                    $typeMessage = "error";
                }
                //set redirection link
                $redirectLink='Location:../users.php';
            }
        }
    }
    else if($action=="signin"){
        $redirectLink='Location:../index.php';
        if(empty($_POST['login']) || empty($_POST['password'])){
            $actionMessage = "<strong>Erreur Connexion</strong> : Tous les champs sont obligatoires.";
            $typeMessage = "error";
        }
        else{
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
            $userManager = new UserManager($pdo);
            if($userManager->exists($login, $password)){
                if($userManager->getStatus($login)!=0){
                    $_SESSION['userImmoERPV2'] = $userManager->getUserByLoginPassword($login, $password);
                    $redirectLink = 'Location:../company-choice.php';   
                    $actionMessage = "Salam <strong>$login</strong>";
                    $typeMessage = "info";  
                }
                else{
                    $actionMessage = "<strong>Erreur Connexion</strong> : Votre compte est inactif.";
                    $typeMessage = "error";  
                }
            }
            else{
                $actionMessage = "<strong>Erreur Connexion</strong> : Login/Mot de passe invalides.";
                $typeMessage = "error";
            }
        }
    }
    else if($action == "update"){
        $idUser = $_POST['idUser'];   
        $profil = $_POST['profil'];
        $userManager = new UserManager($pdo);
        $userManager->updateProfil($idUser, $profil);
        $actionMessage = "<strong>Opération valide</strong> : Profil Utlisateur est modifié avec succès.";
        $typeMessage = "success"; 
        //set redirection link
        $redirectLink = 'Location:../users.php';
    }
    else if($action == "update-password"){
        if(!empty($_POST['oldPassword']) 
        and $_POST['oldPassword']==$_SESSION['userImmoERPV2']->password()){
            if($_POST['newPassword1']==$_POST['newPassword2']){
                $newPassword = htmlentities($_POST['newPassword1']);
                $idUser = $_SESSION['userImmoERPV2']->id();
                $userManager = new UserManager($pdo);
                $userManager->changePassword($newPassword, $idUser);
                $actionMessage = "<strong>Opération valide</strong> : Le mot de passe a été changé avec succès.";
                $typeMessage = "success";
            }
            else{
                $actionMessage = "<strong>Erreur Mot de passe</strong> : Les 2 nouveaux mots de passe ne sont pas identiques.";
                $typeMessage = "error";
            }
        }
        else{
            $actionMessage = "<strong>Erreur Mot de passe</strong> : Vous devez saisir votre ancien mot de passe pour créer un nouveau.";
            $typeMessage = "error";
        }
        //set redirection link
        $redirectLink = 'Location:../user-profil.php';
    }
    else if($action=="hide"){

    }
    else if($action=="delete"){
        $idUser = $_POST['idUser'];   
        $userManager = new UserManager($pdo);
        $userManager->delete($idUser);
        $actionMessage  = "<strong>Opération valide</strong> : Utlisateur supprimé avec succès.";
        $typeMessage = "success";
        $redirectLink = 'Location:../users.php';
    }
    $_SESSION['user-action-message'] = $actionMessage;
    $_SESSION['user-type-message'] = $typeMessage;
    header($redirectLink);
    