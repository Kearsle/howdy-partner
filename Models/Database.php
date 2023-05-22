<?php
class Database {
    /*
     * Database.php is used to be able to open and maintain the database. The credentials are here so they are not
     * able to be visable from the website.
     */
    protected static $_dbInstance = null;

    protected $_dbHandle;

    // Database Credentials
    public static function getInstance() {
       $username = [dbUsername];
       $password = [dbPassword];
       $host = [dbHostUrl];
       $dbName = [dbName];
       
       if(self::$_dbInstance === null) {
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$_dbInstance;
    }

    private function __construct($username, $password, $host, $database) {
        try { 
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        }
        catch (PDOException $e) {
	        //echo $e->getMessage();
	    }
    }

    public function getdbConnection() {
        return $this->_dbHandle;
    }

    public function __destruct()
    {
        $this->_dbHandle = null;
    }
}
