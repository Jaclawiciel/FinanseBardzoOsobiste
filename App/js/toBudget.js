/**
 * Created by Jacek on 29.06.2017.
 */

function reloadToBudget() {
    "use strict";

    // To budget amount in header
    var toBudgetDiv = document.getElementById('toBudgetDiv');
    var toBudgetAmountElement = document.getElementById('toBudgetAmount');

    var accounts = document.getElementById("budgetAccounts").getElementsByClassName('accountAmount');
    window.console.log(accounts);
    var accountsSum = 0.00;
    for (var i = 0; i < accounts.length; i++) {
        accountsSum += parseFloat(accounts[i].innerHTML.replace(" zł", ""));
    }

    var budgetedElements = document.getElementsByClassName('budgeted');
    var budgetedSum = 0.00;
    for (var i = 0; i < budgetedElements.length; i++) {
        budgetedSum += parseFloat(budgetedElements[i].innerHTML.replace(" zł", ""));
    }

    var toBudgetAmount = (accountsSum - budgetedSum).toFixed(2);

    toBudgetAmountElement.innerHTML = toBudgetAmount + " zł";

    if (toBudgetAmount > 0) {
        toBudgetDiv.classList.remove('greenAmount');
        toBudgetDiv.classList.remove('redAmount');
        toBudgetDiv.classList.add('yellowAmount');
    } else if(toBudgetAmount == 0.00) {
        toBudgetDiv.classList.remove('redAmount');
        toBudgetDiv.classList.remove('yellowAmount');
        toBudgetDiv.classList.add('greenAmount');
    } else {
        toBudgetDiv.classList.remove('yellowAmount');
        toBudgetDiv.classList.remove('greenAmount');
        toBudgetDiv.classList.add('redAmount');
    }


    // Available coloring
    var availables = document.getElementsByClassName('budCatAmount available');
    for (var i = 0; i < availables.length; i++) {
        var available = availables[i].getElementsByTagName('span')[0];
        var availableValue = parseFloat(available.innerHTML.replace(" zł", ""));
        if (availableValue > 0) {
            available.classList.add('greenAmount');
            available.classList.remove('yellowAmount');
            available.classList.remove('redAmount');
        } else if (availableValue === 0) {
            available.classList.add('yellowAmount');
            available.classList.remove('greenAmount');
            available.classList.remove('redAmount');
        } else {
            available.classList.add('redAmount');
            available.classList.remove('greenAmount');
            available.classList.remove('yellowAmount');
        }
    }
}