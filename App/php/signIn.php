<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 17.06.2017
 * Time: 16:55
 */
session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$email = $password = "";
$dataValid = true;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty($_POST["email"])) {
        echo "Błędne dane logowania";
        $dataValid = false;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Błędne dane logowania";
            $dataValid = false;
        }
    }
    if (empty($_POST["password"])) {
        echo "Błędne dane logowania";
        $dataValid = false;
    } else {
        $password = test_input($_POST["password"]);
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

        $retUserID = $retMail = $retPassword = "";

        $quotedEMail = quoter($email);

        try {
            $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
            // seth the PDO error mode to exception
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT UserID, Mail, PassHash FROM Users WHERE Mail = $quotedEMail";
            foreach ($connection->query($sql) as $row) {
                $retUserID = $row['UserID'];
                $retMail = $row['Mail'];
                $retPassword = $row['PassHash'];
            }
            if (($email == $retMail) && ($password == $retPassword)) {

                $_SESSION['userID'] = $retUserID;
                $_SESSION['password'] = $retPassword;
                echo "OK";
            } else {
                echo "Błędne dane logowania";
            }

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $connection = null;
    }
}