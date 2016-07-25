<?php
class NotesClientManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(NotesClient $note){
        $query = $this->_db->prepare(
        'INSERT INTO t_notes_client (note, idProjet, codeContrat, created, createdBy)
        VALUES (:note, :created, :idProjet, :codeContrat, :created, :createdBy)') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':note', $note->note());
		$query->bindValue(':idProjet', $note->idProjet());
		$query->bindValue(':codeContrat', $note->codeContrat());
        $query->bindValue(':created', $note->created());
        $query->bindValue(':createdBy', $note->createdBy());
        $query->execute();
        $query->closeCursor();
    }
	
	public function update(NotesClient $note){
        $query = $this->_db->prepare(
        ' UPDATE t_notes_client SET note=:note, updated=:updated, 
        updatedBy=:updatedBy WHERE codeContrat=:codeContrat') 
        or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':note', $note->note());
		$query->bindValue(':codeContrat', $note->codeContrat());
        $query->bindValue(':updated', $note->updated());
        $query->bindValue(':updatedBy', $note->updatedBy());
        $query->execute();
        $query->closeCursor();
    }
	
	public function delete($idNote){
		$query = $this->_db->prepare(' DELETE FROM t_notes_client WHERE id=:id ') 
        or die(print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $idNote);
        $query->execute();
        $query->closeCursor();
	}
    
    public function getNotesNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS notesNumber FROM t_notes_client');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['notesNumber'];
    }
    
    public function getNotesNumberToday(){
        $query = $this->_db->query('SELECT COUNT(*) AS notesNumber FROM t_notes_client WHERE DATE(created)=CURDATE()');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['notesNumber'];
    }
    
	public function getNotesToday(){
        $notes = array();
        $query = $this->_db->query('SELECT * FROM t_notes_client WHERE DATE(created)=CURDATE() ORDER BY created DESC LIMIT 0, 10');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $notes[] = new NotesClient($data);
        }
        $query->closeCursor();
        return $notes;
    }
	
    public function getNotes(){
        $notes = array();
        $query = $this->_db->query('SELECT * FROM t_notes_client ORDER BY id DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $notes[] = new NotesClient($data);
        }
        $query->closeCursor();
        return $notes;
    }
}