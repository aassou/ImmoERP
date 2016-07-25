<?php
class ContratTravail{

	//attributes
	private $_id;
	private $_nom;
	private $_cin;
	private $_adresse;
	private $_dateNaissance;
	private $_matiere;
	private $_prix;
	private $_mesure;
	private $_prixTotal;
	private $_dateContrat;
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

	public function setNom($nom){
		$this->_nom = $nom;
   	}

	public function setCin($cin){
		$this->_cin = $cin;
   	}

	public function setAdresse($adresse){
		$this->_adresse = $adresse;
   	}

	public function setDateNaissance($dateNaissance){
		$this->_dateNaissance = $dateNaissance;
   	}

	public function setMatiere($matiere){
		$this->_matiere = $matiere;
   	}

	public function setPrix($prix){
		$this->_prix = $prix;
   	}

	public function setMesure($mesure){
		$this->_mesure = $mesure;
   	}

	public function setPrixTotal($prixTotal){
		$this->_prixTotal = $prixTotal;
   	}
	
	public function setDateContrat($dateContrat){
		$this->_dateContrat = $dateContrat;
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

	public function nom(){
		return $this->_nom;
   	}

	public function cin(){
		return $this->_cin;
   	}

	public function adresse(){
		return $this->_adresse;
   	}

	public function dateNaissance(){
		return $this->_dateNaissance;
   	}

	public function matiere(){
		return $this->_matiere;
   	}

	public function prix(){
		return $this->_prix;
   	}

	public function mesure(){
		return $this->_mesure;
   	}

	public function prixTotal(){
		return $this->_prixTotal;
   	}
	
	public function dateContrat(){
		return $this->_dateContrat;
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