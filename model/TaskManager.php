<?php
class TaskManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Task $task){
    	$query = $this->_db->prepare(' INSERT INTO t_task (
		user, content, status, created, createdBy)
		VALUES (:user, :content, :status, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':user', $task->user());
		$query->bindValue(':content', $task->content());
		$query->bindValue(':status', $task->status());
		$query->bindValue(':created', $task->created());
		$query->bindValue(':createdBy', $task->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Task $task){
    	$query = $this->_db->prepare(' UPDATE t_task SET 
		user=:user, content=:content, status=:status, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $task->id());
		$query->bindValue(':user', $task->user());
		$query->bindValue(':content', $task->content());
		$query->bindValue(':status', $task->status());
		$query->bindValue(':updated', $task->updated());
		$query->bindValue(':updatedBy', $task->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

    public function updateStatus(Task $task){
        $query = $this->_db->prepare(' UPDATE t_task SET 
        status=:status, updated=:updated, updatedBy=:updatedBy
        WHERE id=:id ')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':id', $task->id());
        $query->bindValue(':status', $task->status());
        $query->bindValue(':updated', $task->updated());
        $query->bindValue(':updatedBy', $task->updatedBy());
        $query->execute();
        $query->closeCursor();
    }

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_task
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}
    
    public function deleteValideTasksByUser($user){
        $query = $this->_db->prepare('DELETE FROM t_task WHERE user=:user AND status=1 ')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':user', $user);
        $query->execute();
        $query->closeCursor();
    }

	public function getTaskById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_task
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Task($data);
	}
    
    public function getTaskNumberByUser($user){
        $query = $this->_db->prepare(' SELECT COUNT(id) AS taskNumber FROM t_task WHERE user=:user AND status=0')
        or die (print_r($this->_db->errorInfo()));
        $query->bindValue(':user', $user);
        $query->execute();      
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['taskNumber'];
    }
    
    public function getTasksByUser($user){
        $tasks = array();
        $query = $this->_db->prepare('SELECT * FROM t_task WHERE user=:user
        ORDER BY id DESC');
        $query->bindValue(':user', $user);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $tasks[] = new Task($data);
        }
        $query->closeCursor();
        return $tasks;
    }
    
    public function getTasksAffectedByMeToOther($createdBy){
        $tasks = array();
        $query = $this->_db->prepare('SELECT * FROM t_task WHERE createdBy=:createdBy
        ORDER BY status');
        $query->bindValue(':createdBy', $createdBy);
        $query->execute();
        while($data = $query->fetch(PDO::FETCH_ASSOC)){
            $tasks[] = new Task($data);
        }
        $query->closeCursor();
        return $tasks;
    }

	public function getTasks(){
		$tasks = array();
		$query = $this->_db->query('SELECT * FROM t_task
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$tasks[] = new Task($data);
		}
		$query->closeCursor();
		return $tasks;
	}

	public function getTasksByLimits($begin, $end){
		$tasks = array();
		$query = $this->_db->query('SELECT * FROM t_task
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$tasks[] = new Task($data);
		}
		$query->closeCursor();
		return $tasks;
	}

	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_task
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}