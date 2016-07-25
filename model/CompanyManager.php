<?php
class CompanyManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Company $company){
    	$query = $this->_db->prepare(' INSERT INTO t_company (
		nom, adresse, nomArabe, adresseArabe, directeur, created, createdBy)
		VALUES (:nom, :adresse, :nomArabe, :adresseArabe, :directeur, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $company->nom());
		$query->bindValue(':adresse', $company->adresse());
		$query->bindValue(':nomArabe', $company->nomArabe());
		$query->bindValue(':adresseArabe', $company->adresseArabe());
		$query->bindValue(':directeur', $company->directeur());
		$query->bindValue(':created', $company->created());
		$query->bindValue(':createdBy', $company->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Company $company){
    	$query = $this->_db->prepare(' UPDATE t_company SET 
		nom=:nom, adresse=:adresse, nomArabe=:nomArabe, adresseArabe=:adresseArabe, directeur=:directeur, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $company->id());
		$query->bindValue(':nom', $company->nom());
		$query->bindValue(':adresse', $company->adresse());
		$query->bindValue(':nomArabe', $company->nomArabe());
		$query->bindValue(':adresseArabe', $company->adresseArabe());
		$query->bindValue(':directeur', $company->directeur());
		$query->bindValue(':updated', $company->updated());
		$query->bindValue(':updatedBy', $company->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_company
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getCompanyById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_company
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Company($data);
	}

	public function getCompanys(){
		$companys = array();
		$query = $this->_db->query('SELECT * FROM t_company ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$companys[] = new Company($data);
		}
		$query->closeCursor();
		return $companys;
	}

	public function getCompanysByLimits($begin, $end){
		$companys = array();
		$query = $this->_db->query('SELECT * FROM t_company
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$companys[] = new Company($data);
		}
		$query->closeCursor();
		return $companys;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_company
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}