/**
 * Created by Jacek on 22.06.2017.
 */

// function redirectToAccount(accountID) {
//     "use strict";
//     if (document.location.href === "http://localhost/html/budget.php") {
//         var url = "http://localhost/html/transactions.php";
//         var params = "?accountID=" + accountID;
//         document.location.replace(url + params);
//     }
// }

function addNewTransactionFor(accountID) {
    "use strict";
    var date = document.getElementById('NewTranDateInput').value;
    var name;
    if (document.getElementById('NewTranNameInputSmall').value === "") {
        name = document.getElementById('NewTranNameInputLarge').value;
    } else {
        name = document.getElementById('NewTranNameInputSmall').value;
    }
    var categoryID = document.getElementById('NewTranCategoryID').value;
    var amount = document.getElementById('NewTranAmountInput').value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            hideNewTransactionsRow();
        }
    };
    xhttp.open("POST", "../php/manipulateTransactions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("date=" + date + "&name=" + name + "&categoryID=" + categoryID + "&amount=" + amount + "&accountID=" + accountID);
    setTimeout(function(){ displayTransactions(accountID); }, 1000);
}

function displayTransactions(accountID) {
    "use strict";
    var url;
    var params;
    if (document.location.href === "http://localhost/html/budget.php") {
        url = "http://localhost/html/transactions.php";
        params = "?accountID=" + accountID;
        document.location.replace(url + params);
    } else {
        var transactionsMain = document.getElementById('transactionsMain');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                transactionsMain.innerHTML = this.responseText;
                highlightAccount(accountID);
            }
        };
        url = "../php/manipulateTransactions.php";
        params = "?accountID=" + accountID;
        xhttp.open("GET", url + params, true);
        xhttp.send();
    }
}
