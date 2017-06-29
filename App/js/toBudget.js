/**
 * Created by Jacek on 29.06.2017.
 */

function reloadToBudget() {
    "use strict";
    var toBudgetDiv = document.getElementById('toBudgetDiv');
    var toBudgetAmountElement = document.getElementById('toBudgetAmount');

    var accounts = document.getElementById("budgetAccounts").getElementsByClassName('accountAmount');
    window.console.log(accounts);
    var accountsSum = 0.00;
    for (var i = 0; i < accounts.length; i++) {
        accountsSum += parseFloat(accounts[i].innerHTML.replace(" zł", ""));
    }
    toBudgetAmountElement.innerHTML = accountsSum.toFixed(2) + " zł";

    if (accountsSum > 0) {
        toBudgetDiv.classList.remove('greenAmount');
        toBudgetDiv.classList.remove('redAmount');
        toBudgetDiv.classList.add('yellowAmount');
    } else if(accountsSum === 0) {
        toBudgetDiv.classList.remove('redAmount');
        toBudgetDiv.classList.remove('yellowAmount');
        toBudgetDiv.classList.add('greenAmount');
    } else {
        toBudgetDiv.classList.remove('yellowAmount');
        toBudgetDiv.classList.remove('greenAmount');
        toBudgetDiv.classList.add('redAmount');
    }
}