<?php
class CommandeManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Commande $commande){
    	$query = $this->_db->prepare(' INSERT INTO t_commande (
		idFournisseur, idProjet, dateCommande, numeroCommande, designation, status, codeLivraison, created, createdBy)
		VALUES (:idFournisseur, :idProjet, :dateCommande, :numeroCommande, :designation, :status, :codeLivraison, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idFournisseur', $commande->idFournisseur());
		$query->bindValue(':idProjet', $commande->idProjet());
		$query->bindValue(':dateCommande', $commande->dateCommande());
		$query->bindValue(':numeroCommande', $commande->numeroCommande());
		$query->bindValue(':designation', $commande->designation());
		$query->bindValue(':status', $commande->status());
		$query->bindValue(':codeLivraison', $commande->codeLivraison());
		$query->bindValue(':created', $commande->created());
		$query->bindValue(':createdBy', $commande->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Commande $commande){
    	$query = $this->_db->prepare(
    	'UPDATE t_commande SET 
		idFournisseur=:idFournisseur, idProjet=:idProjet, dateCommande=:dateCommande, 
		numeroCommande=:numeroCommande, designation=:designation, updated=:updated, 
		updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $commande->id());
		$query->bindValue(':idFournisseur', $commande->idFournisseur());
		$query->bindValue(':idProjet', $commande->idProjet());
		$query->bindValue(':dateCommande', $commande->dateCommande());
		$query->bindValue(':numeroCommande', $commande->numeroCommande());
		$query->bindValue(':designation', $commande->designation());
		$query->bindValue(':updated', $commande->updated());
		$query->bindValue(':updatedBy', $commande->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_commande
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getCommandeById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_commande
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Commande($data);
	}
    
    public function getCommandeByCode($code){
        $query = $this->_db->prepare(' SELECT * FROM t_commande
        WHERE codeLivraison=:code')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':code', $code);
        $query->execute();      
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Commande($data);
    }

	public function getCommandes(){
		$commandes = array();
		$query = $this->_db->query('SELECT * FROM t_commande
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$commandes[] = new Commande($data);
		}
		$query->closeCursor();
		return $commandes;
	}

	public function getCommandesByLimits($begin, $end){
		$commandes = array();
		$query = $this->_db->query('SELECT * FROM t_commande
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$commandes[] = new Commande($data);
		}
		$query->closeCursor();
		return $commandes;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_commande
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
    
    /**********************************************************************************************/
    /***********                                 New Methods                              *********/
    /**********************************************************************************************/
    
    public function getCommandesGroupByMonth(){
        $commandes = array();
        $query = $this->_db->query(
        "SELECT * FROM t_commande 
        GROUP BY MONTH(dateCommande), YEAR(dateCommande)
        ORDER BY dateCommande DESC");
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $commandes[] = new Commande($data);
        }
        $query->closeCursor();
        return $commandes;
    }
    
    public function getCommandesByMonthYear($month, $year){
        $commandes = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_commande 
        WHERE MONTH(dateCommande) = :month
        AND YEAR(dateCommande) = :year
        ORDER BY dateCommande DESC");
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $commandes[] = new Commande($data);
        }
        $query->closeCursor();
        return $commandes;
    }

}