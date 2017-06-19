<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 19.06.2017
 * Time: 18:20
 */

session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $dataValid = true;
    $accName = $accType = "";
    $userID = $_SESSION['userID'];

    if (empty($_POST["name"])) {
        echo "Błędne dane";
        $dataValid = false;
    } else {
        $accName = test_input($_POST["name"]);
    }

    if (empty($_POST["type"])) {
        echo "Błędne dane";
        $dataValid = false;
    } else {
        $accType = test_input($_POST["type"]);
    }

    if ($dataValid) {
        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = "^79q+a8&}u9/4Un";
        $dbname = "fbo";

        function quoter($data) {
            $data = "'" . $data . "'";
            return $data;
        }

        $quotedName = quoter($accName);
        $quotedType = quoter($accType);

        try {
            $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
            // seth the PDO error mode to exception
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO Accounts (UserID, Name, Type) VALUES ($userID, $quotedName, $quotedType)";
            $connection->exec($sql);
            echo "Konto utworzone";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $connection = null;
    }
}