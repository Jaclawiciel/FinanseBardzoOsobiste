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
$connection -> query ('SET NAMES utf8');

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

class TransactionRow {
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
            <tr class='transactionRow' id='transactionRow" . $this->transactionID . "'>
				<td class='tranElem tranCheck hid'><input type='checkbox' name='checkTran" . $this->transactionID . "' id='checkTran" . $this->transactionID . "'></td>
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

class CategoryList {
    public $userID;
    public $categoryID;
    public $categoryName;

    public function __construct($userID, $categoryID, $categoryName) {
        $this->userID = $userID;
        $this->categoryID = $categoryID;
        $this->categoryName = $categoryName;

    }

    public function draw() {
        return "
        <option value='" . $this->categoryID . "'>" . $this->categoryName . "</option>
        ";
    }
}

$categoryList = "";
$sql = "SELECT UserID, CategoryID, CategoryName FROM Groups JOIN Categories ON Groups.GroupID = Categories.GroupID WHERE UserID = $userID";
foreach ($connection->query($sql) as $row) {
    $category = new CategoryList($row['UserID'], $row['CategoryID'], $row['CategoryName']);
    $categoryList .= $category->draw();
}






$dataValid = false;
$accountID = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $headerStart = "<header class='transactionsHeader' id='transactionsHeader'>";
    $transactionsHeader = "";
    $headerEnd = "</header>";
    $sectionStart = "<section class=\"transactionsSection\">
					<header class=\"tableEditor\">";
    $sectionAddButton = "";

