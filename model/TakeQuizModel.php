<?php
include_once('DbConnection.php');

class TakeQuizModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function addTQ($id, $StudentId,$QuizId,$DateTaken,$Status, $Duration)
    {  	
	    	$sql = "INSERT INTO `take_table`( `StudentId`, `QuizId`, `DateTaken`,  `Status`, `DurationMinutes`) VALUES ('$StudentId','$QuizId','$DateTaken','$Status', '$Duration')";
	        
	    	return $this->getConnection()->query($sql)?$this->getConnection()->insert_id:0;    	
    }
    
    public function editScoreTQ($id,$TotalScore, $PassingScore,$Remarks)
    {
        
      $sql = "UPDATE `take_table` SET `PassingScore`='$PassingScore', `TotalScore`='$TotalScore',`Remarks`='$Remarks' WHERE `TakeNo`=$id";        
        
        return $this->getConnection()->query($sql);
    }
    
    public function addAnswer($TakeNo,$QuestionNo,$ChoiceAns, $IsCorrect)
    {  	
    	$sql = "INSERT INTO `answer_table`(`TakeNo`, `QuestionNo`, `ChoiceAns`, `IsCorrect`) VALUES ('$TakeNo','$QuestionNo','$ChoiceAns', '$IsCorrect')";    
               
        return $this->getConnection()->query($sql);    	
    }
    
    
     public function getAllTQ($quizid)
    {
        $sql = "SELECT `TakeNo`, `StudentId`, `QuizId`, `DateTaken`, `TotalScore`, `PassingScore`, `Remarks`, `Status` FROM `take_table` WHERE `QuizId`='$quizid'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    
    public function getAllTQStudent($studid)
    {
        $sql = "SELECT `take_table`.*, `student_table`.*
FROM `take_table` 
	LEFT JOIN `student_table` ON `take_table`.`StudentId` = `student_table`.`StudentId` WHERE `take_table`.`StudentId`='$studid'";
        
        if ($studid==0) {
            $sql = "SELECT `take_table`.*, `student_table`.*
FROM `take_table` 
	LEFT JOIN `student_table` ON `take_table`.`StudentId` = `student_table`.`StudentId`;";
            
        }
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getTQ($id)
    {
        $sql = "SSELECT `TakeNo`, `StudentId`, `QuizId`, `DateTaken`, `TotalScore`, `PassingScore`, `Remarks`, `Status` FROM `take_table` WHERE `TakeNo`='$id'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
	
}