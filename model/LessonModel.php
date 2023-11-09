<?php
include_once('DbConnection.php');

class LessonModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function addEdit($id, $SubjectId,$TopicDescription,$InstructorId, $status)
    {  	
	    	$sql = "INSERT INTO `topic_table`(`SubjectId`, `TopicDescription`, `InstructorId`, `Status`) 
VALUES ('$SubjectId','$TopicDescription','$InstructorId', '$status')";
	
	        if ($id>0) {
	            $sql = "UPDATE `topic_table` SET `SubjectId`='$SubjectId',`TopicDescription`='$TopicDescription',`InstructorId`='$InstructorId',`Status`='$status' WHERE `TopicNo`=$id";
	            
	        }
	        
	        return $this->getConnection()->query($sql);    	
    }
    
    
    public function get($id)
    {
        $sql = "SELECT `TopicNo`, `SubjectId`, `TopicDescription`, `InstructorId`, `Status` FROM `topic_table` WHERE `TopicNo`='$id'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
    public function getAll($insId)
    {
        $sql = "SELECT `topic_table`.*, `subject_table`.`Subject`
FROM `topic_table` 
	LEFT JOIN `subject_table` ON `topic_table`.`SubjectId` = `subject_table`.`SubjectCode` WHERE `InstructorId`='$insId';";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getAllActive($insId)
    {
        $sql = "SELECT `TopicNo`, `SubjectId`, `TopicDescription`, `InstructorId`, `Status` FROM 
`topic_table` WHERE Status='1' AND `InstructorId`='$insId'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
	
}