/**
 * Created by Jacek on 25.06.2017.
 */

function showNewTransactionRowFor(accountID) {
    "use strict";
    var formRow = document.getElementById('newTransactionRow');
    var buttonsRow = document.getElementById('newTransactionRowButtons');

    formRow.style.cssText = "display: table-row";
    buttonsRow.style.cssText = "display: table-row";
}

function hideNewTransactionsRow() {
    "use strict";
    var formRow = document.getElementById('newTransactionRow');
    var buttonsRow = document.getElementById('newTransactionRowButtons');
    var inputs = formRow.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = "";
    }

    formRow.style.cssText = "display: none";
    buttonsRow.style.cssText = "display: none";
}