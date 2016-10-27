<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=immoerp_v2', 'root', '');   
}
catch(PDOException $e){
    echo "Cannot connect to the Database<br>";
    echo "Details : [ ".$e->getCode().", ".$e->getMessage." ]";
}