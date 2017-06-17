<?php session_start(); ?>
<?php include '../php/isSignedIn.php'; ?>

<!doctype html>
<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
		      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="../css/normalize.css">
		<link rel="stylesheet" href="../css/master.css">
		<link rel="stylesheet" href="../css/responsive.css">
		<title>FBO | Zaloguj się</title>
        <script>
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

            function mailValidation(value) {
                "use strict";
                var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return !pattern.test(value);
            }

            function validate(elementID) {
                'use strict';

                var formElement = document.getElementById(elementID);
                var formInput = formElement.children[1];
                var formInputValue = formInput.value;
                var formErrorMsg = formElement.children[2];

                if (elementID === 'mailElement') {
                    if (empty(formInputValue)) {
                        setErrorElements(formInput, formErrorMsg, 'Pole \"Adres e-mail\" nie może być puste', true);
                        formElement.classList.remove('valid');
                    } else if (mailValidation(formInputValue)) {
                        setErrorElements(formInput, formErrorMsg, 'Pole zawiera niedozwolone znaki. Wprowadź poprawny adres e-mail', true);
                        formElement.classList.remove('valid');
                    } else {
                        setErrorElements(formInput, formErrorMsg, null, false);
                        formElement.classList.add('valid');
                    }
                }
                var button = document.getElementById('submitButton');
                if (document.getElementsByClassName('valid').length === 1) {
                    button.disabled = false;
                } else {
                    button.disabled = true;
                }
            }
        </script>
        <script>
            function checkLogin(email, password) {
                var msgDisplay = document.getElementById('dbError');
//                msgDisplay.style.cssText = "display: none";
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        window.console.log("TUTAj");
                        msgDisplay.innerHTML = this.responseText;
                        msgDisplay.style.cssText = "display: block; opacity: 0";
                        if (this.responseText == "OK") {
                            window.location.replace("../html/budget.html");
                        }
                    }
                };
                xhttp.open("POST", "../php/signIn.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("email=" + email + "&password=" + password);
            }
        </script>
	</head>
	<body class="widthLimit">
		<header class="header">
			<div class="headerLogo headerElement">
				<a href="../index.html"><img src="../images/baners/baner-white.png" alt="Logo FBO"></a>
			</div>
			<div class="headerTitle headerElement">
				<h1>Logowanie użytkownika</h1>
			</div>
		</header>
		<main>
			<section class="signSection">
				<h1 class="signTitle hideTitle">Logowanie użytkownika</h1>
                <h3 class="dbError" id="dbError"></h3>
				<form class="formDiv" action="" method="GET">
					<div class="formElement" id="mailElement">
						<span>Adres e-mail</span>
						<input type="email" id="mailInput" name="email" maxlength="50" title="Podaj swój adres e-mail" autofocus onfocusout="validate('mailElement')">
                        <span class="formErrorMsg ok"><?php echo $emailErr;?></span>
					</div>
					<div class="formElement" id="passwordElement">
						<span>Hasło</span>
						<input class="" id="passwordInput" type="password" name="password" minlength="8" maxlength="20"
						       title="Podaj swoje hasło">
					</div>
					<div class="buttonDiv">
						<input id="submitButton" class="button" type="button" value="Zaloguj mnie"
                               onclick="checkLogin(document.getElementById('mailInput').value, document.getElementById('passwordInput').value)"
                               style="cursor:pointer" disabled>
					</div>
				</form>
				<div id="noAccountYet">
					<span>Nie masz jeszcze konta? <a href="sign-up.php">Zarejestruj się</a></span>
				</div>
			</section>
		</main>
		<footer>
			<address>
				<p><a href="http://jacekgalka.pl">&copy; 2016 Jacek Gałka</a></p>
			</address>
		</footer>
	</body>
</html>