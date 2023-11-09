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
	        
	        return $this->getConnection()->query($sql);    	
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
        $sql = "SELECT `learningmaterials_table`.*, `topic_table`.`TopicDescription`, `learningmaterials_category_table`.`CategoryName`
FROM `learningmaterials_table` 
	LEFT JOIN `topic_table` ON `learningmaterials_table`.`TopicId` = `topic_table`.`TopicNo` 
	LEFT JOIN `learningmaterials_category_table` ON `learningmaterials_table`.`CategoryId` = `learningmaterials_category_table`.`LMCatId` WHERE `learningmaterials_table`.`MaterialNo`='$id'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
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
}