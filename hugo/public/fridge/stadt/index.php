<?php require_once("../uploader/uploader.class.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>Delikatrestessen Uploader</title>
   <link href="../uploader/style/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
    $myUpload = new uploader("stadt.jpg", "Stadt");
    $myUpload->uploadFile();
?>
</body>
