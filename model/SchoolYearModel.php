<?php
include_once('DbConnection.php');

class SchoolYearModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	 public function addEditSY($id, $syStart, $syEnd, $status)
    {  	
	    	$sql = "INSERT INTO `schoolyear_table`(`YearStart`, `YearEnd`, `Status`) VALUES ('$syStart','$syEnd','$status')";
	
	        if ($id>0) {
	            $sql = "UPDATE `schoolyear_table` SET `YearStart`='$syStart',`YearEnd`='$syEnd',`Status`='$status' WHERE `SYCode`=$id";
	            
	        }
	        
	        return $this->getConnection()->query($sql);    	
    }
    
    public function getSY($id)
    {
        $sql = "SELECT * FROM `schoolyear_table` WHERE `SYCode`=$id";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
     public function getAllSY()
    {
        $sql = "SELECT * FROM `schoolyear_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getAllActiveSY()
    {
        $sql = "SELECT * FROM `schoolyear_table` WHERE `Status`=1";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
}