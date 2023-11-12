<?php
include_once('DbConnection.php');

class MaterialsModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function addEdit($id,$TopicId,$Title,$MaterialsDescription,$URL,$CategoryId, $Status)
    {  	
	    	$sql = "INSERT INTO `learningmaterials_table`(`TopicId`, `Title`, `MaterialsDescription`, `URL`, `CategoryId`, `Status`) 
VALUES ('$TopicId','$Title','$MaterialsDescription','$URL','$CategoryId', '$Status')";
	
	        if ($id>0) {
	            $sql = "UPDATE `learningmaterials_table` SET `TopicId`='$TopicId',`Title`='$Title',
`MaterialsDescription`='$MaterialsDescription',`URL`='$URL',`CategoryId`='$CategoryId', `Status`='$Status' WHERE `MaterialNo`='$id'";
	            
	        }
	        
	        return $this->getConnection()->query($sql)&&$id==0?$this->getConnection()->insert_id:True;    	
    }
    
     public function getAll()
    {
        $sql = "SELECT `learningmaterials_table`.*, `topic_table`.`TopicDescription`, `learningmaterials_category_table`.`CategoryName`
FROM `learningmaterials_table` 
	LEFT JOIN `topic_table` ON `learningmaterials_table`.`TopicId` = `topic_table`.`TopicNo` 
	LEFT JOIN `learningmaterials_category_table` ON `learningmaterials_table`.`CategoryId` = `learningmaterials_category_table`.`LMCatId`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getAllByTopic($topicid)
    {
        $sql = "SELECT `learningmaterials_table`.*, `topic_table`.`TopicDescription`, `learningmaterials_category_table`.`CategoryName`
FROM `learningmaterials_table`
	LEFT JOIN `topic_table` ON `learningmaterials_table`.`TopicId` = `topic_table`.`TopicNo`
	LEFT JOIN `learningmaterials_category_table` ON `learningmaterials_table`.`CategoryId` = `learningmaterials_category_table`.`LMCatId`
WHERE TopicId='$topicid'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getAllActive()
    {
        $sql = "SELECT `learningmaterials_table`.*, `topic_table`.`TopicDescription`, `learningmaterials_category_table`.`CategoryName`
FROM `learningmaterials_table` 
	LEFT JOIN `topic_table` ON `learningmaterials_table`.`TopicId` = `topic_table`.`TopicNo` 
	LEFT JOIN `learningmaterials_category_table` ON `learningmaterials_table`.`CategoryId` = `learningmaterials_category_table`.`LMCatId` WHERE `Status`='1'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function get($id)
    {
        $sql = "SELECT `learningmaterials_table`.*, `topic_table`.`TopicDescription`, `learningmaterials_category_table`.`CategoryName`, subject_table.Subject
FROM `learningmaterials_table` 
	LEFT JOIN `topic_table` ON `learningmaterials_table`.`TopicId` = `topic_table`.`TopicNo` 
	LEFT JOIN `learningmaterials_category_table` ON `learningmaterials_table`.`CategoryId` = `learningmaterials_category_table`.`LMCatId` 
	LEFT JOIN `subject_table` ON `topic_table`.`SubjectId` = `subject_table`.`SubjectCode` 
WHERE `learningmaterials_table`.`MaterialNo`='$id'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
	
    public function addMaterialLoad($InstructorLoadId,$MaterialsId)
    {  	
    	$sql = "INSERT INTO `materialsload_table`(`InstructorLoadId`, `MaterialsId`) VALUES ('$InstructorLoadId','$MaterialsId')";

        
        return $this->getConnection()->query($sql);    	
    }
    
     public function getAllCatogory()
    {
        $sql = "SELECT `LMCatId`, `CategoryName` FROM `learningmaterials_category_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }

     public function getAllMaterialsLoad($matid)
    {
        $sql = "SELECT `section_table`.*, `instructorload_table`.`LoadId`, `materialsload_table`.`MaterialsId`
FROM `section_table` 
	LEFT JOIN `instructorload_table` ON `instructorload_table`.`SectionId` = `section_table`.`SectionId` 
	LEFT JOIN `materialsload_table` ON `materialsload_table`.`InstructorLoadId` = `instructorload_table`.`LoadId` 
WHERE `materialsload_table`.`MaterialsId`='$matid'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function isMaterialVisibleto($materialid, $loadid)
    {
        $sql = "SELECT * FROM `materialsload_table` WHERE `InstructorLoadId`='$loadid' AND `MaterialsId`='$materialid'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return True;
        }

        return null;
    }

     public function deleteAllMatrialLoad($matid)
     {  	
    	$sql = "DELETE FROM `materialsload_table` WHERE `MaterialsId`='$matid'";

        return $this->getConnection()->query($sql);    	
     }

      public function getAllMaterialsBySubjectforSection($subid, $secid)
      {
        $sql = "SELECT `learningmaterials_table`.*, `learningmaterials_category_table`.`CategoryName`, `topic_table`.`TopicDescription`, `materialsload_table`.`InstructorLoadId`, `instructorload_table`.`SectionId`
FROM `learningmaterials_table` 
	LEFT JOIN `learningmaterials_category_table` ON `learningmaterials_table`.`CategoryId` = `learningmaterials_category_table`.`LMCatId` 
	LEFT JOIN `topic_table` ON `learningmaterials_table`.`TopicId` = `topic_table`.`TopicNo` 
	LEFT JOIN `materialsload_table` ON `materialsload_table`.`MaterialsId` = `learningmaterials_table`.`MaterialNo` 
	LEFT JOIN `instructorload_table` ON `materialsload_table`.`InstructorLoadId` = `instructorload_table`.`LoadId` 
WHERE `topic_table`.`SubjectId`='$subid' AND `instructorload_table`.`SectionId`='$secid';";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
      }
}