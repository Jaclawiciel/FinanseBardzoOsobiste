<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 22.06.2017
 * Time: 22:06
 */

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "^79q+a8&}u9/4Un";
$dbname = "fbo";

$connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
// seth the PDO error mode to exception
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userID = $_SESSION['userID'];

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

$dataValid = false;
$accountID = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['accountID'])) {
        $accountID = test_input($_GET['accountID']);
        if (preg_match("/^\d+$/", $accountID)) {
            $dataValid = true;
        }
    }
    if ($dataValid) {

        class TransactionHeader {
            public $accID;
            public $name;
            public $balance;

            public function __construct($accID, $name, $balance) {
                $this->accID = $accID;
                $this->name = $name;
                $this->balance = $balance;
            }

            public function draw() {
                return
                    "
                    <div class='hamburger'>
                        <button onclick='showMenu(true)'>
                            <img src='../images/icons/svg/hamburger.svg' style='width: 40px; height: 40px'>
                        </button>
                    </div>
					<div class='transHeadAccountName'>
						" . $this->name . "
					</div>
					<div class='transHeadAccountBalances'>
						<div class='col balance'>
							<span class='desc'>Stan konta</span>
							<span class='balance'>" . $this->balance . "</span>
						</div>
					</div>
				";
            }
        }

        try {
            $sql = "SELECT AccountID, Name, Balance FROM Accounts WHERE  AccountID = $accountID AND UserID = $userID";
            foreach ($connection->query($sql) as $row) {
                $transactionsHeader = new TransactionHeader($row['AccountID'], $row['Name'], $row['Balance']);
            }

            echo $transactionsHeader->draw();
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}