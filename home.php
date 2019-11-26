<!DOCTYPE html>
<html lang="en">
<head>
        <title>Camagru</title>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    </head>
<body>
    <?php
        include_once "config/setup.php";
        if(isset($_GET['sign']))
        {
            echo '<script type="text/javascript">alert("Sign in first.");</script>';
        }
    ?>
    <header>
        <a href="home.php" class = "nav"><i class="fas fa-home"></i></a>
        <?php
            session_start();
            if (isset($_SESSION['username']))
            {
                echo '<a class = "nav" href="camera.php"><i class = "fas fa-camera"></i></a>
                <a class = "nav" href="edit_profile.php"><i class="far fa-user"></i></a>
                <a class = "nav" href="login/logout.php"><i class="fas fa-sign-out-alt"></i></a>';
            }
            else
                echo '<a class = "nav" href="login/login.php"><i class="fas fa-sign-in-alt"></i></a>';
        ?>
    </header>
    <div class="main-content">
    <?php
        try
        {
            if (isset($_GET['pageno'])) 
            {
                $pageno = $_GET['pageno'];
            } 
            else 
            {
                $pageno = 1;
            }
            $total_pages;
            $pic_per_page = 10;
            $start = ($pageno-1) * $pic_per_page;
            $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * from images";
            $res = $conn->prepare($sql);
            $res->execute();
            if ($res->rowCount())
            {
                $total_images = $res->rowCount();
                $total_pages = ceil($total_images / $pic_per_page);


                $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT image_name,image_path,images.image_id, images.user_id, li.likeno FROM images INNER JOIN likes as li WHERE li.image_id = images.image_id ORDER BY images.image_id DESC LIMIT $start, $pic_per_page";
                $res = $conn->prepare($sql);
                $res->execute();
                if ($res->rowCount())
                {
                    $list = '<ul class = "list-gallery">';
                    while ($row = $res->fetch())
                    {
                        $list .= '<li><img src = "'.$row['image_path'].$row['image_name'].'" width = "340px" height = "250px"/><br/>
                                <form action= "like.php" method="POST">        
                                <input class = "like" type = "submit" value = "like"/><label style = "float:left; padding-left:5px">'.$row['likeno'].'</label>
                                <input type="hidden" name = "image_id" value = "'.$row['image_id'].'"/>
                                <input type="hidden" name = "user_image" value = "'.$row['user_id'].'"/>
                                </form>
                                <form action= "comments.php" method="POST">
                                    <input type="hidden" name = "image_name" value = "'.$row['image_path'].$row['image_name'].'"/>
                                    <input type="hidden" name = "image_id" value = "'.$row['image_id'].'"/>
                                    <input class = "comment" type = "submit" value = "comment"/>
                                    <input type="hidden" name = "user_image" value = "'.$row['user_id'].'"/>
                                </form></li>';
                    }
                    $list .= '</ul>';
                    echo $list;
                }
            }
        }
        catch(PDOException $ex)
        {
            echo "Error : ".$ex->getMessage();
        }
    ?>
    </div>
    <div class = "pagination-div">
        <ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo 'home.php'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo 'home.php'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
        </ul>
    </div>
    <footer>
        <p class = "footer-text">&copy; <em>ndlamini</em> 2019</p>
    </footer>
</body>
</html>