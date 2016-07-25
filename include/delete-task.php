<?php 
    include('../config.php');  
    include('../model/TodoManager.php');
    $todoManager = new TodoManager($pdo);
    $task_id = $_GET['idTask'];
    //mysql_query("DELETE FROM tasks WHERE id='$task_id'");
    $todoManager->delete($task_id);
    header('Location:../todo.php');
?>