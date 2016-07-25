<?php
class EmployeProjetSalaire{

    //attributes
    private $_id;
	private $_salaire;
	private $_nombreJours;
	private $_dateOperation;
	private $_idEmploye;
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

	public function setNom($nom){
		$this->_nom = $nom;
	}
	
	public function setSalaire($salaire){
		$this->_salaire = $salaire;
	}
	
	public function setNombreJours($nombreJours){
		$this->_nombreJours = $nombreJours;
	}
	
	public function setDateOperation($dateOperation){
		$this->_dateOperation = $dateOperation;
	}
	
	public function setIdEmploye($idEmploye){
		$this->_idEmploye = $idEmploye;
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
    
	public function nom(){
		return $this->_nom;
	}
	
	public function salaire(){
		return $this->_salaire;
	}
	
	public function nombreJours(){
		return $this->_nombreJours;
	}
	
	public function dateOperation(){
		return $this->_dateOperation;
	}
	
	public function idEmploye(){
		return $this->_idEmploye;
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