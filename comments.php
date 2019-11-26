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
        session_start();
        if (!isset($_SESSION['id']))
        {
            header('Location: home.php?sign=1');
        }
        if (isset($_POST['image_name']))
        {
            $_SESSION['image_name'] = $_POST['image_name'];
            $_SESSION['image_id'] = $_POST['image_id'];
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
        <div class = "main-comment">
            <div class = "comment-image">
                <img src = "<?php echo $_SESSION['image_name'];?>"/>
            </div>
            <div class = "comment-list">
                <?php
                    $image_id =  $_SESSION['image_id'];
                    $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT * from comments WHERE image_id = ? ORDER BY comment_id DESC";
                    $res = $conn->prepare($sql);
                    $res->bindParam(1, $image_id);
                    $res->execute();
                    if ($res->rowCount())
                    {
                        $img_dir = "uploads/images/";
                        $html = '<ul class = "comments-list">';
                        while ($row = $res->fetch())
                        {
                            $comment = $row['comment'];
                            $html .= '<li ><p>'.$comment.'</p></li>';
                        }
                        $html .= '</ul>';
                        echo $html;
                    }
                ?>
            </div>
            <div class = "bottom-div">
            <form action="insert_comments.php" method="POST">
                <input id="comment-text" name="comment" type = "text" required/>
                <input  name="image_id" type = "hidden" value = "<?php echo $image_id;?>"/>
                <input  name="user_image" type = "hidden" value = "<?php echo $_POST['user_image'];?>"/>
                <input id="send-comment" name="send" type = "submit" value = "send"/>
            </form>
            </div>
        </div> 
    </div>
    <footer>
        <p class = "footer-text">&copy; <em>ndlamini</em> 2019</p>
    </footer>
</body>
</html>