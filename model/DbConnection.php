<?php
class DbConnection{
 
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'studentexpertpooltutorialsystem';
 
    protected $connection;

    protected $currentDate;
 
    public function __construct(){
    	
    	date_default_timezone_set('Asia/Manila');
        $this->currentDate=date("Y/m/d h:i:s a");
        
        if (!isset($this->connection)) {
 
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
 
            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }
    }

    public function getConnection(){
        return $this->connection;
    }

    public function getCurrentDate(){
        return $this->currentDate;
    }

    public function isRequestPost() {
    	if($_SERVER['REQUEST_METHOD']=="POST"){
    		return TRUE;
    	}
    	
    	return FALSE;
    }
    
    public function formatDate($date){
        return date("M d, Y", strtotime($date));
    }
    
    public function getCurrentURL(){
        $current_url = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $current_url .= "s";
        }
        $current_url .= "://".$_SERVER['HTTP_HOST'];
        return $current_url;
    }
    
    public function escapeString($value)
    {
    	return $this->connection->real_escape_string($value);
    }

    public function generateCaptchaStringToSession($charLenth) {
        // Generate a random string
        $length = $charLenth;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, strlen($characters) - 1)];
        }
        $_SESSION['captcha']=$random_string;
    }

}
?>