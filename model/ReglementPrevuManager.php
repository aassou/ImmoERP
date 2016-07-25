<?php
class ReglementPrevuManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ReglementPrevu $reglementPrevu){
    	$query = $this->_db->prepare(' INSERT INTO t_reglementprevu (
		datePrevu, codeContrat, status, created, createdBy)
		VALUES (:datePrevu, :codeContrat, :status, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':datePrevu', $reglementPrevu->datePrevu());
		$query->bindValue(':codeContrat', $reglementPrevu->codeContrat());
		$query->bindValue(':status', $reglementPrevu->status());
		$query->bindValue(':created', $reglementPrevu->created());
		$query->bindValue(':createdBy', $reglementPrevu->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ReglementPrevu $reglementPrevu){
    	$query = $this->_db->prepare(' UPDATE t_reglementprevu SET 
		datePrevu=:datePrevu, codeContrat=:codeContrat, status=:status, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $reglementPrevu->id());
		$query->bindValue(':datePrevu', $reglementPrevu->datePrevu());
		$query->bindValue(':codeContrat', $reglementPrevu->codeContrat());
		$query->bindValue(':status', $reglementPrevu->status());
		$query->bindValue(':updated', $reglementPrevu->updated());
		$query->bindValue(':updatedBy', $reglementPrevu->updatedBy());
		$query->execute();
		$query->closeCursor();
	}
    
    public function updateStatus($id, $status){
        $query = $this->_db->prepare(' UPDATE t_reglementprevu SET status=:status WHERE id=:id')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->bindValue(':status', $status);
        $query->execute();
        $query->closeCursor();
    }

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_reglementprevu
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}
    
    public function deleteByCodeContrat($codeContrat){
        $query = $this->_db->prepare('DELETE FROM t_reglementprevu WHERE codeContrat=:codeContrat')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':codeContrat', $codeContrat);
        $query->execute();
        $query->closeCursor();
    }

	public function getReglementPrevuById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_reglementprevu
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ReglementPrevu($data);
	}

	public function getReglementPrevus(){
		$reglementPrevus = array();
		$query = $this->_db->query('SELECT * FROM t_reglementprevu
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$reglementPrevus[] = new ReglementPrevu($data);
		}
		$query->closeCursor();
		return $reglementPrevus;
	}

	public function getReglementPrevusByLimits($begin, $end){
		$reglementPrevus = array();
		$query = $this->_db->query('SELECT * FROM t_reglementprevu
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$reglementPrevus[] = new ReglementPrevu($data);
		}
		$query->closeCursor();
		return $reglementPrevus;
	}
    
    public function getReglementPrevuByCodeContrat($codeContrat){
        $reglementsPrevus = array();
        $query = $this->_db->prepare('SELECT * FROM t_reglementprevu 
        WHERE codeContrat=:codeContrat ORDER BY id ASC');
        $query->bindValue(':codeContrat', $codeContrat);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglementsPrevus[] = new ReglementPrevu($data);
        }
        $query->closeCursor();
        return $reglementsPrevus;
    }
    
    public function getReglementNumberByCodeContrat($codeContrat){
        $query = $this->_db->prepare(
        'SELECT COUNT(*) AS number FROM t_reglementprevu 
        WHERE codeContrat=:codeContrat');
        $query->bindValue(':codeContrat', $codeContrat);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['number'];
    }
    
    public function getReglementPrevuEnRetard(){
        $reglementsPrevus = array();
        $query = $this->_db->query('SELECT * FROM t_reglementprevu 
        WHERE status=0 AND datePrevu < CURDATE() ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglementsPrevus[] = new ReglementPrevu($data);
        }
        $query->closeCursor();
        return $reglementsPrevus;
    }
    
    public function getReglementPrevuToday(){
        $reglementsPrevus = array();
        $query = $this->_db->query('SELECT * FROM t_reglementprevu 
        WHERE status=0 AND datePrevu = CURDATE() ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglementsPrevus[] = new ReglementPrevu($data);
        }
        $query->closeCursor();
        return $reglementsPrevus;
    }
    
    public function getReglementPrevuWeek(){
        $reglementsPrevus = array();
        $query = $this->_db->query('SELECT * FROM t_reglementprevu 
        WHERE status=0 AND ( datePrevu BETWEEN ADDDATE(CURDATE(), 1) AND ADDDATE(CURDATE(), 7) ) ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglementsPrevus[] = new ReglementPrevu($data);
        }
        $query->closeCursor();
        return $reglementsPrevus;
    }
    
    public function getReglementPrevuMonth(){
        $reglementsPrevus = array();
        $query = $this->_db->query('SELECT * FROM t_reglementprevu 
        WHERE status=0 AND ( datePrevu BETWEEN ADDDATE(CURDATE(), 1) AND ADDDATE(CURDATE(), 31) ) ORDER BY codeContrat');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $reglementsPrevus[] = new ReglementPrevu($data);
        }
        $query->closeCursor();
        return $reglementsPrevus;
    }

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_reglementprevu
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}