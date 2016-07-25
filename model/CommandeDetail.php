<?php
class CommandeDetail{

	//attributes
	private $_id;
	private $_reference;
	private $_libelle;
	private $_quantite;
	private $_idCommande;
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
	public function setReference($reference){
		$this->_reference = $reference;
   	}

	public function setLibelle($libelle){
		$this->_libelle = $libelle;
   	}

	public function setQuantite($quantite){
		$this->_quantite = $quantite;
   	}

	public function setIdCommande($idCommande){
		$this->_idCommande = $idCommande;
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
	public function reference(){
		return $this->_reference;
   	}

	public function libelle(){
		return $this->_libelle;
   	}

	public function quantite(){
		return $this->_quantite;
   	}

	public function idCommande(){
		return $this->_idCommande;
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