<?php
include_once('DbConnection.php');

class QuizModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function addEditQuiz($id,$MaterialId,$DatePosted,$PercentagePassing,$TotalItem,$Status)
    {  	
	    	$sql = "INSERT INTO `quiz_table`(`MaterialId`, `DatePosted`, `PercentagePassing`, `TotalItem`, `Status`) 
VALUES ('$MaterialId','$DatePosted','$PercentagePassing','$TotalItem','$Status')";
	
	        if ($id>0) {
	            $sql = "UPDATE `quiz_table` SET `PercentagePassing`='$PercentagePassing',
`TotalItem`='$TotalItem',`Status`='$Status' WHERE `QuizNo`='$id'";
	            
	        }
	        
	        return $this->getConnection()->query($sql)&&$id==0?$this->getConnection()->insert_id:TRUE;    	
    }
    

    public function addQuestion($QuizId,$Question,$ChoiceA,$ChoiceB,$ChoiceC,$ChoiceD,$Answer,$Status,$Points)
    {  	
	    	$sql = "INSERT INTO `question_table`(`QuizId`, `Question`, `ChoiceA`, `ChoiceB`, `ChoiceC`, `ChoiceD`, `Answer`, `Status`, `Points`) 
VALUES ('$QuizId','$Question','$ChoiceA','$ChoiceB','$ChoiceC','$ChoiceD','$Answer','$Status','$Points')";
	        
	        return $this->getConnection()->query($sql);    	
    }
    
     public function getAllQuiz($matId)
    {
        $sql = "SELECT `QuizNo`, `MaterialId`, `DatePosted`, `PercentagePassing`, `TotalItem`, quiz_table.`Status`, COUNT(question_table.QQId) AS QCount FROM `quiz_table` 
LEFT JOIN question_table ON quiz_table.QuizNo=question_table.QuizId WHERE `MaterialId`='$matId'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getQuiz($id)
    {
        $sql = "SELECT `QuizNo`, `MaterialId`, `DatePosted`, `PercentagePassing`, `TotalItem`, `Status` FROM `quiz_table` WHERE `QuizNo`='$id'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
     public function getAllQuestionsOfQuiz($quizid)
    {
        $sql = "SELECT `QQId`, `QuizId`, `Question`, `ChoiceA`, `ChoiceB`, `ChoiceC`, `ChoiceD`, `Answer`, `Status`, `Points` FROM `question_table` WHERE `QuizId`='$quizid'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function deleteAllQuestionsOfQuiz($quizid)
    {
        $sql = "DELETE FROM `question_table` WHERE `QuizId`='$quizid'";
        
        return $queryResult = $this->getConnection()->query($sql);;
    }
    
	
}