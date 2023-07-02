<?php

 class Upload {
     private $filename = null ;
     private $error = null ;

     public function __construct($file, $uploadFolder)
     {
        if (!empty($_FILES[$file]["name"])) {
            $orginal = $_FILES[$file]["name"] ;
            $tmp_name = $_FILES[$file]["tmp_name"] ;
            $size = $_FILES[$file]["size"] ;
          
            $ext = strtolower(pathinfo($orginal, PATHINFO_EXTENSION)) ;
            $whitelist = [ "gif", "png", "jpg", "jpeg", "bmp", "jfif"] ;
            if ( !in_array($ext, $whitelist)) {
                $this->error = "Not an Image File" ;
            } else if ( $size > 1024 * 1024) {
                $this->error = "Too big file" ;
            } else {
                $this->filename = sha1( "AYBU" . uniqid() . $orginal) . ".$ext" ; // a string with 40 characters
                if ( !move_uploaded_file($tmp_name, $uploadFolder . "/" . $this->filename)) {
                    $this->error = "System Error" ;
                    $this->filename = null ; 
                }
            }
        } else {
            $this->error = "No file uploaded" ;
        }
     }


     public function file() {
         return $this->filename ;
     }

     public function error() {
         return $this->error ;
     }
 }