<?php
include_once('DbConnection.php');
include_once('UserModel.php');


class InstructorModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function Add($Firstname,$MI,$Lastname,$NameExt,$Gender,$Contact,$Email,$Status, $IdNo)
    {  	
    	$sql = "INSERT INTO `employees_table`(`EmpId`,`Firstname`, `MI`, `Lastname`, `NameExt`, `Gender`, `Contact`, `Email`, `Status`,`Verified`) VALUES
 ('$IdNo','$Firstname','$MI','$Lastname','$NameExt','$Gender','$Contact','$Email','$Status','0')";

        return $this->getConnection()->query($sql)? $this->getConnection()->insert_id:0;    	
    }
	
    public function EditInfo($id, $Firstname,$MI,$Lastname,$NameExt,$Gender,$Contact, $IdNo)
    {
        $sql = "UPDATE `employees_table` SET `EmpId`='$IdNo', `Firstname`='$Firstname',`MI`='$MI',`Lastname`='$Lastname',`NameExt`='$NameExt',
 `Gender`='$Gender',`Contact`='$Contact' WHERE `EmpKey`='$id'";
        
        return $this->getConnection()->query($sql);
    }
    
    public function EditPhoto($id, $Photo)
    {
        $sql = "UPDATE `employees_table` SET `Photo`='$Photo' WHERE `EmpKey`='$id'";
        
        return $this->getConnection()->query($sql);
    }
    
    public function getAll()
    {
        $sql = "SELECT `EmpKey`, `EmpId`, `Firstname`, `MI`, `Lastname`, `Designation`, `Gender`, `Contact`, `Email`, `Photo`, `TypeOfService`, `Status`, `Academic Qualifications`, `MaximumLoad`, `NameExt`, `Verified` FROM `employees_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getInstructor($id)
    {
        $sql = "SELECT `EmpKey`, `EmpId`, `Firstname`, `MI`, `Lastname`, `Designation`, `Gender`, `Contact`, `Email`, `Photo`, `TypeOfService`, `Status`, `Academic Qualifications`, `MaximumLoad`, `NameExt`, `Verified` 
FROM `employees_table` WHERE `EmpKey`= '$id' ";
        
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }
        
        return null;
    }

    public function Verify($id)
    {  	
	    	
	     $sql = "UPDATE `employees_table` SET `Verified`='1' WHERE `EmpKey`='$id'";
	        
	    return $this->getConnection()->query($sql);    	
    }

    
}