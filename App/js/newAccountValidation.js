/**
 * Created by Jacek on 19.06.2017.
 */
/**
 * Created by Jacek on 14.06.2017.
 */

function setErrorElements(formInput, formErrorMsg, errorMessageStr, errorState) {
    "use strict";
    if (errorState) {
        formInput.classList.add('inputError');
        formErrorMsg.classList.remove('ok');
        formErrorMsg.innerHTML = errorMessageStr;
    } else {
        formInput.classList.remove('inputError');
        formErrorMsg.classList.add('ok');
    }
}

function empty(value) {
    'use strict';
    var pattern = /.+/;
    window.console.log(pattern.test(value));
    return !pattern.test(value);
}

function accountNameValidation(value) {
    "use strict";
    var pattern = /^^[a-zA-Z0-9 ()_-óÓąĄśŚłŁżŻźŹćĆńŃ]+$/;
    return !pattern.test(value);
}


function validate(elementID) {
    'use strict';

    var formElement = document.getElementById(elementID);


    // First name
    if (elementID === 'accountNameElement') {
        var formInput = formElement.children[1];
        var formInputValue = formInput.value;
        var formErrorMsg = formElement.children[2];
        if (empty(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole \"Nazwa\" nie może być puste', true);
            formElement.classList.remove('valid');
        } else if (accountNameValidation(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole zawiera niedozwolone znaki. Wprowadź poprawnie nazwę konta', true);
            formElement.classList.remove('valid');
        } else {
            setErrorElements(formInput, formErrorMsg, null, false);
            formElement.classList.add('valid');
        }
    }

    var button = document.getElementById('newAccSubmitButton');
    if (document.getElementsByClassName('valid').length === 1) {
        button.disabled = false;
    } else {
        button.disabled = true;
    }
}