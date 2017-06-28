/**
 * Created by Jacek on 28.06.2017.
 */
var widths = [0, 568];
window.console.log('Tutaj');

function resizeFn() {
    "use strict";
    if (window.innerWidth>=widths[0] && window.innerWidth<widths[1]) {
        document.getElementById('newTransactionRowButtons').innerHTML = "" +
            "<td colspan='3'>" +
                "<button class='accept'>Akceptuj</button>" +
                "<button class='cancel'>Odrzuć</button>" +
            "</td>";
        window.console.log('Mały ekran');
    } else {
        document.getElementById('newTransactionRowButtons').innerHTML = "" +
            "<td colspan='5'>" +
            "<button class='accept'>Akceptuj</button>" +
            "<button class='cancel'>Odrzuć</button>" +
            "</td>";
        window.console.log('Duży ekran');
    }
}
window.onresize = resizeFn;