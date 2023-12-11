<?php
include_once('DbConnection.php');

class ChatModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function addChat($StudentId,$InstructorId,$DateCreated, $meeting_id)
    {  	
	    	$sql = "INSERT INTO `chat_table`(`StudentId`, `InstructorId`, `DateCreated`, `MeetingId`) 
VALUES ('$StudentId','$InstructorId','$DateCreated','$meeting_id')";
	
	    	
	        
	    	return $this->getConnection()->query($sql)?$this->connection->insert_id:0;    	
    }
    
    public function editChatMeetingId($chatid, $meeting_id)
    {
        $sql = "UPDATE `chat_table` SET `MeetingId`='$meeting_id' WHERE `ChatId`='$chatid'";
        
        
        
        return $this->getConnection()->query($sql);
    }
    
    
    public function getChat($chatid)
    {
        $sql = "SELECT `ChatId`, `StudentId`, `InstructorId`, `DateCreated`, `MettingId` FROM `chat_table` WHERE `ChatId`='$chatid'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
    
    public function getAllChat($ins_id, $studid)
    {
        $sql = "SELECT `ChatId`, `StudentId`, `InstructorId`,  `DateCreated`, `MettingId` FROM `chat_table`";
        
        if ($ins_id!=0) {
            $sql = "SELECT `ChatId`, `StudentId`, `InstructorId`,  `DateCreated`, `MettingId` FROM `chat_table`";
        }else if ($studid!=0) {
            $sql = "SELECT `ChatId`, `StudentId`, `InstructorId`,  `DateCreated`, `MettingId` FROM `chat_table`";
        }
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function isChatExisted($instructorsId,$studId)
    {
        $sql = "SELECT `ChatId`, `StudentId`, `InstructorId`, `DateCreated`, `MeetingId` FROM `chat_table` WHERE `StudentId`='$studId' AND `InstructorId`='$instructorsId' LIMIT 1";
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
        
    public function getAllMessagesOfChat($chat_id)
    {
        $sql = "SELECT `message_table`.*, CONCAT(`employees_table`.`Firstname`,' ',`employees_table`.`MI`,' ',`employees_table`.`Lastname`) AS INSNAME, CONCAT(`student_table`.`Firstname`,' ',`student_table`.`Middlename`,' ',`student_table`.`Lastname`) AS STUDNAME
FROM `message_table` 
	LEFT JOIN `employees_table` ON `message_table`.`SenderIns` = `employees_table`.`EmpKey` 
	LEFT JOIN `student_table` ON `message_table`.`SenderStudent` = `student_table`.`StudentId`
    WHERE ChatId='$chat_id'
    ORDER BY message_table.MessageId DESC;";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function markAllMessagesOfChatViewed($chat_id, $studid, $insid)
    {
        $sql = "";
        
        if ($studid==0) {
            $sql = "UPDATE `message_table` SET `Viewed`='1' WHERE `ChatId`='$chat_id' AND `message_table`.`SenderStudent` IS NOT NULL";
        }elseif ($insid==0){
            
            $sql = "UPDATE `message_table` SET `Viewed`='1' WHERE `ChatId`='$chat_id' AND `message_table`.`SenderIns` IS NOT NULL";
            
        }
        
        return $this->getConnection()->query($sql);
        
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
    
    public function getAllChatWithUnviewedMessage($ins_id, $studid, $includeviewed)
    {
        $sql = "";
        if($ins_id!=0){ 
            $sql = "SELECT `chat_table`.*, COUNT(message_table.Message) AS Unviewed, 
(SELECT message_table.Message FROM message_table WHERE message_table.ChatId=`chat_table`.`ChatId` ORDER BY message_table.MessageId DESC LIMIT 1) AS TOPMSG, CONCAT(student_table.Firstname,' ',student_table.Middlename,' ',student_table.Lastname) AS NAME 
FROM `chat_table` 
LEFT JOIN `message_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` 
LEFT JOIN `student_table` ON chat_table.StudentId = student_table.StudentId 
WHERE chat_table.InstructorId='$ins_id' AND (message_table.SenderStudent IS NOT NULL AND message_table.Viewed='0') GROUP BY chat_table.ChatId ";
        
            if ($includeviewed) {
                $sql="SELECT `chat_table`.*, (SELECT COUNT(mt.MessageId) FROM message_table mt JOIN chat_table ct ON mt.ChatId=ct.ChatId WHERE mt.ChatId=`chat_table`.`ChatId` AND mt.Viewed=0 AND mt.SenderIns IS NULL) AS Unviewed, 
    (SELECT message_table.Message FROM message_table WHERE message_table.ChatId=`chat_table`.`ChatId` ORDER BY message_table.MessageId DESC LIMIT 1) AS TOPMSG, CONCAT(student_table.Firstname,' ',student_table.Middlename,' ',student_table.Lastname) AS NAME 
    FROM `chat_table` 
    LEFT JOIN `message_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` 
    LEFT JOIN `student_table` ON chat_table.StudentId = student_table.StudentId 
    WHERE chat_table.InstructorId='$ins_id'  GROUP BY chat_table.ChatId ORDER BY Unviewed DESC";
            }
        
        }elseif ($studid!=0) {
            $sql = "SELECT `chat_table`.*, COUNT(message_table.Message) AS Unviewed, 
(SELECT message_table.Message FROM message_table WHERE message_table.ChatId=`chat_table`.`ChatId` ORDER BY message_table.MessageId DESC LIMIT 1) AS TOPMSG, CONCAT(employees_table.Firstname,' ',employees_table.MI,' ',employees_table.Lastname) AS NAME 
FROM `chat_table` 
LEFT JOIN `message_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` 
LEFT JOIN `employees_table` ON chat_table.InstructorId = employees_table.EmpKey
WHERE chat_table.StudentId='$studid' AND (message_table.SenderIns IS NOT NULL AND message_table.Viewed='0')  GROUP BY chat_table.ChatId ";
            
            if ($includeviewed) {
                $sql="SELECT `chat_table`.*, (SELECT COUNT(mt.MessageId) FROM message_table mt JOIN chat_table ct ON mt.ChatId=ct.ChatId WHERE mt.ChatId=`chat_table`.`ChatId` AND mt.Viewed=0 AND mt.SenderStudent IS NULL) AS Unviewed, 
    (SELECT message_table.Message FROM message_table WHERE message_table.ChatId=`chat_table`.`ChatId` ORDER BY message_table.MessageId DESC LIMIT 1) AS TOPMSG, CONCAT(employees_table.Firstname,' ',employees_table.MI,' ',employees_table.Lastname) AS NAME 
    FROM `chat_table` 
    LEFT JOIN `message_table` ON `message_table`.`ChatId` = `chat_table`.`ChatId` 
    LEFT JOIN employees_table ON chat_table.InstructorId = employees_table.EmpKey 
    WHERE chat_table.StudentId='$studid'  GROUP BY chat_table.ChatId ORDER BY Unviewed DESC";
            }
        }
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
	
    
    public function getChatHasMeetingId($mettingId)
    {
        $sql = "SELECT * FROM `chat_table` WHERE `MeetingId`='$mettingId'";
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }
        
        return null;
    }
}