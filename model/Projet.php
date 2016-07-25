<?php
/**
 * This is a Model class for the project component
 * Created By : AASSOU Abdelilah
 * Date       : 03/11/2015
 * Github     : @aassou
 * email      : aassou.abdelilah@gmail.com
 */
class Projet{

    //attributes
    private $_id;
    private $_nom;
    private $_nomArabe;
    private $_titre;
    private $_adresse;
    private $_adresseArabe;
    private $_superficie;
    private $_description;
    private $_budget;
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
    
    public function setNomArabe($nomArabe){
        $this->_nomArabe = $nomArabe;
    }
    
    public function setTitre($titre){
        $this->_titre = $titre;
    }
    
    public function setAdresse($adresse){
        $this->_adresse = $adresse;
    }
    
    public function setAdresseArabe($adresseArabe){
        $this->_adresseArabe = $adresseArabe;
    }
    
    public function setSuperficie($superficie){
        $this->_superficie = $superficie;
    }
    
    public function setDescription($description){
        $this->_description = $description;
    }
    
    public function setBudget($budget){
        $this->_budget = $budget;
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
    
    public function nomArabe(){
        return $this->_nomArabe;
    }
    
    public function titre(){
        return $this->_titre;
    }
    
    public function adresse(){
        return $this->_adresse;
    }
    
    public function adresseArabe(){
        return $this->_adresseArabe;
    }
    
    public function superficie(){
        return $this->_superficie;
    }
    
    public function description(){
        return $this->_description;
    }
    
    public function budget(){
        return $this->_budget;
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