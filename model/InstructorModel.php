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
        $_SESSION["PhotoSEPTS"] =$Photo;
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

     public function getAllInsLoad($insId)
     {
        $sql = "SELECT `section_table`.*, `instructorload_table`.`InstructorId`, `instructorload_table`.`LoadId`
FROM `section_table` LEFT JOIN `instructorload_table` ON `instructorload_table`.`SectionId` = `section_table`.`SectionId`
    WHERE `instructorload_table`.`InstructorId`='$insId';";
            
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
     public function addInsLoad($insid, $secid)
     {  	
    	$sql = "INSERT INTO `instructorload_table`( `InstructorId`, `SectionId`) VALUES ('$insid','$secid')";
        
        return $this->getConnection()->query($sql);    	
     }
     
     public function removeInsLoad($loadid)
     {
         $sql = "DELETE FROM `instructorload_table` WHERE `LoadId`='$loadid'";
         
         return $this->getConnection()->query($sql);
     }

      public function generatePieChartReport($instructor_id, $sy_id)
    {
        $sql = "SELECT `section_table`.*, `instructorload_table`.`InstructorId`, (SELECT COUNT(studsection_table.StudentId) FROM studsection_table WHERE studsection_table.SectionId=section_table.SectionId AND studsection_table.SYId='$sy_id') AS StudCount
FROM `section_table` 
	LEFT JOIN `instructorload_table` ON `instructorload_table`.`SectionId` = `section_table`.`SectionId`
WHERE instructorload_table.InstructorId='$instructor_id'";
        
        if ($instructor_id==0) {
            $sql = "SELECT `section_table`.*, (SELECT COUNT(studsection_table.StudentId) FROM studsection_table WHERE studsection_table.SectionId=section_table.SectionId AND studsection_table.SYId='$sy_id') AS StudCount FROM `section_table`";
        }
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }

     public function countSubOfIns($ins_id)
    {
        $sql = "SELECT `subject_table`.*
FROM `subject_table` 
	LEFT JOIN `topic_table` ON `topic_table`.`SubjectId` = `subject_table`.`SubjectCode` 
	LEFT JOIN `employees_table` ON `topic_table`.`InstructorId` = `employees_table`.`EmpKey`
    WHERE employees_table.EmpKey='$ins_id'
    GROUP BY SubjectCode";
        
        $queryResult = $this->getConnection()->query($sql);
       
        return mysqli_num_rows($queryResult);
    }
    
    public function countTopicOfIns($ins_id)
    {
        $sql = "SELECT `topic_table`.*
FROM `topic_table` 
	LEFT JOIN `employees_table` ON `topic_table`.`InstructorId` = `employees_table`.`EmpKey`
    WHERE employees_table.EmpKey='$ins_id'
    GROUP BY topic_table.TopicNo";
        
        $queryResult = $this->getConnection()->query($sql);
        
        return mysqli_num_rows($queryResult);
       
    }
    
    public function countMaterialsOfIns($ins_id)
    {
        $sql = "SELECT `learningmaterials_table`.*
FROM learningmaterials_table 
	LEFT JOIN topic_table ON learningmaterials_table.TopicId = topic_table.TopicNo
    WHERE topic_table.InstructorId='$ins_id'
    GROUP BY learningmaterials_table.MaterialNo";
        
        $queryResult = $this->getConnection()->query($sql);
        
        return mysqli_num_rows($queryResult);
        
    }
    
    public function countQuizOfIns($ins_id)
    {
        $sql = "SELECT `quiz_table`.* FROM quiz_table LEFT JOIN topic_table ON quiz_table.TopicId = topic_table.TopicNo WHERE topic_table.InstructorId='$ins_id' GROUP BY quiz_table.QuizNo";
        
        $queryResult = $this->getConnection()->query($sql);
        
        return mysqli_num_rows($queryResult);
        
    }
}