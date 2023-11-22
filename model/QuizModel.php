<?php
include_once('DbConnection.php');

class QuizModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function addEditQuiz($id,$MaterialId,$DatePosted,$PercentagePassing,$TotalItem,$Status, $TopicId)
    {  	
	    	$sql = "INSERT INTO `quiz_table`(`MaterialId`,`TopicId`, `DatePosted`, `PercentagePassing`, `TotalItem`, `Status`) 
VALUES ('$MaterialId','$TopicId','$DatePosted','$PercentagePassing','$TotalItem','$Status')";
	    	
	    	if (is_null($MaterialId)) {
	    	    $sql = "INSERT INTO `quiz_table`(`TopicId`, `DatePosted`, `PercentagePassing`, `TotalItem`, `Status`)
VALUES ('$TopicId','$DatePosted','$PercentagePassing','$TotalItem','$Status')";
	    	}
	
	        if ($id>0) {
	            $sql = "UPDATE `quiz_table` SET `PercentagePassing`='$PercentagePassing',
`TotalItem`='$TotalItem',`Status`='$Status', `DateLastModefied`='$this->currentDate' WHERE `QuizNo`='$id'";
	            
	        }
	        
	        return $this->getConnection()->query($sql)&&$id==0?$this->getConnection()->insert_id:TRUE;    	
    }
    
    public function addQuestion($QuizId,$Question,$ChoiceA,$ChoiceB,$ChoiceC,$ChoiceD,$Answer,$Status,$Points)
    {  	
	    	$sql = "INSERT INTO `question_table`(`QuizId`, `Question`, `ChoiceA`, `ChoiceB`, `ChoiceC`, `ChoiceD`, `Answer`, `Status`, `Points`) 
VALUES ('$QuizId','$Question','$ChoiceA','$ChoiceB','$ChoiceC','$ChoiceD','$Answer','$Status','$Points')";
	        
	        return $this->getConnection()->query($sql);    	
    }
     
    
     public function getAllQuiz($matId, $studid)
    {
        $sql = "SELECT `QuizNo`, `MaterialId`,`TopicId`, `DatePosted`, `DateLastModefied`, `PercentagePassing`, `TotalItem`, quiz_table.`Status`, COUNT(question_table.QQId) AS QCount,
(SELECT COUNT(*) AS Taken FROM take_table WHERE take_table.QuizId=quiz_table.QuizNo AND take_table.StudentId='$studid') TakenByStudent
FROM `quiz_table` 
LEFT JOIN question_table ON quiz_table.QuizNo=question_table.QuizId WHERE `MaterialId`='$matId' GROUP BY `quiz_table`.`QuizNo`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getAllQuizesOfTopic($topicId, $studid)
    {
        $sql = "SELECT `QuizNo`, `MaterialId`,`TopicId`, `DatePosted`, `DateLastModefied`, `PercentagePassing`, `TotalItem`, quiz_table.`Status`, COUNT(question_table.QQId) AS QCount,
(SELECT COUNT(*) AS Taken FROM take_table WHERE take_table.QuizId=quiz_table.QuizNo AND take_table.StudentId='$studid') TakenByStudent
FROM `quiz_table`
LEFT JOIN question_table ON quiz_table.QuizNo=question_table.QuizId
WHERE `TopicId`='$topicId' GROUP BY `quiz_table`.`QuizNo`";
        
        if ($studid==0) {
            $sql = "SELECT `QuizNo`, `MaterialId`,`TopicId`, `DatePosted`, `DateLastModefied`, `PercentagePassing`, `TotalItem`, quiz_table.`Status`, COUNT(question_table.QQId) AS QCount,
(SELECT COUNT(*) AS Taken FROM take_table WHERE take_table.QuizId=quiz_table.QuizNo) TakenByStudent
FROM `quiz_table`
LEFT JOIN question_table ON quiz_table.QuizNo=question_table.QuizId
WHERE `TopicId`='$topicId' GROUP BY `quiz_table`.`QuizNo`";
        }
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getQuiz($id)
    {
        $sql = "SELECT `QuizNo`, `MaterialId`,`TopicId`, `DatePosted`, `DateLastModefied`, `PercentagePassing`, `TotalItem`, quiz_table.`Status`, COUNT(question_table.QQId) AS QCount FROM `quiz_table` 
LEFT JOIN question_table ON quiz_table.QuizNo=question_table.QuizId WHERE `QuizNo`='$id'";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }

        return null;
    }
    
    public function getQuizToTake($qid)
    {
        $sql = "SELECT `quiz_table`.`QuizNo`, `DateLastModefied`, `quiz_table`.`MaterialId`,`quiz_table`.`TopicId`, `quiz_table`.`DatePosted`, `quiz_table`.`PercentagePassing`, `quiz_table`.`TotalItem`, `quiz_table`.`Status`, COUNT(question_table.QQId) AS QCount, `learningmaterials_table`.`MaterialNo`, `topic_table`.`TopicDescription`, `subject_table`.`Subject`
FROM `quiz_table` 
    LEFT JOIN question_table ON quiz_table.QuizNo=question_table.QuizId
	LEFT JOIN `learningmaterials_table` ON `quiz_table`.`MaterialId` = `learningmaterials_table`.`MaterialNo` 
	LEFT JOIN `topic_table` ON `learningmaterials_table`.`TopicId` = `topic_table`.`TopicNo` 
	LEFT JOIN `subject_table` ON `topic_table`.`SubjectId` = `subject_table`.`SubjectCode` WHERE quiz_table.QuizNo='$qid'";
        
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
        
        return $queryResult = $this->getConnection()->query($sql);
    }
        
    public function isQuizTaken($qid)
    {
        $sql = "SELECT * FROM `take_table` WHERE `QuizId`='$qid' ";
        $queryResult = $this->getConnection()->query($sql);

        if (mysqli_num_rows($queryResult) > 0) {
            return TRUE;
        }

        return FALSE;
    }
	
}