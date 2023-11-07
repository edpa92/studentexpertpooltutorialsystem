<?php

class FileUploadModel{
    private $msg = "";
    private $filename = "";

    public function __construct(){  
    }

    public function UploadFile($ControlName, $Path, $filename){
        $msg = "";
        $target_dir = $Path;
        $temp = explode(".", $_FILES[$ControlName]["name"]);
        $imageFileType = end($temp);
        $target_file = $target_dir . $filename.".".$imageFileType;
        $uploadOk = 1;
       
        $check = getimagesize($_FILES[$ControlName]["tmp_name"]);
          if($check !== false) {
            $uploadOk = 1;
          } else {
            $msg .= "File is not an image. ";
            $uploadOk = 0;
          }

       

        // Check file size
        if ($_FILES[$ControlName]["size"] > 5000000) {
            $msg .= "Sorry, your file is too large. ";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
            $msg .="Sorry, only JPG, JPEG, PNG files are allowed. ";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg .= "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$ControlName]["tmp_name"], $target_file)) {
                $msg .= "The file has been uploaded. ";
                $filename = $filename.".".$imageFileType;
            } else {
                $msg .= "Sorry, there was an error uploading your file.";
            }
        }


        $this->setMsg($msg);
        $this->setFilename($filename);
        return $target_file;
    }

    
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * Set the value of msg
     *
     * @return  self
     */ 
    public function setMsg($msg)
    {
        $this->msg = $msg;

        return $this;
    }

    /**
     * Get the value of filename
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

   
}
?>