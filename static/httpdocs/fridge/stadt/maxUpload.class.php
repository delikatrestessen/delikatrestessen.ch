<?php
class maxUpload{
    var $uploadLocation;
    var $tagetName;
    var $locationName;

    function maxUpload(){
        $this->uploadLocation = getcwd().DIRECTORY_SEPARATOR;
	$this->targetName = "stadt.jpg";
	$this->locationName = "Stadt";
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
                $target_path = $this->uploadLocation . $this->targetName;

                if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
                    $msg = "Image uploaded successfully to " . $this->targetName . "!";
                } else{
                    $error = "The upload process failed!";
                }
            }
            $this->showUploadForm($msg,$error);
        }

    }
}
?>
