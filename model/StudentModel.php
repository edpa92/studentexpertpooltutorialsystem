<?php
include_once('DbConnection.php');
require_once 'model/UserModel.php';
//require_once 'model/EmailVerificationModel.php';

class StudentModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function addStudent($StudentIDNo, $Firstname, $Middlename, $Lastname, $NameEx,  $Email, $Contact, $Gender)
    {  		    
    	$sql = "INSERT INTO `student_table`(`StudentIDNo`,`Firstname`, `Middlename`, `Lastname`, `NameExt`, `Gender`, `ContactNumber`,`Email`, `EmailVerified`, `DateRegistered`, `Status`) VALUES 
    	    ('$StudentIDNo','$Firstname','$Middlename','$Lastname', '$NameEx','$Gender','$Contact','$Email','0', '$this->currentDate','1')";
    	
    	if($this->getConnection()->query($sql)){    	    
    	    return $this->getConnection()->insert_id;
    	}        
        return 0;    	
    }    
   
    public function getAllStudent()
    {
        $sql = "SELECT * FROM `student_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function Verify($id)
    {        
        $sql = "UPDATE `student_table` SET `EmailVerified`=1 WHERE `StudentId`='$id'";
        
        return $this->getConnection()->query($sql);
    }
    
    
    
    
    public function EditStudent($id, $Firstname, $Middlename, $Lastname, $DateofBirth, $Gender, $ContactNumber, $FatherName, $Mothername, $GuardianName, $EmergencyContact, $CompeleteAddress, $PostalCode, $Image, $type)
    {
      
       $sql = "UPDATE `student_table` SET `Firstname`='$Firstname',`Middlename`='$Middlename',`Lastname`='$Lastname',`DateofBirth`='$DateofBirth',`Gender`='$Gender',`ContactNumber`='$ContactNumber',`FatherName`='$FatherName',`Mothername`='$Mothername',`GuardianName`='$GuardianName',`EmergencyContact`='$EmergencyContact',`CompeleteAddress`='$CompeleteAddress',`PostalCode`='$PostalCode',`Image`='$Image', `StudentType`='$type' WHERE `StudentId`=$id";
        
       if ($Image=="") {
           $sql = "UPDATE `student_table` SET `Firstname`='$Firstname',`Middlename`='$Middlename',`Lastname`='$Lastname',`DateofBirth`='$DateofBirth',`Gender`='$Gender',`ContactNumber`='$ContactNumber',`FatherName`='$FatherName',`Mothername`='$Mothername',`GuardianName`='$GuardianName',`EmergencyContact`='$EmergencyContact',`CompeleteAddress`='$CompeleteAddress',`PostalCode`='$PostalCode', `StudentType`='$type' WHERE `StudentId`=$id";
       }
       
       if ($Image!=="") {
           $_SESSION["PhotoCSHS"] =$Image;
       }
        
        return $this->getConnection()->query($sql);
    }
       
    public function getStudent($id)
    {
        $sql = "SELECT `StudentId`, `Firstname`, `Middlename`, `Lastname`, `DateofBirth`, `Gender`, `ContactNumber`, `Email`, `EmailVerified`, `VerificationCode`, `FatherName`, `Mothername`, `GuardianName`, `EmergencyContact`, `CompeleteAddress`, `PostalCode`, `Image`,   `DateRegistered`, `Status`, `StudentType` FROM `student_table` WHERE `StudentId`=$id";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
    public function StudentEmailExist($email)
    {
        $sql = "SELECT stu.*, user.Username FROM student_table stu JOIN `users_table` user ON stu.StudentId=user.StudentId WHERE stu.Email='$email' AND user.Username='$email';";
        $queryResult = $this->getConnection()->query($sql);
        return !mysqli_num_rows($queryResult) ==0;
        
    }
    
    public function StudentNameExist($fname, $Mname, $Lname)
    {
        $sql = "SELECT * FROM student_table WHERE (Firstname='$fname' AND Middlename='$Mname') AND Lastname='$Lname';";
        $queryResult = $this->getConnection()->query($sql);
        return !mysqli_num_rows($queryResult) ==0;
        
    }
    
    public function VerifyStudentEmail($id, $code) {
        $sql = "SELECT * FROM `student_table` WHERE `StudentId`=$id AND `VerificationCode`='$code'";
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            $verifyQuery="UPDATE `student_table` SET `EmailVerified`=1 WHERE `StudentId`=$id";
            
            $this->getConnection()->query($verifyQuery);
            $_SESSION["IsVerifiedCSHS"]=1;
            return TRUE;
        }
        
        return FALSE;
    }
	   
    
}