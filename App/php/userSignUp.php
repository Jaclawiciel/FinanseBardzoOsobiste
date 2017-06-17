<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 16.06.2017
 * Time: 15:01
 */

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function quoter($data) {
    $data = "'" . $data . "'";
    return $data;
}

$firstName = $email = $password = $passwordRepeat = "";
$firstNameErr = $emailErr = $passwordErr = $passwordRepeatErr = "";
$dataValid = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['firstname'])) {
        $firstNameErr = "Pole \"Imię\" nie może być puste";
        $dataValid = false;
    } else {
        $firstName = test_input($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
            $firstNameErr = "Pole zawiera niedozwolone znaki. Wprowadź poprawnie swoje imię";
            $dataValid = false;
        }
    }
    if (empty($_POST["email"])) {
        $emailErr = "Pole \"Adres e-mail\" nie może być puste";
        $dataValid = false;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Pole zawiera niedozwolone znaki. Wprowadź poprawnie swój adres e-mail";
            $dataValid = false;
        }
    }
    if (empty($_POST["password"])) {
        $passwordErr = "Pole \"Hasło\" nie może być puste";
        $dataValid = false;
    } else {
        $password = test_input($_POST["password"]);
        if (!(preg_match("/[A-Z]/", $password)) && (preg_match("/[a-z]/", $password)) && (preg_match("/d/", $password))) {
            $passwordErr = "Hasło musi zawierać co najmniej 8 znaków, dużą literę, małą literę oraz cyfrę.";
            $dataValid = false;
        }
    }
    if (empty($_POST["passwordRepeat"])) {
        $passwordRepeatErr = "Pole \"Powtórz hasło\" nie może być puste";
        $dataValid = false;
    } else {
        $passwordRepeat = test_input($_POST["passwordRepeat"]);
        if ($password != $passwordRepeat) {
            $passwordRepeatErr = "Hasła nie zgadzają się";
            $dataValid = false;
        }
    }

    if ($dataValid) {
        $quotedFirstName = quoter($firstName);
        $quotedEmail = quoter($email);
        $quotedPassword = quoter($password);

        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = "^79q+a8&}u9/4Un";
        $dbname = "fbo";

        try {
            $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
            // seth the PDO error mode to exception
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO Users (FirstName, Mail, PassHash) VALUES ($quotedFirstName, $quotedEmail, $quotedPassword)";
            $connection->exec($sql);
            $lastID = $connection->lastInsertId();
            $_SESSION["userID"] = $lastID;
            $_SESSION["password"] = $password;
            header('Location: introduction.php');

        } catch (PDOException $e) {
            $dbError = "Użytkownik z podanym adresem e-mail już istnieje";
//            echo "Connection failed: " . $e->getMessage();
        }
        $connection = null;
    }
}

