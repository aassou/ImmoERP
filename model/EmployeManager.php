<?php
class EmployeManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Employe $employe){
    	$query = $this->_db->prepare(' INSERT INTO t_employe (
		nom, adresse, nomArabe, adresseArabe, cin, telephone, created, createdBy)
		VALUES (:nom, :adresse, :nomArabe, :adresseArabe, :cin, :telephone, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $employe->nom());
		$query->bindValue(':adresse', $employe->adresse());
		$query->bindValue(':nomArabe', $employe->nomArabe());
		$query->bindValue(':adresseArabe', $employe->adresseArabe());
		$query->bindValue(':cin', $employe->cin());
		$query->bindValue(':telephone', $employe->telephone());
		$query->bindValue(':created', $employe->created());
		$query->bindValue(':createdBy', $employe->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Employe $employe){
    	$query = $this->_db->prepare(' UPDATE t_employe SET 
		nom=:nom, adresse=:adresse, nomArabe=:nomArabe, adresseArabe=:adresseArabe, cin=:cin, telephone=:telephone, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $employe->id());
		$query->bindValue(':nom', $employe->nom());
		$query->bindValue(':adresse', $employe->adresse());
		$query->bindValue(':nomArabe', $employe->nomArabe());
		$query->bindValue(':adresseArabe', $employe->adresseArabe());
		$query->bindValue(':cin', $employe->cin());
		$query->bindValue(':telephone', $employe->telephone());
		$query->bindValue(':updated', $employe->updated());
		$query->bindValue(':updatedBy', $employe->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_employe WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getEmployeById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_employe WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Employe($data);
	}

	public function getEmployes(){
		$employes = array();
		$query = $this->_db->query('SELECT * FROM t_employe
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$employes[] = new Employe($data);
		}
		$query->closeCursor();
		return $employes;
	}

	public function getEmployesByLimits($begin, $end){
		$employes = array();
		$query = $this->_db->query('SELECT * FROM t_employe
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$employes[] = new Employe($data);
		}
		$query->closeCursor();
		return $employes;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_employe
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}