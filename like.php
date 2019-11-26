<?php
    include_once "config/setup.php";
    session_start();
    if (isset($_POST['image_id']))
    {
        try
        {
            $image_id = $_POST['image_id'];
            $user_id = $_SESSION['id'];
            $user_image = $_POST['user_image'];
            if ($user_id)
            {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM liked WHERE image_id = ? AND `user_id` = ?";
                $res = $conn->prepare($sql);
                $res->bindParam(1, $image_id);
                $res->bindParam(2, $user_id);
                $res->execute();
                if (!$res->rowCount())
                {
                    $sql = "SELECT likeno FROM likes WHERE image_id = ?";
                    $res = $conn->prepare($sql);
                    $res->bindParam(1, $image_id);
                    $res->execute();

                    if ($res->rowCount())
                    {
                        $row = $res->fetch();
                        $number = $row['likeno'] + 1;
                        $sql = "UPDATE likes SET likeno = ? WHERE image_id = ?";
                        $res = $conn->prepare($sql);
                        $res->bindParam(1, $number);
                        $res->bindParam(2, $image_id);
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
                                $body = "One of your pictures got liked.";
                                mail($row['user_email'], "Picture Like", $body, "From : info@camagru.co.za");
                            }
                        }
                        $sql = "INSERT INTO liked (image_id, `user_id`) VALUES(?, ?)";
                        $res = $conn->prepare($sql);
                        $res->bindParam(1, $image_id);
                        $res->bindParam(2, $user_id);
                        $res->execute();
                    }
                }
                header('Location: home.php');
            }
            else
            {
                header('Location: home.php?sign=1');
            }
        }
        catch(PDOException $ex)
        {
            echo "Error : ".$ex->getMessage();
        }
    }
?>