<?php
    include_once "config/setup.php";
    session_start();
    if(isset($_POST['send']) && isset($_POST['image_id']))
    {
        $user_id = $_SESSION["id"];
        $image_id = $_POST['image_id'];
        $user_image = $_POST['user_image'];
        $comment = htmlspecialchars(trim($_POST['comment']));
        try
        {
            if (!empty($comment))
            {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO comments (comment, image_id, `user_id`) VALUES (?, ?, ?)";
                $res = $conn->prepare($sql);
                $res->bindParam(1, $comment);
                $res->bindParam(2, $image_id);
                $res->bindParam(3, $user_id);
                $res->execute();

                $sql = "SELECT * FROM users WHERE `user_id` = ?";
                $res = $conn->prepare($sql);
                $res->bindParam(1, $user_image);
                $res->execute();
                if ($res->rowCount())
                {
                    $row = $res->fetch();
                    if ($row['notification'])
                    {
                        $body = "Someone just commented on your picture.";
                        mail($row['user_email'], "Picture comment", $body, "From : info@camagru.co.za");
                    }
                }
            }
            header('Location: comments.php');
        }
        catch(PDOException $ex)
        {
            echo "Error : ".$ex->getMessage();
        }
    }
?>