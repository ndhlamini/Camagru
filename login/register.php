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
   require_once '../config/setup.php';
   require_once 'inpuuut.php';
   require_once 'validate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
<div class="field">
<label for="username">Username</label>
<input type="text" name="username" id="username" value="" autocomplete="off" required>
</div>
<div class="field">
<label for="username">email</label>
<input type="text" name="email" id="email" value="" autocomplete="off" required>
</div>
<div class="field">
<label for="password">choose a password</label>
<input type="password" name="password" id="password" required>
</div>

<div class="field">
    <label for="password_again">Enter your password again</label>
    <input type="password" name="password_again" id="password_argain" required>
</div>
<input type="submit" name = 'register' value="Register">
</form>
</body>
</html>

<?php
require_once '../config/setup.php';
if(Input::exists()){
    $validate = new Validate();
    $validate = $validate->check($_POST, array(
        'username' => array(
            'required' => true,
            'min' => 2,
            'max' => 20,
            'unique' => 'users'
        ),
        'password' => array(
            'requuired' => true,
            'min' => 6
        ),
        'password_again' => array(
            'required' => true,
            'matches' => 'password'
        ),
        'email' => array(
            'required' => true,
            'min' => 2,
            'max' => 50
        )
    ));
    if($validate->passed())
    {
        if (isset($_POST['register']))
        {
             $username=$_POST["username"];
             $email=$_POST["email"];
             $password=$_POST["password"];
             $passowrd_again=$_POST["password_again"];
             if (empty($username) || empty($email) || empty($password) || empty(password_again))
             {
                 echo "all fields are required";
             }
             else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
             {
                 echo "$email is not valid";
             }
             else if ($password != $passowrd_again)
             {
                 echo "password do not match";
             }
             else
             {
                 $code = hash('md5', rand(10, 10000), FALSE);
                 $hash_pass = hash('md5', $password, FALSE);
                 $sql = "INSERT INTO users(`user_name`, user_email, user_password, activation_code) values(?, ?, ?, ?)";
                 $res = $conn->prepare($sql);
                 $res->bindParam(1, $username);
                 $res->bindParam(2, $email);
                 $res->bindParam(3, $hash_pass);
                 $res->bindParam(4, $code);
                 $res->execute();
                 if ($res->rowCount())
                 {
                     echo "Inserted successfully";
                     $body = "http://localhost:8080/Camagru_proj/login/activate.php?email=$email&code=$code";
                     mail($email, "Account Verification", $body, "From : info@camagru.co.za");
                     echo "Check the email to verify your account";
                 }
            }
        }

    }
    else
    {
        //output errors
        print_r($validate->errors());
    }
}
?>