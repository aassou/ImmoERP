<?php
class ContratDetailsManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ContratDetails $contratDetails){
    	$query = $this->_db->prepare(' INSERT INTO t_contratdetails (
		dateOperation, montant, numeroCheque, idContratEmploye, created, createdBy)
		VALUES (:dateOperation, :montant, :numeroCheque, :idContratEmploye, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOperation', $contratDetails->dateOperation());
		$query->bindValue(':montant', $contratDetails->montant());
		$query->bindValue(':numeroCheque', $contratDetails->numeroCheque());
		$query->bindValue(':idContratEmploye', $contratDetails->idContratEmploye());
		$query->bindValue(':created', $contratDetails->created());
		$query->bindValue(':createdBy', $contratDetails->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ContratDetails $contratDetails){
    	$query = $this->_db->prepare(' UPDATE t_contratdetails SET 
		dateOperation=:dateOperation, montant=:montant, numeroCheque=:numeroCheque WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $contratDetails->id());
		$query->bindValue(':dateOperation', $contratDetails->dateOperation());
		$query->bindValue(':montant', $contratDetails->montant());
		$query->bindValue(':numeroCheque', $contratDetails->numeroCheque());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_contratdetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getContratDetailsById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_contratdetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ContratDetails($data);
	}

	public function getContratDetails(){
		$contratDetails = array();
		$query = $this->_db->query('SELECT * FROM t_contratdetails
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratDetails[] = new ContratDetails($data);
		}
		$query->closeCursor();
		return $contratDetails;
	}
    
    public function getContratDetailsByIdContratEmploye($idContratEmploye){
        $contratDetails = array();
        $query = $this->_db->prepare('SELECT * FROM t_contratdetails WHERE idContratEmploye=:idContratEmploye
        ORDER BY id DESC');
        $query->bindValue(':idContratEmploye', $idContratEmploye);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contratDetails[] = new ContratDetails($data);
        }
        $query->closeCursor();
        return $contratDetails;
    }
    
    public function getContratDetailsTotalByIdContratEmploye($idContratEmploye){
        $query = $this->_db->prepare('SELECT SUM(montant) AS total FROM t_contratdetails WHERE idContratEmploye=:idContratEmploye');
        $query->bindValue(':idContratEmploye', $idContratEmploye);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $total = $data['total'];
        return $total;
    }

	public function getContratDetailsByLimits($begin, $end){
		$contratDetailss = array();
		$query = $this->_db->query('SELECT * FROM t_contratdetails
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratDetails[] = new ContratDetails($data);
		}
		$query->closeCursor();
		return $contratDetails;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_contratdetails
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}