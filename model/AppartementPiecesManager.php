<?php
class AppartementPiecesManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(AppartementPieces $piecesAppartement){
        $query = $this->_db->prepare(
        'INSERT INTO t_pieces_appartement (nom, url, idAppartement)
        VALUES (:nom, :url, :idAppartement)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $piecesAppartement->nom());
		$query->bindValue(':url', $piecesAppartement->url());
		$query->bindValue(':idAppartement', $piecesAppartement->idAppartement());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(AppartementPieces $piecesAppartement){
		$query = $this->_db->prepare('
		UPDATE t_pieces_appartement SET nom=:nom, url=:url WHERE id=:idPiecesAppartement') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesAppartement', $piecesAppartement->id());
		$query->bindValue(':nom', $piecesAppartement->nom());
		$query->bindValue(':url', $piecesAppartement->url());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idPiecesAppartement){
		$query = $this->_db->prepare('DELETE FROM t_pieces_appartement WHERE id=:idPiecesAppartement')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesAppartement', $idPiecesAppartement);
		$query->execute();
		$query->closeCursor();
	}
	
	public function getPiecesAppartementNumberByIdAppartement($idAppartement){
        $query = $this->_db->prepare('SELECT COUNT(*) AS piecesAppartementNumber FROM t_pieces_appartement WHERE idAppartement=:idAppartement')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idAppartement', $idAppartement);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['piecesAppartementNumber'];
    }

	public function getPiecesAppartementById($id){
        $query = $this->_db->prepare('SELECT * FROM t_pieces_appartement WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new AppartementPieces($data);
    }

	public function getPiecesAppartementByIdAppartement($idAppartement){
        $pieces = array();
        $query = $this->_db->prepare('SELECT * FROM t_pieces_appartement WHERE idAppartement=:idAppartement ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idAppartement', $idAppartement);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$pieces[] = new AppartementPieces($data);
        }
        $query->closeCursor();
        return $pieces;
    }

	public function getPiecesAppartementByIdAppartementByLimits($idAppartement, $beign , $end){
        $pieces = array();
        $query = $this->_db->prepare('SELECT * FROM t_pieces_appartement WHERE idAppartement=:idAppartement ORDER BY id DESC
        LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idAppartement', $idAppartement);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$pieces = new AppartementPieces($data);
        }
        $query->closeCursor();
        return $pieces;
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_pieces_appartement ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}