<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 18.06.2017
 * Time: 13:29
 */


class Group {
    // Creating some properties (variables tied to an object)
    public $id;
    public $name;
    public $budgeted;

    /**
     * Group constructor.
     * @param $id
     * @param $name
     * @param $budgeted
     */
    public function __construct($id, $name, $budgeted) {
        $this->id = $id;
        $this->name = $name;
        $this->budgeted = $budgeted;
    }

    public function draw() {
        return
            "<tr class='budGroup' id='" . $this->id . "'>
                <td class='budGroupName'>" . $this->name . "<img src='../images/icons/svg/plus.svg' alt='Dodaj nową kategorię' style='width: 20px'></td>
                <td class='budGroupAmount hideable'>" . $this->budgeted . "</td>
                <td class='budGroupAmount hideable'></td>
                <td class='budGroupAmount'></td>
            </tr>";
    }
}

// Connect to database

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "^79q+a8&}u9/4Un";
$dbname = "fbo";

try {
    $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
    // seth the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT GroupID,  FROM Groups";
    foreach ($connection->query($sql) as $row) {
        $userID = $row['UserID'];
        $password = $row['PassHash'];
    }
    if (($userID == $_SESSION['userID']) && ($password == $_SESSION['password'])) {
        if (htmlspecialchars($_SERVER['PHP_SELF']) == "/html/sign-in.php") {
            header("Location: budget.php");
        }
    } else {
        header("Location: sign-in.php");
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$connection = null;