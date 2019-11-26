<html>
    <head>
        <title>Camagru</title>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    </head>
    <body>
        <?php
            session_start();
            if (!isset($_SESSION['username']))
            {
                header("Location: index.php");
            }
        ?>
        <header>
                <a href="home.php" class = "nav"><i class="fas fa-home"></i></a>
                <?php
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
        <section class="container">
            <div class="card">
                <div class="card-header">
                    <div class="profile-img">
                        <video autoplay="true" id="videoElement" height = "500px" width = "500px"></video>
                        <img id="imageView" height = "300px" width = "300px"/>
                        <canvas id = "canvas" width="340px" height="250px"></canvas>
                    </div>
                    <div class = "stickers">
                    <ul class = "side-ul">
                        <li  id = "sticker1"><img src="stickers/sticker1.png" width="100" height="100"/></li>
                        <li id = "sticker2"><img src="stickers/sticker2.png" width="100" height="100"/></li>
                        <li  id = "sticker3"><img src="stickers/sticker3.png" width="100" height="100"/></li>
                        <li  id = "sticker4"><img src="stickers/sticker4.png" width="100" height="100"/></li>
                    </ul>
                    </div>
                    <div class = "buttons">
                        <input type = "file" accept="image/*" id="image-picker"/>
                        <input type = "hidden" id = "sticker-name"/>
                        <button id = "take-photo" type = "button">Take Photo</button>
                    </div>
                </div>
            </div>
            <div class = "pictures">
                    <?php
                        $img_dir = "uploads/images/";
                        $array = ' <ul class = "list-picture">';
                        $images = scandir($img_dir);
                        $images = preg_grep('~^'.$_SESSION["username"].'.*\.png$~', $images);
                        foreach($images as $img) 	
                        { 
                            if($img === '.' || $img === '..')
                            {
                                continue;
                            } 		   
                            if (preg_match('/.png/',$img))
                            {				
                                $array .= '<li class = "pic-items" onmousedown="removeImages(event)" ><img src = "'.$img_dir.$img.'"><br/></li>';
                            } 
                            else 
                            { 
                                continue;
                            }	
                        }
                        $array.= '</ul>';
                        echo $array;
                    ?>
            </div>
        </section>
        <script type="text/javascript" src = "js/script.js">
        </script>
    <footer>
        <p class = "footer-text">&copy; <em>ndlamini</em> 2019</p>
    </footer>
    </body>
</html>