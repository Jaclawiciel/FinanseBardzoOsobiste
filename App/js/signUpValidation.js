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

function firstNameValidation(value) {
    "use strict";
    var pattern = /^(([a-zA-z]+) ?([a-zA-Z]+))+$/;
    return !pattern.test(value);
}

function mailValidation(value) {
    "use strict";
    var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return !pattern.test(value);
}

function passwordValidation(value) {
    "use strict";
    if (value.length < 8) {
        return true;
    }
    var hasUpperCase = /[A-Z]/.test(value);
    var hasLowerCase = /[a-z]/.test(value);
    var hasNumbers = /\d/.test(value);
    if (hasUpperCase && hasLowerCase && hasNumbers) {
        return false;
    } else {
        return true;
    }
}

function passwordRepeatVaidation(oldValue, newValue) {
    'use strict';
    return oldValue !== newValue;
}

// function dateOfBirthValidation(value) {
//     "use strict";
//     var pattern = /^(0[1-9]|[12][0-9]|3[01]).(0[1-9]|1[012]).(19|20)\d\d$/;
//     if (!pattern.test(value)) {
//         return false;
//     }
//
//     var currentDate = new Date();
//     function MyDate(day, month, year) {
//         this.day = day;
//         this.month = month;
//         this.year = year;
//         if(this.day<10) {
//             this.day='0'+this.day;
//         }
//         if(this.month<10) {
//             this.month='0'+this.month;
//         }
//     }
//
//     var today = new MyDate(currentDate.getDate(), currentDate.getMonth()+1, currentDate.getFullYear());
//
//     var userDate = new MyDate(value.substr(0, 2), value.substr(3, 2), value.substr(6, 4));
//
//     if (userDate.year <today.year) {
//         return true;
//     }
// }


function validate(elementID) {
    'use strict';



    var formElement = document.getElementById(elementID);
    var formInput = formElement.children[1];
    var formInputValue = formInput.value;
    var formErrorMsg = formElement.children[2];
    window.console.log(formInput.name + ' -> ' + formInputValue);

    // First name
    if (elementID === 'firstNameElement') {
        if (empty(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole nie może być puste', true);
            formElement.classList.remove('valid');
        } else if (firstNameValidation(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole zawiera niedozwolone znaki. Wprowadź poprawnie swoje imię', true);
            formElement.classList.remove('valid');
        } else {
            setErrorElements(formInput, formErrorMsg, null, false);
            formElement.classList.add('valid');
        }
    } else if (elementID === 'mailElement') {
        if (empty(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole nie może być puste', true);
            formElement.classList.remove('valid');
        } else if (mailValidation(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole zawiera niedozwolone znaki. Wprowadź poprawny adres e-mail', true);
            formElement.classList.remove('valid');
        } else {
            setErrorElements(formInput, formErrorMsg, null, false);
            formElement.classList.add('valid');
        }
    } else if (elementID === 'passwordElement') {
        if (empty(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole nie może być puste', true);
            formElement.classList.remove('valid');
        } else if (passwordValidation(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Hasło musi zawierać co najmniej 8 znaków, dużą literę, małą literę oraz cyfrę.', true);
            formElement.classList.remove('valid');
        } else {
            setErrorElements(formInput, formErrorMsg, null, false);
            formElement.classList.add('valid');
        }
    } else if (elementID === 'passwordRepeatElement') {
        var newValue = formInputValue;
        var oldValue = document.getElementById('passwordElement').children[1].value;
        if (empty(formInputValue)) {
            setErrorElements(formInput, formErrorMsg, 'Pole nie może być puste', true);
            formElement.classList.remove('valid');
        } else if (passwordRepeatVaidation(oldValue, newValue)) {
            setErrorElements(formInput, formErrorMsg, 'Hasła nie zgadzają się. ', true);
            formElement.classList.remove('valid');
        } else {
            setErrorElements(formInput, formErrorMsg, null, false);
            formElement.classList.add('valid');
        }
    }
    var button = document.getElementById('submitButton');
    if (document.getElementsByClassName('valid').length === 4) {
        button.disabled = false;
    } else {
        button.disabled = true;
    }
}