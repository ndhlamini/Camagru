<?php
    include_once "../config/setup.php";
    session_start();
    $base64 = str_replace("data:image/png;base64,", "", $_POST['image-url']);
    $base64  = str_replace(" ", "+",  $base64);
    $image = base64_decode($base64);
    $name = $_SESSION["username"].time().'.png';
    file_put_contents('images/'.$name, $image);
    function super_impose($src,$dest,$added)
    {
        $base = imagecreatefrompng($src);
        $superpose= imagecreatefrompng($added);
        list($width, $height) = getimagesize($src);
        list($width_small, $height_small) = getimagesize($added);
        imagecopyresampled($base , $superpose,  0, 0, 0, 0, 100, 100,$width_small, $height_small);
        imagepng($base , $dest);
    }
    super_impose("images/".$name,"images/".$name,"../stickers/".$_POST['image']);
    try
    {
        $path = "uploads/images/";
        $user_id = $_SESSION['id'];
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO images (image_name, image_path, `user_id`) VALUES (?, ?, ?)";
        $res = $conn->prepare($sql);
        $res->bindParam(1, $name);
        $res->bindParam(2, $path);
        $res->bindParam(3, $user_id);
        $res->execute();
        if ($res->rowCount())
        {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT image_id FROM images ORDER BY image_id DESC LIMIT 1";
            $res = $conn->prepare($sql);
            $res->execute();
            if ($res->rowCount())
            {
                $row = $res->fetch();
                $image_id = $row['image_id'];

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO likes (image_id) VALUES(?)";
                $res = $conn->prepare($sql);
                $res->bindParam(1, $image_id);
                $res->execute();
            }
            echo "success";
        }
    }
    catch(PDOException $ex)
    {
        echo "Error : ".$ex->getMessage();
    }
?>