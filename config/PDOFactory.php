<?php

class PDOFactory{
    
    protected static $db;
    
    private function __construct() {}
    private function __clone() {}
    
    public static function getMysqlConnection(){
        
        if ( !isset(self::$db) ) {
            self::$db = new PDO('mysql:host=localhost;dbname=immoerp_v2', 'root', '');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }
    
    public static function getPgsqlConnection(){
        
        if ( !isset(self::$db) ) {
            self::$db = new PDO('pgsql:host=localhost;dbname=immoerp_v2', 'root', '');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }
}
