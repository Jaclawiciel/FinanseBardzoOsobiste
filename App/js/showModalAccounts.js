/**
 * Created by Jacek on 21.06.2017.
 */

function showModalAccounts(state) {
    var body = document.getElementsByTagName("body")[0];
    var modal = document.getElementsByClassName('newAccountModal')[0];
    var blured =  document.getElementById('blurDiv');
    if (state) {
        blured.style.cssText = "filter:blur(15px)";
        modal.style.cssText = "top: 0; overflow-y: auto; height:100%";
        body.style.cssText = "overflow: hidden; position: fixed";
    } else {
        blured.style.cssText = "filter:none";
        modal.style.cssText = "top: -750px";
        body.style.cssText = "overflow: auto; position: static";
        document.getElementById('newAccMsg').innerHTML = "";
        document.getElementById('newAccountForm').reset();
        document.getElementById('newAccSubmitButton').disabled = true;
    }
}