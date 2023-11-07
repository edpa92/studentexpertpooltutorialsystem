<?php
include_once('DbConnection.php');

class SectionModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function addEdit($id, $sect, $status)
    {  	
    	$sql = "INSERT INTO `section_table`(`Section`, `Status`) VALUES ('$sect', '$status')";

        if ($id>0) {
            $sql = "UPDATE `section_table` SET `Section`='$sect', `Status`='$status' WHERE `SectionId`=$id";
            
        }
        
        try {
            
            return $this->getConnection()->query($sql)&&$id>0?TRUE:$this->connection->insert_id;    
        } catch (mysqli_sql_exception $e) {
            return FALSE;
        }
        	
    }
    
    public function addSectionSub($sectId, $subId)
    {
        $sql = "INSERT INTO `sectionsubject_table`(`SectionId`, `SubjectId`) VALUES ('$sectId','$subId')";        
        
        
        return $this->getConnection()->query($sql);
    }
    
    public function deleteAllSectionSubs($sectId)
    {
        $sql = "DELETE FROM `sectionsubject_table` WHERE `SectionId`='$sectId'";
        
        
        return $this->getConnection()->query($sql);
    }
	
    
    public function getAll()
    {
        $sql = "SELECT * FROM `section_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function get($id)
    {
        $sql = "SELECT * FROM `section_table` WHERE `SectionId`=$id";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
    public function classSubExist($secid, $subid)
    {
        $sql = "SELECT * FROM `sectionsubject_table` WHERE `SectionId`='$secid' AND `SubjectId`='$subid'";
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return TRUE;
        }
        
        return FALSE;
    }
	
}