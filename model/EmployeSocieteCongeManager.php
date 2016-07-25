<?php
class EmployeSocieteCongeManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(EmployeSocieteConge $conge){
        $query = $this->_db->prepare(
        'INSERT INTO t_conge_employe_societe (dateDebut, dateFin, idEmploye)
        VALUES (:dateDebut, :dateFin, :idEmploye)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':dateDebut', $conge->dateDebut());
		$query->bindValue(':dateFin', $conge->dateFin());
		$query->bindValue(':idEmploye', $conge->idEmploye());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(EmployeSocieteConge $conge){
		$query = $this->_db->prepare('UPDATE t_conge_employe_societe SET dateDebut=:dateDebut,
		dateFin=:dateFin WHERE id=:id') or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':dateDebut', $conge->dateDebut());
		$query->bindValue(':dateFin', $conge->dateFin());
        $query->bindValue(':id', $conge->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idConge){
		$query = $this->_db->prepare('DELETE FROM t_conge_employe_societe WHERE id=:idConge');
		$query->bindValue(':idConge', $idConge);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getCongesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS congesNumbers FROM t_conge_employe_societe');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['congesNumbers'];
    }
	
	public function getCongesById($idConge){
        $query = $this->_db->prepare('SELECT * FROM t_conge_employe_societe WHERE id=:idconge');
		$query->bindValue(':idConge', $idConge);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new EmployeSocieteConge($data);
    }
    
    public function getCongesByIdEmploye($idEmploye){
        $employeSocieteConge = array();
        $query = $this->_db->prepare('SELECT * FROM t_conge_employe_societe WHERE idEmploye=:idEmploye');
		$query->bindValue(':idEmploye', $idEmploye);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $employeSocieteConge[] = new EmployeSocieteConge($data);
        }
        $query->closeCursor();
        return $employeSocieteConge;
    }
	
	public function getNombreJoursCongeByIdEmploye($idEmploye){
		$query = $this->_db->prepare("SELECT SUM(dateFin-dateDebut) AS joursConge 
		FROM t_conge_employe_societe WHERE idEmploye=:idEmploye");
		$query->bindValue(':idEmploye', $idEmploye);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $joursConge = $data['joursConge'];
        return $joursConge;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_conge_employe_societe ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}