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
    
    public function getStudent($id)
    {
        $sql = "SELECT `StudentId`, `StudentIDNo`, `Firstname`, `Middlename`, `Lastname`, `NameExt`, `DateofBirth`, `Gender`, `ContactNumber`, `Email`, `EmailVerified`, `VerificationCode`, `Image`, `DateRegistered`, `Status`, `StudentType` FROM `student_table` WHERE `StudentId`=$id";
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }
        
        return null;
    }
        
    public function EditStudent($id, $studidno, $Firstname, $Middlename, $Lastname, $NameEx, $Gender, $ContactNumber)
    {
      
       $sql = "UPDATE `student_table` SET `StudentIDNo`='$studidno',`Firstname`='$Firstname',`Middlename`='$Middlename',
`Lastname`='$Lastname',`NameExt`='$NameEx',
`Gender`='$Gender',`ContactNumber`='$ContactNumber' WHERE `StudentId`=$id";
        
        return $this->getConnection()->query($sql);
    }
    
    public function EditPhoto($id, $Photo)
    {
        $sql = "UPDATE `student_table` SET `Image`='$Photo' WHERE `StudentId`='$id'";
        $_SESSION["PhotoSEPTS"] =$Photo;
        return $this->getConnection()->query($sql);
    }
    
     public function getAllStudentsPerSec($sec_id)
    {
        $sql = "SELECT `student_table`.*, `studsection_table`.*, `section_table`.`Section` FROM `student_table` LEFT JOIN `studsection_table` ON `studsection_table`.`StudentId` = `student_table`.`StudentId` LEFT JOIN `section_table` ON `studsection_table`.`SectionId` = `section_table`.`SectionId` WHERE `studsection_table`.`SectionId`='$sec_id'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
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