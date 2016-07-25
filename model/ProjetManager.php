<?php
/**
 * This is a ModelManager class for the Project component
 * Created By : AASSOU Abdelilah
 * Date       : 03/11/2015
 * Github     : @aassou
 * email      : aassou.abdelilah@gmail.com
 */
class ProjetManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Projet $projet){
        $query = $this->_db->prepare(
        'INSERT INTO t_projet (nom, nomArabe, titre, adresse, adresseArabe, superficie, description, budget, createdBy, created)
        VALUES (:nom, :nomArabe, :titre, :adresse, :adresseArabe, :superficie, :description, :budget, :createdBy, :created)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':nom', $projet->nom());
        $query->bindValue(':nomArabe', $projet->nomArabe());
        $query->bindValue(':titre', $projet->titre());
        $query->bindValue(':adresse', $projet->adresse());
        $query->bindValue(':adresseArabe', $projet->adresseArabe());
        $query->bindValue(':superficie', $projet->superficie());
        $query->bindValue(':description', $projet->description());
        $query->bindValue(':budget', $projet->budget());
        $query->bindValue(':created', $projet->created());
        $query->bindValue(':createdBy', $projet->createdBy());
        $query->execute();
        $query->closeCursor();
    }
    
    public function update(Projet $projet){
        $query = $this->_db->prepare(
        'UPDATE t_projet SET nom=:nom, nomArabe=:nomArabe, titre=:titre, adresse=:adresse, 
        adresseArabe=:adresseArabe, superficie=:superficie, description=:description, 
        budget=:budget, updatedBy=:updatedBy, updated=:updated WHERE id=:id')
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $projet->id());
        $query->bindValue(':nom', $projet->nom());
        $query->bindValue(':nomArabe', $projet->nomArabe());
        $query->bindValue(':titre', $projet->titre());
        $query->bindValue(':adresse', $projet->adresse());
        $query->bindValue(':adresseArabe', $projet->adresseArabe());
        $query->bindValue(':description', $projet->description());
        $query->bindValue(':superficie', $projet->superficie());
        $query->bindValue(':budget', $projet->budget());
        $query->bindValue(':updated', $projet->updated());
        $query->bindValue(':updatedBy', $projet->updatedBy());
        $query->execute();
        $query->closeCursor();
    }
	
	public function delete($idProjet){
		$query = $this->_db->prepare('DELETE FROM t_projet WHERE id=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getProjetsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS projectNumbers FROM t_projet');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['projectNumbers'];
    }
    
    public function getProjetNameById($id){
        $query = $this->_db->prepare('SELECT nom FROM t_projet WHERE id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nom'];
    }
    
	public function getProjetBySearch($recherche){
		$query = $this->_db->prepare("SELECT id FROM t_projet WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:recherche, ' ', '')");
		$query->bindValue(':recherche', $recherche);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['id'];
	}
	
	public function getProjetsIds(){
		$projetsId = array();
        $query = $this->_db->query('SELECT id FROM t_projet ORDER BY id ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $projetsId[] = $data['id'];
        }
        $query->closeCursor();
        return $projetsId;
	}
	
    public function getProjets(){
        $projets = array();
        $query = $this->_db->query('SELECT * FROM t_projet ORDER BY cast(nom as unsigned)');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $projets[] = new Projet($data);
        }
        $query->closeCursor();
        return $projets;
    }
	
	public function getProjetsByLimits($begin, $end){
        $projets = array();
        $query = $this->_db->query('SELECT * FROM t_projet ORDER BY id DESC LIMIT '.$begin.' , '.$end);
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $projets[] = new Projet($data);
        }
        $query->closeCursor();
        return $projets;
    }
    
    public function getProjetById($id){
        $query = $this->_db->prepare('SELECT * FROM t_projet WHERE id=:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Projet($data);
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_projet ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($nomProjet){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_projet WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nomProjet, ' ', '') ");
        $query->execute(array(':nomProjet' => $nomProjet));
        //get result
        return $query->fetchColumn();
    }
}