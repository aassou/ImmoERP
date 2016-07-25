<?php
class PiecesTerrainManager{//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(PiecesTerrain $piecesTerrain){
        $query = $this->_db->prepare(
        'INSERT INTO t_pieces_terrain (nom, url, idTerrain)
        VALUES (:nom, :url, :idTerrain)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $piecesTerrain->nom());
		$query->bindValue(':url', $piecesTerrain->url());
		$query->bindValue(':idTerrain', $piecesTerrain->idTerrain());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(PiecesTerrain $piecesTerrain){
		$query = $this->_db->prepare('
		UPDATE t_pieces_terrain SET nom=:nom, url=:url WHERE id=:idPiecesTerrain') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesTerrain', $piecesTerrain->id());
		$query->bindValue(':nom', $piecesTerrain->nom());
		$query->bindValue(':url', $piecesTerrain->url());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idPiecesTerrain){
		$query = $this->_db->prepare('DELETE FROM t_pieces_terrain WHERE id=:idPiecesTerrain')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesTerrain', $idPiecesTerrain);
		$query->execute();
		$query->closeCursor();
	}
	
	public function getPiecesTerrainNumberByIdTerrain($idTerrain){
        $query = $this->_db->prepare('SELECT COUNT(*) AS piecesTerrainNumber FROM t_pieces_terrain WHERE idTerrain=:idTerrain')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idTerrain', $idTerrain);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['piecesTerrainNumber'];
    }

	public function getPiecesTerrainById($id){
        $query = $this->_db->prepare('SELECT * FROM t_pieces_terrain WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new PiecesTerrain($data);
    }

	public function getPiecesTerrainByIdTerrain($idTerrain){
        $pieces = array();	
        $query = $this->_db->prepare('SELECT * FROM t_pieces_terrain WHERE idTerrain=:idTerrain ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idTerrain', $idTerrain);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$pieces[] = new PiecesTerrain($data); 
        }
        $query->closeCursor();
        return $pieces;
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_pieces_terrain ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}
	
		
	