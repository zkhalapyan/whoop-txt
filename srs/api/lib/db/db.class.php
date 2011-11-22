<?php

require_once dirname(dirname(dirname(__FILE__))).'/config/ConfigFactory.class.php';

class DB {
	
    private static $_mysqli = null;

    private static $_host = null;
    private static $_user = null;
    private static $_pass = null; 
    private static $_db   = null;

    /**
     * Constructor and clone functions are declared private to make the class a
     * singleton.
     */
    private function __construct() 
    {
		
    }
   
    private function __clone() {}

    /**
     * Singleton accessor method that returns the instance of the mysqli object.
     *
     * @return Mysqli
     */
    public static function &mysqli()
    {
    	
    	//Only create a new mysqli object none has been created so far.
      	if(self::$_mysqli == null ||
         self::$_host != ConfigFactory::get('db_host') || 
         self::$_user != ConfigFactory::get('db_user') ||
         self::$_pass != ConfigFactory::get('db_pass') ||
         self::$_db   != ConfigFactory::get('db_name'))
		{
        	self::$_host = ConfigFactory::get('db_host');
        	self::$_user = ConfigFactory::get('db_user');
        	self::$_pass = ConfigFactory::get('db_pass');
        	self::$_db   = ConfigFactory::get('db_name');
        	
            self::$_mysqli = new mysqli(self::$_host, self::$_user, self::$_pass, self::$_db);	
		}
           
        if (mysqli_connect_errno()) 
        {
            die("Unable to connect!");
        }
        
        return self::$_mysqli;
    }
    
    /**
     * Returns the number of rows matched by the query. Note that this is 
     * different than number rows affected by the query. 
     * 
     * @return integer The number of rows matche by the query.
     */
    public static function matched_rows()
    {
        //Parse the digits from the info string that has the following format:
        //Rows matched: 0 Changed: 0 Warnings: 0
        preg_match_all('!\d+!', DB::mysqli()->info, $m);
        return $m[0][0]; 
    }
}

?>