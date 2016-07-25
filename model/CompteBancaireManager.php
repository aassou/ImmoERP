<?php
class CompteBancaireManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(CompteBancaire $CompteBancaire){
    	$query = $this->_db->prepare(' INSERT INTO t_comptebancaire (
		numero, denomination, dateCreation, created, createdBy)
		VALUES (:numero, :denomination, :dateCreation, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':numero', $CompteBancaire->numero());
        $query->bindValue(':denomination', $CompteBancaire->denomination());
		$query->bindValue(':dateCreation', $CompteBancaire->dateCreation());
		$query->bindValue(':created', $CompteBancaire->created());
		$query->bindValue(':createdBy', $CompteBancaire->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(CompteBancaire $CompteBancaire){
    	$query = $this->_db->prepare('UPDATE t_comptebancaire SET 
		numero=:numero, denomination=:denomination, dateCreation=:dateCreation, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $CompteBancaire->id());
		$query->bindValue(':numero', $CompteBancaire->numero());
        $query->bindValue(':denomination', $CompteBancaire->denomination());
		$query->bindValue(':dateCreation', $CompteBancaire->dateCreation());
		$query->bindValue(':updated', $CompteBancaire->updated());
		$query->bindValue(':updatedBy', $CompteBancaire->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_comptebancaire
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getCompteBancaireById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_comptebancaire
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new CompteBancaire($data);
	}

	public function getCompteBancaires(){
		$CompteBancaires = array();
		$query = $this->_db->query('SELECT * FROM t_comptebancaire ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$CompteBancaires[] = new CompteBancaire($data);
		}
		$query->closeCursor();
		return $CompteBancaires;
	}

	public function getCompteBancairesByLimits($begin, $end){
		$CompteBancaires = array();
		$query = $this->_db->query('SELECT * FROM t_comptebancaire
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$CompteBancaires[] = new CompteBancaire($data);
		}
		$query->closeCursor();
		return $CompteBancaires;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_comptebancaire
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}