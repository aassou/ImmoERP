<?php
class PiecesLocauxManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(PiecesLocaux $piecesLocaux){
        $query = $this->_db->prepare(
        'INSERT INTO t_pieces_locaux (nom, url, idLocaux) VALUES (:nom, :url, :idLocaux)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $piecesLocaux->nom());
		$query->bindValue(':url', $piecesLocaux->url());
		$query->bindValue(':idLocaux', $piecesLocaux->idLocaux());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(PiecesLocaux $piecesLocaux){
		$query = $this->_db->prepare('
		UPDATE t_pieces_locaux SET nom=:nom, url=:url WHERE id=:idPiecesLocaux') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesLocaux', $piecesLocaux->id());
		$query->bindValue(':nom', $piecesLocaux->nom());
		$query->bindValue(':url', $piecesLocaux->url());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idPiecesLocaux){
		$query = $this->_db->prepare('DELETE FROM t_pieces_locaux WHERE id=:idPiecesLocaux')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idPiecesLocaux', $idPiecesLocaux);
		$query->execute();
		$query->closeCursor();
	}
	
	public function getPiecesLocauxNumberByIdLocaux($idLocaux){
        $query = $this->_db->prepare('SELECT COUNT(*) AS piecesLocauxNumber FROM t_pieces_locaux WHERE idLocaux=:idLocaux')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idLocaux', $idLocaux);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['piecesLocauxNumber'];
    }

	public function getPiecesLocauxById($id){
        $query = $this->_db->prepare('SELECT * FROM t_pieces_locaux WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new PiecesLocaux($data);
    }

	public function getPiecesLocauxByIdLocaux($idLocaux){
        $pieces = array();
        $query = $this->_db->prepare('SELECT * FROM t_pieces_locaux WHERE idLocaux=:idLocaux ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idLocaux', $idLocaux);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$pieces[] = new PiecesLocaux($data);
        }
        $query->closeCursor();
        return $pieces;
    }

	public function getPiecesLocauxByIdLocauxByLimits($idLocaux, $beign , $end){
        $query = $this->_db->prepare('SELECT * FROM t_pieces_locaux WHERE idLocaux=:idLocaux ORDER BY id DESC
        LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idLocaux', $idLocaux);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new PiecesLocaux($data);
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_pieces_locaux ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}
	
		
	