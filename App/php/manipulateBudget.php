<?php
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 18.06.2017
 * Time: 13:29
 */

$userID = $_SESSION['userID'];

class Group {
    // Creating some properties (variables tied to an object)
    public $groupID;
    public $userID;
    public $groupName;
    public $budgeted;
    public $spent;
    public $available;

    public function __construct($groupID, $userID, $groupName, $budgeted, $spent, $available) {
        $this->groupID = $groupID;
        $this->userID = $userID;
        $this->groupName = $groupName;
        $this->budgeted = $budgeted;
        $this->spent = $spent;
        $this->available = $available;
    }

    public function draw() {
        return "
        <tr class='budGroup'>
			<td class='budGroupName'>" . $this->groupName . " 
			    <img src='../images/icons/svg/plus.svg' alt='Dodaj nową kategorię' style='width: 20px'>
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
				<td class='budCatAmount budgeted hideable'>" . number_format($this->budgeted, 2, ',', ' ') . " zł</td>
				<td class=\"budCatAmount spent hideable\">" . number_format($this->spent, 2, ',', ' ') . " zł</td>
				<td class=\"budCatAmount available budCatAvailable\"><span>" . number_format($this->available, 2, ',', ' ') . " zł</span></td>
			</tr>
        ";
    }
}

// Connect to database

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "^79q+a8&}u9/4Un";
$dbname = "fbo";



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
        // seth the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection -> query ('SET NAMES utf8');

        $budgetTable = "";
        $group;
        $category;
        $categories = "";

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
            }
            $group->spent += $category->spent;
            $group->available = $group->budgeted - $group->spent;
            $budgetTable .= $group->draw() . $categories;
        }
        echo $budgetTable;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $connection = null;
}