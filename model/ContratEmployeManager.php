<?php
class ContratEmployeManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ContratEmploye $contratEmploye){
    	$query = $this->_db->prepare('
    	INSERT INTO t_contratemploye (dateContrat, dateFinContrat, prixUnitaire, unite, nomUnite, nomUniteArabe, nombreUnites, 
    	prixUnitaire2, unite2, nomUnite2, nomUniteArabe2, nombreUnites2, traveaux, traveauxArabe, articlesArabes, total, employe, idSociete, idProjet, created, createdBy)
		VALUES (:dateContrat, :dateFinContrat, :prixUnitaire, :unite, :nomUnite, :nomUniteArabe, :nombreUnites, 
		:prixUnitaire2, :unite2, :nomUnite2, :nomUniteArabe2, :nombreUnites2, 
        :traveaux, :traveauxArabe, :articlesArabes, :total, :employe, :idSociete, :idProjet, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateContrat', $contratEmploye->dateContrat());
        $query->bindValue(':dateFinContrat', $contratEmploye->dateFinContrat());
        $query->bindValue(':prixUnitaire', $contratEmploye->prixUnitaire());
        $query->bindValue(':unite', $contratEmploye->unite());
        $query->bindValue(':nomUnite', $contratEmploye->nomUnite());
        $query->bindValue(':nomUniteArabe', $contratEmploye->nomUniteArabe());
        $query->bindValue(':nombreUnites', $contratEmploye->nombreUnites());
        $query->bindValue(':prixUnitaire2', $contratEmploye->prixUnitaire2());
        $query->bindValue(':unite2', $contratEmploye->unite2());
        $query->bindValue(':nomUnite2', $contratEmploye->nomUnite2());
        $query->bindValue(':nomUniteArabe2', $contratEmploye->nomUniteArabe2());
        $query->bindValue(':nombreUnites2', $contratEmploye->nombreUnites2());
        $query->bindValue(':traveaux', $contratEmploye->traveaux());
        $query->bindValue(':traveauxArabe', $contratEmploye->traveauxArabe());
        $query->bindValue(':articlesArabes', $contratEmploye->articlesArabes());
		$query->bindValue(':total', $contratEmploye->total());
		$query->bindValue(':employe', $contratEmploye->employe());
        $query->bindValue(':idSociete', $contratEmploye->idSociete());
		$query->bindValue(':idProjet', $contratEmploye->idProjet());
		$query->bindValue(':created', $contratEmploye->created());
		$query->bindValue(':createdBy', $contratEmploye->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ContratEmploye $contratEmploye){
    	$query = $this->_db->prepare(
    	'UPDATE t_contratemploye SET dateContrat=:dateContrat, dateFinContrat=:dateFinContrat, 
    	nombreUnites=:nombreUnites, prixUnitaire=:prixUnitaire, unite=:unite, nomUnite=:nomUnite, nomUniteArabe=:nomUniteArabe, 
    	nombreUnites2=:nombreUnites2, prixUnitaire2=:prixUnitaire2, unite2=:unite2, nomUnite2=:nomUnite2, nomUniteArabe2=:nomUniteArabe2, 
    	traveaux=:traveaux, traveauxArabe=:traveauxArabe, articlesArabes=:articlesArabes, total=:total, employe=:employe, idSociete=:idSociete, idProjet=:idProjet 
    	WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $contratEmploye->id());
		$query->bindValue(':dateContrat', $contratEmploye->dateContrat());
        $query->bindValue(':dateFinContrat', $contratEmploye->dateFinContrat());
        $query->bindValue(':prixUnitaire', $contratEmploye->prixUnitaire());
        $query->bindValue(':unite', $contratEmploye->unite());
        $query->bindValue(':nomUnite', $contratEmploye->nomUnite());
        $query->bindValue(':nomUniteArabe', $contratEmploye->nomUniteArabe());
        $query->bindValue(':nombreUnites', $contratEmploye->nombreUnites());
        $query->bindValue(':prixUnitaire2', $contratEmploye->prixUnitaire2());
        $query->bindValue(':unite2', $contratEmploye->unite2());
        $query->bindValue(':nomUnite2', $contratEmploye->nomUnite2());
        $query->bindValue(':nomUniteArabe2', $contratEmploye->nomUniteArabe2());
        $query->bindValue(':nombreUnites2', $contratEmploye->nombreUnites2());
        $query->bindValue(':traveaux', $contratEmploye->traveaux());
        $query->bindValue(':traveauxArabe', $contratEmploye->traveauxArabe());
        $query->bindValue(':articlesArabes', $contratEmploye->articlesArabes());
		$query->bindValue(':total', $contratEmploye->total());
		$query->bindValue(':employe', $contratEmploye->employe());
        $query->bindValue(':idSociete', $contratEmploye->idSociete());
		$query->bindValue(':idProjet', $contratEmploye->idProjet());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_contratemploye
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getContratEmployeById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_contratemploye WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ContratEmploye($data);
	}

	public function getContratEmployes(){
		$contratEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_contratemploye
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratEmployes[] = new ContratEmploye($data);
		}
		$query->closeCursor();
		return $contratEmployes;
	}
    
    public function getContratEmployesByIdProjet($idProjet){
        $contratEmployes = array();
        $query = $this->_db->prepare('SELECT * FROM t_contratemploye WHERE idProjet=:idProjet
        ORDER BY id DESC');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contratEmployes[] = new ContratEmploye($data);
        }
        $query->closeCursor();
        return $contratEmployes;
    }

	public function getContratEmployesByLimits($begin, $end){
		$contratEmployes = array();
		$query = $this->_db->query('SELECT * FROM t_contratemploye
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$contratEmployes[] = new ContratEmploye($data);
		}
		$query->closeCursor();
		return $contratEmployes;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_contratemploye
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}