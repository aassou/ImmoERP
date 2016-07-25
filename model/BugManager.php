<?php
class BugManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Bug $bug){
    	$query = $this->_db->prepare(' INSERT INTO t_bug (
		bug, lien, status, created, createdBy)
		VALUES (:bug, :lien, :status, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':bug', $bug->bug());
		$query->bindValue(':lien', $bug->lien());
		$query->bindValue(':status', $bug->status());
		$query->bindValue(':created', $bug->created());
		$query->bindValue(':createdBy', $bug->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Bug $bug){
    	$query = $this->_db->prepare(' UPDATE t_bug SET 
		bug=:bug, lien=:lien, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $bug->id());
		$query->bindValue(':bug', $bug->bug());
		$query->bindValue(':lien', $bug->lien());
		$query->bindValue(':updated', $bug->updated());
		$query->bindValue(':updatedBy', $bug->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_bug
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getBugById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_bug
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Bug($data);
	}

	public function getBugs(){
		$bugs = array();
		$query = $this->_db->query('SELECT * FROM t_bug
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$bugs[] = new Bug($data);
		}
		$query->closeCursor();
		return $bugs;
	}

	public function getBugsByLimits($begin, $end){
		$bugs = array();
		$query = $this->_db->query('SELECT * FROM t_bug
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$bugs[] = new Bug($data);
		}
		$query->closeCursor();
		return $bugs;
	}
    
    public function getBugsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS bugNumber FROM t_bug WHERE status=0');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['bugNumber'];
    }
    
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_bug
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}