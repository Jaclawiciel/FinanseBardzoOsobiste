<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 17.06.2017
 * Time: 16:04
 */

if (!(empty($_SESSION['userID']) || empty($_SESSION['password']))) {
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "^79q+a8&}u9/4Un";
    $dbname = "fbo";

    $userID = $_SESSION['userID'];
    $password = "";

    try {
        $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
        // seth the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT UserID, PassHash FROM Users WHERE UserID = $userID";
        foreach ($connection->query($sql) as $row) {
            $userID = $row['UserID'];
            $password = $row['PassHash'];
        }
        if (($userID == $_SESSION['userID']) && ($password == $_SESSION['password'])) {
            header("Location: budget.html");
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $connection = null;
}