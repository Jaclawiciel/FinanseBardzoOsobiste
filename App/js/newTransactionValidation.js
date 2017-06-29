/**
 * Created by Jacek on 29.06.2017.
 */

var dateValid = false;
var nameValid = false;
var amountValid = false;

function empty(value) {
    "use strict";
    var pattern = /.+/;
    return !pattern.test(value);
}

function formatDate(date) {
    "use strict";

    var day = date.getDate();
    var month = date.getMonth();
    var year = date.getFullYear();

    return day + '.' + month + '.' + year;
}

function dateValidation(value) {
    "use strict";

    var pattern = /^(0[1-9]|[12][0-9]|3[01]).(0[1-9]|1[012]).(19|20)\d\d$/;

    if (pattern.test(value)) {
        value = new MyDate(value.substr(1, 1), value.substr(4, 1), value.substr(6, 4));
        window.console.log(value.printDate());
    } else {
        value = new Date(value);
        value = new MyDate(value.getDate(), value.getMonth() + 1, value.getFullYear());
        window.console.log(value.printDate());
    }


    if (!pattern.test(value.printDate())) {
        return false;
    }

    if (empty(value.printDate())) {
        return false;
    }

    var currentDate = new Date();

    function MyDate(day, month, year) {
        this.day = day;
        this.month = month;
        this.year = year;
        if (this.day < 10) {
            this.day = '0' + this.day;
        }
        if (this.month < 10) {
            this.month = '0' + this.month;
        }

        this.printDate = function() {
            return this.day + '.' + this.month + '.' + this.year;
        };
    }

    var today = new MyDate(currentDate.getDate(), currentDate.getMonth() + 1, currentDate.getFullYear());

    var userDate = value;

    window.console.log(today.year);
    if (userDate.year < today.year) {
        return true;
    } else if (userDate.year == today.year) {
        window.console.log("TUTAJ");
        if (userDate.month < today.month) {
            return true;
        } else if (userDate.month == today.month) {
            if (userDate.day <= today.day) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function transactionNameValidation(value) {
    "use strict";
    var pattern = /^[\w\s()]+$/;
    return !pattern.test(value);
}

function transactionAmountValidation(value) {
    "use strict";
    var pattern = /^-?\d+(.\d{2})?$/;
    return !pattern.test(value);
}

function validateNewTransaction(input, type) {
    "use strict";
    var valid = true;
    if (type === 'date') {
        if (empty(input.value)) {
            valid = false;
        }
        if (!dateValidation(input.value)) {
            valid = false;
        }
        if (valid) {
            dateValid = true;
        } else {
            dateValid = false;
        }
    } else if (type === 'name') {
        if (empty(input.value)) {
            valid = false;
        }
        if (transactionNameValidation(input.value)) {
            valid = false;
        }
        if (valid) {
            nameValid = true;
        } else {
            nameValid = false;
        }
    } else if (type === 'amount') {
        if (empty(input.value)) {
            valid = false;
        }
        if (transactionAmountValidation(input.value)) {
            valid = false;
        }
        if (valid) {
            amountValid = true;
        } else {
            amountValid = false;
        }
    }

    if (valid) {
        input.classList.add('valid');
        input.classList.remove('inputError');
    } else {
        input.classList.add('inputError');
        input.classList.remove('valid');
    }

    var acceptButton = document.getElementById('newTransactionAcceptButton')
    if (dateValid && nameValid && amountValid) {
        acceptButton.disabled = false;
    } else {
        acceptButton.disabled = true;
    }
}

