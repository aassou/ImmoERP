<?php
class ContratManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Contrat $contrat){
        $query = $this->_db->prepare('
        INSERT INTO t_contrat (reference, numero, dateCreation, prixVente, prixVenteArabe, 
        avance, avanceArabe, modePaiement, dureePaiement, nombreMois, echeance, note, imageNote, 
        idClient, idProjet, idBien, typeBien, code, status, revendre, numeroCheque, societeArabe, 
        etatBienArabe, facadeArabe, articlesArabes, created, createdBy)
        VALUES (:reference, :numero, :dateCreation, :prixVente, :prixVenteArabe, 
        :avance, :avanceArabe, :modePaiement, :dureePaiement, :nombreMois, :echeance, :note, :imageNote, 
        :idClient, :idProjet, :idBien, :typeBien, :code, :status, :revendre, :numeroCheque, 
        :societeArabe, :etatBienArabe, :facadeArabe, :articlesArabes, :created, :createdBy)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':reference', $contrat->reference());
        $query->bindValue(':numero', $contrat->numero());
        $query->bindValue(':dateCreation', $contrat->dateCreation());
        $query->bindValue(':prixVente', $contrat->prixVente());
        $query->bindValue(':prixVenteArabe', $contrat->prixVenteArabe());
        $query->bindValue(':avance', $contrat->avance());
        $query->bindValue(':avanceArabe', $contrat->avanceArabe());
		$query->bindValue(':modePaiement', $contrat->modePaiement());
		$query->bindValue(':dureePaiement', $contrat->dureePaiement());
        $query->bindValue(':nombreMois', $contrat->nombreMois());
        $query->bindValue(':echeance', $contrat->echeance());
		$query->bindValue(':note', $contrat->note());
        $query->bindValue(':imageNote', $contrat->imageNote());
        $query->bindValue(':idClient', $contrat->idClient());
        $query->bindValue(':idProjet', $contrat->idProjet());
        $query->bindValue(':idBien', $contrat->idBien());
		$query->bindValue(':typeBien', $contrat->typeBien());
		$query->bindValue(':code', $contrat->code());
		$query->bindValue(':status', 'actif');
        $query->bindValue(':revendre', 0);
		$query->bindValue(':numeroCheque', $contrat->numeroCheque());
        $query->bindValue(':societeArabe', $contrat->societeArabe());
        $query->bindValue(':etatBienArabe', $contrat->etatBienArabe());
        $query->bindValue(':facadeArabe', $contrat->facadeArabe());
        $query->bindValue(':articlesArabes', $contrat->articlesArabes());
        $query->bindValue(':created', $contrat->created());
        $query->bindValue(':createdBy', $contrat->createdBy());
        $query->execute();
        $query->closeCursor();
    }
    
    public function update(Contrat $contrat){
        $query = $this->_db->prepare(
        'UPDATE t_contrat SET numero=:numero, dateCreation=:dateCreation, 
        prixVente=:prixVente, prixVenteArabe=:prixVenteArabe, avance=:avance, avanceArabe=:avanceArabe, 
        modePaiement=:modePaiement, numeroCheque=:numeroCheque,
        nombreMois=:nombreMois, dureePaiement=:dureePaiement, echeance=:echeance,  
        societeArabe=:societeArabe, etatBienArabe=:etatBienArabe, facadeArabe=:facadeArabe, 
        articlesArabes=:articlesArabes, note=:note, updated=:updated, updatedBy=:updatedBy WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $contrat->id());
		$query->bindValue(':numero', $contrat->numero());
        $query->bindValue(':dateCreation', $contrat->dateCreation());
        $query->bindValue(':prixVente', $contrat->prixVente());
        $query->bindValue(':prixVenteArabe', $contrat->prixVenteArabe());
        $query->bindValue(':avance', $contrat->avance());
        $query->bindValue(':avanceArabe', $contrat->avanceArabe());
		$query->bindValue(':modePaiement', $contrat->modePaiement());
		$query->bindValue(':dureePaiement', $contrat->dureePaiement());
        $query->bindValue(':numeroCheque', $contrat->numeroCheque());
        $query->bindValue(':nombreMois', $contrat->nombreMois());
        $query->bindValue(':echeance', $contrat->echeance());
		$query->bindValue(':note', $contrat->note());
        $query->bindValue(':societeArabe', $contrat->societeArabe());
        $query->bindValue(':etatBienArabe', $contrat->etatBienArabe());
        $query->bindValue(':facadeArabe', $contrat->facadeArabe());
        $query->bindValue(':articlesArabes', $contrat->articlesArabes());
        $query->bindValue(':updated', $contrat->updated());
        $query->bindValue(':updatedBy', $contrat->updatedBy());
        $query->execute();
        $query->closeCursor();
    }
	
	public function updateNumeroCheque($numeroCheque, $idContrat){
        $query = $this->_db->prepare('UPDATE t_contrat SET numeroCheque=:numeroCheque WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $contrat->id());
		$query->bindValue(':numeroCheque', $contrat->numeroCheque());
        $query->execute();
        $query->closeCursor();
    }
	
	public function desisterContrat($idContrat){
		$query = $this->_db->prepare('UPDATE t_contrat SET status=:status WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idContrat);
		$query->bindValue(':status', 'annulle');
        $query->execute();
        $query->closeCursor();
	}

	public function activerContrat($idContrat){
		$query = $this->_db->prepare('UPDATE t_contrat SET status=:status WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idContrat);
		$query->bindValue(':status', 'actif');
        $query->execute();
        $query->closeCursor();
	}
	
	public function changerBien($idContrat, $idBien, $typeBien){
		$query = $this->_db->prepare('UPDATE t_contrat SET typeBien=:typeBien, idBien=:idBien WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idContrat);
        $query->bindValue(':idBien', $idBien);
        $query->bindValue(':typeBien', $typeBien);
        $query->execute();
        $query->closeCursor();
	}

    public function updateRevendre($idContrat, $revendre){
        $query = $this->_db->prepare('UPDATE t_contrat SET revendre=:revendre WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idContrat);
        $query->bindValue(':revendre', $revendre);
        $query->execute();
        $query->closeCursor();
    }
	
    public function hide($idContrat){
        $query = $this->_db->prepare("UPDATE t_contrat SET status='hidden' WHERE id=:idContrat")
        or die(print_r($this->_db->errorInfo()));;
        $query->bindValue(':idContrat', $idContrat);
        $query->execute();
        $query->closeCursor();
    }
    
	public function delete($idContrat){
		$query = $this->_db->prepare('DELETE FROM t_contrat WHERE id=:idContrat')
		or die(print_r($this->_db->errorInfo()));;
		$query->bindValue(':idContrat', $idContrat);
		$query->execute();
		$query->closeCursor();
	}
    
    public function getClientNameByIdContract($idContrat){
        $query = $this->_db->prepare('SELECT nom FROM t_client, t_contrat WHERE t_client.id=t_contrat.idClient AND t_contrat.id=:idContrat');
        $query->bindValue(':idContrat', $idContrat);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nom'];
    }
    
    public function getIdClientByIdProjetByIdBienTypeBien($idProjet, $idBien, $typeBien){
        $query = $this->_db->prepare('SELECT idClient FROM t_contrat 
        WHERE status=:status AND idProjet=:idProjet AND idBien=:idBien AND typeBien=:typeBien');
        $query->bindValue(':idProjet', $idProjet);
        $query->bindValue(':idBien', $idBien);
        $query->bindValue(':typeBien', $typeBien);
        $query->bindValue(':status', 'actif');
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['idClient'];
    }
    
    public function getContratsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS contratNumbers FROM t_contrat');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['contratNumbers'];
    }
	
	public function getContratsNumberByIdProjet($idProjet){
        $query = $this->_db->query('SELECT COUNT(*) AS contratNumbers FROM t_contrat WHERE idProjet='.$idProjet);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['contratNumbers'];
    }
    
    public function getContratNumberToday(){
        $query = $this->_db->query('SELECT COUNT(*) AS contratNumbersToday FROM t_contrat WHERE dateCreation=CURDATE()');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['contratNumbersToday'];
    }

     public function getContratNumberWeek(){
        $query = $this->_db->query('SELECT COUNT(*) AS contratNumbersWeek FROM t_contrat WHERE dateCreation BETWEEN SUBDATE(CURDATE(),7) AND CURDATE()');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['contratNumbersWeek'];
    }
    
    public function getContratNumberMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS contratNumbersMonth FROM t_contrat WHERE MONTHNAME(dateCreation) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['contratNumbersMonth'];
    }
    
    public function getContrats(){
        $contrats = array();
        $query = $this->_db->query('SELECT * FROM t_contrat GROUP BY idClient');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
	
	public function getContratIdsByIdProjet($idProjet){
        $ids = array();
        $query = $this->_db->prepare('SELECT id FROM t_contrat WHERE idProjet=:idProjet');
		$query->bindValue(':idProjet', $idProjet);
		$query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $ids[] = $data['id'];
        }
        $query->closeCursor();
        return $ids;
    }

    public function getContratActifIds(){
        $ids = array();
        $query = $this->_db->query(' SELECT id FROM t_contrat WHERE status="actif" ');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $ids[] = $data['id'];
        }
        $query->closeCursor();
        return $ids;
    }
    
    public function getContratActifIdsByIdProjet($idProjet){
        $ids = array();
        $query = $this->_db->prepare(
        'SELECT id FROM t_contrat 
        WHERE idProjet=:idProjet AND status="actif" ');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $ids[] = $data['id'];
        }
        $query->closeCursor();
        return $ids;
    }

    public function getIdClientByIdProject($idProject){
        $idsClient = array();
        $query = $this->_db->prepare('SELECT idClient FROM t_contrat WHERE idProjet=:idProjet');
        $query->bindValue(':idProjet', $idProject);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $idsClient[] = $data['idClient'];
        }
        $query->closeCursor();
        return $idsClient;
    }

    public function getContratByIdBien($idBien){
        $query = $this->_db->prepare('SELECT * FROM t_contrat WHERE idBien=:idBien');
        $query->bindValue(':idBien', $idBien);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Contrat($data);
    }

    public function getContratsByIdProjet($idProjet, $begin, $end){
        $contrats = array();    
        $query = $this->_db->prepare("SELECT * FROM t_contrat WHERE idProjet=:idProjet ORDER BY status, dateCreation LIMIT ".$begin.", ".$end);
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getTotalPrixVenteByIdProjet($idProjet){
        $query = $this->_db->prepare(
        'SELECT SUM(prixVente) AS total FROM t_contrat 
        WHERE idProjet=:idProjet AND status="actif" ');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['total'];
    }
	
	public function getContratsByIdProjetOnly($idProjet){
        $contrats = array();    
        $query = $this->_db->prepare("SELECT * FROM t_contrat WHERE idProjet=:idProjet ORDER BY status ASC, dateCreation DESC");
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
	
    public function getContratsDesistes(){
        $contrats = array();    
        $query = $this->_db->query("SELECT * FROM t_contrat WHERE status='annulle' ");
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
	public function getContratsDesistesByIdProjet($idProjet){
        $contrats = array();    
        $query = $this->_db->prepare("SELECT * FROM t_contrat WHERE idProjet=:idProjet AND status='annulle' ");
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getContratsActifsByIdProjet($idProjet){
        $contrats = array();    
        $query = $this->_db->prepare("SELECT * FROM t_contrat WHERE idProjet=:idProjet AND status='actif'");
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }

    public function getContratsToday(){
        $contrats = array();
        $query = $this->_db->query('SELECT c.prixVente, cl.nom FROM t_contrat c, t_client cl WHERE cl.id=c.idClient AND c.dateCreation = CURDATE() ORDER BY c.dateCreation');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getContratYesterday(){
        $contrats = array();
        $query = $this->_db->query('SELECT c.prixVente, cl.nom FROM t_contrat c, t_client cl WHERE cl.id=c.idClient AND dateCreation = SUBDATE(CURDATE(),1)');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getContratWeek(){
        $contrats = array();
        $query = $this->_db->query('SELECT c.prixVente, cl.nom FROM t_contrat c, t_client cl WHERE cl.id=c.idClient AND dateCreation BETWEEN SUBDATE(CURDATE(),7) AND CURDATE()');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getContratsByIdClient($idClient){
        $contrats = array();    
        $query = $this->_db->prepare('SELECT * FROM t_contrat WHERE idClient =:id');
        $query->bindValue(':id', $idClient);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getContratsActifsByIdClient($idClient){
        $contrats = array();    
        $query = $this->_db->prepare('SELECT * FROM t_contrat WHERE status="actif" AND idClient =:id');
        $query->bindValue(':id', $idClient);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
	
	public function getContratsByIdClientByIdProjet($idClient, $idProjet){
        $contrats = array();    
        $query = $this->_db->prepare('SELECT * FROM t_contrat WHERE idClient=:idClient AND idProjet=:idProjet');
        $query->bindValue(':idClient', $idClient);
		$query->bindValue(':idProjet', $idProjet);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getContratById($idContrat){
        $query = $this->_db->prepare('SELECT * FROM t_contrat WHERE id=:id');
        $query->bindValue(':id', $idContrat);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Contrat($data);
    }

	public function getContratByCode($code){
        $query = $this->_db->prepare('SELECT * FROM t_contrat WHERE code=:code');
        $query->bindValue(':code', $code);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Contrat($data);
    }
    
    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_contrat ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
	public function getCodeContrat($code){
        $query = $this->_db->prepare('SELECT code FROM t_contrat WHERE code=:code');
		$query->bindValue(':code', $code);
		$query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['code'];
    }
	
	public function sommeAvanceByIdProjet($idProjet){
        $query = $this->_db->prepare('SELECT SUM(avance) AS total FROM t_contrat 
        WHERE idProjet=:idProjet');
        $query->bindValue(':idProjet', $idProjet);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
        return $data['total'];
    }
    //Status Revendre
    public function getAppartementsRevendre() {
        $contrats = array();    
        $query = $this->_db->prepare(
        'SELECT * FROM t_contrat 
        WHERE revendre=:revendre AND typeBien=:typeBien');
        $query->bindValue(':revendre', 1);
        $query->bindValue(':typeBien', 'appartement');
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    public function getLocauxRevendre() {
        $contrats = array();    
        $query = $this->_db->prepare(
        'SELECT * FROM t_contrat 
        WHERE revendre=:revendre AND typeBien=:typeBien');
        $query->bindValue(':revendre', 1);
        $query->bindValue(':typeBien', 'localCommercial');
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
    
    ////////////////////////////////////////////////////////////////////////////////////
    
    public function updateImageNote($idContrat, $imageNote){
        $query = $this->_db->prepare('UPDATE t_contrat SET imageNote=:imageNote WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idContrat);
        $query->bindValue(':imageNote', $imageNote);
        $query->execute();
        $query->closeCursor();
    }
    
    public function getContratsToChange(){
        $contrats = array();    
        $query = $this->_db->query('SELECT * FROM t_contrat WHERE LENGTH(note)>=2 AND status="actif" ORDER BY dateCreation DESC');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $contrats[] = new Contrat($data);
        }
        $query->closeCursor();
        return $contrats;
    }
}
