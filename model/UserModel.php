<?php
include_once ('DbConnection.php');


class UserModel extends DbConnection
{

    public function __construct()
    {
        parent::__construct();
    }
            
    public function check_user($username, $password)
    {
        $uname = $this->escapeString($username);
        $pw = $this->escapeString($password);
        
        $sql = "SELECT * FROM users_table WHERE `Username` = '$uname'";
        $query = $this->getConnection()->query($sql);
        
        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
            
            if (password_verify($pw, $row["Password"])) {
                return True;
            }
        }
        
        return false;
    }
    
    public function check_login($username, $password)
    {
        $uname = $this->escapeString($username);
        $pw = $this->escapeString($password);
        
        $sql = "SELECT * FROM users_table WHERE `Username` = '$uname'";
        $query = $this->getConnection()->query($sql);

        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
           if ($row['Status']!="active") {               
               return "Unable to Login, Your account has been deactivated by the System Admin";
           }
            
            
          if (password_verify($pw, $row["Password"])) {

            $_SESSION["loggedinSEPTS"] = TRUE;
            $_SESSION["UserIdSEPTS"] = $row['UserId'];
            $_SESSION["UsernameSEPTS"] = $row['Username'];
            

            if (!is_null($row["EmpId"]) && $row["EmpId"]!="") {
                $empid = $row["EmpId"];
                $sql = "SELECT * FROM `employees_table` WHERE `EmpKey`=$empid";
                $query = $this->connection->query($sql);

                if ($query->num_rows > 0) {
                    $userId = $row['UserId'];
                    $rowEmp = $query->fetch_array();
                    
                    $sql = "SELECT `roles_table`.`Role`, `userroles_table`.`UserId`, `roles_table`.`RoleId`
                    FROM `roles_table` LEFT JOIN `userroles_table` ON `userroles_table`.`RoleId` = `roles_table`.`RoleId`
                        WHERE `userroles_table`.`UserId`=$userId";

                    $query = $this->connection->query($sql);
                    $rowRole = $query->fetch_array();
                    $_SESSION["FullnameSEPTS"] = $rowEmp["Firstname"]." " . $rowEmp["MI"] ." " . $rowEmp["Lastname"];
                    $_SESSION["NameInSideBarSEPTS"] = $rowEmp["Firstname"];
                    $_SESSION["DesignationSEPTS"] = $rowEmp["Designation"];
                    $_SESSION["EmpIdCSHS"] =  $rowEmp['EmpKey'];
                    $_SESSION["EmpIdCodeSEPTS"] =  $rowEmp['EmpId'];                    
                    $_SESSION["IsVerifiedSEPTS"] =  $rowEmp['Verified'];
                    
                    $_SESSION["RoleSEPTS"] = "Instructor";
                    $_SESSION["RoleIdSEPTS"] = $rowRole['RoleId'];
                    $_SESSION["PhotoSEPTS"] = ($rowEmp['Photo']!=""?$rowEmp['Photo']:"img/undraw_profile.svg");                    
                }
                
            }else if (! is_null($row["StudentId"]) && $row["StudentId"]!="") {
                $studid = $row["StudentId"];
                $sql = "SELECT * FROM `student_table` WHERE `StudentId`=$studid";
                $query = $this->connection->query($sql);
                
                if ($query->num_rows > 0) {
                    $rowEmp = $query->fetch_array();
                   
                    
                    $_SESSION["FullnameSEPTS"] = $rowEmp["Firstname"]." " . $rowEmp["Middlename"] ." " . $rowEmp["Lastname"];
                    $_SESSION["NameInSideBarSEPTS"] = $rowEmp["Firstname"];
                    $_SESSION["DesignationSEPTS"] = "Student";
                    $_SESSION["StudentId"] =  $rowEmp['StudentId'];
                    $_SESSION["RoleSEPTS"] = "Student";
                    $_SESSION["PhotoSEPTS"] = ($rowEmp['Image']!=""&&$rowEmp['Image']!=Null?$rowEmp['Image']:"img/undraw_profile.svg");
                    $_SESSION["IsVerifiedSEPTS"] = $rowEmp['EmailVerified'];
                  
                }
                
            }else {
            	$_SESSION["FullnameSEPTS"] = "System Admin";
            	$_SESSION["NameInSideBarSEPTS"] = "System Admin";
                $_SESSION["DesignationSEPTS"] = "System Admin";
                $_SESSION["PhotoSEPTS"] = "img/undraw_rocket.svg";
                $_SESSION["RoleSEPTS"] = "Admin";
            }

            $this->updateUserLastLogin($row['UserId']);
                if (isset($_SESSION["IsVerifiedSEPTS"]) && $_SESSION["IsVerifiedSEPTS"]==0) {
                    
                    session_destroy();
                    return "Your account is not yet verified by the System Admin! Please contact system administrator.";
                }
            
            	return True;
        	}
        }
            
        return "Invalid Username/Password";
    }
    
    public function updateUserLastLogin($Id)
    {
        $curDate = $this->getCurrentDate();
        $sql = "UPDATE `users_table` SET `LastLogin`='$curDate' WHERE `UserId`=$Id";
        return $this->getConnection()->query($sql);
    }
    
    public function AddEmpUser($empId, $email, $roleId, $pass)
    {
        $hash_default_salt_pw = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users_table`(`EmpId`, `Username`, `Password`, `Status`) VALUES ('$empId','$email','$hash_default_salt_pw','active')";
        
        if ($this->getConnection()->query($sql)) {
            $userId = $this->getConnection()->insert_id;
            
            $sql = "INSERT INTO `userroles_table`(`UserId`, `RoleId`) VALUES ('$userId','$roleId')";
            return $this->getConnection()->query($sql);
        }
        return FALSE;
    }
    
    public function AddStudentUser($studId, $status, $pw, $email)
    {
        
        $hash_default_salt_pw = password_hash($pw, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users_table`(`StudentId`, `Username`, `Password`, `Status`) VALUES ('$studId','$email','$hash_default_salt_pw','$status')";
        
        if ($this->getConnection()->query($sql)) {
            $userId = $this->getConnection()->insert_id;
            
            $sql = "INSERT INTO `userroles_table`(`UserId`, `RoleId`) VALUES ($userId,9)";
            return $this->getConnection()->query($sql);
        }
        return FALSE;
    }
    
    public function ChangePW($UserId, $username, $password, $newPW, $newPWAgain)
    {
        $sql = "SELECT * FROM users_table WHERE Username = '$username' AND UserId=$UserId";
        $query = $this->getConnection()->query($sql);
        if ($query->num_rows > 0) {
            $row=$query->fetch_assoc();
            if (password_verify($password, $row["Password"])) {
                
                
                if ($newPW==$newPWAgain) {
                    
                    $hash_default_salt_pw = password_hash($newPWAgain, PASSWORD_DEFAULT);
                    $sql = "UPDATE `users_table` SET `Password`='$hash_default_salt_pw' WHERE `UserId`=$UserId AND Username = '$username'";
                    $this->getConnection()->query($sql);
                    return "Password Changed success!";
                }
                
                return "New Password not Matched!";
            }
        }
        return "You have entered Invalid current password.";
        
    }
    
    
    
    
    public function getAllEmpUsers()
    {
        $sql = "SELECT `users_table`.`UserId` AS UserId, `users_table`.`EmpId` AS EmpKey, `users_table`.`Username`, `users_table`.`LastLogin`, `users_table`.`Status`, `userroles_table`.`RoleId`, `roles_table`.`Role`, `employees_table`.`EmpId` AS EmpIDNo, `employees_table`.`Firstname`, `employees_table`.`MI`, `employees_table`.`Lastname`,`employees_table`.`NameExt`, `employees_table`.`Designation` 
                FROM `users_table` 
                LEFT JOIN `userroles_table` ON `userroles_table`.`UserId` = `users_table`.`UserId` 
                LEFT JOIN `roles_table` ON `userroles_table`.`RoleId` = `roles_table`.`RoleId` 
                LEFT JOIN `employees_table` ON `users_table`.`EmpId` = `employees_table`.`EmpKey` 
                WHERE  `users_table`.`EmpId` IS NOT Null;";
        $result=$this->getConnection()->query($sql);
        
        if (mysqli_num_rows($result)>0) {
            return $result;
        }
        return NULL;
    }    
        
    public function getAllStudUsers()
    {
        $sql = "SELECT `users_table`.`UserId`, `users_table`.`StudentId`, `users_table`.`Username`, `users_table`.`LastLogin`, `users_table`.`Status`, CONCAT(`student_table`.`Firstname`, ' ', `student_table`.`Middlename`, ' ', `student_table`.`Lastname`) AS Fullname, `student_table`.`DateRegistered`, `student_table`.`StudentType`, `student_table`.`EmailVerified`
            FROM `users_table` 
            LEFT JOIN `student_table` ON `users_table`.`StudentId` = `student_table`.`StudentId`
            WHERE `users_table`.`StudentId` IS NOT Null;";
        $result=$this->getConnection()->query($sql);
        
        if (mysqli_num_rows($result)>0) {
            return $result;
        }
        return NULL;
    }    
       
    public function GetUserEmpRole($empId)
    {
        $sql = "SELECT `userroles_table`.`UserId`, `userroles_table`.`RoleId`, `users_table`.`Status`, `employees_table`.`EmpId`, `employees_table`.`EmpKey`, `employees_table`.`Firstname`, `employees_table`.`MI`, `employees_table`.`Lastname`,`employees_table`.`Photo`, `employees_table`.`Designation`
        FROM `userroles_table`
        	LEFT JOIN `users_table` ON `userroles_table`.`UserId` = `users_table`.`UserId`
        	LEFT JOIN `employees_table` ON `users_table`.`EmpId` = `employees_table`.`EmpKey`
            where users_table.EmpId = $empId";
        
        $result=$this->getConnection()->query($sql);
        if (mysqli_num_rows($result)>0) {
            return $result;
        }
        
        return NULL; 
    }
        
    public function EditUser($UserId, $status, $roleId)
    {
        $sql = "UPDATE `users_table` SET `Status`='$status' WHERE `UserId`=$UserId";
        
        if ($this->getConnection()->query($sql)) {
            
            $sql = "UPDATE `userroles_table` SET `RoleId`='$roleId' WHERE `UserId`=$UserId";
            return $this->getConnection()->query($sql);
        }
        return FALSE;
    }
            
    public function isPasswordAndIdSame(){
        if (isset($_SESSION["EmpIdCSHS"])) {
            $empId=$_SESSION["EmpIdCSHS"];
            $sql = "SELECT `UserId`, `StudentId`, `EmpId`, `Username`, `Password`, `LastLogin`, `Status` FROM `users_table` WHERE `EmpId`=$empId";
            $query=$this->getConnection()->query($sql);
            $row=$query->fetch_assoc();
            
            return password_verify($_SESSION["EmpIdCodeCSHS"], $row['Password']);
        }
        return null;
    }
        
    public function ChangePWStudent($UserId, $newPW)
    {
        $sql = "SELECT * FROM users_table WHERE UserId=$UserId";
        $query = $this->getConnection()->query($sql);
        if ($query->num_rows > 0) {
                
                    $hash_default_salt_pw = password_hash($newPW, PASSWORD_DEFAULT);
                    $sql = "UPDATE `users_table` SET `Password`='$hash_default_salt_pw' WHERE `UserId`=$UserId";
                    
                    if ($this->getConnection()->query($sql)) {
                        $sql = "DELETE FROM `passwordresets_table` WHERE `user_id`=$UserId";
                        $this->getConnection()->query($sql);
                    }
                    return "Password Changed success! You can now Login using your new Password.";
              
        }
        
        
        return "User Account not found!";
        
    }
            
    public function resetPassword($Username, $EmpKey, $EmpId){
        
        $HashedDefaultPW=password_hash($EmpId, PASSWORD_DEFAULT);
        
        $sql = "UPDATE `users_table` SET `Password`='$HashedDefaultPW' WHERE `Username`='$Username' AND `EmpId`=$EmpKey;";
        
        return $this->getConnection()->query($sql);
    }
    
    public function getUserIdOfStudentbyEmail($email)
    {
        $sql = "SELECT `UserId` FROM `users_table` WHERE `Username`='$email' AND `StudentId` IS NOT NULL AND `Status`='Active'";
        
        $result=$this->getConnection()->query($sql);
        if (mysqli_num_rows($result)>0) {
            return $result->fetch_assoc()['UserId'];
        }
        
        return NULL;
    }
    
    public function changeStatusOfUser($uid, $status){
        $sql = "UPDATE `users_table` SET `Status`='$status' WHERE `UserId`=$uid";
        
        if ($this->getConnection()->query($sql)) {
             return TRUE;
        }
        return FALSE;
    }
    
    ///////////////////////////////////////////////////////////
    
    
    public function GetUserEmp($empId)
    {
        $sql = "SELECT `users_table`.*, `employees_table`.*, `departments_table`.`DepartmentName`
                FROM `users_table` 
                	LEFT JOIN `employees_table` ON `users_table`.`EmpId` = `employees_table`.`Id`
                	LEFT JOIN `departments_table` ON `employees_table`.`DepartmentId` = `departments_table`.`Id`
                    WHERE `employees_table`.`Id`='$empId'";

        return $this->getConnection()->query($sql);
    }
    
    public function GetUserEmpInv($empId)
    {
    	$sql = "SELECT `employees_table`.*, `departments_table`.`DepartmentName`
                FROM `employees_table`
                	LEFT JOIN `departments_table` ON `employees_table`.`DepartmentId` = `departments_table`.`Id`
                    WHERE `employees_table`.`Id`='$empId'";
    	
    	return $this->getConnection()->query($sql);
    }
            
    public function GetUserEmpByUserId($UId)
    {
    	$sql = "SELECT `users_table`.`Id` AS UserId, `employees_table`.*
        FROM `users_table` 
        	LEFT JOIN `employees_table` ON `users_table`.`EmpId` = `employees_table`.`Id`
            where`users_table`.`Id`= $UId";
    	
    	$queryResult =$this->getConnection()->query($sql);
    	if (mysqli_num_rows($queryResult) > 0) {
    		return $queryResult;
    	}
    	
    	return NULL;
    }
    
    public function GetUser($userId)
    {
        $sql = "SELECT `users_table`.*
                FROM `users_table`
                WHERE Id='$userId'";
        
        return $this->getConnection()->query($sql);
    }

    
    public function AddAdminUser()
    {
    	$hash_default_salt_pw = password_hash("pass", PASSWORD_DEFAULT);
    	$sql = "INSERT INTO `users_table`(`Username`, `Password`) VALUES ('DivisionAdmin','$hash_default_salt_pw')";
    	
    	if ($this->getConnection()->query($sql)) {
    		return  TRUE;
    	}
    	return FALSE;
    }


}