<?php
class MailManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(Mail $mail){
        $query = $this->_db->prepare('INSERT INTO t_mail (content, sender, created)
                                VALUES (:content, :sender, :created)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':content', $mail->content());
        $query->bindValue(':sender', $mail->sender());
        $query->bindValue(':created', $mail->created());
        $query->execute();
        $query->closeCursor();
    }
    
    public function getMailsNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS mailsNumber FROM t_mail');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['mailsNumber'];
    }
    
    public function getMailsNumberToday(){
        $query = $this->_db->query('SELECT COUNT(*) AS mailsNumber FROM t_mail WHERE DATE(created)=CURDATE()');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['mailsNumber'];
    }
    
	public function getMailsToday(){
        $mails = array();
        $query = $this->_db->query('SELECT * FROM t_mail WHERE DATE(created)=CURDATE() ORDER BY created DESC LIMIT 0, 10');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $mails[] = new Mail($data);
        }
        $query->closeCursor();
        return $mails;
    }
	
    public function getMails(){
        $mails = array();
        $query = $this->_db->query('SELECT * FROM t_mail ORDER BY created DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $mails[] = new Mail($data);
        }
        $query->closeCursor();
        return $mails;
    }
    
    
}