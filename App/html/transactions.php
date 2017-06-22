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
		<title>FBO | Transakcje</title>
        <script src="../js/blockTransactionsButton.js"></script>
        <script src="../js/showSettings.js"></script>
        <script src="../js/showModalAccounts.js"></script>
        <script src="../js/showMenu.js"></script>
        <script src="../js/newAccountValidation.js"></script>
        <script src="../js/deleteConfirm.js"></script>
        <script src="../js/manipulateAccount.js"></script>
	</head>
	<body>
		<div class="transactionsGrid" id="blurDiv">
            <nav class="mainMenuContainer">
                <div class="mainMenu">
                    <div class="menuLogo">
                        <img class="logo" src="../images/baners/logo-white.png" alt="Logo FBO">
                        <button class="closeSign" onclick="showMenu(false)">
                            <img src="../images/icons/svg/close-white.svg" alt="Zamknij menu" style="width: 40px">
                        </button>
                    </div>
                    <div class="menuButtons">
                        <a href="budget.php" class="menuButton budgetButton">Budżet</a>
                        <a href="transactions.php" id="tranButton" class="menuButton transactionsButton activeMenu">Transakcje</a>
                        <a href="#" class="menuButton reportsButton inactiveMenu">Raporty</a>
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
                <button class="settingsButton rotating" onclick="showModalSettings()"><img src="../images/icons/svg/settings-white.svg" alt="Settings"
                                                                                           style="width: 60px"></button>
            </nav>
			<main class="transactionsMain" id="blurDiv2">
				<header class="transactionsHeader">
                    <div class="hamburger">
                        <button onclick="showMenu(true)">
                            <img src="../images/icons/svg/hamburger.svg" style="width: 40px; height: 40px">
                        </button>
                    </div>
					<div class="transHeadAccountName">
						Gotówka
					</div>
					<div class="transHeadAccountBalances">
						<div class="col accepted">
							<span class="desc">Zaakceptowane</span>
							<span class="balance">250,00 zł</span>
						</div>
						<span class="col symbol">+</span>
						<div class="col waiting">
							<span class="desc">Oczekujące</span>
							<span class="balance">- 50,00 zł</span>
						</div>
						<span class="col symbol">=</span>
						<div class="col balance">
							<span class="desc">Stan konta</span>
							<span class="balance">200,00 zł</span>
						</div>
					</div>
				</header>
				<section class="transactionsSection">
					<header class="tableEditor">
						<a href="" id="addTransaction">
							<div><img src="../images/icons/svg/plus-orange.svg" alt="Dodaj nową" style="width: 25px">Dodaj
								transakcję
							</div>
						</a>
						<a id="editTransaction" href=""><img src="../images/icons/svg/edit.svg" style="width: 25px"></a>
						<a id="deleteTransaction" href=""><img src="../images/icons/svg/delete.svg" style="width: 25px"></a>
						<div></div>
						<a>Filtruj</a>
					</header>
					<table class="transactionsTable">
						<thead>
						<tr class="tranDesc">
							<th class="tranDescElem tranCheck"><input type="checkbox" name="checkAll"
							                                          id="checkAllCheckbox"></th>
							<th class="tranDescElem tranDate">Data transakcji</th>
							<th class="tranDescElem tranName">Nazwa transakcji</th>
							<th class="tranDescElem tranCat">Kategoria</th>
							<th class="tranDescElem tranCost">Kwota transakcji</th>
							<th class="tranDescElem tranAccept">Akceptacja</th>
						</tr>
						</thead>
						<tbody>
						<tr class="transactionRow">
							<td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
							</td>
							<td class="tranElem tranDate">12.05.17</td>
							<td class="small">
								<span class="tranElem tranName">Tesco</span>
								<span class="tranElem tranCat">Jedzenie i picie</span>
							</td>
							<td class="tranElem tranName hid">Tesco</td>
							<td class="tranElem tranCat hid">Jedzenie i picie</td>
							<td class="tranElem tranCost">-150,00 zł</td>
							<td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
							                                     alt="Akceptacja" style="width: 25px"></td>
						</tr>
						<tr class="transactionRow">
							<td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran2">
							</td>
							<td class="tranElem tranDate">13.05.17</td>
							<td class="small">
								<span class="tranElem tranName">Rossmann</span>
								<span class="tranElem tranCat">Kosmetyki</span>
							</td>
							<td class="tranElem tranName hid">Rossmann</td>
							<td class="tranElem tranCat hid">Kosmetyki</td>
							<td class="tranElem tranCost">-100,00 zł</td>
							<td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
							                                     alt="Akceptacja" style="width: 25px"></td>
						</tr>
						<tr class="transactionRow">
							<td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran3">
							</td>
							<td class="tranElem tranDate">14.05.17</td>
							<td class="small">
								<span class="tranElem tranName">Rachunek za internet</span>
								<span class="tranElem tranCat">Jedzenie i picie</span>
							</td>
							<td class="tranElem tranName hid">Rachunek za internet</td>
							<td class="tranElem tranCat hid">Telefon, internet</td>
							<td class="tranElem tranCost">-50,00 zł</td>
							<td class="tranElem tranAccept not"><img src="../images/icons/svg/accept-orange.svg"
							                                     alt="Akceptacja" style="width: 25px"></td>
						</tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
                        </tr>
                        <tr class="transactionRow">
                            <td class="tranElem tranCheck hid"><input type="checkbox" name="checkTran1" id="checkTran1">
                            </td>
                            <td class="tranElem tranDate">12.05.17</td>
                            <td class="small">
                                <span class="tranElem tranName">Tesco</span>
                                <span class="tranElem tranCat">Jedzenie i picie</span>
                            </td>
                            <td class="tranElem tranName hid">Tesco</td>
                            <td class="tranElem tranCat hid">Jedzenie i picie</td>
                            <td class="tranElem tranCost">-150,00 zł</td>
                            <td class="tranElem tranAccept"><img src="../images/icons/svg/accept-orange.svg"
                                                                 alt="Akceptacja" style="width: 25px"></td>
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
        <script>window.onload = displayAccounts;</script>
	</body>
</html>