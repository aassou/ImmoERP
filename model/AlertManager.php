<?php
class AlertManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Alert $alert){
    	$query = $this->_db->prepare(' INSERT INTO t_alert (
		alert, status, created, createdBy)
		VALUES (:alert, :status, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':alert', $alert->alert());
		$query->bindValue(':status', $alert->status());
		$query->bindValue(':created', $alert->created());
		$query->bindValue(':createdBy', $alert->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Alert $alert){
    	$query = $this->_db->prepare(' UPDATE t_alert SET 
		alert=:alert, status=:status, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $alert->id());
		$query->bindValue(':alert', $alert->alert());
		$query->bindValue(':status', $alert->status());
		$query->bindValue(':updated', $alert->updated());
		$query->bindValue(':updatedBy', $alert->updatedBy());
		$query->execute();
		$query->closeCursor();
	}
    
    public function updateStatus($idAlert, $status){
        $query = $this->_db->prepare(
        'UPDATE t_alert SET status=:status WHERE id=:id')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idAlert);
        $query->bindValue(':status', $status);
        $query->execute();
        $query->closeCursor();
    }

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_alert
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getAlertById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_alert
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Alert($data);
	}

	public function getAlerts(){
		$alerts = array();
		$query = $this->_db->query('SELECT * FROM t_alert
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$alerts[] = new Alert($data);
		}
		$query->closeCursor();
		return $alerts;
	}

	public function getAlertsByLimits($begin, $end){
		$alerts = array();
		$query = $this->_db->query('SELECT * FROM t_alert
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$alerts[] = new Alert($data);
		}
		$query->closeCursor();
		return $alerts;
	}
    
    public function getAlertsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS alertNumber FROM t_alert WHERE status=0');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['alertNumber'];
    }

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_alert
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}