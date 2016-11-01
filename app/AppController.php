<?php
abstract class AppController{
    
    protected $manager;
    protected $actionMessage;
    protected $typeMessage;
    protected $redirectionLink;
    
    abstract public function add();
    abstract public function delete();
    abstract public function update();
}
