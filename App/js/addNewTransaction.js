/**
 * Created by Jacek on 25.06.2017.
 */

function addNewTransactionFor(accountID) {
    "use strict";

    document.getElementById('newTransactionRow').innerHTML = "" +
            "<td class='tranElem tranCheck hid'></td>" +
            "<td class='tranElem tranDate'><input type='date' placeholder='Data'></td>" +
            "<td class='small'>" +
                "<span class='tranElem tranName'><input type='text' placeholder='Nazwa transakcji'></span>" +
                "<span class='tranElem tranCat'>" +
        "           <select name='categories' id=''>" +
                        "<option value='Jedzenie i picie'>Jedzenie i picie</option>" +
                        "<option value='Kosmetyki'>Kosmetyki</option>" +
                    "</select>" +
                "</span>" +
            "</td>" +
            "<td class='tranElem tranName hid'><input type='text' placeholder='Nazwa transakcji'></td>" +
            "<td class='tranElem tranCat hid'>" +
                "<select name='categories' id=''>" +
                    "<option value='Jedzenie i picie'>Jedzenie i picie</option>" +
                    "<option value='Kosmetyki'>Kosmetyki</option>" +
                "</select>" +
            "</td>" +
            "<td class='tranElem tranCost'><input type='text' placeholder='0.00 zł'></td>";
    document.getElementById('newTransactionRowButtons').innerHTML = "" +
            "<td colspan='5'>" +
                "<button class='accept'>Akceptuj</button>" +
                "<button class='cancel'>Odrzuć</button>" +
            "</td>";
}