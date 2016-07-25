<?php
class LivraisonPiecesManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(LivraisonPieces $livraisonPieces){
        $query = $this->_db->prepare(
        'INSERT INTO t_pieces_livraison (nom, url, idLivraison)
        VALUES (:nom, :url, :idLivraison)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $livraisonPieces->nom());
		$query->bindValue(':url', $livraisonPieces->url());
		$query->bindValue(':idLivraison', $livraisonPieces->idLivraison());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(LivraisonPieces $livraisonPieces){
		$query = $this->_db->prepare('
		UPDATE t_pieces_livraison SET nom=:nom, url=:url WHERE id=:idPiecesLivraison') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesLivraison', $livraisonPieces->id());
		$query->bindValue(':nom', $livraisonPieces->nom());
		$query->bindValue(':url', $livraisonPieces->url());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idPiecesLivraison){
		$query = $this->_db->prepare('DELETE FROM t_pieces_livraison WHERE id=:idPiecesLivraison')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesLivraison', $idPiecesLivraison);
		$query->execute();
		$query->closeCursor();
	}
	
	public function getPiecesLivraisonNumberByIdLivraison($idLivraison){
        $query = $this->_db->prepare('SELECT COUNT(*) AS piecesLivraisonNumber FROM t_pieces_livraison
         WHERE idLivraison=:idLivraison')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idLivraison', $idLivraison);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['piecesLivraisonNumber'];
    }

	public function getPiecesLivraisonById($id){
        $query = $this->_db->prepare('SELECT * FROM t_pieces_livraison WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new LivraisonPieces($data);
    }

	public function getPiecesLivraisonByIdLivraison($idLivraison){
        $pieces = array();
        $query = $this->_db->prepare('SELECT * FROM t_pieces_livraison WHERE idLivraison=:idLivraison ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idLivraison', $idLivraison);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$pieces[] = new LivraisonPieces($data);
        }
        $query->closeCursor();
        return $pieces;
    }

	public function getPiecesLivraisonByIdLivraisonByLimits($idLivraison, $beign , $end){
        $pieces = array();
        $query = $this->_db->prepare('SELECT * FROM t_pieces_livraison WHERE idLivraiosn=:idLivraison ORDER BY id DESC
        LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idLivraison', $idLivraison);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$pieces = new LivraisonPieces($data);
        }
        $query->closeCursor();
        return $pieces;
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_pieces_livraison ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}
