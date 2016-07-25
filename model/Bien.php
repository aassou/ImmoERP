<?php
class Bien{
    
    //attributes
    private $_id;
    private $_numero;
    private $_etage;
    private $_superficie;
    private $_facade;
    private $_reserve;
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
    public function setId($id){
        $this->_id = $id;
    }
    
    public function setNumero($numero){
        $this->_numero = $numero;
    }
    
    public function setEtage($etage){
        $this->_etage = $etage;
    }
    
    public function setSuperficie($superficie){
        $this->_superficie = $superficie;
    }
    
    public  function setFacade($facade){
        $this->_facade = $facade;
    }
    
    public function setReserve($reserve){
        $this->_reserve = $reserve;
    }
    
    public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
    
    //getters
    public function id(){
        return $this->_id;
    }
    
    public function numero(){
        return $this->_numero;
    }
    
    public function etage(){
        return $this->_etage;
    }
    
    public function superficie(){
        return $this->_superficie;
    }
    
    public function facade(){
        return $this->_facade;
    }
    
    public function reserve(){
        return $this->_reserve;
    }
    
    public function idProjet(){
        return $this->_idProjet;
    }
}
