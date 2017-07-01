<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 18.06.2017
 * Time: 13:29
 */

if (!isset($_SESSION)) {
    session_start();
}
$userID = $_SESSION['userID'];

function quoter($data) {
    $data = "'" . $data . "'";
    return $data;
}

class Group {
    // Creating some properties (variables tied to an object)
    public $groupID;
    public $userID;
    public $groupName;
    public $budgeted;
    public $spent;
    public $available;
    public $newCategoryRow;

    public function __construct($groupID, $userID, $groupName, $budgeted, $spent, $available) {
        $this->groupID = $groupID;
        $this->userID = $userID;
        $this->groupName = $groupName;
        $this->budgeted = $budgeted;
        $this->spent = $spent;
        $this->available = $available;
        $this->newCategoryRow = new NewCategory($groupID);
    }

    public function draw() {
        return "
        <tr class='budGroup'>
			<td class='budGroupName'>" . $this->groupName . " 
			    <button onclick='showNewCategoryForm(true, " . $this->groupID . ")'><img src='../images/icons/svg/plus.svg' alt='Dodaj nową kategorię' style='width: 20px'></button>
			</td>
			<td class='budGroupAmount hideable'>" . number_format($this->budgeted, 2, ',', ' ') . " zł</td>
			<td class='budGroupAmount hideable'>" . number_format($this->spent, 2, ',', ' ') . " zł</td>
            <td class='budGroupAmount'>" . number_format($this->available, 2, ',', ' ') . " zł</td>
		</tr>
        ";
    }
}

class Category {
    public $groupID;
    public $categoryID;
    public $categoryName;
    public $budgeted;
    public $spent;
    public $available;

    public function __construct($groupID, $categoryID, $categoryName, $budgeted, $spent, $available) {
        $this->groupID = $groupID;
        $this->categoryID = $categoryID;
        $this->categoryName = $categoryName;
        $this->budgeted = $budgeted;
        $this->spent = $spent;
        $this->available = $available;
    }

    public function draw() {
        return "
            <tr class='budCategory'>
				<td class='budCatName'>" . $this->categoryName . "</td>
				<td class='budCatAmount budgeted hideable'><input id='category" . $this->categoryID . "' onfocus='eraseCurrencyOnFocus()' onfocusout='updateBudget(" . $this->categoryID . ")' type='text' value='" . number_format($this->budgeted, 2, ',', '') . " zł'></td>
				<td class=\"budCatAmount spent hideable\">" . number_format($this->spent, 2, ',', '') . " zł</td>
				<td class=\"budCatAmount available budCatAvailable\"><span>" . number_format($this->available, 2, ',', '') . " zł</span></td>
			</tr>
        ";
    }
}

class NewGroup {

    public function __construct() {
    }

    public function draw() {
        return
            "
            <tr class='budNewGroup'>
			    <td id='newGroupTD' colspan='4'><button id='newGroupButton' onclick='showNewGroupForm(true)'>Dodaj nową grupę</button></td>
			</tr>
			<tr class='budGroup' id='budNewGroupRow'>
			    <td colspan='4'>
			    <div class='budNewGroupForm'>
			        <input id='newGroupNameInput' type='text' placeholder='Nazwa nowej grupy' onfocusout='validateNewGroupName()'>
			        <div class='buttonDiv'>
			            <button id='newGroupAcceptButton' class='accept button' onclick='addGroup()' disabled>Dodaj</button>
			            <button class='cancel button' onclick='showNewGroupForm(false)'>Odrzuc</button>
			        </div>
			        </div>
			    </td>
            </tr>
        ";
    }
}

class NewCategory {
    public $groupID;

    public function __construct($groupID) {
        $this->groupID = $groupID;
    }

    public function draw() {
        return "
        <tr class='newCategoryRow' id='newCategoryRowForGroupID" . $this->groupID . "'>
			    <td colspan='4'>
			    <div class='newCategoryForm'>
			        <input id='newCategoryNameInputForGroupID" . $this->groupID . "' type='text' placeholder='Nazwa nowej kategorii' onfocusout='validateNewCategoryName(" . $this->groupID . ")'>
			        <div class='buttonDiv'>
			            <button id='newCategoryAcceptButton' class='accept button' onclick='addCategoryToGroupID(" . $this->groupID . ")' disabled>Dodaj</button>
			            <button class='cancel button' onclick='showNewCategoryForm(false, " . $this->groupID . ")'>Odrzuc</button>
			        </div>
			        </div>
			    </td>
            </tr>
        ";
    }
}

