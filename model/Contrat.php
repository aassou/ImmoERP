<?php
class Contrat{
        
    //attributes
    private $_id;
    private $_reference;
	private $_numero;
    private $_dateCreation;
    private $_prixVente;
    private $_prixVenteArabe;
    private $_avance;
    private $_avanceArabe;
	private $_modePaiement;
	private $_dureePaiement;
    private $_nombreMois;
    private $_echeance;
    private $_note;
    private $_imageNote;
    private $_idClient;
    private $_idProjet;
    private $_idBien;
	private $_typeBien;
	private $_code;
	private $_status;
    private $_revendre;
	private $_numeroCheque;
    private $_societeArabe;
    private $_etatBienArabe;
    private $_facadeArabe;
    private $_articlesArabes;
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
	
	public function setNumero($numero){
        $this->_numero = $numero;
    }
    
    public function setDateCreation($dateCreation){
        $this->_dateCreation = $dateCreation;
    }
    
    public function setPrixVente($prixVente){
        $this->_prixVente = $prixVente;
    }
    
    public function setPrixVenteArabe($prixVenteArabe){
        $this->_prixVenteArabe = $prixVenteArabe;
    }
    
    public function setAvance($avance){
        $this->_avance = $avance;
    }
    
    public function setAvanceArabe($avanceArabe){
        $this->_avanceArabe = $avanceArabe;
    }
    
	public function setModePaiement($modePaiement){
        $this->_modePaiement = $modePaiement;
    }
	
	public function setDureePaiement($dureePaiement){
        $this->_dureePaiement = $dureePaiement;
    }
    
    public function setNombreMois($nombreMois){
        $this->_nombreMois = $nombreMois;
    }
	
	public function setEcheance($echeance){
        $this->_echeance = $echeance;
    }
    
    public function setNote($note){
        $this->_note = $note;
    }
    
    public function setImageNote($imageNote){
        $this->_imageNote = $imageNote;
    }
    
    public function setIdClient($idClient){
        $this->_idClient = $idClient;
    }
    
    public function setIdProjet($idProjet){
        $this->_idProjet = $idProjet;
    }
    
    public function setIdBien($idBien){
        $this->_idBien = $idBien;
    }
	
	public function setTypeBien($typeBien){
        $this->_typeBien = $typeBien;
    }
	
	public function setCode($code){
        $this->_code = $code;
    }
	
	public function setStatus($status){
        $this->_status = $status;
    }
    
    public function setRevendre($revendre){
        $this->_revendre = $revendre;
    }
	
	public function setNumeroCheque($numeroCheque){
        $this->_numeroCheque = $numeroCheque;
    }
    
    public function setSocieteArabe($societeArabe){
        $this->_societeArabe = $societeArabe;
    }
    
    public function setEtatBienArabe($etatBienArabe){
        $this->_etatBienArabe = $etatBienArabe;
    }
    
    public function setFacadeArabe($facadeArabe){
        $this->_facadeArabe = $facadeArabe;
    }
    
    public function setArticlesArabes($articlesArabes){
        $this->_articlesArabes = $articlesArabes;
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
    
	public function numero(){
        return $this->_numero;
    }
    
    public function dateCreation(){
        return $this->_dateCreation;
    }
    
    public function prixVente(){
        return $this->_prixVente;
    }
    
    public function prixVenteArabe(){
        return $this->_prixVenteArabe;
    }
    
    public function avance(){
        return $this->_avance;
    }
    
    public function avanceArabe(){
        return $this->_avanceArabe;
    }
    
	public function modePaiement(){
        return $this->_modePaiement;
    }
	
	public function dureePaiement(){
        return $this->_dureePaiement;
    }
	
    public function nombreMois(){
        return $this->_nombreMois;
    }
    
    public function echeance(){
        return $this->_echeance;
    }
    
    public function note(){
        return $this->_note;
    }
    
    public function imageNote(){
        return $this->_imageNote;
    }
    
    public function idClient(){
        return $this->_idClient;
    }
    
    public function idProjet(){
        return $this->_idProjet;
    }
    
    public function idBien(){
        return $this->_idBien;
    }
	
	public function typeBien(){
        return $this->_typeBien;
    }
	
	public function code(){
        return $this->_code;
    }
	
	public function status(){
        return $this->_status;
    }
	
    public function revendre(){
        return $this->_revendre;
    }
    
	public function numeroCheque(){
        return $this->_numeroCheque;
    }
    
    public function societeArabe(){
        return $this->_societeArabe;
    }
    
    public function etatBienArabe(){
        return $this->_etatBienArabe;
    }
    
    public function facadeArabe(){
        return $this->_facadeArabe;
    }
    
    public function articlesArabes(){
        return $this->_articlesArabes;
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
