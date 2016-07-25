<?php
class CaisseSortiesManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(CaisseSorties $sortie){
        $query = $this->_db->prepare(
        'INSERT INTO t_caisse_sorties (montant, designation, dateOperation, destination, utilisateur)
        VALUES (:montant, :designation, :dateOperation, :destination, :utilisateur)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':montant', $sortie->montant());
		$query->bindValue(':designation', $sortie->designation());
		$query->bindValue(':destination', $sortie->destination());
		$query->bindValue(':dateOperation', $sortie->dateOperation());
		$query->bindValue(':utilisateur', $sortie->utilisateur());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(CaisseSorties $sortie){
		$query = $this->_db->prepare('
		UPDATE t_caisse_sorties SET montant=:montant, designation=:designation, 
		dateOperation=:dateOperation, destination=:destination, utilisateur=:utilisateur WHERE id=:idEntrees') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idEntrees', $sortie->id());
		$query->bindValue(':montant', $sortie->montant());
		$query->bindValue(':designation', $sortie->designation());
		$query->bindValue(':destination', $sortie->destination());
		$query->bindValue(':dateOperation', $sortie->dateOperation());
		$query->bindValue(':utilisateur', $sortie->utilisateur());
        $query->execute();
        $query->closeCursor();
	}

	public function delete($idSortie){
		$query = $this->_db->prepare('DELETE FROM t_caisse_sorties WHERE id=:idSortie')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idSortie', $idSortie);
		$query->execute();
		$query->closeCursor();
	}

	public function getCaisseSortiesByLimits($begin, $end){
		$CaisseSorties = array();
        $query = $this->_db->query('SELECT * FROM t_caisse_sorties ORDER BY id DESC LIMIT '.$begin.', '.$end)
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$CaisseSorties[] = new CaisseSorties($data);
        }
        $query->closeCursor();
        return $CaisseSorties;
    }
	
	public function getCaisseSorties(){
		$CaisseSorties = array();
        $query = $this->_db->query('SELECT * FROM t_caisse_sorties ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$CaisseSorties[] = new CaisseSorties($data);
        }
        $query->closeCursor();
        return $CaisseSorties;
    }
	
	public function getCaisseSortiesBureauByLimits($begin, $end){
		$CaisseSorties = array();
        $query = $this->_db->query('SELECT * FROM t_caisse_sorties WHERE destination="Bureau" ORDER BY id DESC LIMIT '.$begin.', '.$end)
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$CaisseSorties[] = new CaisseSorties($data);
        }
        $query->closeCursor();
        return $CaisseSorties;
    }
	
	public function getCaisseSortiesBureau(){
		$CaisseSorties = array();
        $query = $this->_db->query('SELECT * FROM t_caisse_sorties WHERE destination="Bureau" ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$CaisseSorties[] = new CaisseSorties($data);
        }
        $query->closeCursor();
        return $CaisseSorties;
    }
	
	public function getCaisseSortiesProjetByLimits($idProjet, $begin, $end){
		$CaisseSorties = array();
        $query = $this->_db->prepare('SELECT * FROM t_caisse_sorties WHERE destination=:idProjet ORDER BY id DESC LIMIT '.$begin.', '.$end)
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$CaisseSorties[] = new CaisseSorties($data);
        }
        $query->closeCursor();
        return $CaisseSorties;
    }
	
	public function getCaisseSortiesProjet($idProjet){
		$CaisseSorties = array();
        $query = $this->_db->prepare('SELECT * FROM t_caisse_sorties WHERE destination=:idProjet ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$CaisseSorties[] = new CaisseSorties($data);
        }
        $query->closeCursor();
        return $CaisseSorties;
    }
    
	public function getDestinations(){
		$destinations = array();
		$query = $this->_db->query('SELECT DISTINCT destination FROM t_caisse_sorties')
		or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$destinations[] = $data['destination'];	
        }
        $query->closeCursor();
        return $destinations;
	}
	
	public function getCaisseSortiesNumber(){
		$query = $this->_db->query('SELECT COUNT(*) AS numberSorties FROM t_caisse_sorties')
		or die(print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['numberSorties'];
	}
	
	public function getCaisseSortiesNumberBureau(){
		$query = $this->_db->query('SELECT COUNT(*) AS numberSorties FROM t_caisse_sorties WHERE destination="Bureau"')
		or die(print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['numberSorties'];
	}
	
	public function getCaisseSortiesNumberProjet($idProjet){
		$query = $this->_db->prepare('SELECT COUNT(*) AS numberSorties FROM t_caisse_sorties WHERE destination=:idProjet')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['numberSorties'];
	}
	
	public function getTotalCaisseSorties(){
		$query = $this->_db->query('SELECT SUM(montant) AS total FROM t_caisse_sorties');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $total = $data['total'];
        return $total;
	}
	
	public function getTotalCaisseSortiesBureau(){
		$query = $this->_db->query('SELECT SUM(montant) AS total FROM t_caisse_sorties WHERE destination="Bureau"');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $total = $data['total'];
        return $total;
	}
	
	public function getTotalCaisseSortiesProjet($idProjet){
		$query = $this->_db->prepare('SELECT SUM(montant) AS total FROM t_caisse_sorties WHERE destination=:idProjet');
        $query->bindValue(':idProjet', $idProjet);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $total = $data['total'];
        return $total;
	}
	
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_caisse_sorties ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}
