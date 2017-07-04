/**
 * Created by Jacek on 29.06.2017.
 */



function showNewGroupForm(state) {
    "use strict";
    var newGroupRow = document.getElementById('budNewGroupRow');
    var input = document.getElementById('newGroupNameInput');
    if (state) {
        newGroupRow.style.cssText = 'display: table-row';
    } else {
        newGroupRow.style.cssText = 'display: none';
        input.value = "";
        input.classList.remove('inputError');
    }
}

function validateNewGroupName() {
    "use strict";
    var input = document.getElementById('newGroupNameInput');
    var inputValue = input.value;
    var acceptButton = document.getElementById('newGroupAcceptButton');

    function empty(value) {
        var pattern = /.+/;
        return !pattern.test(value);
    }

    function groupNameValidation(value) {
        var pattern = /^(([a-zA-zóÓąĄśŚłŁżŻźŹćĆńŃ0-9]+) ?([a-zA-ZóÓąĄśŚłŁżŻźŹćĆńŃ0-9]+))+$/;
        return !pattern.test(value);
    }

    var dataValid = true;
    if (empty(inputValue) || groupNameValidation(inputValue)) {
        dataValid = false;
    }
    if (dataValid) {
        acceptButton.disabled = false;
        input.classList.remove('inputError');
    } else {
        acceptButton.disabled = true;
        input.classList.add('inputError');
    }
}

function showNewCategoryForm(state, groupID) {
    "use strict";
    var idStr = "newCategoryRowForGroupID" + groupID;
    var inputStr = "newCategoryNameInputForGroupID" + groupID;

    var newCategoryRow = document.getElementById(idStr);
    var newCategoryInput = document.getElementById(inputStr);

    if (state) {
        newCategoryRow.style.cssText = 'display: table-row';
    } else {
        newCategoryRow.style.cssText = 'display: none';
        newCategoryInput.value = "";
        newCategoryInput.classList.remove('inputError');
    }
}

function validateNewCategoryName(groupID) {
    "use strict";
    var idStr = "newCategoryRowForGroupID" + groupID;
    var inputStr = "newCategoryNameInputForGroupID" + groupID;

    var newCategoryRow = document.getElementById(idStr);
    var input = document.getElementById(inputStr);
    var inputValue = input.value;
    var acceptButton = newCategoryRow.getElementsByClassName('accept button')[0];

        function empty(value) {
        var pattern = /.+/;
        return !pattern.test(value);
    }

    function categoryNameValidation(value) {
        var pattern = /^(([a-zA-zóÓąĄśŚłŁżŻźŹćĆńŃ0-9]+) ?([a-zA-ZóÓąĄśŚłŁżŻźŹćĆńŃ0-9]+))+$/;
        return !pattern.test(value);
    }

    var dataValid = true;
    if (empty(inputValue) || categoryNameValidation(inputValue)) {
        dataValid = false;
    }
    if (dataValid) {
        acceptButton.disabled = false;
        input.classList.remove('inputError');
    } else {
        acceptButton.disabled = true;
        input.classList.add('inputError');
    }
}

function reloadToBudget() {
    "use strict";

    // To budget amount in header
    var toBudgetDiv = document.getElementById('toBudgetDiv');
    var toBudgetAmountElement = document.getElementById('toBudgetAmount');

    var accounts = document.getElementById("budgetAccounts").getElementsByClassName('accountAmount');
    var accountsSum = 0.00;
    for (var i = 0; i < accounts.length; i++) {
        accountsSum += parseFloat(accounts[i].innerHTML.replace(" zł", ""));
    }

    var budgetedElements = document.getElementsByClassName('budgeted');
    var budgetedSum = 0.00;
    for (var i = 0; i < budgetedElements.length; i++) {
        var currentBudgeted = budgetedElements[i].getElementsByTagName('input')[0].value;
        currentBudgeted = currentBudgeted.replace(" zł", "");
        currentBudgeted = currentBudgeted.replace(",", ".");

        budgetedSum += parseFloat(currentBudgeted);
    }

    var toBudgetAmount = (accountsSum - budgetedSum).toFixed(2);

    toBudgetAmountElement.innerHTML = toBudgetAmount.replace(".", ",") + " zł";

    if (toBudgetAmount > 0) {
        toBudgetDiv.classList.remove('greenAmount');
        toBudgetDiv.classList.remove('redAmount');
        toBudgetDiv.classList.add('yellowAmount');
    } else if(toBudgetAmount == 0) {
        toBudgetDiv.classList.remove('redAmount');
        toBudgetDiv.classList.remove('yellowAmount');
        toBudgetDiv.classList.add('greenAmount');
    } else if(toBudgetAmount < 0) {
        toBudgetDiv.classList.remove('yellowAmount');
        toBudgetDiv.classList.remove('greenAmount');
        toBudgetDiv.classList.add('redAmount');
    } else {
        toBudgetDiv.classList.remove('yellowAmount');
        toBudgetDiv.classList.remove('greenAmount');
        toBudgetDiv.classList.remove('redAmount');
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
            available.classList.add('greyAmount');
            available.classList.remove('greenAmount');
            available.classList.remove('redAmount');
        } else {
            available.classList.add('redAmount');
            available.classList.remove('greenAmount');
            available.classList.remove('yellowAmount');
            window.console.log(available);
        }
    }
}

