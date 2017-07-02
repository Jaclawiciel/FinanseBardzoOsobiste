/**
 * Created by Jacek on 23.06.2017.
 */

function highlightAccount(accountID) {
    "use strict";
    var accountDivs = document.getElementsByClassName("accountDiv");
    for (var i = 0; i < accountDivs.length; i++) {
        accountDivs[i].classList.remove('active');
    }

    var toHighlight = document.getElementById("accountID" + accountID);
    toHighlight.classList.add('active');
}