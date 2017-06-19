<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 19.06.2017
 * Time: 18:20
 */

session_start();
$userID = $_SESSION['userID'];

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    class Account {
        public $accID;
        public $name;
        public $balance;
        public $type;

        public function __construct($accID, $name, $balance, $type) {
            $this->accID = $accID;
            $this->name = $name;
            $this->balance = $balance;
            $this->type = $type;
        }

        public function draw() {
            return
                "<div class='account' id='$this->accID'>
					<span class='accountName'>" . $this->name . "</span>
					<span class='accountAmount'>" . $this->balance . " zł</span>
				</div>";
        }
    }

    class AccoundDesc {
        public function __construct($balance, $type) {
            $this->name = "";
            $this->balance = $balance;
            $this->type = $type;
        }

        public function draw() {
            $descName = "";
            if ($this->type == "budget") {
                $descName = "Budżet";
            } else {
                $descName = "Oszczędności";
            }
            return
                "<div class='accountsDesc'>
					<span class='accountDescName'>" . $descName . "</span>
					<span class='accountDescSum'>" . $this->balance . " zł</span>
				</div>";
        }
    }

    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "^79q+a8&}u9/4Un";
    $dbname = "fbo";



    try {
        $budgetSum = 0.00;
        $savingsSum = 0.00;
        $budgetAccountsStr = "";
        $savingAccountsStr = "";
        $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
        // seth the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT AccountID, Name, Balance, Type FROM Accounts WHERE Type = 'budget' AND UserID = $userID";
        foreach ($connection->query($sql) as $row) {
            $account = new Account($row['AccountID'], $row['Name'], $row['Balance'], $row['Type']);
            $budgetSum += $account->balance;
            $budgetAccountsStr .= $account->draw();
        }
        $sql = "SELECT AccountID, Name, Balance, Type FROM Accounts WHERE Type = 'savings' AND UserID = $userID";
        foreach ($connection->query($sql) as $row) {
            $account = new Account($row['AccountID'], $row['Name'], $row['Balance'], $row['Type']);
            $savingsSum += $account->balance;
            $savingAccountsStr .= $account->draw();
        }
        $budgetDescAccount = new AccoundDesc($budgetSum, 'budget');
        $savingDescAccount = new AccoundDesc($savingsSum, 'savings');

        $returnStr = "<div class='accounts'>";

        echo "<div class='accounts'>" . $budgetDescAccount->draw() . $budgetAccountsStr . "</div>" . "<div class='accounts'>" . $savingDescAccount->draw() . $savingAccountsStr . "</div>";
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $connection = null;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $dataValid = true;
    $accName = $accType = "";

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