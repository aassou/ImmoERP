<?php
class OperationManager{
    //attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Operation $operation){
        $query = $this->_db->prepare(
        'INSERT INTO t_operation (date, dateReglement, compteBancaire, observation, reference, 
        montant, modePaiement, idContrat, numeroCheque, status, url, created, createdBy)
        VALUES (:date, :dateReglement, :compteBancaire, :observation, :reference, :montant,
        :modePaiement,:idContrat, :numeroCheque, :status, :url, :created, :createdBy)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':date', $operation->date());
        $query->bindValue(':dateReglement', $operation->dateReglement());
        $query->bindValue(':compteBancaire', $operation->compteBancaire());
        $query->bindValue(':observation', $operation->observation());
        $query->bindValue(':montant', $operation->montant());
        $query->bindValue(':reference', $operation->reference());
		$query->bindValue(':modePaiement', $operation->modePaiement());
        $query->bindValue(':numeroCheque', $operation->numeroCheque());
        $query->bindValue(':status', $operation->status());
        $query->bindValue(':idContrat', $operation->idContrat());
        $query->bindValue(':url', $operation->url());
        $query->bindValue(':created', $operation->created());
        $query->bindValue(':createdBy', $operation->createdBy());
        $query->execute();
        $query->closeCursor();
    }
    
    public function updatePiece($idOperation, $url){
        $query = $this->_db->prepare('UPDATE t_operation SET url=:url WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idOperation);
        $query->bindValue(':url', $url);
        $query->execute();
        $query->closeCursor();
    }
    
    public function validate($idOperation, $status){
        $query = $this->_db->prepare('UPDATE t_operation SET status=:status WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idOperation);
        $query->bindValue(':status', $status);
        $query->execute();
        $query->closeCursor();
    }
    
    public function cancel($idOperation, $status){
        $query = $this->_db->prepare('UPDATE t_operation SET status=:status WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idOperation);
        $query->bindValue(':status', $status);
        $query->execute();
        $query->closeCursor();
    }
    
    public function hide($idOperation, $status){
        $query = $this->_db->prepare('UPDATE t_operation SET status=:status WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idOperation);
        $query->bindValue(':status', $status);
        $query->execute();
        $query->closeCursor();
    }
    
    public function update(Operation $operation){
        $query = $this->_db->prepare(
        'UPDATE t_operation SET date=:date, dateReglement=:dateReglement, compteBancaire=:compteBancaire,
        montant=:montant, modePaiement=:modePaiement, observation=:observation, 
        numeroCheque=:numeroCheque, updated=:updated, updatedBy=:updatedBy WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $operation->id());
        $query->bindValue(':date', $operation->date());
        $query->bindValue(':dateReglement', $operation->dateReglement());
        $query->bindValue(':compteBancaire', $operation->compteBancaire());
        $query->bindValue(':observation', $operation->observation());
        $query->bindValue(':montant', $operation->montant());
        $query->bindValue(':modePaiement', $operation->modePaiement());
        $query->bindValue(':numeroCheque', $operation->numeroCheque());
        $query->bindValue(':updated', $operation->updated());
        $query->bindValue(':updatedBy', $operation->updatedBy());
        $query->execute();
        $query->closeCursor();
    }

	public function updateNumeroCheque($numeroCheque, $idOperation){
        $query = $this->_db->prepare('UPDATE t_operation SET numeroCheque=:numeroCheque WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':numeroCheque', $numeroCheque);
        $query->bindValue(':id', $idOperation);
        $query->execute();
        $query->closeCursor();
    }
	
	public function delete($idOperation){
        $query = $this->_db->prepare('DELETE FROM t_operation WHERE id=:id') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $idOperation);
        $query->execute();
        $query->closeCursor();
    }
    
    public function getOperations(){
        $operations = array();
        $query = $this->_db->query('SELECT * FROM t_operation WHERE status<>2 ORDER BY id DESC');
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsByIdContrat($idContrat){
        $operations = array();
        $query = $this->_db->prepare('SELECT * FROM t_operation WHERE idContrat=:idContrat ORDER BY id DESC');
        $query->bindValue(':idContrat', $idContrat);
        $query->execute();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOpertaionsNumberByIdContrat($idContrat){
        $query = $this->_db->prepare('SELECT count(id) AS nombreOperations 
        FROM t_operation WHERE idContrat =:idContrat');
        $query->bindValue('idContrat', $idContrat);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nombreOperations'];
    }
    
    public function getOpertaionsNumberTotal(){
        $query = $this->_db->query('SELECT count(id) AS nombreOperations 
        FROM t_operation');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['nombreOperations'];
    }
    
    public function getOperationNumberToday(){
        $query = $this->_db->query('SELECT COUNT(*) AS operationNumbersToday FROM t_operation WHERE date=CURDATE()');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['operationNumbersToday'];
    }

     public function getOperationNumberWeek(){
        $query = $this->_db->query('SELECT COUNT(*) AS operationNumbersWeek FROM t_operation WHERE date BETWEEN SUBDATE(CURDATE(),7) AND CURDATE()');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['operationNumbersWeek'];
    }
    
    public function getOperationNumberMonth(){
        $query = $this->_db->query('SELECT COUNT(*) AS operationNumbersMonth FROM t_operation WHERE MONTHNAME(date) = MONTHNAME(CURDATE())');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['operationNumbersMonth'];
    }
    
    public function getOperationsToday(){
        $operations = array();    
        $query = $this->_db->query('SELECT * FROM t_operation WHERE date = CURDATE()');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsYesterday(){
        $operations = array();
        $query = $this->_db->query('SELECT * FROM t_operation WHERE date BETWEEN SUBDATE(CURDATE(),1) AND CURDATE()');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsWeek(){
        $operations = array();
        $query = $this->_db->query('SELECT * FROM t_operation WHERE date BETWEEN SUBDATE(CURDATE(),7) AND CURDATE()');
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function sommeTotal(){
        $query = $this->_db->query('SELECT SUM(montant) AS total FROM t_operation');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['total'];
    }
    
    public function sommeOperations($idContrat){
        $query = $this->_db->prepare('SELECT sum(montant) AS somme 
        FROM t_operation WHERE idContrat =:idContrat');
        $query->bindValue('idContrat', $idContrat);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['somme'];
    }

    public function getLastId(){
        $query = $this->_db->query('SELECT id AS last_id FROM t_operation ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
	
	public function getLastIdByIdContrat($idContrat){
        $query = $this->_db->query('SELECT id AS last_id FROM t_operation 
        WHERE idContrat='.$idContrat.' ORDER BY id DESC LIMIT 0, 1');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $id = $data['last_id'];
        return $id;
    }
    
    public function getOperationById($id){
        $query = $this->_db->prepare('SELECT * FROM t_operation WHERE id =:id');
        $query->bindValue(':id', $id);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new Operation($data);
    }
    
    /**************************************************************************************/
    /*                                     New Methods                                    */
    /**************************************************************************************/
    
    public function getOperationsGroupByMonth(){
        $operations = array();
        $query = $this->_db->query(
        "SELECT * FROM t_operation 
        GROUP BY MONTH(dateReglement), YEAR(dateReglement)
        ORDER BY dateReglement DESC");
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsByMonthYear($month, $year){
        $operationss = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_operation 
        WHERE MONTH(dateReglement) = :month
        AND YEAR(dateReglement) = :year
        ORDER BY dateReglement DESC");
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOpenOperationsGroupByMonth(){
        $operations = array();
        $query = $this->_db->query(
        "SELECT * FROM t_operation 
        WHERE status<>2
        GROUP BY MONTH(dateReglement), YEAR(dateReglement)
        ORDER BY dateReglement DESC");
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsValideesGroupByMonth(){
        $operations = array();
        $query = $this->_db->query(
        "SELECT * FROM t_operation 
        WHERE status=1 OR status=2
        GROUP BY MONTH(dateReglement), YEAR(dateReglement)
        ORDER BY dateReglement DESC");
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOpenOperationsByMonthYear($month, $year){
        $operationss = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_operation 
        WHERE 
        status<>2
        AND MONTH(dateReglement) = :month
        AND YEAR(dateReglement) = :year
        ORDER BY dateReglement DESC");
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsValideesByMonthYear($month, $year){
        $operationss = array();
        $query = $this->_db->prepare(
        "SELECT * FROM t_operation 
        WHERE 
        (status=1 OR status=2)
        AND MONTH(dateReglement) = :month
        AND YEAR(dateReglement) = :year
        ORDER BY dateReglement DESC");
        $query->bindValue(':month', $month);
        $query->bindValue(':year', $year);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsValidees(){
        $operations = array();
        $query = $this->_db->query('SELECT * FROM t_operation WHERE status=1 ORDER BY id DESC');
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
    
    public function getOperationsNonValidees(){
        $operations = array();
        $query = $this->_db->query('SELECT * FROM t_operation WHERE status=0 ORDER BY id DESC');
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $operations[] = new Operation($data);
        }
        $query->closeCursor();
        return $operations;
    }
}
