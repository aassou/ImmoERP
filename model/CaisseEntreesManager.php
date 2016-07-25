<?php
class CaisseEntreesManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(CaisseEntrees $entree){
        $query = $this->_db->prepare(
        'INSERT INTO t_caisse_entrees (montant, designation, dateOperation, utilisateur)
        VALUES (:montant, :designation, :dateOperation, :utilisateur)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':montant', $entree->montant());
		$query->bindValue(':designation', $entree->designation());
		$query->bindValue(':dateOperation', $entree->dateOperation());
		$query->bindValue(':utilisateur', $entree->utilisateur());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(CaisseEntrees $entree){
		$query = $this->_db->prepare('
		UPDATE t_caisse_entrees SET montant=:montant, designation=:designation, 
		dateOperation=:dateOperation, utilisateur=:utilisateur WHERE id=:idEntrees') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idEntrees', $entree->id());
		$query->bindValue(':montant', $entree->montant());
		$query->bindValue(':designation', $entree->designation());
		$query->bindValue(':dateOperation', $entree->dateOperation());
		$query->bindValue(':utilisateur', $entree->utilisateur());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idEntree){
		$query = $this->_db->prepare('DELETE FROM t_caisse_entrees WHERE id=:idEntree')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idEntree', $idEntree);
		$query->execute();
		$query->closeCursor();
	}

	public function getCaisseEntrees(){
		$caisseEntrees = array();
        $query = $this->_db->query('SELECT * FROM t_caisse_entrees ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$caisseEntrees[] = new CaisseEntrees($data);
        }
        $query->closeCursor();
        return $caisseEntrees;
    }

	public function getCaisseEntreesByLimits($begin, $end){
		$caisseEntrees = array();
        $query = $this->_db->query('SELECT * FROM t_caisse_entrees ORDER BY id DESC LIMIT '.$begin.', '.$end)
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$caisseEntrees[] = new CaisseEntrees($data);
        }
        $query->closeCursor();
        return $caisseEntrees;
    }
    
	public function getCaisseEntreesNumber(){
		$query = $this->_db->query('SELECT COUNT(*) AS numberEntrees FROM t_caisse_entrees')
		or die(print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['numberEntrees'];
	}
	
	public function getTotalCaisseEntrees(){
		$query = $this->_db->query('SELECT SUM(montant) AS total FROM t_caisse_entrees');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $total = $data['total'];
        return $total;
	}
	
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_caisse_entrees ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}
