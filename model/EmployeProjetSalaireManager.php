<?php
class EmployeProjetSalaireManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(EmployeProjetSalaire $salaires){
        $query = $this->_db->prepare(
        'INSERT INTO t_salaires_projet (salaire, nombreJours, dateOperation, idEmploye)
        VALUES (:salaire, :nombreJours, :dateOperation, :idEmploye)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':salaire', $salaires->salaire());
		$query->bindValue(':nombreJours', $salaires->nombreJours());
		$query->bindValue(':dateOperation', $salaires->dateOperation());
		$query->bindValue(':idEmploye', $salaires->idEmploye());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(EmployeProjetSalaire $salaire){
		$query = $this->_db->prepare('UPDATE t_salaires_projet SET salaire=:salaire, nombreJours=:nombreJours, 
		dateOperation=:dateOperation WHERE id=:id') or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':salaire', $salaire->salaire());
		$query->bindValue(':nombreJours', $salaire->nombreJours());
		$query->bindValue(':dateOperation', $salaire->dateOperation());
        $query->bindValue(':id', $salaire->id());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idSalaire){
		$query = $this->_db->prepare('DELETE FROM t_salaires_projet WHERE id=:idSalaire');
		$query->bindValue(':idSalaire', $idSalaire);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getSalairesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS salairesNumbers FROM t_salaires_projet');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['salairesNumbers'];
    }
	
	public function getSalairesById($idSalaire){
        $query = $this->_db->prepare('SELECT * FROM t_salaires_projet WHERE id=:idSalaire');
		$query->bindValue(':idSalaire', $idSalaire);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new EmployeProjetSalaire($data);
    }
    
    public function getSalairesByIdEmploye($idEmploye){
        $employeProjetSalaire = array();
        $query = $this->_db->prepare('SELECT * FROM t_salaires_projet WHERE idEmploye=:idEmploye');
		$query->bindValue(':idEmploye', $idEmploye);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $employeProjetSalaire[] = new EmployeProjetSalaire($data);
        }
        $query->closeCursor();
        return $employeProjetSalaire;
    }
	
	public function getTotalByIdEmploye($idEmploye){
        $query = $this->_db->prepare('SELECT SUM(salaire*nombreJours) as total FROM t_salaires_projet WHERE idEmploye=:idEmploye');
		$query->bindValue(':idEmploye', $idEmploye);
		$query->execute();
        //get result
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['total'];
    }
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_salaires_projet ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}