<?php
class LivraisonDetailManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(LivraisonDetail $livraison){
        $query = $this->_db->prepare(
        'INSERT INTO t_livraison_detail (designation, quantite, prixUnitaire, idLivraison, created, createdBy)
        VALUES (:designation, :quantite, :prixUnitaire, :idLivraison, :created, :createdBy)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':designation', $livraison->designation());
        $query->bindValue(':quantite', $livraison->quantite());
        $query->bindValue(':prixUnitaire', $livraison->prixUnitaire());
        $query->bindValue(':idLivraison', $livraison->idLivraison());
        $query->bindValue(':created', $livraison->created());
        $query->bindValue(':createdBy', $livraison->createdBy());
        $query->execute();
        $query->closeCursor();
    }

    public function update(LivraisonDetail $livraison){
        $query = $this->_db->prepare(
        'UPDATE t_livraison_detail SET designation=:designation, quantite=:quantite, 
        prixUnitaire=:prixUnitaire, updated=:updated, updatedBy=:updatedBy WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $livraison->id());
        $query->bindValue(':designation', $livraison->designation());
        $query->bindValue(':quantite', $livraison->quantite());
        $query->bindValue(':prixUnitaire', $livraison->prixUnitaire());
        $query->bindValue(':updated', $livraison->updated());
        $query->bindValue(':updatedBy', $livraison->updatedBy());
        $query->execute();
        $query->closeCursor();
    }
	
	public function delete($id){
		$query = $this->_db->prepare('DELETE FROM t_livraison_detail WHERE id=:id')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}
	
	public function deleteLivraison($idLivraison){
		$query = $this->_db->prepare('DELETE FROM t_livraison_detail WHERE idLivraison=:idLivraison')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idLivraison', $idLivraison);
		$query->execute();
		$query->closeCursor();
	}
	
	public function getLivraisonsDetailByIdLivraison($idLivraison){
        $livraisonsDetail = array();
        $query = $this->_db->prepare('SELECT * FROM t_livraison_detail WHERE idLivraison=:idLivraison
        ORDER BY id DESC');
        $query->bindValue(':idLivraison', $idLivraison);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $livraisonsDetail[] = new LivraisonDetail($data);
        }
        $query->closeCursor();
        return $livraisonsDetail;
    }
	    
	public function getLivraisonDetailNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS livraisonDetailNumber FROM t_livraison_detail');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['livraisonDetailNumber'];
    }	

	public function getNombreArticleLivraisonByIdLivraison($idLivraison){
		$query = $this->_db->prepare('SELECT COUNT(*) AS nombreArticle FROM t_livraison_detail 
		WHERE idLivraison=:idLivraison')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idLivraison', $idLivraison);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return $data['nombreArticle'];
	}
	
	public function getTotalLivraison(){
		$query = $this->_db->query('SELECT SUM(prixUnitaire*quantite) AS totalLivraison FROM t_livraison_detail')
		or die(print_r($this->_db->errorInfo()));
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return $data['totalLivraison'];
	}
	
	public function getTotalLivraisonByIdLivraison($idLivraison){
		$query = $this->_db->prepare('SELECT SUM(prixUnitaire*quantite) AS totalLivraison FROM t_livraison_detail 
		WHERE idLivraison=:idLivraison')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idLivraison', $idLivraison);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return $data['totalLivraison'];
	}

    public function getTotalLivraisonByIdLivraisonByDate($idLivraison, $date){
        $query = $this->_db->prepare(
        "SELECT SUM(prixUnitaire*quantite) AS totalLivraison 
        FROM t_livraison_detail 
        WHERE idLivraison=:idLivraison 
        AND MONTH(:date)=MONTH(dateLivraison)
        AND YEAR(:date)=YEAR(dateLivraison)")
        or die(print_r($this->_db->errorInfo()));;
        $query->bindValue(':idLivraison', $idLivraison);
        $query->bindValue(':date', $date);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['totalLivraison'];
    }
		
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_livraison ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}