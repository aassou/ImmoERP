<?php
class ContratTravailReglementManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ContratTravailReglement $contratTravailReglement){
    	$query = $this->_db->prepare(' INSERT INTO t_contratTravailReglement (
		montant,motif,dateReglement,idContratTravail)
		VALUES (:montant,:motif,:dateReglement,:idContratTravail)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':montant', $contratTravailReglement->montant());
		$query->bindValue(':motif', $contratTravailReglement->motif());
		$query->bindValue(':dateReglement', $contratTravailReglement->dateReglement());
		$query->bindValue(':idContratTravail', $contratTravailReglement->idContratTravail());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ContratTravailReglement $contratTravailReglement){
    	$query = $this->_db->prepare(' UPDATE t_contratTravailReglement SET 
		montant=:montant,motif=:motif,dateReglement=:dateReglement,idContratTravail=:idContratTravail
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $contratTravailReglement->id());
		$query->bindValue(':montant', $contratTravailReglement->montant());
		$query->bindValue(':motif', $contratTravailReglement->motif());
		$query->bindValue(':dateReglement', $contratTravailReglement->dateReglement());
		$query->bindValue(':idContratTravail', $contratTravailReglement->idContratTravail());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_contratTravailReglement
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getContratTravailReglementById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_contratTravailReglement
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ContratTravailReglement($data);
	}

	public function getContratTravailReglements(){
		$contratTravailReglements = array();
		$query = $this->_db->query('SELECT * FROM t_contratTravailReglement
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratTravailReglements[] = new ContratTravailReglement($data);
		}
		$query->closeCursor();
		return $contratTravailReglements;
	}
	public function getContratTravailReglementsByLimits($begin, $end){
		$contratTravailReglements = array();
		$query = $this->_db->query('SELECT * FROM t_contratTravailReglement
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratTravailReglements[] = new ContratTravailReglement($data);
		}
		$query->closeCursor();
		return $contratTravailReglements;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_contratTravailReglement
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}