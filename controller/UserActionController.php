<?php
    require('../app/classLoad.php');
    require('../db/PDOFactory.php'); 
    
    session_start();
    //post input processing
    $action = htmlentities($_POST['action']);
    //This var contains result message of CRUD action
    $actionMessage = "";
    $typeMessage = "";
    $redirectLink = "";
    //process begins
    $userManager = new UserManager(PDOFactory::getMysqlConnection());
    $historyManager = new HistoryManager(PDOFactory::getMysqlConnection());
    
    //ADD USER ACTION BEGIN
    if( $action == "add" ) {
        if(empty($_POST['login']) || empty($_POST['password']) || empty($_POST['rpassword'])){
            $actionMessage = "<strong>Erreur Ajout Utilisateur</strong> : Tous les champs sont obligatoires";
            $typeMessage = "error";
        }
        else{
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
    //ADD USER ACTION END
    
    //SIGNIN USER ACTION BEGIN
    else if($action=="signin"){
        $redirectLink='Location:../views/index.php';
        if(empty($_POST['login']) || empty($_POST['password'])){
            $actionMessage = "<strong>Erreur Connexion</strong> : Tous les champs sont obligatoires.";
            $typeMessage = "error";
        }
        else{
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
            if($userManager->exists($login, $password)){
                if($userManager->getStatus($login)!=0){
                    $_SESSION['userImmoERPV2'] = $userManager->getUserByLoginPassword($login, $password);
                    $redirectLink = 'Location:../views/company-choice.php';   
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
    //SIGNIN USER ACTION END
    
    //UPDATE USER ACTION BEGIN
    else if ( $action == "update" ) {
        //get form params
        $idUser = htmlentities($_POST['idUser']);   
        $profil = htmlentities($_POST['profil']);
        //set the action demanded
        $userManager->updateProfil($idUser, $profil);
        //set client response informations
        $actionMessage = "<strong>Opération valide</strong> : Profil Utlisateur est modifié avec succès.";
        $typeMessage = "success"; 
        //set redirection link
        $redirectLink = 'Location:../views/users.php';
    }
    //UPDATE USER ACTION END
    
    //UPDATE PASSWORD USER ACTION BEGIN
    else if ( $action == "update-password" ) {
        //check if the old password is set and if it's the same as the current session
        if ( !empty($_POST['oldPassword'] ) and $_POST['oldPassword'] == $_SESSION['userImmoERPV2']->password() ) {
            //check if the new password and new password retype are the same
            if ( $_POST['newPassword1'] == $_POST['newPassword2'] ) {
                //if so, get form params
                $newPassword = htmlentities($_POST['newPassword1']);
                //get the user id from the current session
                $idUser = $_SESSION['userImmoERPV2']->id();
                //set the action demanded
                $userManager->changePassword($newPassword, $idUser);
                //set client response informations
                $actionMessage = "<strong>Opération valide</strong> : Le mot de passe a été changé avec succès.";
                $typeMessage = "success";
            }
            //if the new password and new password retype aren't the same, so an error message will shown
            else{
                $actionMessage = "<strong>Erreur Mot de passe</strong> : Les 2 nouveaux mots de passe ne sont pas identiques.";
                $typeMessage = "error";
            }
        }
        //if the old password isn't set and if it's not the same as the current session, so an error message will shown
        else{
            $actionMessage = "<strong>Erreur Mot de passe</strong> : Vous devez saisir votre ancien mot de passe pour créer un nouveau.";
            $typeMessage = "error";
        }
        //set redirection url 
        $redirectLink = 'Location:../views/user-profil.php';
    }
    //UPDATE PASSWORD USER ACTION END
    
    //DELETE USER ACTION BEGIN
    else if ( $action=="delete" ) {
        //get form params
        $idUser = htmlentities($_POST['idUser']);
        //set the action demanded   
        $userManager->delete($idUser);
        //set client response informations
        $actionMessage  = "<strong>Opération valide</strong> : Utlisateur supprimé avec succès.";
        $typeMessage = "success";
        //set redirection url 
        $redirectLink = 'Location:../views/users.php';
    }
    //DELETE USER ACTION END
    
    //set session informations
    $_SESSION['user-action-message'] = $actionMessage;
    $_SESSION['user-type-message'] = $typeMessage;
    //redirect to the response url
    header($redirectLink);
    