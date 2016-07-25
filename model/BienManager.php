<?php
class BienManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Bien $bien){
        $query = $this->_db->prepare('INSERT INTO t_bien (numero, etage, superficie, facade, reserve, idProjet)
        VALUES (:numero, :etage, :superficie, :facade, :reserve, :idProjet)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':numero', $bien->numero());
        $query->bindValue(':etage', $bien->etage());
        $query->bindValue(':facade', $bien->facade());
        $query->bindValue(':superficie', $bien->superficie());
        $query->bindValue(':reserve', $bien->reserve());
        $query->bindValue(':idProjet', $bien->idProjet());
        $query->execute();
        $query->closeCursor();
    }
    
    public function update(Bien $bien){
        $query = $this->_db->prepare('UPDATE t_bien SET numero=:numero, etage=:etage, superficie=:superficie, 
        facade=:facade, reserve=:reserve, idProjet=:idProjet WHERE id=:id') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':numero', $bien->numero());
        $query->bindValue(':etage', $bien->etage());
        $query->bindValue(':superficie', $bien->superficie());
        $query->bindValue(':facade', $bien->facade());
        $query->bindValue(':reserve', $bien->reserve());
        $query->bindValue(':idProjet', $bien->idProjet());
        $query->bindValue(':id', $bien->id());
        $query->execute();
        $query->closeCursor();
    }
    
    public function updateReserve($state, $id){
        $query = $this->_db->prepare('UPDATE t_bien SET reserve=:state WHERE id=:id ');
        $query->bindValue(':state', $state);
        $query->bindValue(':id', $id);
        $query->execute();
        $query->closeCursor();
    }
    
    public function getBienNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS bienNumbers FROM t_bien');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['bienNumbers'];
    }
	
	public function getBienNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS bienNumbers FROM t_bien 
        WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['bienNumbers'];
    }
	
	public function getBienReserveNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS bienNumbers FROM t_bien 
        WHERE idProjet=:idProjet AND reserve="oui"');
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['bienNumbers'];
    }
    
    public function getBiens(){
        $biens = array();
        $query = $this->_db->query('SELECT * FROM t_bien ORDER BY id ASC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $biens[] = new Bien($data);
        }
        $query->closeCursor();
        return $biens;
    }
    
    public function getBienById($id){
        $query = $this->_db->prepare('SELECT * FROM t_bien WHERE id =:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Bien($data);
    }
    
    public function getBienNumeroById($id){
        $query = $this->_db->prepare('SELECT numero FROM t_bien WHERE id =:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['numero'];
    }
    
    public function getBienByIdProjet($idProjet){
    	$biens = array();
        $query = $this->_db->prepare('SELECT * FROM t_bien WHERE idProjet =:idProjet');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$biens = new Bien($data);
        }
        $query->closeCursor();
        return $biens;
    }
	
	public function getBienLibreByIdProjet($idProjet){
        $biens = array();
        $query = $this->_db->prepare(" SELECT * FROM t_bien WHERE idProjet =:idProjet AND reserve<>'oui' ");
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$biens = new Bien($data);
        }
        $query->closeCursor();
        return $biens;
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_bien ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
}
