<?php session_start(); ?>
<?php require '../php/isSignedInOnLogin.php'; ?>
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
		<script>
            function showModalSettings() {
                document
                    .getElementById("settingsOn")
                    .style
                    .cssText = "top:0px";

                document.getElementById("blurDiv").style.cssText = "filter:blur(15px)";
                window.scrollTo(0, 0);
            }
            function hideModalSettings() {
                document.getElementById("blurDiv").style.cssText = "filter:none";
                document
                    .getElementById("settingsOn")
                    .style
                    .cssText = "top:-500px";
            }
            function showMenu(state) {
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
		</script>
	</head>
	<body>
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
						<a href="budget.html" class="menuButton budgetButton activeMenu">Budżet</a>
						<a href="transactions.html" class="menuButton transactionsButton">Transakcje</a>
						<a href="reports.html" class="menuButton reportsButton">Raporty</a>
					</div>
					<div class="menuAccounts">
						<div class="accounts">
							<div class="accountsDesc">
								<span class="accountDescName">Budżet</span>
								<span class="accountDescSum">4 850,00 zł</span>
							</div>
							<div class="account">
								<span class="accountName">Gotówka</span>
								<span class="accountAmount">200,00 zł</span>
							</div>
							<div class="account">
								<span class="accountName">Konto bieżące</span>
								<span class="accountAmount">1 200,00 zł</span>
							</div>
							<div class="account">
								<span class="accountName">Konto oszczędnościowe</span>
								<span class="accountAmount">3 450,00 zł</span>
							</div>
						</div>
						<div class="accounts">
							<div class="accountsDesc">
								<span class="accountDescName">Oszczędności</span>
								<span class="accountDescSum">8 430,00 zł</span>
							</div>
							<div class="account">
								<span class="accountName">Lokata</span>
								<span class="accountAmount">3 000,00 zł</span>
							</div>
							<div class="account">
								<span class="accountName">Fundusze inwestycyjne</span>
								<span class="accountAmount">5 430,00 zł</span>
							</div>
						</div>
					</div>
				</div>
				<button class="settingsButton rotating" onclick="showModalSettings()"><img src="../images/icons/svg/settings-white.svg" alt="Settings"
				                                                                  style="width: 60px"></button>
			</nav>
			<main class="budgetMain" id="blurDiv2">
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
						<div class="toBudgetDiv yellowAmount">
							<span class="toBudgetAmount">1 500,00 zł</span>
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
<!--                        --><?php //include "../php/loadBudget.php"; ?>
						<tr class="budGroup">
							<td class="budGroupName">Najważniejsze po... <img src="../images/icons/svg/plus.svg"
							                                                  alt="Dodaj nową kategorię"
							                                                  style="width: 20px"></td>
							<td class="budGroupAmount hideable">3 950,00 zł</td>
							<td class="budGroupAmount hideable">200,00 zł</td>
							<td class="budGroupAmount">3 750,00 zł</td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Jedzenie i picie</td>
							<td class="budCatAmount hideable">1 700,00 zł</td>
							<td class="budCatAmount hideable">200,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">1 500,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Koszty leczenia i leki</td>
							<td class="budCatAmount hideable">35,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">35,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Ubranie</td>
							<td class="budCatAmount hideable">500,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">500,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Czynsz za mieszkanie</td>
							<td class="budCatAmount hideable">460,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">460,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Prąd</td>
							<td class="budCatAmount hideable">90,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">90,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Koszty dojazdu do pracy</td>
							<td class="budCatAmount hideable">180,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="yellowAmount">180,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Higiena, kosmetyki, fryzjer</td>
							<td class="budCatAmount hideable">220,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">220,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Środki czystości</td>
							<td class="budCatAmount hideable">120,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">120,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Wydatki na szkołe i przedszkole</td>
							<td class="budCatAmount hideable">550,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">550,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Telefon, internet</td>
							<td class="budCatAmount hideable">95,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">95,00 zł</span></td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Inne niezbędne potrzeby</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greyAmount">0,00 zł</span></td>
						</tr>
						<tr class="budGroup">
							<td class="budGroupName">Raty składki i podatki <img src="../images/icons/svg/plus.svg"
							                                                     alt="Dodaj nową kategorię"
							                                                     style="width: 20px"></td>
							<td class="budGroupAmount hideable">1 300,00 zł</td>
							<td class="budGroupAmount hideable">0,00 zł</td>
							<td class="budGroupAmount">1 300,00 zł</td>
						</tr>
						<tr class="budCategory">
							<td class="budCatName">Rata kredytu hipotecznego</td>
							<td class="budCatAmount hideable">1 300,00 zł</td>
							<td class="budCatAmount hideable">0,00 zł</td>
							<td class="budCatAmount budCatAvailable"><span class="greenAmount">1 300,00 zł</span></td>
						</tr>
						<tr class="budNewGroup">
							<td id="newGroupTD">Dodaj nową grupę</td>
							<td class="hideable"></td>
							<td class="hideable"></td>
							<td></td>
						</tr>
						<tr class="budSum">
							<td class="budSumName">SUMA</td>
							<td class="budSumAmount hideable">5 250,00 zł</td>
							<td class="budSumAmount hideable">200,00 zł</td>
							<td class="budSumAmount">5 050,00 zł</td>
						</tr>
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
	</body>
</html>
