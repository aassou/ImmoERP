<?php
class CommandeDetailManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(CommandeDetail $commandeDetail){
    	$query = $this->_db->prepare(' INSERT INTO t_commandedetail (
		reference, libelle, quantite, idCommande, created, createdBy)
		VALUES (:reference, :libelle, :quantite, :idCommande, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':reference', $commandeDetail->reference());
		$query->bindValue(':libelle', $commandeDetail->libelle());
		$query->bindValue(':quantite', $commandeDetail->quantite());
		$query->bindValue(':idCommande', $commandeDetail->idCommande());
		$query->bindValue(':created', $commandeDetail->created());
		$query->bindValue(':createdBy', $commandeDetail->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(CommandeDetail $commandeDetail){
    	$query = $this->_db->prepare(
    	'UPDATE t_commandedetail SET 
		reference=:reference, libelle=:libelle, quantite=:quantite, 
		updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $commandeDetail->id());
		$query->bindValue(':reference', $commandeDetail->reference());
		$query->bindValue(':libelle', $commandeDetail->libelle());
		$query->bindValue(':quantite', $commandeDetail->quantite());
		$query->bindValue(':updated', $commandeDetail->updated());
		$query->bindValue(':updatedBy', $commandeDetail->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_commandedetail
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}
    
    public function deleteCommande($idCommande){
        $query = $this->_db->prepare('DELETE FROM t_commandedetail WHERE idCommande=:idCommande')
        or die(print_r($this->_db->errorInfo()));;
        $query->bindValue(':idCommande', $idCommande);
        $query->execute();
        $query->closeCursor();
    }

	public function getCommandeDetailById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_commandedetail
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new CommandeDetail($data);
	}

	public function getCommandeDetails(){
		$commandeDetails = array();
		$query = $this->_db->query('SELECT * FROM t_commandedetail
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$commandeDetails[] = new CommandeDetail($data);
		}
		$query->closeCursor();
		return $commandeDetails;
	}

	public function getCommandeDetailsByLimits($begin, $end){
		$commandeDetails = array();
		$query = $this->_db->query('SELECT * FROM t_commandedetail
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$commandeDetails[] = new CommandeDetail($data);
		}
		$query->closeCursor();
		return $commandeDetails;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_commandedetail
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
    
    /**********************************************************************************************/
    /***********                                 New Methods                              *********/
    /**********************************************************************************************/
    
    public function getCommandesDetailByIdCommande($idCommande){
        $commandesDetail = array();
        $query = $this->_db->prepare('SELECT * FROM t_commandedetail WHERE idCommande=:idCommande
        ORDER BY id DESC');
        $query->bindValue(':idCommande', $idCommande);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $commandesDetail[] = new CommandeDetail($data);
        }
        $query->closeCursor();
        return $commandesDetail;
    }
        
    public function getCommandeDetailNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS commandeDetailNumber FROM t_commandedetail');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['commandeDetailNumber'];
    }   

    public function getNombreArticleCommandeByIdCommande($idCommande){
        $query = $this->_db->prepare('SELECT COUNT(*) AS nombreArticle FROM t_commandedetail 
        WHERE idCommande=:idCommande')
        or die(print_r($this->_db->errorInfo()));;
        $query->bindValue(':idCommande', $idCommande);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nombreArticle'];
    }

}