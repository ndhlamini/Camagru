<?php
    include_once "config/setup.php";
    session_start();
    if (isset($_POST['save-changes']))
    {
        $id = $_SESSION['id'];
        $username = htmlspecialchars(trim($_POST['username_update']));
        $email = htmlspecialchars(trim($_POST['email_update']));
        $notification = $_POST['notifi_update'];
        try
        {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE users SET `user_name` = ?, user_email = ?, `notification` = ? WHERE `user_id` = ?";
            $res = $conn->prepare($sql);
            $res->bindParam(1, $username);
            $res->bindParam(2, $email);
            $res->bindParam(3, $notification);
            $res->bindParam(4, $id);
            $res->execute();
            if ($res->rowCount())
            {
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["notification"] = $notification;
                header("Location: login/logout.php");
                die();
            }
            else
            {
                header("Location: edit_profile.php");
            }
        }
        catch(PDOException $ex)
        {
            echo "Error : ".$ex->getMessage();
        }
    }
    header("Location: edit_profile.php");
?>