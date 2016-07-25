<?php
class EmployeProjetManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(EmployeProjet $employe){
        $query = $this->_db->prepare(
        'INSERT INTO t_employe_projet (nom, cin, photo, telephone, email, etatCivile, dateDebut, dateSortie, idProjet)
        VALUES (:nom, :cin, :photo, :telephone, :email, :etatCivile, :dateDebut, :dateSortie, :idProjet)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $employe->nom());
        $query->bindValue(':cin', $employe->cin());
		$query->bindValue(':photo', $employe->photo());
		$query->bindValue(':telephone', $employe->telephone());
		$query->bindValue(':email', $employe->email());
		$query->bindValue(':etatCivile', $employe->etatCivile());
		$query->bindValue(':dateDebut', $employe->dateDebut());
		$query->bindValue(':dateSortie', $employe->dateSortie());
		$query->bindValue(':idProjet', $employe->idProjet());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(EmployeProjet $employe){
		$query = $this->_db->prepare('
		UPDATE t_employe_projet SET nom=:nom, cin=:cin, photo=:photo, telephone=:telephone, 
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
	
	public function delete($idEmployeProjet){
		$query = $this->_db->prepare('DELETE FROM t_employe_projet WHERE id=:idEmployeProjet')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idEmployeProjet', $idEmployeProjet);
		$query->execute();
		$query->closeCursor();
	}

	public function getEmployeProjetBySearch($recherche, $testRadio){
		$query = "";	
		if($testRadio==1){
			$query = $this->_db->prepare("SELECT * FROM t_employe_projet WHERE nom LIKE :recherche");
			$query->bindValue(':recherche', '%'.$recherche.'%');
		}
		else if($testRadio==2){
			$query = $this->_db->prepare("SELECT * FROM t_employe_projet WHERE cin=:cin");
			$query->bindValue(':cin', $recherche);
		}
		$query->execute();
        $employes = array();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $employes[] = new EmployeProjet($data);
        }
        $query->closeCursor();
        return $employes;
	}

	public function getEmployeProjetNumberByIdProjet($idProjet){
		$query = $this->_db->prepare('SELECT COUNT(*) AS numberEmploye FROM t_employe_projet WHERE idProjet=:idProjet')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['numberEmploye'];
	}

	public function getEmployeProjetById($id){
		$query = $this->_db->prepare('SELECT * FROM t_employe_projet WHERE id=:id')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new EmployeProjet($data);
	}

	public function getEmployesProjetByLimits($begin, $end){
		$employes = array();
		$query = $this->_db->query('SELECT * FROM t_employe_projet ORDER BY id DESC LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$employes[] = new EmployeProjet($data);
        }
        $query->closeCursor();
        return $employes;
	}
	
	public function getEmployesProjetByIdProjetByLimits($idProjet, $begin, $end){
		$employes = array();
		$query = $this->_db->prepare('SELECT * FROM t_employe_projet WHERE idProjet=:idProjet ORDER BY id DESC LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$employes[] = new EmployeProjet($data);
        }
        $query->closeCursor();
        return $employes;
	}
	
	public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_employe_projet ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($nom){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_employe_projet WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nom, ' ', '') ");
        $query->execute(array(':nom' => $nom));
        //get result
        return $query->fetchColumn();
    }
}
	