/**
 * Created by Jacek on 21.06.2017.
 */
function showMenu(state) {
    "use strict";
    var body = document.getElementsByTagName("body")[0];
    var menuContainer = document.getElementsByClassName('mainMenuContainer')[0];
    if (state) {
        document.getElementById("blurDiv2").style.cssText = "filter:blur(15px)";
        menuContainer.style.cssText = "left: 0; overflow-y: scroll";
        body.style.cssText = "overflow: hidden; position: fixed";
    } else {
        document.getElementById("blurDiv2").style.cssText = "filter:none";
        menuContainer.style.cssText = "left: -95%;";
        body.style.cssText = "overflow: auto; position: static"
    }
}