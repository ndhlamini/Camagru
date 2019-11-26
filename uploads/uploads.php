<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Upload</h1>
</body>
</html>
<?php
if (isset($_POST['submit'])){
    $file = $file_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmpname'];
    $fileName = $_FILES['file']['name'];
    $fileName = $_FILES['file']['name'];
    $fileName = $_FILES['file']['name'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    if (in_array($fileActualExt, $allowed))
    {
         if ($fileError == 0)
         {
             if ($fileSize < 1000000)
             {
                 $fileNameNew = uniqid('', true).".".$fileActualExt;
                 $fileDestination = 'uploads/'.$fileNameNew;
                 move_uplaoded_file($fileTmpName, $fileDestination);

             }
             else 
             {
                 echo "Yor file is too big!";
             }

         }
         else
         {
             echo "there was an error uploading this file";
         }
    } 
    else
    {
        echo "you cannot upload files this type!";
    }
}
?>