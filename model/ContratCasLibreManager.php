<?php
class ContratCasLibreManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ContratCasLibre $contratCasLibre){
    	$query = $this->_db->prepare(' INSERT INTO t_contratcaslibre (
		date, montant, observation, status, codeContrat, created, createdBy)
		VALUES (:date, :montant, :observation, :status, :codeContrat, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':date', $contratCasLibre->date());
		$query->bindValue(':montant', $contratCasLibre->montant());
		$query->bindValue(':observation', $contratCasLibre->observation());
        $query->bindValue(':status', $contratCasLibre->status());
		$query->bindValue(':codeContrat', $contratCasLibre->codeContrat());
		$query->bindValue(':created', $contratCasLibre->created());
		$query->bindValue(':createdBy', $contratCasLibre->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ContratCasLibre $contratCasLibre){
    	$query = $this->_db->prepare(' UPDATE t_contratcaslibre SET 
		date=:date, montant=:montant, observation=:observation, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $contratCasLibre->id());
		$query->bindValue(':date', $contratCasLibre->date());
		$query->bindValue(':montant', $contratCasLibre->montant());
		$query->bindValue(':observation', $contratCasLibre->observation());
		$query->bindValue(':updated', $contratCasLibre->updated());
		$query->bindValue(':updatedBy', $contratCasLibre->updatedBy());
		$query->execute();
		$query->closeCursor();
	}
    
    public function updateStatus($id, $status){
        $query = $this->_db->prepare(
        'UPDATE t_contratcaslibre SET status=:status WHERE id=:id')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->bindValue(':status', $status);
        $query->execute();
        $query->closeCursor();
    }

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_contratcaslibre
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getContratCasLibreById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_contratcaslibre
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ContratCasLibre($data);
	}

	public function getContratCasLibres(){
		$contratCasLibres = array();
		$query = $this->_db->query('SELECT * FROM t_contratcaslibre
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratCasLibres[] = new ContratCasLibre($data);
		}
		$query->closeCursor();
		return $contratCasLibres;
	}
    
    public function getContratCasLibresByCodeContrat($codeContrat){
        $contratCasLibres = array();
        $query = $this->_db->prepare('SELECT * FROM t_contratcaslibre 
        WHERE codeContrat=:codeContrat ORDER BY id ASC');
        $query->bindValue(':codeContrat', $codeContrat);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contratCasLibres[] = new ContratCasLibre($data);
        }
        $query->closeCursor();
        return $contratCasLibres;
    }

	public function getContratCasLibresByLimits($begin, $end){
		$contratCasLibres = array();
		$query = $this->_db->query('SELECT * FROM t_contratcaslibre
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratCasLibres[] = new ContratCasLibre($data);
		}
		$query->closeCursor();
		return $contratCasLibres;
	}
    
    public function getContratCasLibreNumberByCodeContrat($codeContrat){
        $query = $this->_db->prepare(
        'SELECT COUNT(*) AS number FROM t_contratcaslibre 
        WHERE codeContrat=:codeContrat');
        $query->bindValue(':codeContrat', $codeContrat);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['number'];
    }
    
    public function getReglementEnRetard(){
        $reglements = array();
        $query = $this->_db->query('SELECT * FROM t_contratcaslibre 
        WHERE status=0 AND date < CURDATE() ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglements[] = new ContratCasLibre($data);
        }
        $query->closeCursor();
        return $reglements;
    }
    
    public function getReglementToday(){
        $reglements = array();
        $query = $this->_db->query('SELECT * FROM t_contratcaslibre 
        WHERE status=0 AND date = CURDATE() ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglements[] = new ContratCasLibre($data);
        }
        $query->closeCursor();
        return $reglements;
    }
    
    public function getReglementWeek(){
        $reglements = array();
        $query = $this->_db->query('SELECT * FROM t_contratcaslibre 
        WHERE status=0 AND ( date BETWEEN ADDDATE(CURDATE(), 1) AND ADDDATE(CURDATE(), 7) ) ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglements[] = new ContratCasLibre($data);
        }
        $query->closeCursor();
        return $reglements;
    }
    
    public function getReglementMonth(){
        $reglements = array();
        $query = $this->_db->query('SELECT * FROM t_contratcaslibre 
        WHERE status=0 AND ( date BETWEEN ADDDATE(CURDATE(), 1) AND ADDDATE(CURDATE(), 31) ) ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglements[] = new ContratCasLibre($data);
        }
        $query->closeCursor();
        return $reglements;
    }

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_contratcaslibre
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}