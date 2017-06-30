<?php session_start(); ?>
<?php require '../php/isSignedIn.php'; ?>
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
		<title>FBO | Budżet</title>
        <script src="../js/blockTransactionsButton.js"></script>
        <script src="../js/showSettings.js"></script>
        <script src="../js/showModalAccounts.js"></script>
        <script src="../js/showMenu.js"></script>
        <script src="../js/newAccountValidation.js"></script>
        <script src="../js/deleteConfirm.js"></script>
        <script src="../js/manipulateAccount.js"></script>
        <script src="../js/manipulateTransactions.js"></script>
        <script src="../js/toBudget.js"></script>
	</head>
	<body class="heightLimit">
		<div class="budgetGrid" id="blurDiv">
			<nav class="mainMenuContainer">
				<div class="mainMenu">
					<div class="menuLogo">
						<img class="logo" src="../images/baners/logo-white.png" alt="Logo FBO">
                        <button class="closeSign" onclick="showMenu(false)">
                            <img src="../images/icons/svg/close-white.svg" alt="Zamknij menu" style="width: 40px">
                        </button>
					</div>
					<div class="menuButtons">
						<a href="budget.php" class="menuButton budgetButton activeMenu">Budżet</a>
						<a href="transactions.php" id="tranButton" class="menuButton transactionsButton">Transakcje</a>
						<a href="reports.html" class="menuButton reportsButton inactiveMenu">Raporty</a>
					</div>
					<div class="menuAccounts" id="menuAccounts">
<!--                        Place for accounts in menu container -->
					</div>
                    <div>
                        <span class="addAccount">
                            <button class="addAccountButton" onclick="showModalAccounts(true)">Dodaj konto</button>
                        </span>
                    </div>
				</div>
                <div class="menuBottom">
                    <button class="settingsButton rotating" onclick="showModalSettings()"><img src="../images/icons/svg/settings-white.svg" alt="Settings"
                                                                                               style="width: 60px"></button>
                    <button class="button" onclick="window.location.replace('../php/logout.php')">Wyloguj</button>
                </div>
			</nav>
			<main class="budgetMain" id="transactionsMain">
				<header class="budgetHeader">
					<div class="hamburger">
						<button onclick="showMenu(true)">
                            <img src="../images/icons/svg/hamburger.svg" style="width: 40px; height: 40px">
                        </button>
					</div>
					<div class="headerElements">
						<div class="monthDiv">
							<img class="monthDivElement" src="../images/icons/svg/back.svg"
							     style="width: 20px; height: 20px"
							     alt="Poprzedni miesiąc">
							<span class="curMonth monthDivElement">Maj 2017</span>
							<img class="monthDivElement" src="../images/icons/svg/next.svg"
							     style="width: 20px; height: 20px"
							     alt="Następny miesiąc">
						</div>
						<div class="toBudgetDiv yellowAmount" id="toBudgetDiv">
							<span class="toBudgetAmount" id="toBudgetAmount">0 zł</span>
							<span class="toBudgetDesc">Do rozdysponowania</span>
						</div>
					</div>
				</header>
				<section class="budgetTableSection">
					<table class="budgetTable">
						<thead>
						<tr class="budDesc">
							<th class="budDescName">Kategoria</th>
							<th class="budDescAmount hideable">Rozdysponowane</th>
							<th class="budDescAmount hideable">Wydane</th>
							<th class="budDescAmount">Dostępne</th>
						</tr>
						</thead>
						<tbody>
                        <?php include "../php/manipulateBudget.php"; ?>
						</tbody>
					</table>
				</section>
			</main>
		</div>
		<aside class="settingsModal" id="settingsOn">
			<header class="settingsHeader">
				<h1 class="settingsTitle">Ustawienia</h1>
				<button class="closeSign" onclick="hideModalSettings()"><img
						src="../images/icons/svg/close-orange.svg" alt="Close" style="width: 40px"></button>
			</header>
			<nav class="settingsTabs">
				<div class="settingsTab userTab activeTab">
					<span class="userSpan">Konto użytkownika</span>
				</div>
				<div class="settingsTab appTab notActiveTab">
					<span class="appSpan">Aplikacja</span>
				</div>
			</nav>
			<form class="formDiv" action="" method="GET">
				<div class="formElement">
					<span>Adres e-mail</span>
					<input type="email" name="email" maxlength="20" title="Podaj swój nowy adres e-mail" autofocus>
				</div>
				<div class="formElement">
					<span>Hasło</span>
					<input class="" type="password" name="password" minlength="8" maxlength="20"
					       title="Podaj swoje nowe hasło">
				</div>
				<div class="formElement">
					<span>Data urodzenia</span>
					<input class="" type="date" name="dateOfBirth" minlength="10" maxlength="10"
					       title="Podaj swoją datę urodzenia">
				</div>
				<div class="buttons">
					<div class="buttonDiv">
						<input class="button" onclick="hideModalSettings()" type="submit" value="Zapisz" style="cursor:pointer">
					</div>
					<div class="buttonDiv">
						<input class="button grey" onclick="hideModalSettings()" type="submit" value="Anuluj" style="cursor:pointer">
					</div>
				</div>
			</form>
		</aside>
        <aside class="newAccountModal" id="newAccountModal">
            <header class="modalHeader">
                <h1 class="modalTitle">Dodaj nowe konto</h1>
                <button class="closeSign" onclick="showModalAccounts(false)"><img
                            src="../images/icons/svg/close-orange.svg" alt="Close" style="width: 40px">
                </button>
            </header>
            <h3 class="dbMsg ok" id="newAccMsg"></h3>
            <form class="formDiv" id="newAccountForm" action="" method="POST">
                <div class="formElement" id="accountNameElement">
                    <span>Nazwa konta</span>
                    <input id="newAccountNameValue" type="text" name="accountName" maxlength="50" title="Podaj nazwę nowego konta" onfocusout="validate('accountNameElement')">
                    <span class="formErrorMsg ok"><?php echo $accountNameErr;?></span>
                </div>
                <div class="formElement radioForm" id="accountTypeElement">
                    <span class="radioTitle">Typ konta</span>
                    <div class="radioInputs">
                        <div class="radioInput">
                            <input id="type1" class="" type="radio" name="type" value="budget" checked="checked"><span>Konto budżetowe</span>
                        </div>
                        <div class="radioInput">
                            <input id="type2" class="" type="radio" name="type" value="savings"><span>Konto oszczędnościowe</span>
                        </div>
                    </div>
                </div>
                <h4>Różnica w typach konta</h4>
                <p>Środki zgromadzone na koncie budżetowym to środki, z których budujesz swój budżet. Np. gotówka w portfelu, konto połączone z Twoją kartą, konto oszczędnościowe, na którym masz zgromadzony fundusz bezpieczeństwa. </p>
                <p>Środki zgromadzone na koncie oszczędnościowym nie wpływają na stan budżetu. Wybierz ten typ jeśli chcesz tylko śledzic stan środków zgromadzonych na koncie.</p>
                <div class="buttons">
                    <div class="buttonDiv">
                        <input id="newAccSubmitButton" class="button"
                               onclick="addNewAccount()"
                               type="button" value="Dodaj" style="cursor:pointer" disabled>
                    </div>
                    <div class="buttonDiv">
                        <button class="button grey" type="reset" onclick="showModalAccounts(false)" style="cursor:pointer">Anuluj</button>
                    </div>
                </div>
            </form>
        </aside>
        <script>setTimeout(function() {reloadToBudget()}, 500)</script>
        <script>window.onload = displayAccounts;</script>
	</body>
</html>
