<?php
class Operation{
    //attributes
    private $_id;
    private $_reference;
    private $_date;
    private $_dateReglement;
    private $_compteBancaire;
    private $_observation;
    private $_montant;
	private $_modePaiement;
    private $_idContrat;
	private $_numeroCheque;
    private $_status;
    private $_url;
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
    
    public function setReference($reference){
        $this->_reference = $reference;
    } 
    
    public function setDate($date){
        $this->_date = $date;
    }
    
    public function setDateReglement($dateReglement){
        $this->_dateReglement = $dateReglement;
    }
    
    public function setCompteBancaire($compteBancaire){
        $this->_compteBancaire = $compteBancaire;
    }
    
    public function setObservation($observation){
        $this->_observation = $observation;
    }
    
    public function setMontant($montant){
        $this->_montant = $montant;
    }
	
	public function setModePaiement($modePaiement){
        $this->_modePaiement = $modePaiement;
    }
    
    public function setIdContrat($idContrat){
        $this->_idContrat = $idContrat;
    }
	
	public function setNumeroCheque($numeroCheque){
        $this->_numeroCheque = $numeroCheque;
    }
    
    public function setStatus($status){
        $this->_status = $status;
    }
    
    public function setUrl($url){
        $this->_url = $url;
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
    
    public function date(){
        return $this->_date;
    }
    
    public function dateReglement(){
        return $this->_dateReglement;
    }
    
    public function compteBancaire(){
        return $this->_compteBancaire;
    }
    
    public function observation(){
        return $this->_observation;
    }
    
    public function montant(){
        return $this->_montant;
    }
    
	public function modePaiement(){
        return $this->_modePaiement;
    }
	
    public function idContrat(){
        return $this->_idContrat;
    }
	
	public function numeroCheque(){
        return $this->_numeroCheque;
    }
    
    public function status(){
        return $this->_status;
    }
    
    public function url(){
        return $this->_url;
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
