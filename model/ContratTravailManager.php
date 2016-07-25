<?php
class ContratTravailManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ContratTravail $contratTravail){
    	$query = $this->_db->prepare(' INSERT INTO t_contratTravail (
		nom,cin,adresse,dateNaissance,matiere,prix,mesure,prixTotal, dateContrat, idProjet)
		VALUES (:nom,:cin,:adresse,:dateNaissance,:matiere,:prix,:mesure,:prixTotal, :dateContrat, :idProjet)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $contratTravail->nom());
		$query->bindValue(':cin', $contratTravail->cin());
		$query->bindValue(':adresse', $contratTravail->adresse());
		$query->bindValue(':dateNaissance', $contratTravail->dateNaissance());
		$query->bindValue(':matiere', $contratTravail->matiere());
		$query->bindValue(':prix', $contratTravail->prix());
		$query->bindValue(':mesure', $contratTravail->mesure());
		$query->bindValue(':prixTotal', $contratTravail->prixTotal());
		$query->bindValue(':dateContrat', $contratTravail->dateContrat());
		$query->bindValue(':idProjet', $contratTravail->idProjet());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ContratTravail $contratTravail){
    	$query = $this->_db->prepare(' UPDATE t_contratTravail SET 
		nom=:nom,cin=:cin,adresse=:adresse,dateNaissance=:dateNaissance,
		matiere=:matiere,prix=:prix,mesure=:mesure,prixTotal=:prixTotal,
		dateContrat=:dateContrat
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $contratTravail->id());
		$query->bindValue(':nom', $contratTravail->nom());
		$query->bindValue(':cin', $contratTravail->cin());
		$query->bindValue(':adresse', $contratTravail->adresse());
		$query->bindValue(':dateNaissance', $contratTravail->dateNaissance());
		$query->bindValue(':matiere', $contratTravail->matiere());
		$query->bindValue(':prix', $contratTravail->prix());
		$query->bindValue(':mesure', $contratTravail->mesure());
		$query->bindValue(':prixTotal', $contratTravail->prixTotal());
		$query->bindValue(':dateContrat', $contratTravail->dateContrat());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_contratTravail
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getContratTravailById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_contratTravail
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ContratTravail($data);
	}

	public function getContratTravails(){
		$contratTravails = array();
		$query = $this->_db->query('SELECT * FROM t_contratTravail
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratTravails[] = new ContratTravail($data);
		}
		$query->closeCursor();
		return $contratTravails;
	}
	public function getContratTravailsByLimits($begin, $end){
		$contratTravails = array();
		$query = $this->_db->query('SELECT * FROM t_contratTravail
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratTravails[] = new ContratTravail($data);
		}
		$query->closeCursor();
		return $contratTravails;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_contratTravail
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////
	
	public function getContratTravailsByIdProjets($idProjet){
		$contratTravails = array();
		$query = $this->_db->prepare('SELECT * FROM t_contratTravail WHERE idProjet=:idProjet
		ORDER BY id DESC');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratTravails[] = new ContratTravail($data);
		}
		$query->closeCursor();
		return $contratTravails;
	}
	
	public function getContratTravailsByIdProjetsByLimits($idProjet, $beign, $end){
		$contratTravails = array();
		$query = $this->_db->prepare('SELECT * FROM t_contratTravail WHERE idProjet=:idProjet
		ORDER BY id DESC LIMIT '.$beign.', '.$end);
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();		
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratTravails[] = new ContratTravail($data);
		}
		$query->closeCursor();
		return $contratTravails;
	}
	
	public function getContratsTravailNumberByIdProjet($idProjet){
        $query = $this->_db->query('SELECT COUNT(*) AS contratNumbers FROM t_contrattravail WHERE idProjet='.$idProjet);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['contratNumbers'];
    }

}