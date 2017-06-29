<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 19.06.2017
 * Time: 18:20
 */

session_start();

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "^79q+a8&}u9/4Un";
$dbname = "fbo";

$connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
// seth the PDO error mode to exception
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection -> query ('SET NAMES utf8');

$userID = $_SESSION['userID'];

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function quoter($data)
{
    $data = "'" . $data . "'";
    return $data;
}



/****** GET REQUEST ******/
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
                "<div class='accountDiv' id='accountID" . $this->accID . "'>
                    <div class='account'>
                        <div class='accountNameDiv'>
                            <span onclick='displayTransactions(" . $this->accID . ")' class='accountName'>" . $this->name . "</span>
					        <button class='deleteAccountButton' onclick='showDeleteConfirm(true," . $this->accID . ")'></button>
					    </div>
					    <span class='accountAmount'>" . $this->balance . " zł</span>
				    </div>
				    <div class='delConfirmationDiv' id='delConfirmationDiv" . $this->accID . "'>
				        <span>Czy na pewno chcesz usunąc konto?</span>
				        <div>
				            <button class='button' onclick='deleteAccount($this->accID)'>Tak</button><button class='button' onclick='showDeleteConfirm(false," . $this->accID . ")'>Nie</button>
                        </div>
                    </div>
                 </div>
				";
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

    try {
        $budgetSum = 0.00;
        $savingsSum = 0.00;
        $budgetAccountsStr = "";
        $savingAccountsStr = "";

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

        echo "<div class='accounts' id='budgetAccounts'>" . $budgetDescAccount->draw() . $budgetAccountsStr . "</div>" . "<div class='accounts'>" . $savingDescAccount->draw() . $savingAccountsStr . "</div>";
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    /****** POST REQUEST ******/
} elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
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

        $quotedName = quoter($accName);
        $quotedType = quoter($accType);

        try {
            $sql = "INSERT INTO Accounts (UserID, Name, Type) VALUES ($userID, $quotedName, $quotedType)";
            $connection->exec($sql);
            echo "Konto utworzone";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }




    /****** DELETE REQUEST ******/
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"),$delete_vars);
    $accountID = $delete_vars['accountID'];
    try {
        $sql = "DELETE FROM Accounts WHERE AccountID = $accountID";
        $connection->exec($sql);

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

$connection = null;