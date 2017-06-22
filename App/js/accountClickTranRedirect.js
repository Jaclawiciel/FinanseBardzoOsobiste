/**
 * Created by Jacek on 22.06.2017.
 */

function redirectToAccount(accountID) {
    "use strict";
    if (document.location.href === "http://localhost/html/budget.php") {
        var url = "http://localhost/html/transactions.php";
        var params = "?accountID=" + accountID;
        document.location.replace(url + params);
    }
}