    $sectionMiddle = "<a id=\"editTransaction\" href=\"\"><img src=\"../images/icons/svg/edit.svg\" style=\"width: 25px\"></a>
                        <button id='deleteTransaction' onclick='deleteTransactions()'><img src=\"../images/icons/svg/delete.svg\" style=\"width: 25px\"></button>
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
						<tbody>
						";
    $sectionNewTransactionBeforeSmallCat = "<tr id='newTransactionRow' class='transactionRow'>
                                                <td class='tranElem tranCheck hid'></td>
                                                <td class='tranElem tranDate'><input id='NewTranDateInput' type='date' placeholder='yyyy-mm-dd' onfocusout=\"validateNewTransaction(document.getElementById('NewTranDateInput'), 'date')\"></td>
                                                <td class='small'>
                                                    <span class='tranElem tranName'><input id='NewTranNameInputSmall' type='text' placeholder='Nazwa transakcji' onfocusout=\"validateNewTransaction(document.getElementById('NewTranNameInputSmall'), 'name')\"></span>
                                                    <span class='tranElem tranCat'>
                                                        <select name='categories' id='NewTranCategoryID'>";
    $sectionNewTransactionSmallCat = $categoryList;
    $sectionNewTransactionAfterSmallCat = "        </select>
                                                </span>
                                            </td>";
    $sectionNewTransactionBeforeLargeCat = "<td class='tranElem tranName hid'><input id='NewTranNameInputLarge' type='text' placeholder='Nazwa transakcji' onfocusout=\"validateNewTransaction(document.getElementById('NewTranNameInputLarge'), 'name')\"></td>
                                            <td class='tranElem tranCat hid'>
                                                <select name='categories' id=''>";
    $sectionNewTransactionLargeCat = $categoryList;
    $sectionNewTransactionAfterLargeCat = "    </select>
                                           </td>
                                           <td class='tranElem tranCost'><input id='NewTranAmountInput' type='text' placeholder='0.00 zł' onfocusout=\"validateNewTransaction(document.getElementById('NewTranAmountInput'), 'amount')\"></td>";
    $sectionNewTransactionEnd = "</tr>";
    $sectionNewTransactionButtons = "";
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
            $sql = "SELECT UserID, AccountID, Transactions.CategoryID AS TranCatID, CategoryName, TransactionID, TransactionDate, TransactionName, Amount 
                    FROM Transactions JOIN Categories ON Transactions.CategoryID = Categories.CategoryID
                    WHERE UserID = $userID AND AccountID = $transactionsHeader->accID ORDER BY TransactionDate DESC";
            foreach ($connection->query($sql) as $row) {
                $transactionRow = new TransactionRow($row['UserID'], $row['AccountID'], $row['TranCatID'], $row['CategoryName'],
                    $row['TransactionID'], $row['TransactionDate'], $row['TransactionName'], $row['Amount']);
                $transactionRows .= $transactionRow->draw();
            }
            $sectionAddButton = "<button onclick='showNewTransactionRowFor(" . $transactionsHeader->accID . ")' id='addTransaction'>
							<div><img src=' ../images/icons/svg/plus-orange.svg' alt='Dodaj nową' style='width: 25px'>
							Dodaj transakcję
							</div>
						</button>";
            $sectionNewTransactionButtons = "<tr id='newTransactionRowButtons' class='transactionRow'>
                                        <td colspan='5'>
                                            <button id='newTransactionAcceptButton' class='accept' onclick='addNewTransactionFor(" . $transactionsHeader->accID . ")' disabled>Akceptuj</button>
                                            <button class='cancel' onclick='hideNewTransactionsRow()'>Odrzuć</button>
                                        </td>
                                     </tr>";
            echo $headerStart . $transactionsHeader->draw() . $headerEnd . $sectionStart . $sectionAddButton . $sectionMiddle . $sectionNewTransactionBeforeSmallCat . $sectionNewTransactionSmallCat . $sectionNewTransactionAfterSmallCat . $sectionNewTransactionBeforeLargeCat . $sectionNewTransactionLargeCat . $sectionNewTransactionAfterLargeCat . $sectionNewTransactionEnd . $sectionNewTransactionButtons . $transactionRows . $sectionEnd;
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
            $sql = "SELECT UserID, AccountID, Transactions.CategoryID AS TranCatID, CategoryName, TransactionID, TransactionDate, TransactionName, Amount 
                    FROM Transactions JOIN Categories ON Transactions.CategoryID = Categories.CategoryID
                    WHERE UserID = $userID AND AccountID = $accountID ORDER BY TransactionDate DESC";
            foreach ($connection->query($sql) as $row) {
                $transactionRow = new TransactionRow($row['UserID'], $row['AccountID'], $row['TranCatID'], $row['CategoryName'],
                    $row['TransactionID'], $row['TransactionDate'], $row['TransactionName'], $row['Amount']);
                $transactionRows .= $transactionRow->draw();
            }
            $sectionAddButton = "<button onclick='showNewTransactionRowFor(" . $transactionsHeader->accID . ")' id='addTransaction'>
							<div><img src=' ../images/icons/svg/plus-orange.svg' alt='Dodaj nową' style='width: 25px'>
							Dodaj transakcję
							</div>
						</button>";
            $sectionNewTransactionButtons = "<tr id='newTransactionRowButtons' class='transactionRow'>
                                        <td colspan='5'>
                                            <button id='newTransactionAcceptButton' class='accept' onclick='addNewTransactionFor(" . $transactionsHeader->accID . ")' disabled>Akceptuj</button>
                                            <button class='cancel' onclick='hideNewTransactionsRow()'>Odrzuć</button>
                                        </td>
                                     </tr>";
            echo $headerStart . $transactionsHeader->draw() . $headerEnd . $sectionStart . $sectionAddButton . $sectionMiddle . $sectionNewTransactionBeforeSmallCat . $sectionNewTransactionSmallCat . $sectionNewTransactionAfterSmallCat . $sectionNewTransactionBeforeLargeCat . $sectionNewTransactionLargeCat . $sectionNewTransactionAfterLargeCat . $sectionNewTransactionEnd . $sectionNewTransactionButtons . $transactionRows . $sectionEnd;
            echo "<script>setTimeout(function() { highlightAccount(" . $transactionsHeader->accID . ")}, 300)</script>";
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    class Transaction {
        public $userID;
        public $accountID;
        public $categoryID;
        public $transactionDate;
        public $name;
        public $amount;

        public function __construct($userID, $accountID, $categoryID, $transactionDate, $name, $amount) {
            $this->userID = $userID;
            $this->accountID = $accountID;
            $this->categoryID = $categoryID;
            $this->transactionDate = $transactionDate;
            $this->transactionName = $name;
            $this->amount = $amount;
        }

        public function sqlInsertOperation() {
            return "INSERT
                    INTO Transactions (UserID, AccountID, CategoryID, TransactionDate, TransactionName, Amount)
                    VALUES ($this->userID, $this->accountID, $this->categoryID," . quoter($this->transactionDate) . "," . quoter($this->transactionName) . ", $this->amount)";
        }
    }

    try {
        $transaction = new Transaction($userID, $_POST['accountID'], $_POST['categoryID'], $_POST['date'], $_POST['name'], $_POST['amount']);
        $connection->exec($transaction->sqlInsertOperation());
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    /****** PUT REQUEST ******/
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $delete_vars);
    foreach ($delete_vars as $key => $value) {
        try {
            $sql = "DELETE FROM Transactions WHERE TransactionID = $value";
            $connection->exec($sql);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
$connection = null;