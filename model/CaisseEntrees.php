<?php
class CaisseEntrees{
	//attributes
	private $_id;
	private $_montant;
	private $_designation;
	private $_dateOperation;
	private $_utilisateur;
	
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
	
	public function setDesignation($designation){
        $this->_designation = $designation;
    }
	
	public function setMontant($montant){
        $this->_montant = $montant;
    }
	
	public function setDateOperation($dateOperation){
        $this->_dateOperation = $dateOperation;
    }
	
	public function setUtilisateur($utilisateur){
        $this->_utilisateur = $utilisateur;
    }
	
	//getters
	public function id(){
        return $this->_id;
    }
	
	public function designation(){
        return $this->_designation;
    }
	
	public function montant(){
        return $this->_montant;
    }
	
	public function dateOperation(){
        return $this->_dateOperation;
    }
	
	public function utilisateur(){
        return $this->_utilisateur;
    }
}
