<?php
include_once('DbConnection.php');

class ChatModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function addChat($StudentId,$InstructorId,$MaterialId,$DateCreated)
    {  	
	    	$sql = "INSERT INTO `chat_table`(`StudentId`, `InstructorId`, `MaterialId`, `DateCreated`) 
VALUES ('$StudentId','$InstructorId','$MaterialId','$DateCreated')";
	
	    	
	        
	    	return $this->getConnection()->query($sql)?$this->connection->insert_id:0;    	
    }
    
    
    public function getChat($chatid)
    {
        $sql = "SELECT `ChatId`, `StudentId`, `InstructorId`, `MaterialId`, `DateCreated` FROM `chat_table` WHERE `ChatId`='$chatid'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
    
    public function getAllChat()
    {
        $sql = "SELECT `ChatId`, `StudentId`, `InstructorId`, `MaterialId`, `DateCreated` FROM `chat_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function isChatExisted($materialsId,$instructorsId,$studId)
    {
        $sql = "SELECT * FROM `chat_table` WHERE `StudentId`='$studId' AND `InstructorId`='$instructorsId' AND `MaterialId`='$materialsId'";
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }
        
        return NULL;
    }
    
    
    
    public function addMessage($ChatId,$SenderStudent,$SenderIns,$SendDateTime,$Message)
    {
        $sql = "INSERT INTO `message_table`(`ChatId`, `SenderStudent`, `SenderIns`, `SendDateTime`, `Message`, `Viewed`)
 VALUES ('$ChatId','$SenderStudent','$SenderIns','$SendDateTime','$Message','0')";
        
        if ($SenderIns=="0" || $SenderIns==0) {
            $sql = "INSERT INTO `message_table`(`ChatId`, `SenderStudent`,  `SendDateTime`, `Message`, `Viewed`)
 VALUES ('$ChatId','$SenderStudent','$SendDateTime','$Message','0')";
        }elseif ($SenderStudent=="0" || $SenderStudent==0){
            $sql = "INSERT INTO `message_table`(`ChatId`,  `SenderIns`, `SendDateTime`, `Message`, `Viewed`)
 VALUES ('$ChatId','$SenderIns','$SendDateTime','$Message','0')";
        }
                
        return $this->getConnection()->query($sql);
    }
    
    
    public function getMessage($chatid)
    {
        $sql = "SELECT `MessageId`, `ChatId`, `SenderStudent`, `SenderIns`, `SendDateTime`, `Message`, `Viewed` FROM `message_table` WHERE `ChatId`='$chatid'";
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }
        
        return null;
    }
    
    
    public function getAllMessage()
    {
        $sql = "SELECT `MessageId`, `ChatId`, `SenderStudent`, `SenderIns`, `SendDateTime`, `Message`, `Viewed` FROM `message_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function countAllUnviewedMessage($ins_id, $studid)
    {
        $sql = "SELECT count(`message_table`.`MessageId`) AS Unviewed FROM `message_table` LEFT JOIN `chat_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` WHERE chat_table.InstructorId='$ins_id' AND (message_table.SenderStudent IS NOT NULL AND message_table.Viewed=0) GROUP BY chat_table.ChatId";
        
        if ($studid!=0) {
            $sql = "SELECT count(`message_table`.`MessageId`) AS Unviewed FROM `message_table` LEFT JOIN `chat_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` WHERE chat_table.StudentId='$studid' AND (message_table.SenderIns IS NOT NULL AND message_table.Viewed=0)  GROUP BY chat_table.ChatId";
        }
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }
        
        return null;
    }
    
    public function getAllChatWithUnviewedMessage($ins_id, $studid)
    {
        $sql = "SELECT `chat_table`.*, COUNT(message_table.Message) AS Unviewed, 
(SELECT message_table.Message FROM message_table WHERE message_table.ChatId=`chat_table`.`ChatId` ORDER BY message_table.MessageId DESC LIMIT 1) AS TOPMSG, CONCAT(student_table.Firstname,' ',student_table.Middlename,' ',student_table.Lastname) AS NAME 
FROM `chat_table` 
LEFT JOIN `message_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` 
LEFT JOIN `student_table` ON chat_table.StudentId = student_table.StudentId 
WHERE chat_table.InstructorId='$ins_id' AND (message_table.SenderStudent IS NOT NULL AND message_table.Viewed=0) GROUP BY chat_table.ChatId";
        
        if ($studid!=0) {
            $sql = "SELECT `chat_table`.*, COUNT(message_table.Message) AS Unviewed, 
(SELECT message_table.Message FROM message_table WHERE message_table.ChatId=`chat_table`.`ChatId` ORDER BY message_table.MessageId DESC LIMIT 1) AS TOPMSG, CONCAT(student_table.Firstname,' ',student_table.Middlename,' ',student_table.Lastname) AS NAME 
FROM `chat_table` 
LEFT JOIN `message_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` 
LEFT JOIN `student_table` ON chat_table.StudentId = student_table.StudentId 
WHERE chat_table.StudentId='$studid' AND (message_table.SenderIns IS NOT NULL AND message_table.Viewed=0)  GROUP BY chat_table.ChatId";
        }
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
	
}