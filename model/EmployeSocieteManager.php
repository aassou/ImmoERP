<?php
class EmployeSocieteManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(EmployeSociete $employe){
        $query = $this->_db->prepare(
        'INSERT INTO t_employe_societe (nom, cin, photo, telephone, email, etatCivile, dateDebut, dateSortie)
        VALUES (:nom, :cin, :photo, :telephone, :email, :etatCivile, :dateDebut, :dateSortie)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $employe->nom());
        $query->bindValue(':cin', $employe->cin());
		$query->bindValue(':photo', $employe->photo());
		$query->bindValue(':telephone', $employe->telephone());
		$query->bindValue(':email', $employe->email());
		$query->bindValue(':etatCivile', $employe->etatCivile());
		$query->bindValue(':dateDebut', $employe->dateDebut());
		$query->bindValue(':dateSortie', $employe->dateSortie());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(EmployeSociete $employe){
		$query = $this->_db->prepare('
		UPDATE t_employe_societe SET nom=:nom, cin=:cin, photo=:photo, telephone=:telephone, 
		email=:email, etatCivile=:etatCivile, dateDebut=:dateDebut, dateSortie=:dateSortie WHERE id=:id') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $employe->id());
		$query->bindValue(':nom', $employe->nom());
        $query->bindValue(':cin', $employe->cin());
		$query->bindValue(':photo', $employe->photo());
		$query->bindValue(':telephone', $employe->telephone());
		$query->bindValue(':email', $employe->email());
		$query->bindValue(':etatCivile', $employe->etatCivile());
		$query->bindValue(':dateDebut', $employe->dateDebut());
		$query->bindValue(':dateSortie', $employe->dateSortie());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idEmployeSociete){
		$query = $this->_db->prepare('DELETE FROM t_employe_societe WHERE id=:idEmployeSociete')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idEmployeSociete', $idEmployeSociete);
		$query->execute();
		$query->closeCursor();
	}

	public function getEmployesSocieteById($id){
		$query = $this->_db->prepare('SELECT * FROM t_employe_societe WHERE id=:id')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new EmployeSociete($data);
	}

	public function getEmployesSocieteByLimits($begin, $end){
		$employes = array();
		$query = $this->_db->query('SELECT * FROM t_employe_societe ORDER BY id DESC LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$employes[] = new EmployeSociete($data);
        }
        $query->closeCursor();
        return $employes;
	}
	
	public function getEmployeSocieteNumber(){
		$query = $this->_db->query('SELECT COUNT(*) AS employeNumber FROM t_employe_societe');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $employeNumber = $data['employeNumber'];
        return $employeNumber;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_employe_societe ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($nom){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_employe_societe WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nom, ' ', '') ");
        $query->execute(array(':nom' => $nom));
        //get result
        return $query->fetchColumn();
    }
}
	