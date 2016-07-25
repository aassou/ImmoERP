<?php
class Livraison{
    //attributes
    private $_id;
    private $_libelle;
    private $_designation;
    private $_type;
    private $_status;
    private $_quantite;
    private $_prixUnitaire;
    private $_paye;
    private $_reste;
    private $_dateLivraison;
    private $_modePaiement;
    private $_idFournisseur;
    private $_idProjet;
	private $_code;
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
    
    public function setLibelle($libelle){
        $this->_libelle = $libelle;
    }
    
    public function setDesignation($designation){
        $this->_designation = $designation;
    }
    
    public function setType($type){
        $this->_type = $type;
    }
    
    public function setStatus($status){
        $this->_status = $status;
    }
    
    public function setQuantite($quantite){
        $this->_quantite = (float) $quantite;
    }
    
    public function setPrixUnitaire($prixUnitaire){
        $this->_prixUnitaire = (float) $prixUnitaire;
    }
    
    public function setPaye($paye){
        $this->_paye = (float) $paye;
    }
    
    public function setReste($reste){
        $this->_reste = (float) $reste;
    }
    
    public function setDateLivraison($dateLivraison){
        $this->_dateLivraison = $dateLivraison;
    }
    
    public function setModePaiement($modePaiement){
        $this->_modePaiement = $modePaiement;
    }
    
    public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
    
    public function setIdFournisseur($idFournisseur){
        $this->_idFournisseur = $idFournisseur;
    }
    
	public function setCode($code){
        $this->_code = $code;
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
    
    public function libelle(){
        return $this->_libelle;
    }
    
    public function designation(){
        return $this->_designation;
    }
    
    public function type(){
        return $this->_type;
    }
    
    public function status(){
        return $this->_status;
    }
    
    public function quantite(){
        return $this->_quantite;
    }
    
    public function prixUnitaire(){
        return $this->_prixUnitaire;
    }
    
    public function paye(){
        return $this->_paye;
    }
    
    public function reste(){
        return $this->_reste;
    }
    
    public function dateLivraison(){
        return $this->_dateLivraison;
    }
    
    public function modePaiement(){
        return $this->_modePaiement;
    }
    
    public function idFournisseur(){
        return $this->_idFournisseur;
    }
    
    public function idProjet(){
        return $this->_idProjet;
    }
    
	public function code(){
        return $this->_code;
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
