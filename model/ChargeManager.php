<?php
class ChargeManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Charge $charge){
    	$query = $this->_db->prepare(' INSERT INTO t_charge (
		type, dateOperation, montant, societe, designation, idProjet, created, createdBy)
		VALUES (:type, :dateOperation, :montant, :societe, :designation, :idProjet, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':type', $charge->type());
		$query->bindValue(':dateOperation', $charge->dateOperation());
		$query->bindValue(':montant', $charge->montant());
		$query->bindValue(':societe', $charge->societe());
		$query->bindValue(':designation', $charge->designation());
		$query->bindValue(':idProjet', $charge->idProjet());
		$query->bindValue(':created', $charge->created());
		$query->bindValue(':createdBy', $charge->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Charge $charge){
    	$query = $this->_db->prepare(' UPDATE t_charge SET 
		type=:type, dateOperation=:dateOperation, montant=:montant, 
		societe=:societe, designation=:designation, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $charge->id());
		$query->bindValue(':type', $charge->type());
		$query->bindValue(':dateOperation', $charge->dateOperation());
		$query->bindValue(':montant', $charge->montant());
		$query->bindValue(':societe', $charge->societe());
		$query->bindValue(':designation', $charge->designation());
		$query->bindValue(':updated', $charge->updated());
		$query->bindValue(':updatedBy', $charge->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_charge
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getChargeById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_charge
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Charge($data);
	}

	public function getCharges(){
		$charges = array();
		$query = $this->_db->query('SELECT * FROM t_charge
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$charges[] = new Charge($data);
		}
		$query->closeCursor();
		return $charges;
	}
    
    public function getChargesByIdProjet($idProjet){
        $charges = array();
        $query = $this->_db->prepare('SELECT * FROM t_charge WHERE idProjet=:idProjet ORDER BY dateOperation DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new Charge($data);
        }
        $query->closeCursor();
        return $charges;
    }
    
    public function getChargesByIdProjetByType($idProjet, $type){
        $charges = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_charge 
        WHERE idProjet=:idProjet 
        AND type=:type 
        ORDER BY dateOperation");
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':type', $type);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new Charge($data);
        }
        $query->closeCursor();
        return $charges;
    }
    
    public function getChargesByGroupByIdProjet($idProjet){
        $charges = array();
        $query = $this->_db->prepare('SELECT id, type, SUM(montant) AS montant FROM t_charge WHERE idProjet=:idProjet GROUP BY type');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new Charge($data);
        }
        $query->closeCursor();
        return $charges;
    }

	public function getChargesByLimits($begin, $end){
		$charges = array();
		$query = $this->_db->query('SELECT * FROM t_charge
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$charges[] = new Charge($data);
		}
		$query->closeCursor();
		return $charges;
	}
    
    public function getChargesByIdProjetByDates($idProjet, $dateFrom, $dateTo){
        $charges = array();
        $query = $this->_db->prepare('SELECT * FROM t_charge WHERE idProjet=:idProjet
        AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY dateOperation DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new Charge($data);
        }
        $query->closeCursor();
        return $charges;
    }
    
    public function getChargesByIdProjetByDatesByType($idProjet, $dateFrom, $dateTo, $type){
        $charges = array();
        $query = $this->_db->prepare('SELECT * FROM t_charge WHERE idProjet=:idProjet AND type=:type
        AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY dateOperation DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->bindValue(':type', $type);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $charges[] = new Charge($data);
        }
        $query->closeCursor();
        return $charges;
    }
    
    public function getTotalByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_charge WHERE idProjet=:idProjet');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotal(){
        $query = $this->_db->query('SELECT SUM(montant) as total FROM t_charge');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotalByIdProjetByType($idProjet, $type){
        $query = $this->_db->prepare(
        'SELECT SUM(montant) as total FROM t_charge WHERE idProjet=:idProjet AND type=:type');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':type', $type);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotalByIdProjetByDates($idProjet, $dateFrom, $dateTo){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_charge 
        WHERE idProjet=:idProjet AND dateOperation BETWEEN :dateFrom AND :dateTo ');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotalByIdProjetByDatesByType($idProjet, $dateFrom, $dateTo, $type){
        $query = $this->_db->prepare('SELECT SUM(montant) as total FROM t_charge 
        WHERE idProjet=:idProjet AND type=:type AND dateOperation BETWEEN :dateFrom AND :dateTo ');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->bindValue(':type', $type);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_charge
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}