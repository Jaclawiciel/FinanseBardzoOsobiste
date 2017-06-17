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
				<form class="formDiv" action="introduction.php" method="GET">
					<div class="formElement">
						<span>Adres e-mail</span>
						<input type="email" name="email" maxlength="20" title="Podaj swój adres e-mail" autofocus>
					</div>
					<div class="formElement">
						<span>Hasło</span>
						<input class="" type="password" name="password" minlength="8" maxlength="20"
						       title="Podaj swoje hasło">
					</div>
					<div class="buttonDiv">
						<input class="button" type="submit" value="Zaloguj mnie" style="cursor:pointer">
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