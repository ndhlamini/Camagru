<?php
    include_once "../config/setup.php";
    if (isset($_POST['remove']))
    {
        $image_name = $_POST['image'];
        $path = "images/".$image_name;
        if (is_file($path))
        {
            unlink($path);
            try
            {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SET FOREIGN_KEY_CHECKS=0";
                $res = $conn->prepare($sql);
                $res->execute();
            
                $sql = "DELETE FROM images WHERE image_name = ?";
                $res = $conn->prepare($sql);
                $res->bindParam(1, $image_name);
                $res->execute();
                if ($res->rowCount())
                    echo "success";
            }
            catch(PDOException $ex)
            {
                echo "Error : ".$ex->getMessage();
            }
        }
    }
?>