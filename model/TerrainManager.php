<?php
class TerrainManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(Terrain $terrain){
        $query = $this->_db->prepare(
        'INSERT INTO t_terrain (prix, vendeur, fraisAchat, superficie, emplacement, idProjet, created, createdBy)
        VALUES (:prix, :vendeur, :fraisAchat, :superficie, :emplacement, :idProjet, :created, :createdBy)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':prix', $terrain->prix());
		$query->bindValue(':vendeur', $terrain->vendeur());
		$query->bindValue(':fraisAchat', $terrain->fraisAchat());
		$query->bindValue(':superficie', $terrain->superficie());
		$query->bindValue(':emplacement', $terrain->emplacement());
		$query->bindValue(':idProjet', $terrain->idProjet());
        $query->bindValue(':created', $terrain->created());
        $query->bindValue(':createdBy', $terrain->createdBy());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Terrain $terrain){
		$query = $this->_db->prepare('
		UPDATE t_terrain SET prix=:prix, vendeur=:vendeur, fraisAchat=:fraisAchat, superficie=:superficie, 
		emplacement=:emplacement, updated=:updated, updatedBy=:updatedBy WHERE id=:idTerrain') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idTerrain', $terrain->id());
		$query->bindValue(':prix', $terrain->prix());
		$query->bindValue(':vendeur', $terrain->vendeur());
		$query->bindValue(':fraisAchat', $terrain->fraisAchat());
		$query->bindValue(':superficie', $terrain->superficie());
		$query->bindValue(':emplacement', $terrain->emplacement());
        $query->bindValue(':updated', $terrain->updated());
        $query->bindValue(':updatedBy', $terrain->updatedBy());
        $query->execute();
        $query->closeCursor();
	}
	
	public function delete($idTerrain){
		$query = $this->_db->prepare('DELETE FROM t_terrain WHERE id=:idTerrain')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idTerrain', $idTerrain);
		$query->execute();
		$query->closeCursor();
	}
	
	public function getTerrainNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS terrainNumber FROM t_terrain WHERE idProjet=:idProjet')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['terrainNumber'];
    }

	public function getTerrainById($id){
        $query = $this->_db->prepare('SELECT * FROM t_terrain WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Terrain($data);
    }

	public function getTerrainByIdProjet($idProjet){
		$terrains = array();
        $query = $this->_db->prepare('SELECT * FROM t_terrain WHERE idProjet=:idProjet ORDER BY id DESC')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$terrains[] = new Terrain($data); 
        }
        $query->closeCursor();
        return $terrains;
    }

	public function getTerrainByIdProjetByLimits($idProjet, $beign , $end){
        $query = $this->_db->prepare('SELECT * FROM t_terrain WHERE idProjet=:idProjet ORDER BY id DESC
        LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Terrain($data);
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_terrain ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}
	
