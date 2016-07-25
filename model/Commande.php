<?php
class Commande{

	//attributes
	private $_id;
	private $_idFournisseur;
	private $_idProjet;
	private $_dateCommande;
	private $_numeroCommande;
	private $_designation;
	private $_status;
	private $_codeLivraison;
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
	public function setIdFournisseur($idFournisseur){
		$this->_idFournisseur = $idFournisseur;
   	}

	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
   	}

	public function setDateCommande($dateCommande){
		$this->_dateCommande = $dateCommande;
   	}

	public function setNumeroCommande($numeroCommande){
		$this->_numeroCommande = $numeroCommande;
   	}

	public function setDesignation($designation){
		$this->_designation = $designation;
   	}

	public function setStatus($status){
		$this->_status = $status;
   	}

	public function setCodeLivraison($codeLivraison){
		$this->_codeLivraison = $codeLivraison;
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
	public function idFournisseur(){
		return $this->_idFournisseur;
   	}

	public function idProjet(){
		return $this->_idProjet;
   	}

	public function dateCommande(){
		return $this->_dateCommande;
   	}

	public function numeroCommande(){
		return $this->_numeroCommande;
   	}

	public function designation(){
		return $this->_designation;
   	}

	public function status(){
		return $this->_status;
   	}

	public function codeLivraison(){
		return $this->_codeLivraison;
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