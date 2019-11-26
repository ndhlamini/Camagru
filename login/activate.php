<?php
 require_once '../config/setup.php';
 if (isset($_GET["email"]) && isset($_GET["code"]))
 {
     $email = $_GET["email"];
     $code = $_GET["code"];
    try
    {
     $activate = 1;
     $sql = "UPDATE users SET activated = ? WHERE user_email = ? AND activation_code = ?";
     $res = $conn->prepare($sql);
     $res->bindParam(1, $activate);
     $res->bindParam(2, $email);
     $res->bindParam(3, $code);
     $res->execute();
     if ($res->rowCount())
     {
         echo "<br/>Account is verified";
     }
     else
     {
        echo "<br/>Account is not verified";
     }
    }
    catch(PDOException $ex)
    {
        echo "Error : ".$ex->getMessage();
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="login.php">login</a>
</body>
</html>