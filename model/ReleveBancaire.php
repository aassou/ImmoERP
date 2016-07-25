<?php
class ReleveBancaire{

	//attributes
	private $_id;
	private $_dateOpe;
	private $_dateVal;
	private $_libelle;
	private $_reference;
	private $_debit;
	private $_credit;
	private $_projet;
    private $_idCompteBancaire;
    private $_status;
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
	public function setDateOpe($dateOpe){
		$this->_dateOpe = $dateOpe;
   	}

	public function setDateVal($dateVal){
		$this->_dateVal = $dateVal;
   	}

	public function setLibelle($libelle){
		$this->_libelle = $libelle;
   	}

	public function setReference($reference){
		$this->_reference = $reference;
   	}

	public function setDebit($debit){
		$this->_debit = $debit;
   	}

	public function setCredit($credit){
		$this->_credit = $credit;
   	}

	public function setProjet($projet){
		$this->_projet = $projet;
   	}
    
    public function setIdCompteBancaire($idCompteBancaire){
        $this->_idCompteBancaire = $idCompteBancaire;
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
	public function dateOpe(){
		return $this->_dateOpe;
   	}

	public function dateVal(){
		return $this->_dateVal;
   	}

	public function libelle(){
		return $this->_libelle;
   	}

	public function reference(){
		return $this->_reference;
   	}

	public function debit(){
		return $this->_debit;
   	}

	public function credit(){
		return $this->_credit;
   	}

	public function projet(){
		return $this->_projet;
   	}
    
    public function idCompteBancaire(){
        return $this->_idCompteBancaire;
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