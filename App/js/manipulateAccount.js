/**
 * Created by Jacek on 19.06.2017.
 */
function addNewAccount() {
    "use strict";
    var name = document.getElementById('newAccountNameValue').value;
    var type;
    if (document.getElementById('type1').checked) {
        type = "budget";
    } else {
        type = "savings";
    }

    var msgDisplay = document.getElementById('newAccMsg');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            msgDisplay.innerHTML = this.responseText;
            if (this.responseText == "Konto utworzone") {
                document.getElementById('newAccountForm').reset();
                document.getElementById('newAccSubmitButton').disabled = true;
                displayAccounts();
            }
        }
    };
    xhttp.open("POST", "../php/manipulateAccount.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name=" + name + "&type=" + type);
    // setTimeout(function(){ displayAccounts(); }, 1000);
}

function displayAccounts() {
    "use strict";
    var accountsDiv = document.getElementById('menuAccounts');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            accountsDiv.innerHTML = this.responseText;
            blockTransactionsIfNoAccounts();
            formatAccountsAmount();
        }
    };
    xhttp.open("GET", "../php/manipulateAccount.php", true);
    xhttp.send();

    // setTimeout(function(){ blockTransactionsIfNoAccounts(); }, 300);
    // setTimeout(function(){ formatAccountsAmount(); }, 300);
}

function deleteAccount(accountID) {
    "use strict";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            window.console.log(this.responseText);
            displayAccounts();
        }
    };
    xhttp.open("DELETE", "../php/manipulateAccount.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("accountID=" + accountID);
    var sheet = window.document.styleSheets[1];
    sheet.insertRule('#accountID' + accountID + ' { animation: slideLeft 0.3s ease 0s 1; }', sheet.cssRules.length);
    // setTimeout(function(){ displayAccounts(); }, 300);
}

function formatAccountsAmount() {
    "use strict";

    // Description amounts
    var descAmounts = document.getElementsByClassName('accountDescSum');
    for (var i = 0; i < descAmounts.length; i++) {
        descAmounts[i].innerHTML = descAmounts[i].innerHTML.replace(".", ",");
    }

    // Accounts amounts
    var amounts = document.getElementsByClassName('accountAmount');
    for (var i = 0; i < amounts.length; i++) {
        amounts[i].innerHTML = amounts[i].innerHTML.replace(".", ",");
    }

}