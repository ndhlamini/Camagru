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
                    $username; $id; $email;
                    if (isset($_SESSION['username']))
                    {
                        echo '<a class = "nav" href="camera.php"><i class = "fas fa-camera"></i></a>
                        <a class = "nav" href="edit_profile.php"><i class="far fa-user"></i></a>
                        <a class = "nav" href="login/logout.php"><i class="fas fa-sign-out-alt"></i></a>';
                        $id = $_SESSION['id'];
                        $username = $_SESSION['username'];
                        $email = $_SESSION['email'];
                    }
                    else
                    {
                        echo '<a class = "nav" href="login/login.php"><i class="fas fa-sign-in-alt"></i></a>';
                    }
                ?>
        </header>
        <section class="container">
            <div class="profile-edit">
                <div class="card-header">
                    <form action = "save_changes.php" method = "POST">
                    <div>
                        <label>Want to change the username?:</label>
                        <input type = "text" name = "username_update"  value = "<?php echo $_SESSION['username'];?>" required/><br/><br/>
                        <label>Want to change the email?:</label>
                        <input type = "text" name = "email_update" value = "<?php echo $_SESSION['email'];?>" required/><br/><br/>
                        <label>Want to receive nofications?:</label>
                        <input type = "radio" name = "notifi_update" 
                        <?php if(isset($_SESSION['notification']) && $_SESSION['notification'] == 1)
                        {
                            echo "Checked";
                        }
                        ?> value = "1"/>YES<input type = "radio" name = "notifi_update"
                        <?php if(isset($_SESSION['notification']) && $_SESSION['notification'] == 0)
                        {
                            echo "Checked";
                        }
                        ?>
                        value = "0"/>NO
                    </div>
                    <div class = "buttons">
                        <input type = "hidden" id = "sticker-name"/><br/><br/>
                        <button id = "save" type = "submit" name = "save-changes" value = "save">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </section>
    <footer>
        <p class = "footer-text">&copy; <em>ndlamini</em> 2019</p>
    </footer>
    </body>
</html>