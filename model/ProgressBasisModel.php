<?php
include_once('DbConnection.php');

class ProgressBasisModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	

	public function addEditProgressBasis($ProgressBasisId,$ProgressBasis,$LowerLimit,$HigherLimit)
    {  	
	    	$sql = "INSERT INTO `progressbasis_table`(`ProgressBasis`, `LowerLimit`, `HigherLimit`) VALUES ('$ProgressBasis','$LowerLimit','$HigherLimit')";
	
	    	if ($ProgressBasisId>0) {
	            $sql = "UPDATE `progressbasis_table` SET `ProgressBasis`='$ProgressBasis',`LowerLimit`='$LowerLimit',`HigherLimit`='$HigherLimit' WHERE `ProgressBasisId`='$ProgressBasisId'";
	            
	        }
	        
	        return $this->getConnection()->query($sql);    	
    }
    
    public function getProgressBasis($ProgressBasisId)
    {
        $sql = "SELECT `ProgressBasisId`, `ProgressBasis`, `LowerLimit`, `HigherLimit` FROM `progressbasis_table` WHERE `ProgressBasisId`='$ProgressBasisId'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
    
    public function getAllProgressBasis()
    {
        $sql = "SELECT `ProgressBasisId`, `ProgressBasis`, `LowerLimit`, `HigherLimit` FROM `progressbasis_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
	
}