class GlobalSum {
    public $budgetedSum;
    public $spentSum;
    public $availableSum;

    public function __construct($budgetedSum, $spentSum, $availableSum) {
        $this->budgetedSum = $budgetedSum;
        $this->spentSum = $spentSum;
        $this->availableSum = $availableSum;
    }

    public function draw() {
        return
            "
            <tr class='budSum'>
				<td class='budSumName'>SUMA</td>
				<td class='budSumAmount hideable'>" . number_format($this->budgetedSum, 2, ',', '') . " zł</td>
				<td class='budSumAmount hideable'>" . number_format($this->spentSum, 2, ',', '') . " zł</td>
				<td class='budSumAmount'>" . number_format($this->availableSum, 2, ',', '') . " zł</td>
			</tr>
		    ";
    }
}

// Connect to database

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "^79q+a8&}u9/4Un";
$dbname = "fbo";
$connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
// seth the PDO error mode to exception
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection -> query ('SET NAMES utf8');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $budgetTable = "";
        $group;
        $category;
        $categories = "";
        $newGroupRow = new NewGroup();
        $globalSum = new GlobalSum(0, 0, 0);


        $sql = "SELECT GroupID, GroupName FROM Groups WHERE UserID = $userID AND GroupName != 'Do rozdysponowania'";
        foreach ($connection->query($sql) as $groupRow) {
            $categories = "";
            $group = new Group($groupRow['GroupID'], $userID, $groupRow['GroupName'], 0, 0, 0);

            $sql = "SELECT CategoryID, CategoryName, Budgeted FROM Categories WHERE GroupID = $group->groupID";
            foreach ($connection->query($sql) as $categoryRow) {
                $category = new Category($group->groupID, $categoryRow['CategoryID'], $categoryRow['CategoryName'], $categoryRow['Budgeted'], 0, 0);

                $sql = "SELECT Amount FROM Transactions JOIN Accounts ON Transactions.AccountID = Accounts.AccountID WHERE CategoryID = $category->categoryID AND Type = 'budget'";
                foreach ($connection->query($sql) as $transactionRow) {
                    $category->spent += $transactionRow['Amount'];
                }
                $category->available = $category->budgeted + $category->spent;
                $categories .= $category->draw();
                $group->budgeted += $category->budgeted;
                $group->spent += $category->spent;
                $group->available = $group->budgeted + $group->spent;
                $globalSum->budgetedSum += $group->budgeted;
                $globalSum->spentSum += $group->spent;
                $globalSum->availableSum += $group->available;
            }

            $budgetTable .= $group->draw() . $group->newCategoryRow->draw() . $categories;
        }

        $budgetTable .= $newGroupRow->draw();
        $budgetTable .= $globalSum->draw();
        echo $budgetTable;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    /****** PUT REQUEST ******/
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $put_vars);
    $categoryID = $put_vars['categoryID'];
    $amount = $put_vars['amount'];
    try {
        $sql = "UPDATE Categories SET Budgeted = $amount WHERE CategoryID = $categoryID";
        $connection->exec($sql);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['newGroupName'])) {
    $newGroupName = $_POST['newGroupName'];
    $quotedNewGroupName = quoter($newGroupName);
    try {
        $sql = "INSERT INTO Groups (UserID, GroupName) VALUES ($userID, $quotedNewGroupName)";
        $connection->exec($sql);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['newCategoryName'])) {
    $groupID = $_POST['groupID'];
    $newCategoryName = $_POST['newCategoryName'];
    $quotedNewCategoryName = quoter($newCategoryName);
    try {
        $sql = "INSERT INTO Categories (GroupID, CategoryName) VALUES ($groupID, $quotedNewCategoryName)";
        $connection->exec($sql);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
$connection = null;