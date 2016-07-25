<?php
class ClientProjet{
        
    //attributes
    private $_idClient;
    private $_idProjet;
    
    //le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
    
    //setters
    public function setIdClient($idClient){
        $this->_idClient = $idClient;
    }
    
    public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
    
    //getters
    public function idClient(){
        return $this->_idClient;
    }
    
    public function idProjet(){
        return $this->_idProjet;
    }
}
