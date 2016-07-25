<?php
class UserManager{
//attributes
    private $_db;
    
    //constructor
    public function __construct($db){
        $this->_db = $db;
    }
    
    //CRUD operations
    public function add(User $user){
        $query = $this->_db->prepare('INSERT INTO t_user (login, password, created, profil, status)
                                VALUES (:login, :password, :created, :profil, :status)') or die(print_r($this->_db->errorInfo()));
        $query->bindValue(':login', $user->login());
        $query->bindValue(':password', $user->password());
        $query->bindValue(':created', $user->created());
        $query->bindValue(':profil', $user->profil());
		$query->bindValue(':status', $user->status());
        $query->execute();
        $query->closeCursor();
    }
    
	public function delete($idUser){
		$query = $this->_db->prepare('DELETE FROM t_user WHERE id=:idUser');
		$query->bindValue(':idUser', $idUser);
		$query->execute();
		$query->closeCursor();
	}
	
	public function changeStatus($status, $idUser){
		$query = $this->_db->prepare('UPDATE t_user SET status=:status WHERE id=:idUser');
		$query->bindValue(':status', $status);
		$query->bindValue(':idUser', $idUser);
		$query->execute();
		$query->closeCursor();
	}

	public function updateProfil($idUser, $profil){
		$query = $this->_db->prepare('UPDATE t_user SET profil=:profil WHERE id=:idUser');
		$query->bindValue(':profil', $profil);
		$query->bindValue(':idUser', $idUser);
		$query->execute();
		$query->closeCursor();
	}
	
    public function getUsersNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS userNumbers FROM t_user');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['userNumbers'];
    }
    
    public function getStatus($login){
    	$query = $this->_db->prepare('SELECT status FROM t_user WHERE login=:login');
        $query->execute(array(':login' => $login));
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
        //get result
        return $data['status'];
    }
	
	public function getStatusById($idUser){
    	$query = $this->_db->prepare('SELECT status FROM t_user WHERE id=:idUser');
        $query->execute(array(':idUser' => $idUser));
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
        //get result
        return $data['status'];
    }
    
    public function getUsers(){
        $patients = array();
        $query = $this->_db->query('SELECT * FROM t_user ORDER BY created DESC');
        //get result
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $users[] = new User($data);
        }
        $query->closeCursor();
        return $users;
    }
	
	public function changePassword($newPassword, $idUser){
		$query = $this->_db->prepare('UPDATE t_user SET password =:newPassword
		WHERE id=:idUser') or die(print_r($this->_db->errorInfo()));;
        $query->bindValue(':newPassword', $newPassword);
        $query->bindValue(':idUser', $idUser);
        $query->execute();
        $query->closeCursor();
	}
    
    public function exists($login, $password){
        $query = $this->_db->prepare('SELECT COUNT(*) FROM t_user WHERE login=:login AND password=:password');
        $query->execute(array(':login' => $login, ':password' => $password));
        //get result
        return (bool) $query->fetchColumn();
    }
	
	public function exists2($login){
        $query = $this->_db->prepare('SELECT COUNT(*) FROM t_user WHERE login=:login');
        $query->execute(array(':login' => $login));
        //get result
        return (bool) $query->fetchColumn();
    }
    
    public function getUserByLoginPassword($login, $password){
        $query = $this->_db->prepare('SELECT * FROM t_user WHERE login =:login AND password =:password');
        $query->bindValue(':login', $login);
        $query->bindValue(':password', $password);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new User($data);
    }
    
}