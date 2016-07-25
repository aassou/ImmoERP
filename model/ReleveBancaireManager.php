<?php
class ReleveBancaireManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(ReleveBancaire $releveBancaire){
    	$query = $this->_db->prepare(' INSERT INTO t_relevebancaire (
		dateOpe, dateVal, libelle, reference, debit, credit, projet, idCompteBancaire, created, createdBy)
		VALUES (:dateOpe, :dateVal, :libelle, :reference, :debit, :credit, :projet, :idCompteBancaire, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':dateOpe', $releveBancaire->dateOpe());
		$query->bindValue(':dateVal', $releveBancaire->dateVal());
		$query->bindValue(':libelle', $releveBancaire->libelle());
		$query->bindValue(':reference', $releveBancaire->reference());
		$query->bindValue(':debit', $releveBancaire->debit());
		$query->bindValue(':credit', $releveBancaire->credit());
		$query->bindValue(':projet', $releveBancaire->projet());
        $query->bindValue(':idCompteBancaire', $releveBancaire->idCompteBancaire());
		$query->bindValue(':created', $releveBancaire->created());
		$query->bindValue(':createdBy', $releveBancaire->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(ReleveBancaire $releveBancaire){
    	$query = $this->_db->prepare('UPDATE t_relevebancaire SET 
		dateOpe=:dateOpe, dateVal=:dateVal, libelle=:libelle, reference=:reference, debit=:debit, 
		credit=:credit, projet=:projet, idCompteBancaire=:idCompteBancaire, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $releveBancaire->id());
		$query->bindValue(':dateOpe', $releveBancaire->dateOpe());
		$query->bindValue(':dateVal', $releveBancaire->dateVal());
		$query->bindValue(':libelle', $releveBancaire->libelle());
		$query->bindValue(':reference', $releveBancaire->reference());
		$query->bindValue(':debit', $releveBancaire->debit());
		$query->bindValue(':credit', $releveBancaire->credit());
		$query->bindValue(':projet', $releveBancaire->projet());
        $query->bindValue(':idCompteBancaire', $releveBancaire->idCompteBancaire());
		$query->bindValue(':updated', $releveBancaire->updated());
		$query->bindValue(':updatedBy', $releveBancaire->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

    public function hide($id){
        $query = $this->_db->prepare(
        'UPDATE t_relevebancaire
        SET status = 1
        WHERE id=:id')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $query->closeCursor();
    }

	public function deleteReleveActuel(){
        $query = $this->_db->query('DELETE FROM t_relevebancaire
        WHERE status=0')
        or die (print_r($this->_db->errorInfo()));
        $query->closeCursor();
    }
	
	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_relevebancaire
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getReleveBancaireById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_relevebancaire
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new ReleveBancaire($data);
	}

	public function getReleveBancaires(){
		$releveBancaires = array();
		$query = $this->_db->query('SELECT * FROM t_relevebancaire WHERE status=0
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$releveBancaires[] = new ReleveBancaire($data);
		}
		$query->closeCursor();
		return $releveBancaires;
	}
    
    public function getReleveBancairesArchive(){
        $releveBancaires = array();
        $query = $this->_db->query('SELECT * FROM t_relevebancaire ORDER BY id DESC LIMIT 0, 0');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $releveBancaires[] = new ReleveBancaire($data);
        }
        $query->closeCursor();
        return $releveBancaires;
    }
    
    public function getReleveBancairesArchiveBySearch($idCompteBancaire, $dateFrom, $dateTo){
        $releveBancaires = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_relevebancaire WHERE idCompteBancaire=:idCompteBancaire 
        AND ( STR_TO_DATE(dateOpe, '%d/%m/%Y') BETWEEN :dateFrom AND :dateTo ) 
        ORDER BY id");
        $query->bindValue(':idCompteBancaire', $idCompteBancaire);
        $query->bindValue(':dateFrom', $dateFrom);
        $query->bindValue(':dateTo', $dateTo);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $releveBancaires[] = new ReleveBancaire($data);
        }
        $query->closeCursor();
        return $releveBancaires;
    }

	public function getReleveBancairesByLimits($begin, $end){
		$releveBancaires = array();
		$query = $this->_db->query('SELECT * FROM t_relevebancaire
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$releveBancaires[] = new ReleveBancaire($data);
		}
		$query->closeCursor();
		return $releveBancaires;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_relevebancaire
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
	
	public function getLastRow(){
	    $releveBancaires = array();
        $query = $this->_db->query('SELECT * FROM t_relevebancaire ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $releveBancaires[] = new ReleveBancaire($data);
        $query->closeCursor();
        return $releveBancaires;
    }
    
    public function getTotalDebit(){
        $query = $this->_db->query("SELECT SUM(debit) AS totalDebit FROM t_relevebancaire");
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalDebit = $data['totalDebit'];
        $query->closeCursor();
        return $totalDebit;
    }
    
    public function getTotalCredit(){
        $query = $this->_db->query("SELECT SUM(credit) AS totalCredit FROM t_relevebancaire");
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $totalCredit = $data['totalCredit'];
        $query->closeCursor();
        return $totalCredit;
    }

}