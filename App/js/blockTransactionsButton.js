/**
 * Created by Jacek on 21.06.2017.
 */

function blockTransactionsIfNoAccounts() {
    "use strict";
    var link = document.getElementById("tranButton");
    if (document.getElementsByClassName('account').length === 0) {
        link.setAttribute("href", "#");
        link.classList.add("inactiveMenu");
        if (window.location.href === "http://localhost/html/transactions.php") {
            window.location.replace("/html/budget.php");
        }
    } else {
        link.setAttribute("href", "transactions.php");
        link.classList.remove("inactiveMenu");
    }
}