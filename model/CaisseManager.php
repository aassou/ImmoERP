<?php
class CaisseManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Caisse $caisse){
    	$query = $this->_db->prepare(' INSERT INTO t_caisse (
		type, dateOperation, montant, designation, destination, companyID, created, createdBy)
		VALUES (:type, :dateOperation, :montant, :designation, :destination, :companyID, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':type', $caisse->type());
		$query->bindValue(':dateOperation', $caisse->dateOperation());
		$query->bindValue(':montant', $caisse->montant());
		$query->bindValue(':designation', $caisse->designation());
		$query->bindValue(':destination', $caisse->destination());
        $query->bindValue(':companyID', $caisse->companyID());
		$query->bindValue(':created', $caisse->created());
		$query->bindValue(':createdBy', $caisse->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Caisse $caisse){
    	$query = $this->_db->prepare(' UPDATE t_caisse SET 
		type=:type, dateOperation=:dateOperation, montant=:montant, designation=:designation, 
		destination=:destination, companyID=:companyID, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $caisse->id());
		$query->bindValue(':type', $caisse->type());
		$query->bindValue(':dateOperation', $caisse->dateOperation());
		$query->bindValue(':montant', $caisse->montant());
		$query->bindValue(':designation', $caisse->designation());
		$query->bindValue(':destination', $caisse->destination());
        $query->bindValue(':companyID', $caisse->companyID());
		$query->bindValue(':updated', $caisse->updated());
		$query->bindValue(':updatedBy', $caisse->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_caisse
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getCaisseById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_caisse WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Caisse($data);
	}
    
    public function getTotalCaisseByType( $type, $companyID ) {
        $query = $this->_db->prepare(
        "SELECT SUM(montant) as total FROM t_caisse 
        WHERE companyID=:companyID
        AND type=:type")
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':companyID', $companyID);
        $query->bindValue(':type', $type);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
    
    public function getTotalCaisseByTypeByMonthYear($type, $month, $year, $companyID) {
        $query = $this->_db->prepare(
        "SELECT SUM(montant) as total FROM t_caisse 
        WHERE companyID=:companyID 
        AND type=:type 
        AND MONTH(dateOperation)=:month 
        AND YEAR(dateOperation)=:year")
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':companyID', $companyID);
        $query->bindValue(':type', $type);
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    } 
    
    public function getTotalCaisseByTypeByDate($type, $dateFrom, $dateTo, $companyID){
        $query = $this->_db->prepare(
        "SELECT SUM(montant) as total FROM t_caisse 
        WHERE companyID=:companyID
        AND type=:type 
        AND dateOperation BETWEEN :dateFrom AND :dateTo")
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':companyID', $companyID);
        $query->bindValue(':type', $type);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }

	public function getCaisses(){
		$caisses = array();
		$query = $this->_db->query('SELECT * FROM t_caisse ORDER BY type ASC, dateOperation DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$caisses[] = new Caisse($data);
		}
		$query->closeCursor();
		return $caisses;
	}
    
    //Show By Criteria
    public function getCaissesByType($type){
        $caisses = array();
        $query = $this->_db->prepare('SELECT * FROM t_caisse WHERE type=:type ORDER BY dateOperation');
        $query->bindValue(':type', $type);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $caisses[] = new Caisse($data);
        }
        $query->closeCursor();
        return $caisses;
    }
    
    public function getCaissesByDates($dateFrom, $dateTo, $companyID){
        $caisses = array();
        $query = $this->_db->prepare(
        'SELECT * FROM t_caisse WHERE
        companyID=:companyID 
        AND dateOperation BETWEEN :dateFrom AND :dateTo 
        ORDER BY dateOperation DESC');
        $query->bindValue(':companyID', $companyID);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $caisses[] = new Caisse($data);
        }
        $query->closeCursor();
        return $caisses;
    }
    
    public function getCaissesByDatesByType($dateFrom, $dateTo, $type, $companyID){
        $caisses = array();
        $query = $this->_db->prepare(
        'SELECT * FROM t_caisse 
        WHERE companyID=:companyID
        AND type=:type
        AND dateOperation BETWEEN :dateFrom AND :dateTo ORDER BY dateOperation DESC');
        $query->bindValue(':companyID', $companyID);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->bindValue(':type', $type);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $caisses[] = new Caisse($data);
        }
        $query->closeCursor();
        return $caisses;
    }
    
	public function getCaissesByLimits($begin, $end){
		$caisses = array();
		$query = $this->_db->query('SELECT * FROM t_caisse
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$caisses[] = new Caisse($data);
		}
		$query->closeCursor();
		return $caisses;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_caisse
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

    public function getCaissesGroupByMonth($companyID){
        $caisses = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_caisse 
        WHERE companyID=:companyID
        GROUP BY MONTH(dateOperation), YEAR(dateOperation)
        ORDER BY dateOperation DESC");
        $query->bindValue(':companyID', $companyID);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $caisses[] = new Caisse($data);
        }
        $query->closeCursor();
        return $caisses;
    }
    
    public function getCaissesByMonthYear($month, $year, $companyID){
        $caisses = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_caisse 
        WHERE companyID=:companyID
        AND MONTH(dateOperation) = :month
        AND YEAR(dateOperation) = :year
        ORDER BY dateOperation DESC");
        $query->bindValue(':companyID', $companyID);
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $caisses[] = new Caisse($data);
        }
        $query->closeCursor();
        return $caisses;
    }
    
    public function getTotalCaissesByMonthYearByType($month, $year, $type, $companyID){
        $query = $this->_db->prepare(
        "SELECT SUM(montant) AS total FROM t_caisse 
        WHERE companyID=:companyID
        AND MONTH(dateOperation) = :month
        AND YEAR(dateOperation) = :year
        AND type=:type
        ORDER BY dateOperation DESC");
        $query->bindValue(':companyID', $companyID);
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->bindValue(':type', $type);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }

}