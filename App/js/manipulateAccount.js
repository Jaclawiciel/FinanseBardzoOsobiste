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
            }
        }
    };
    xhttp.open("POST", "../php/manipulateAccount.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name=" + name + "&type=" + type);
}