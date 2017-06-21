/**
 * Created by Jacek on 21.06.2017.
 */
function showModalSettings() {
    "use strict";
    document
        .getElementById("settingsOn")
        .style
        .cssText = "top:0px";

    document.getElementById("blurDiv").style.cssText = "filter:blur(15px)";
    window.scrollTo(0, 0);
}
function hideModalSettings() {
    "use strict";
    document.getElementById("blurDiv").style.cssText = "filter:none";
    document
        .getElementById("settingsOn")
        .style
        .cssText = "top:-500px";
}