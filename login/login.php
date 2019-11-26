<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
</body>
</html> 
<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}


require_once '../config/setup.php';
 
$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $password = "";
    $username_err = $password_err = "";
	if(empty(trim($_POST["username"])))
	{
        $username_err = "Please enter username.";
	}
	else
	{
        $username = htmlspecialchars(trim($_POST["username"]));
    }
     
	if(empty(trim($_POST["password"])))
	{
        $password_err = "Please enter your password.";
	}
   	else
	{
        $password = hash('md5',trim($_POST["password"]), FALSE);
    }
    
    if(empty($username_err) && empty($password_err))
	{
        try
        {
        $sql = "SELECT * FROM users WHERE `user_name` = ?";
        $stmt = $conn->prepare($sql);
		if($stmt)
		{
            
           $stmt->bindParam(1, $username);
            
            $param_username = $username;
           
			if($stmt->execute())
			{
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
				if($stmt->rowCount())
				{
                    $id = $row['user_id'];
                    $username = $row['user_name']; 
                    $hashed_password = $row['user_password'];
                    $email = $row['user_email'];
                    $notification = $row['notification'];
                    $activated = $row['activated'];
					if($activated)
					{
						if($password == $hashed_password)
						{
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            $_SESSION["notification"] = $notification;                  
                            
                            header("location: ../index.php");
						} 
						else
						{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                    else
                    {
                        $password_err = "Please Verify your account.";
                    }
				} 
				else
				{
                    $username_err = "No account found with that username.";
                }
			} 
			else
			{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    catch(PDOException $ex)
    {
        echo "Error : ".$ex->getMessage();
    }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://i.dailymail.co.uk/i/pix/2012/09/21/article-2206528-151B468A000005DC-608_964x776.jpg">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        /* .wrapper { background-color : yellow;} */
    </style>
    <link rel="stylesheet" href="../main.css">
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>
