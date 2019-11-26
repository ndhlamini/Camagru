<?php
include_once "database.php";

try 
{
    $conn = new PDO($DB_DSN,$DB_USER,$DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS camagru";
    $res = $conn->prepare($sql);
    $res->execute();
    $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS users
            (
                `user_id` INT PRIMARY KEY AUTO_INCREMENT,
                `user_name` VARCHAR(25) UNIQUE NOT NULL,
                `user_email` VARCHAR(50) UNIQUE NOT NULL,
                `user_password` VARCHAR(255) NOT NULL,
                `activated` int(1) DEFAULT 0,
                `activation_code` VARCHAR(1000) NOT NULL, 
                `notification` int(1) DEFAULT 1
            )";
    $res = $conn->prepare($sql);
    $res->execute();

    $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS images
            (
                `image_id` INT PRIMARY KEY AUTO_INCREMENT,
                `image_name` VARCHAR(25) NOT NULL,
                `image_path` VARCHAR(50) NOT NULL,
                `user_id` INT NOT NULL,
                FOREIGN KEY (`user_id`) REFERENCES users (`user_id`)
            )";
    $res = $conn->prepare($sql);
    $res->execute();

    $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS likes
            (
                `like_id` INT PRIMARY KEY AUTO_INCREMENT,
                `likeno` INT NOT NULL DEFAULT 0,
                `image_id` INT NOT NULL,
                FOREIGN KEY (`image_id`) REFERENCES images (`image_id`)
            )";
    $res = $conn->prepare($sql);
    $res->execute();

    $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS comments
            (
                comment_id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                comment VARCHAR(5000) NOT NULL,
                image_id INT(11) NOT NULL,
                `user_id` INT(11) NOT NULL,
                FOREIGN KEY(image_id) REFERENCES images(image_id),
                FOREIGN KEY(`user_id`) REFERENCES users(`user_id`)
            )";
    $conn->exec($sql);

    $conn = new PDO($DB_MYSQL, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS liked
            (
                id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
                image_id INT(11) NOT NULL,
                `user_id` INT(11) NOT NULL,
                FOREIGN KEY(image_id) REFERENCES images(image_id),
                FOREIGN KEY(`user_id`) REFERENCES users(`user_id`)
            )";
    $conn->exec($sql);
}
catch(PDOException $ex)
{
    echo "Connection Failed: " . $ex->getMessage();
}
?>