/**
 * Created by Jacek on 21.06.2017.
 */
function showDeleteConfirm(state, id) {
    "use strict";
    var sheet = window.document.styleSheets[1];
    if (state) {
        sheet.insertRule('#delConfirmationDiv' + id + ' { display: block; animation: slideRight 0.3s ease 0s 1; }', sheet.cssRules.length);
    } else {
        sheet.insertRule('#delConfirmationDiv' + id + ' { animation: slideLeft 0.3s ease 0s 1; }', sheet.cssRules.length);
        setTimeout(function(){ sheet.insertRule('#delConfirmationDiv' + id + ' { display: none; }', sheet.cssRules.length); }, 300);
    }
}