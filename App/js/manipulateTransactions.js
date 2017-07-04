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
    var categoryID;
    if (document.getElementById('NewTranNameInputSmall').value === "") {
        name = document.getElementById('NewTranNameInputLarge').value;
        categoryID = document.getElementById('NewTranCategoryIDLarge').value;
    } else {
        name = document.getElementById('NewTranNameInputSmall').value;
        categoryID = document.getElementById('NewTranCategoryIDSmall').value;
    }
    var amount = document.getElementById('NewTranAmountInput').value;
    amount = amount.replace(",", ".");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            hideNewTransactionsRow();
            displayAccounts();
            displayTransactions(accountID);
        }
    };
    xhttp.open("POST", "../php/manipulateTransactions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("date=" + date + "&name=" + name + "&categoryID=" + categoryID + "&amount=" + amount + "&accountID=" + accountID);
    // setTimeout(function(){ displayAccounts(); }, 500);
    // setTimeout(function(){ displayTransactions(accountID); }, 1000);
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

function deleteTransactions() {
    "use strict";
    var currentAccountID = document.getElementsByClassName('active')[0].id;
    currentAccountID = currentAccountID.replace("accountID", "");

    var checkTdElements = document.getElementsByClassName('tranCheck');
    var transactionsToDelete = [];
    for (var i = 2; i < checkTdElements.length; i++) {
        var checkTdElement = checkTdElements[i];
        var checkInput = checkTdElement.getElementsByTagName('input')[0];
        if (checkInput.checked) {
            var transactionID = checkInput.name.replace("checkTran", "");
            transactionsToDelete.push(transactionID);
        }
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            // displayAccounts();
            // displayTransactions(currentAccountID);
        }
    };
    xhttp.open("DELETE", "../php/manipulateTransactions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var sheet = window.document.styleSheets[1];
    var params = "";
    for (var i = 0; i < transactionsToDelete.length; i++) {
        if (i > 0) {
            params += "&";
        }
        params += "transactionID" + i + "=" + transactionsToDelete[i];
        sheet.insertRule('#transactionRow' + transactionsToDelete[i] + ' { animation: slideLeft 0.35s ease 0s 1; }', sheet.cssRules.length);
    }
    xhttp.send(params);
    setTimeout(function(){ displayAccounts(); }, 300);
    setTimeout(function () { displayTransactions(currentAccountID); }, 350);
}

function allTransactionsCheck() {
    var descCheckbox = document.getElementById('checkAllCheckbox');
    var transactionRows = document.getElementsByClassName('transactionRow');
    if (descCheckbox.checked) {
        for (var i = 2; i < transactionRows.length; i++) {
            var checkbox = transactionRows[i].getElementsByClassName('tranCheckInput')[0];
            checkbox.checked = true;
        }
    } else {
        for (var i = 2; i < transactionRows.length; i++) {
            var checkbox = transactionRows[i].getElementsByClassName('tranCheckInput')[0];
            checkbox.checked = false;
        }
    }
}