<?php
class User{

    //attributes
    private $_id;
    private $_login;
    private $_password;
    private $_profil;
	private $_status;
    private $_created;
    private $_createdBy;
    private $_updated;
    private $_updatedBy;
    
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
    
    public function setLogin($login){
        $this->_login = $login;
    }
    
    public function setPassword($password){
        $this->_password = $password;
    }
	
	public function setProfil($profil){
		$this->_profil = $profil;
	}
	
	public function setStatus($status){
		$this->_status = $status;
	}
    
    public function setCreated($created){
        $this->_created = $created;
    }
    
    public function setCreatedBy($createdBy){
        $this->_createdBy = $createdBy;
    }
    
    public function setUpdated($updated){
        $this->_updated = $updated;
    }
    
    public function setUpdatedBy($updatedBy){
        $this->_updatedBy = $updatedBy;
    }
	    
    //getters
    
    public function id(){
        return $this->_id;
    }
    
    public function login(){
        return $this->_login;
    }
    
    public function password(){
        return $this->_password;
    }
    
    public function profil(){
        return $this->_profil;
    }
	
	public function status(){
        return $this->_status;
    }
    
    public function created(){
        return $this->_created;
    }
    
    public function createdBy(){
        return $this->_createdBy;
    }
    
    public function updated(){
        return $this->_updated;
    }
    
    public function updatedBy(){
        return $this->_updatedBy;
    }       
}