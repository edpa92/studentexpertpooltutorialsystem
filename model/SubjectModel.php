<?php
include_once('DbConnection.php');

class SubjectModel extends DbConnection{
	
	public function __construct(){
		parent::__construct();
	}
	
	
	public function addSubject($Subject, $Description, $Status)
    {  	
    	$sql = "INSERT INTO `subject_table`(`Subject`, `Description`, `Status`) VALUES ('$Subject','$Description','$Status')";
    	
    	$this->getConnection()->query($sql);
        return  $this->getConnection()->insert_id;   	
    }   
    
    public function EditSubject($id, $Subject, $Description, $Status)
    {
        $sql = "UPDATE `subject_table` SET `Subject`='$Subject',`Description`='$Description',`Status`='$Status' WHERE `SubjectCode`=$id";
        
        return $this->getConnection()->query($sql);
    }
    
    public function getAllSubject()
    {
        $sql = "SELECT * FROM `subject_table`";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }        
        return null;
    }
    
    public function getAllActiveSubject()
    {
        $sql = "SELECT * FROM `subject_table` WHERE Status='1'";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }        
        return null;
    }
        
    public function getSubject($id)
    {
        $sql = "SELECT `SubjectCode`, `Subject`, `Description`, `Status` FROM `subject_table` WHERE `SubjectCode`=$id";
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult->fetch_assoc();
        }
        
        return null;
    }
    
    
    
    
    
    
    public function getAllActiveSubjectPerGradeAndStrand($strandCode, $grader, $sem)
    {
        $sql = "SELECT `SubjectCode`, `Subject`, s1.`Description`, s1.`Status`, s1.`HoursperSem`, `Grader`, s1.`SemId`, 
        (SELECT `Subject` FROM `subject_table` s2 WHERE s2.`SubjectCode`=s1.`PreRequisite`) AS `PreRequisite`, c.`CurriculumSubjectName`,  st.Strand, st.StrandCode
        FROM `subject_table` s1 
        LEFT JOIN `curriculumsubject_table` c ON s1.`CurriculumId` = c.`CurriculumId`
        LEFT JOIN `strandsubject_table` ss ON ss.SuubjectId = s1.SubjectCode
        LEFT JOIN strand_table st ON ss.StrandId = st.StrandCode
        WHERE (s1.Status=1 AND st.StrandCode=$strandCode) AND s1.`Grader` LIKE '%$grader%'
        ORDER BY s1.`SemId`";
        
        if (!is_null($sem)) {
            $sql = "SELECT `SubjectCode`, `Subject`, s1.`Description`, s1.`Status`, s1.`HoursperSem`, `Grader`, s1.`SemId`,
            (SELECT `Subject` FROM `subject_table` s2 WHERE s2.`SubjectCode`=s1.`PreRequisite`) AS `PreRequisite`, c.`CurriculumSubjectName`,  st.Strand, st.StrandCode
            FROM `subject_table` s1
            LEFT JOIN `curriculumsubject_table` c ON s1.`CurriculumId` = c.`CurriculumId`
            LEFT JOIN `strandsubject_table` ss ON ss.SuubjectId = s1.SubjectCode
            LEFT JOIN strand_table st ON ss.StrandId = st.StrandCode
            WHERE s1.Status=1 AND (s1.`SemId`=$sem OR s1.`SemId` IS NULL) AND (st.StrandCode=$strandCode AND s1.`Grader` LIKE '%$grader%')
            ORDER BY s1.`SemId`";
        }
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getAllActive2ndSemSubjectPerGradeAndStrand($strandCode, $grader, $sem, $classid)
    {
        $sql = "SELECT `SubjectCode`, `Subject`, s1.`Description`, s1.`Status`, s1.`HoursperSem`, `Grader`, s1.`SemId`,
        (SELECT `Subject` FROM `subject_table` s2 WHERE s2.`SubjectCode`=s1.`PreRequisite`) AS `PreRequisite`, c.`CurriculumSubjectName`,  st.Strand, st.StrandCode
        FROM `subject_table` s1
        LEFT JOIN `curriculumsubject_table` c ON s1.`CurriculumId` = c.`CurriculumId`
        LEFT JOIN `strandsubject_table` ss ON ss.SuubjectId = s1.SubjectCode
        LEFT JOIN strand_table st ON ss.StrandId = st.StrandCode
        WHERE (s1.Status=1 AND st.StrandCode=$strandCode) AND s1.`Grader` LIKE '%$grader%'
        ORDER BY s1.`SemId`";
        
        if (!is_null($sem)) {
            $sql = "SELECT `SubjectCode`, `Subject`, s1.`Description`, s1.`Status`, s1.`HoursperSem`, `Grader`, s1.`SemId`,
            (SELECT `Subject` FROM `subject_table` s2 WHERE s2.`SubjectCode`=s1.`PreRequisite`) AS `PreRequisite`, c.`CurriculumSubjectName`,  st.Strand, st.StrandCode
            FROM `subject_table` s1
            LEFT JOIN `curriculumsubject_table` c ON s1.`CurriculumId` = c.`CurriculumId`
            LEFT JOIN `strandsubject_table` ss ON ss.SuubjectId = s1.SubjectCode
            LEFT JOIN strand_table st ON ss.StrandId = st.StrandCode
            WHERE (s1.Status=1) AND (s1.`SemId`=$sem OR s1.`SemId` IS NULL) AND (st.StrandCode=$strandCode AND s1.`Grader` LIKE '%$grader%') AND (s1.`SubjectCode` NOT IN (SELECT `SubjectId` FROM `suggestedsubject_table` WHERE `ClassId`=$classid))
            ORDER BY s1.`SemId`";
        }
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
    
    public function getAllToBeAssignedSubjects($semid, $enrollmentCode)
    {
        $sql = "SELECT `suggestedsubject_table`.*, `enrolled_subject_table`.*, `subject_table`.*, `classsection_table`.*
FROM `suggestedsubject_table` 
	INNER JOIN `enrolled_subject_table` ON `enrolled_subject_table`.`ClassSuggSubId` = `suggestedsubject_table`.`SuggSubjectId` 
	INNER JOIN `subject_table` ON `enrolled_subject_table`.`SubjectCode` = `subject_table`.`SubjectCode` 
	INNER JOIN `classsection_table` ON `suggestedsubject_table`.`ClassId` = `classsection_table`.`ClassId`
    WHERE (`suggestedsubject_table`.`SemId`=$semid AND `suggestedsubject_table`.`SuggSubjectId` NOT IN (SELECT `employeesubjectloads_table`.`SuggSubjectCode` FROM `employeesubjectloads_table` WHERE `employeesubjectloads_table`.`EnrollmentCode`=$enrollmentCode)) AND (`subject_table`.`Status`=1)
    GROUP BY `suggestedsubject_table`.`SuggSubjectId`;";
        
        $queryResult = $this->getConnection()->query($sql);
        
        if (mysqli_num_rows($queryResult) > 0) {
            return $queryResult;
        }
        
        return null;
    }
	
    public function SearchSubjects($querySerch, $sem) {
        if (strlen($querySerch)<3) {
            return;
        }
        $query = "SELECT `suggestedsubject_table`.*, 
`classsection_table`.`GradeLevel`, 
`classsection_table`.`Section`, 
`classsection_table`.`RoomNumber`, 
`classsection_table`.`Capacity`, 
`classsection_table`.`Status` AS CLASSSECStatus, 
`classsection_table`.`StrandId`, 
`subject_table`.`Subject`, 
`subject_table`.`Description`, 
`subject_table`.`HoursperSem`, 
`subject_table`.`PreRequisite`,
(SELECT st.Subject FROM subject_table st WHERE st.SubjectCode=`subject_table`.`PreRequisite`) AS PreReqSubject, 
`subject_table`.`SemId`, 
`subject_table`.`SubjectCode`,
`subject_table`.`PreRequisite`,  
`subject_table`.`Status` AS SubjStatus, 
`curriculumsubject_table`.`CurriculumSubjectName`, 
`strandsubject_table`.`StrandSubjectId`, 
`strand_table`.`Strand`
FROM `suggestedsubject_table` 
	INNER JOIN `classsection_table` ON `suggestedsubject_table`.`ClassId` = `classsection_table`.`ClassId` 
	INNER JOIN `subject_table` ON `suggestedsubject_table`.`SubjectId` = `subject_table`.`SubjectCode` 
	INNER JOIN `curriculumsubject_table` ON `subject_table`.`CurriculumId` = `curriculumsubject_table`.`CurriculumId` 
	INNER JOIN `strandsubject_table` ON `strandsubject_table`.`SuubjectId` = `subject_table`.`SubjectCode` 
	INNER JOIN `strand_table` ON `classsection_table`.`StrandId` = `strand_table`.`StrandCode`
   WHERE (`classsection_table`.`Status` = 1 AND `subject_table`.`Status`=1) AND (`suggestedsubject_table`.`SemId`= $sem) AND (`subject_table`.`Subject` LIKE '%$querySerch%' OR `subject_table`.`SubjectCode` LIKE '%$querySerch%')
   GROUP BY `classsection_table`.`ClassId`";
        
        $result=$this->getConnection()->query($query);
        $output=array();
        if (mysqli_num_rows($result)>0) {
            while($row = mysqli_fetch_array($result)){
                
                $classsec=$row["GradeLevel"].'-'.$row["Section"].' Room:'.$row["RoomNumber"];
                $name=$row["Subject"];
                $data['SuggSubjectId']    = $row['SuggSubjectId'];
                $data['id']    = $row['SubjectCode'];
                $data['value'] = $name;
                $data['HoursperSem'] = $row['HoursperSem'];
                $data['Description'] = $row['Description'];
                $data['CurriculumSubjectName'] = $row['CurriculumSubjectName'];
                $data["PreRequisite"]=is_null($row["PreReqSubject"])||$row["PreReqSubject"]==""?"None":$row["PreReqSubject"];
                $data['classsec']=$classsec;
                $data['label'] =
                '<div class="media">
				  <div class="media-body">
				    <h4 class="mt-0">'.$name.'</h4>
				    <h6 class="mb-1">'.$row["Description"].'</h6>
				    <div class="mb-1 lead">'.
				        '<div class="badge badge-success"> Curriculum: '.$row["CurriculumSubjectName"].'</div> '.
    				    '<div class="badge badge-success">Hrs/Sem: '.$row["HoursperSem"].'</div> '.
    				    '<div class="badge badge-success"> PreRequisite: '.($row["PreRequisite"]==NULL||$row["PreRequisite"]==""||$row["PreRequisite"]==0?"None":$row["PreRequisite"]).'</div> '.
    				    '<div class="badge badge-danger"> Class Sec: '.$classsec.'</div>
				     </div>
                  </div><hr>
				</div>';
                
                array_push($output, $data);
            }
        }
        
        return json_encode($output);
    }
    
}