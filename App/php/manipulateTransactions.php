<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 22.06.2017
 * Time: 22:06
 */
if (!isset($_SESSION)) {
    session_start();
}

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
							<span class='balance'>" . $this->balance . " zł</span>
						</div>
					</div>
				";
    }
}

class Transaction {
    public $userID;
    public $accountID;
    public $categoryID;
    public $categoryName;
    public $transactionID;
    public $date;
    public $name;
    public $amount;

    public function __construct($userID, $accountID, $categoryID, $categoryName, $transactionID, $date, $name, $amount) {
        $this->userID = $userID;
        $this->accountID = $accountID;
        $this->categoryID = $categoryID;
        $this->categoryName = $categoryName;
        $this->transactionID = $transactionID;

        $this->date = date_format(date_create($date), "d.m.Y");
        $this->name = $name;
        $this->amount = $amount;
    }

    public function draw() {
        return
            "
            <tr class='transactionRow'>
				<td class='tranElem tranCheck hid'><input type='checkbox' name='checkTran1' id='checkTran1'></td>
				<td class='tranElem tranDate'>" . $this->date . "</td>
				<td class='small'>
				    <span class='tranElem tranName'>" . $this->name . "</span>
				    <span class='tranElem tranCat'>" . $this->categoryName . "</span>
				</td>
				<td class='tranElem tranName hid'>" . $this->name . "</td>
				<td class='tranElem tranCat hid'>" . $this->categoryName . "</td>
				<td class='tranElem tranCost'>" . $this->amount . " zł</td>
			</tr>
			";
    }
}

$dataValid = false;
$accountID = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $headerStart = "<header class='transactionsHeader' id='transactionsHeader'>";
    $transactionsHeader = "";
    $headerEnd = "</header>";
    $sectionStart = "<section class=\"transactionsSection\">
					<header class=\"tableEditor\">
						<a href=\"\" id=\"addTransaction\">
							<div><img src=\"../images/icons/svg/plus-orange.svg\" alt=\"Dodaj nową\" style=\"width: 25px\">Dodaj
								transakcję
							</div>
						</a>
						<a id=\"editTransaction\" href=\"\"><img src=\"../images/icons/svg/edit.svg\" style=\"width: 25px\"></a>
						<a id=\"deleteTransaction\" href=\"\"><img src=\"../images/icons/svg/delete.svg\" style=\"width: 25px\"></a>
						<div></div>
						<a>Filtruj</a>
					</header>
					<table class=\"transactionsTable\">
						<thead>
						<tr class=\"tranDesc\">
							<th class=\"tranDescElem tranCheck\"><input type=\"checkbox\" name=\"checkAll\"
							                                          id=\"checkAllCheckbox\"></th>
							<th class=\"tranDescElem tranDate\">Data transakcji</th>
							<th class=\"tranDescElem tranName\">Nazwa transakcji</th>
							<th class=\"tranDescElem tranCat\">Kategoria</th>
							<th class=\"tranDescElem tranCost\">Kwota transakcji</th>
						</tr>
						</thead>
						<tbody>";
    $transactionRows = "";
    $sectionEnd = "</tbody></table></section>";

    if (!empty($_GET['accountID'])) {
        $accountID = test_input($_GET['accountID']);
        if (preg_match("/^\d+$/", $accountID)) {
            $dataValid = true;
        }
    } else {
        try {
            $sql = "SELECT AccountID, Name, Balance FROM Accounts WHERE UserID = $userID ORDER BY Type";
            foreach ($connection->query($sql) as $row) {
                $transactionsHeader = new TransactionHeader($row['AccountID'], $row['Name'], $row['Balance']);
                break;
            }
            $sql = "SELECT UserID, AccountID, Transactions.CategoryID AS TranCatID, Categories.Name AS CategoryName, TransactionID, TransactionDate, Transactions.Name AS TransactionName, Amount 
                    FROM Transactions JOIN Categories ON Transactions.CategoryID = Categories.CategoryID
                    WHERE UserID = $userID AND AccountID = $transactionsHeader->accID";
            foreach ($connection->query($sql) as $row) {
                $transactionRow = new Transaction($row['UserID'], $row['AccountID'], $row['TranCatID'], $row['CategoryName'],
                    $row['TransactionID'], $row['TransactionDate'], $row['TransactionName'], $row['Amount']);
                $transactionRows .= $transactionRow->draw();
            }
            echo $headerStart . $transactionsHeader->draw() . $headerEnd . $sectionStart . $transactionRows . $sectionEnd;
            echo "<script>setTimeout(function() { highlightAccount(" . $transactionsHeader->accID . ")}, 300)</script>";
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    if ($dataValid) {



        try {
            $sql = "SELECT AccountID, Name, Balance FROM Accounts WHERE  AccountID = $accountID AND UserID = $userID";
            foreach ($connection->query($sql) as $row) {
                $transactionsHeader = new TransactionHeader($row['AccountID'], $row['Name'], $row['Balance']);
            }
            $sql = "SELECT UserID, AccountID, Transactions.CategoryID AS TranCatID, Categories.Name AS CategoryName, TransactionID, TransactionDate, Transactions.Name AS TransactionName, Amount 
                    FROM Transactions JOIN Categories ON Transactions.CategoryID = Categories.CategoryID
                    WHERE UserID = $userID AND AccountID = $accountID";
            foreach ($connection->query($sql) as $row) {
                $transactionRow = new Transaction($row['UserID'], $row['AccountID'], $row['TranCatID'], $row['CategoryName'],
                    $row['TransactionID'], $row['TransactionDate'], $row['TransactionName'], $row['Amount']);
                $transactionRows .= $transactionRow->draw();
            }
            echo $headerStart . $transactionsHeader->draw() . $headerEnd . $sectionStart . $transactionRows . $sectionEnd;
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}