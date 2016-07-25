<?php
class ClientProjetManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(ClientProjet $clientProjet){
        $query = $this->_db->prepare('INSERT INTO t_client_projet (idClient, idProjet) VALUES (:idClient, :idProjet)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idClient', $clientProjet->idClient());
        $query->bindValue(':idProjet', $clientProjet->idProjet());
        $query->execute();
        $query->closeCursor();
    }
}
