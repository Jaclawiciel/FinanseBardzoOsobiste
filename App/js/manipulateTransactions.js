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

function addNewTransaction(accountID) {
    "use strict";
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
