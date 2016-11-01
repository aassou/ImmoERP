<?php
require '../model/UserManager.php';
require '../db/PDOFactory.php';

class UserController extends AppController{
    
    public function __construct(){
        $this->manager = new UserManager(PDOFactory::getMysqlConnection());
    }
    
    //overrite abstract methods
    public function add($user){
        $this->manager->add($user);
    }
    
    public function delete($user){
        $this->$manager->delete($user);
    }
    
    public function update($user){
        $this->$manager->update($user);
    }
    
    //define new methods
    public function singin(){
        
    }
    
    public function signup(){
        
    }
    
    public function updatePassword(){
        
    }
}
