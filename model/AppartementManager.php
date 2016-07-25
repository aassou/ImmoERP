<?php
class AppartementManager{
	//attributes
    private $_db;
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    //CRUD operations
    public function add(Appartement $appartement){
        $query = $this->_db->prepare(
        'INSERT INTO t_appartement (nom, superficie, prix, niveau, facade, 
        nombrePiece, status, cave, idProjet, par, created, createdBy)
        VALUES (:nom, :superficie, :prix, :niveau, :facade, :nombrePiece, 
        :status, :cave, :idProjet, :par, :created, :createdBy)') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':nom', $appartement->nom());
        $query->bindValue(':superficie', $appartement->superficie());
		$query->bindValue(':facade', $appartement->facade());
		$query->bindValue(':prix', $appartement->prix());
		$query->bindValue(':niveau', $appartement->niveau());
		$query->bindValue(':nombrePiece', $appartement->nombrePiece());
		$query->bindValue(':cave', $appartement->cave());
		$query->bindValue(':status', $appartement->status());
		$query->bindValue(':idProjet', $appartement->idProjet());
		$query->bindValue(':par', $appartement->par());
        $query->bindValue(':created', $appartement->created());
        $query->bindValue(':createdBy', $appartement->createdBy());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(Appartement $appartement){
		$query = $this->_db->prepare('
		UPDATE t_appartement SET nom=:nom, superficie=:superficie, prix=:prix, niveau=:niveau, facade=:facade, 
		nombrePiece=:nombrePiece, status=:status, cave=:cave, par=:par, updated=:updated,
		updatedBy=:updatedBy WHERE id=:idAppartement') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idAppartement', $appartement->id());
		$query->bindValue(':nom', $appartement->nom());
		$query->bindValue(':superficie', $appartement->superficie());
		$query->bindValue(':facade', $appartement->facade());
		$query->bindValue(':prix', $appartement->prix());
		$query->bindValue(':niveau', $appartement->niveau());
		$query->bindValue(':nombrePiece', $appartement->nombrePiece());
		$query->bindValue(':cave', $appartement->cave());
		$query->bindValue(':status', $appartement->status());
		$query->bindValue(':par', $appartement->par());
        $query->bindValue(':updated', $appartement->updated());
        $query->bindValue(':updatedBy', $appartement->updatedBy());
        $query->execute();
        $query->closeCursor();
	}
	
    //this method is used to update the attribute reservePar
	public function updatePar($par, $idAppartement){
		$query = $this->_db->prepare('
		UPDATE t_appartement SET par=:par WHERE id=:idAppartement') 
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idAppartement', $idAppartement);
		$query->bindValue(':par', $par);
        $query->execute();
        $query->closeCursor();
	}
    
    //This method is used when a contract is done, so we need to change the price of our property
    //from the older one to the new price
    public function updatePrix($prix, $idAppartement){
        $query = $this->_db->prepare('
        UPDATE t_appartement SET prix=:prix WHERE id=:idAppartement') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idAppartement', $idAppartement);
        $query->bindValue(':prix', $prix);
        $query->execute();
        $query->closeCursor();
    }
    
    //This method is used when a contract is reselled, so we need to mention the reselling price
    //without touching the real price
    public function updateMontantRevente($montantRevente, $idBien){
        $query = $this->_db->prepare('
        UPDATE t_appartement SET montantRevente=:montantRevente WHERE id=:idAppartement') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idAppartement', $idBien);
        $query->bindValue(':montantRevente', $montantRevente);
        $query->execute();
        $query->closeCursor();
    }
	
	public function delete($idAppartement){
		$query = $this->_db->prepare('DELETE FROM t_appartement WHERE id=:idAppartement')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idAppartement', $idAppartement);
		$query->execute();
		$query->closeCursor();
	}
	
	public function changeStatus($id, $status){
        $query = $this->_db->prepare('UPDATE t_appartement SET status=:status WHERE id=:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':status', $status);
        $query->bindValue(':id', $id);
        $query->execute();
        $query->closeCursor();
    }
	
	public function getAppartementNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS appartementNumber FROM t_appartement WHERE idProjet=:idProjet')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['appartementNumber'];
    }
    
    public function getTotalPrixAppartements(){
        $query = $this->_db->query('SELECT SUM(prix) AS prixTotal FROM t_appartement')
        or die(print_r($this->_db->errorInfo()));
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['prixTotal'];
    }
    
    public function getTotalPrixAppartementsByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT SUM(prix) AS prixTotal FROM t_appartement WHERE idProjet=:idProjet')
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['prixTotal'];
    }
	
	public function getAppartementReserveNumberByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT COUNT(*) AS appartementNumber FROM t_appartement 
        WHERE idProjet=:idProjet AND status="reserve"')
		or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['appartementNumber'];
    }

	public function getAppartementById($id){
        $query = $this->_db->prepare('SELECT * FROM t_appartement WHERE id =:id')
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Appartement($data);
    }

    public function getAppartementsNonVendu(){
        $appartements = array();
        $query = $this->_db->query(
        "SELECT * FROM t_appartement WHERE status<>'Vendu' ORDER BY status ASC, niveau ASC, idProjet ASC, niveau ASC")
        or die(print_r($this->_db->errorInfo()));
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $appartements[] = new Appartement($data);
        }
        $query->closeCursor();
        return $appartements;
    }

    public function getAppartementByIdProjet($idProjet){
        $appartements = array();
        $query = $this->_db->prepare(
        'SELECT * FROM t_appartement WHERE idProjet=:idProjet ORDER BY status ASC, niveau ASC, nom ASC')
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $appartements[] = new Appartement($data);
        }
        $query->closeCursor();
        return $appartements;
    }

	public function getAppartementByIdProjetByLimits($idProjet, $begin , $end){
		$appartements = array();
        $query = $this->_db->prepare('SELECT * FROM t_appartement WHERE idProjet=:idProjet ORDER BY id DESC
        LIMIT '.$begin.' , '.$end)
		or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
        	$appartements[] = new Appartement($data);
        }
        $query->closeCursor();
        return $appartements;
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_appartement ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function exists($nom){
        $query = $this->_db->prepare(" SELECT COUNT(*) FROM t_appartement WHERE REPLACE(nom, ' ', '') LIKE REPLACE(:nom, ' ', '') ");
        $query->execute(array(':nom' => $nom));
        //get result
        return $query->fetchColumn();
    }
}