function eraseCurrencyOnFocus() {
    "use strict";
    var focusedElement = document.activeElement;
    var focusedValue = focusedElement.value;
    focusedValue = focusedValue.replace(" zł", "");
    focusedElement.value = focusedValue;
}



function displayBudget() {
    "use strict";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('budgetGoesHere').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../php/manipulateBudget.php", true);
    xhttp.send();
}

function updateBudget(categoryID) {
    "use strict";
    var amountElement = document.getElementById('category' + categoryID);
    var amountValue = amountElement.value;

    // VALIDATION
    function empty(value) {
        var pattern = /.+/;
        return !pattern.test(value);
    }

    function transactionAmountValidation(value) {
        var pattern = /^-?\d+((.|,)\d{2})?$/;
        return !pattern.test(value);
    }

    function isNotInDotNotation(value) {
        var pattern = /^-?\d+(,\d{2})?$/;
        return pattern.test(value);
    }

    if (empty(amountValue) || transactionAmountValidation(amountValue)) {
        amountElement.classList.add('inputError');
        return;
    }

    if (isNotInDotNotation(amountValue)) {
        amountValue = amountValue.replace(",", ".");
    }


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            // displayBudget();
            // reloadToBudget();
        }
    };
    xhttp.open("PUT", "../php/manipulateBudget.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("categoryID=" + categoryID + "&amount=" + amountValue);
    setTimeout(function(){ displayBudget(); }, 300);
    setTimeout(function(){ reloadToBudget(); }, 600);
}

function addGroup() {
    "use strict";
    var input = document.getElementById('newGroupNameInput');
    var inputValue = input.value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            // displayBudget();
            // reloadToBudget();
        }
    };
    xhttp.open("POST", "../php/manipulateBudget.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("newGroupName=" + inputValue);
    setTimeout(function(){ displayBudget(); }, 300);
    setTimeout(function(){ reloadToBudget(); }, 600);
}

function addCategoryToGroupID(groupID) {
    "use strict";
    var inputStr = "newCategoryNameInputForGroupID" + groupID;

    var input = document.getElementById(inputStr);
    var inputValue = input.value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            // displayBudget();
            // reloadToBudget();
        }
    };
    xhttp.open("POST", "../php/manipulateBudget.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("newCategoryName=" + inputValue + "&groupID=" + groupID);
    setTimeout(function(){ displayBudget(); }, 300);
    setTimeout(function(){ reloadToBudget(); }, 600);
}

function deleteCategory(categoryID) {
    "use strict";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            // displayBudget();
            // reloadToBudget();
        }
    };
    xhttp.open("DELETE", "../php/manipulateBudget.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "categoryID=" + categoryID;
    xhttp.send(params);
    var sheet = window.document.styleSheets[1];
    sheet.insertRule('#rowCategoryID' + categoryID + ' { animation: slideLeft 0.35s ease 0s 1; }', sheet.cssRules.length);
    setTimeout(function(){ displayBudget(); }, 350);
    setTimeout(function(){ reloadToBudget(); }, 600);
}

function deleteGroup(groupID) {
    "use strict";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            // displayBudget();
            // reloadToBudget();
        }
    };
    xhttp.open("DELETE", "../php/manipulateBudget.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var params = "groupID=" + groupID;
    xhttp.send(params);


    var rowGroupID = "#rowGroupID" + groupID;
    var categoriesInGroup = document.getElementsByClassName('catInGroupID' + groupID);
    var categoryIDs = [];
    for (var i = 0; i < categoriesInGroup.length; i++) {
        categoryIDs.push(categoriesInGroup[i].id);
    }

    var sheet = window.document.styleSheets[1];
    sheet.insertRule(rowGroupID + ' { animation: slideLeft 0.35s ease 0s 1; }', sheet.cssRules.length);
    for (var i = 0; i < categoryIDs.length; i++) {
        sheet.insertRule('#' + categoryIDs[i] + ' { animation: slideLeft 0.35s ease 0s 1; }', sheet.cssRules.length);
    }

    setTimeout(function(){ displayBudget(); }, 350);
    setTimeout(function(){ reloadToBudget(); }, 600);
}