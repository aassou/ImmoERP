<?php
class Appartement{
	//attributes
	private $_id;
	private $_nom;
	private $_superficie;
	private $_facade;
	private $_prix;
    private $_montantRevente;
	private $_niveau;
	private $_nombrePiece;
	private $_cave;
	private $_status;
	private $_idProjet;
	private $_par;
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
	
	public function setSuperficie($superficie){
		$this->_superficie = $superficie;
	}
	
	public function setFacade($facade){
		$this->_facade = $facade;
	}
	
	public function setPrix($prix){
		$this->_prix = $prix;
	}
    
    public function setMontantRevente($montantRevente){
        $this->_montantRevente = $montantRevente;
    }
	
	public function setNiveau($niveau){
		$this->_niveau = $niveau;
	}
	
	public function setNombrePiece($nombrePiece){
		$this->_nombrePiece = $nombrePiece;
	}
	
	public function setCave($cave){
		$this->_cave = $cave;
	}
	
	public function setStatus($status){
		$this->_status = $status;
	}
	
	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
	}
	
	public function setPar($par){
		$this->_par = $par;
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
	
	public function superficie(){
		return $this->_superficie;
	}
	
	public function facade(){
		return $this->_facade;
	}
	
	public function prix(){
		return $this->_prix;
	}
    
    public function montantRevente(){
        return $this->_montantRevente;
    }
	
	public function niveau(){
		return $this->_niveau;
	}
	
	public function nombrePiece(){
		return $this->_nombrePiece;
	}
	
	public function cave(){
		return $this->_cave;
	}
	
	public function status(){
		return $this->_status;
	}
	
	public function idProjet(){
		return $this->_idProjet;
	}
	
	public function par(){
		return $this->_par;
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
