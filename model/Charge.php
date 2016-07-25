<?php
class Charge{

	//attributes
	private $_id;
	private $_type;
	private $_dateOperation;
	private $_montant;
	private $_societe;
	private $_designation;
	private $_idProjet;
	private $_created;
	private $_createdBy;
	private $_updated;
	private $_updatedBy;

	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d\'une façon dynamique!
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
	public function setType($type){
		$this->_type = $type;
   	}

	public function setDateOperation($dateOperation){
		$this->_dateOperation = $dateOperation;
   	}

	public function setMontant($montant){
		$this->_montant = $montant;
   	}

	public function setSociete($societe){
		$this->_societe = $societe;
   	}

	public function setDesignation($designation){
		$this->_designation = $designation;
   	}

	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
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
	public function type(){
		return $this->_type;
   	}

	public function dateOperation(){
		return $this->_dateOperation;
   	}

	public function montant(){
		return $this->_montant;
   	}

	public function societe(){
		return $this->_societe;
   	}

	public function designation(){
		return $this->_designation;
   	}

	public function idProjet(){
		return $this->_idProjet;
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