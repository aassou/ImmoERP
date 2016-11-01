<?php 
if( time() - $_SESSION['timestamp'] > 900 ) { //subtract new timestamp from the old one
    alert("15 Minutes over!");
    unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
    $_SESSION['logged_in'] = false;
    header("Location: " . index.php); //redirect to index.php
    exit;
} 
else {
    $_SESSION['timestamp'] = time(); //set new timestamp
}