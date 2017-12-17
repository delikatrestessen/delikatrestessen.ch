<?php
class uploader{
    var $uploadLocation;
    var $tagetName;
    var $locationName;

    function uploader($targetName='',$locationName=''){
        $this->uploadLocation = getcwd().DIRECTORY_SEPARATOR;
	      $this->targetName = $targetName;
	      $this->locationName = $locationName;
    }

    function showUploadForm($msg='',$error=''){
?>
       <div id="container">
            <div id="header"><div id="header_left"></div>
<?php
      echo '<div id="header_main">Upload ' . $this->locationName . ' Fridge Image</div><div id="header_right"></div></div>';
?>
            <div id="content">
<?php
if ($msg != ''){
    echo '<p class="msg">'.$msg.'</p>';
} else if ($error != ''){
    echo '<p class="emsg">'.$error.'</p>';
}
?>
                <form action="" method="post" enctype="multipart/form-data" >
                     <center>
                         <label>File:
                             <input name="myfile" type="file" size="30" />
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                         </label>
                     </center>
                 </form>
             </div>
         </div>
<?php
    }

    function uploadFile(){
        if (!isset($_POST['submitBtn'])){
            $this->showUploadForm();
        } else {
            $msg = '';
            $error = '';

            //Check destination directory
            if (!file_exists($this->uploadLocation)){
                $error = "The target directory doesn't exists!";
            } else if (!is_writeable($this->uploadLocation)) {
                $error = "The target directory is not writeable!";
            } else {
                // Everything OK - do the upload
                $tempPath = $this->uploadLocation . "../tmp.jpg";
                $targetPath = $this->uploadLocation . "../" . $this->targetName;

                if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $tempPath)) {
                    // Resize and rotate the uploaded file
                    $size = getimagesize($tempPath);
                    if( $size[2] & IMG_JPG) {
                        $ratio = $size[0]/$size[1]; // width/height
                        if( $ratio > 1) {
                            $height = 500;
                            $width = 500*$ratio;
                            $rotate = true;
                        }
                        else {
                            $width = 500;
                            $height = 500/$ratio;
                            $rotate = false;
                        }
                        $imageResource = imagecreatefromjpeg($tempPath);
                        $resized = imagecreatetruecolor($width,$height);
                        imagecopyresampled($resized,$imageResource,0,0,0,0,$width,$height,$size[0],$size[1]);
                        if ($rotate) {
                            $image = imagerotate($resized, -90, 0);
                            imagejpeg($image, $targetPath, 90);
                            imagedestroy($image);
                        } else {
                          imagejpeg($resized, $targetPath, 90);
                        }
                        imagedestroy($imageResource);
                        imagedestroy($resized);
                        $msg = "Image uploaded successfully to " . $this->targetName . "!";
                    } else {
                        $error = "Non JPG images are not supported for upload!";
                    }
                } else{
                    $error = "The upload process failed!";
                }

            }
            $this->showUploadForm($msg,$error);
        }
    }
}
?>
