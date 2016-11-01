<?php
/**
 * PDOFactory class file
 * 
 * @author Abdelilah Aassou <aassou.abdelilah@gmail.com>
 *
 *  This class by components to get access to the database through its connection methods.
 *  It uses the Singleton design pattern.
 * */
class PDOFactory{
    
    protected static $db;
    
    const HOST = 'mysql:host=localhost;dbname=immoerp_v2';
    const USER = 'root';
    const PASSWORD = '';
    
    private function __construct() {}
    private function __clone() {}
    
    public static function getMysqlConnection(){
        
        if ( !isset(self::$db) ) {
            self::$db = new PDO(PDOFactory::HOST, PDOFactory::USER, PDOFactory::PASSWORD);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }
}
