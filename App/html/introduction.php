<?php
session_start();
if (empty($_SESSION["userID"]) || empty($_SESSION['password'])) {
    $_SESSION["status"] = 401;
    header("Location: sign-in.php");
} else {
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "^79q+a8&}u9/4Un";
    $dbname = "fbo";

    $userID = $_SESSION["userID"];
    $password = "";


    try {
        $connection = new PDO("mysql:host=$dbServername;dbname=$dbname", $dbUsername, $dbPassword);
        // seth the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT UserID, PassHash FROM Users WHERE UserID = $userID";
        foreach ($connection->query($sql) as $row) {
            $userID = $row['UserID'];
            $password = $row['PassHash'];
        }
        if (!($userID == $_SESSION['userID']) || !($password == $_SESSION['password'])) {
            $_SESSION["status"] = 401;
            header("Location: sign-in.php");
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $connection = null;
}
?>
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
		<title>Document</title>
	</head>
	<body class="widthLimit">
		<header class="header">
			<div class="headerLogo headerElement">
				<a href="../index.html"><img src="../images/baners/baner-white.png" alt="Logo FBO"></a>
			</div>
			<div class="headerTitle headerElement">
				<h1>10 kroków - skuteczny plan dla Twoich pieniędzy</h1>
			</div>
		</header>
		<main>
			<section class="introductionSection">
				<article>
					<h1 class="hideTitle">10 kroków - skuteczny plan dla Twoich pieniędzy</h1>
					<p>Finanse osobiste są proste i, o ile sami nie komplikujemy sprawy szukając magicznych formuł,
						łatwo je
						zrozumieć. Najtrudniejszy jest początek, bo zwykle nie wiemy od czego zacząć. Ta aplikacja to
						dla
						Ciebie gotowy plan, który skutecznie pomoże Ci zadbać o własne finanse. Oparty jest on na
						prostej
						zasadzie: zamiast się rozpraszać robiąc 10 rzeczy na raz, skoncentruj się i spokojnie – krok po
						kroku – osiągnij cel.</p>
					<p>
						Budując dom zaczynamy od fundamentów, później stawiamy ściany, dopiero na końcu kładziemy dach.
						W
						finansach też występuje logiczna kolejność: zanim zaczniesz grać o miliony, najpierw zbuduj
						solidny
						fundament. Dokładny przepis na wdrożenie tego planu w życie znajdziesz w mojej książce „Jak
						zadbać o
						własne finanse?”, którą serdecznie Ci polecam.</p>
					<h1>Podstawa wszystkich decyzji</h1>
					<p>Finanse osobiste są na tyle proste, że w zasadzie można je sprowadzić do jednego równania:</p>
					<span class="greyTextBaner">zarobki - wydatki = oszczędności</span>
					<p>Oszczędności są super, bo zwiększają finansowe bezpieczeństwo naszych rodzin i pomagają nam w
						realizacji marzeń i pasji. W dodatku pomnażając je, generujemy dodatkowe dochody, dzięki czemu
						powstaje pozytywne sprzężenie zwrotne: większe oszczędności, to większe dochody, większe dochody
						to jeszcze większe oszczędności, itd. Dzięki temu stajemy się coraz bogatsi.</p>
					<p>
						Jeśli wydajemy więcej niż zarabiamy, to nasze oszczędności są ujemne i wkrótce pojawiają się
						długi. Zadłużanie się jest bardzo nierozsądne, bo spłacane raty (w tym koszty i odsetki)
						powiększają nasze wydatki. W ten sposób powstaje sprzężenie zwrotne działające na naszą
						niekorzyść: wydatki większe od zarobków nieuchronnie prowadzą do życia na kredyt, zaś raty coraz
						szybciej drenują nasze kieszenie. Z tego powodu bogacimy się bardzo powoli, stoimy w miejscu,
						lub jeszcze częściej – stajemy się po prostu biedniejsi.</p>
					<p>
						Ta formuła jest niezawodna niczym prawo grawitacji. Aby konsekwentnie się bogacić, wystarczy po
						prostu:
						– systematycznie zwiększać zarobki,
						– trzymać wydatki pod kontrolą,
						– unikać kredytów i pożyczek konsumenckich, – mądrze budować oszczędności i skutecznie je
						pomnażać inwestując.</p>
					<p>
						Tyle teorii. A jak to wprowadzić w praktyce? Do tego służy właśnie plan 10 kroków.</p>
					<ul class="stepsList">
						<li class="stepLine">1. Określ punkt startu – poznaj wartość swojego majątku</li>
						<li class="stepLine">2. Przejmij dowodzenie – przygotuj domowy budżet</li>
						<li class="stepLine">3. Odłóż 2000 zł – Twój fundusz awaryjny</li>
						<li class="stepLine">4. Pozbądź się długów metodą śnieżnej kuli</li>
						<li class="stepLine">5. Zbuduj fundusz bezpieczeństwa</li>
						<li class="stepLine">6. Zafunduj sobie nagrodę</li>
						<li class="stepLine">7. Otwórz konto emerytalne</li>
						<li class="stepLine">8. Przygotuj środki na studia dzieci</li>
						<li class="stepLine">9. Zaatakuj największy dług – kredyt hipoteczny</li>
						<li class="stepLine">10. Przeznacz nadwyżki na trzy ważne cele</li>
					</ul>
				</article>
				<div class="buttonDiv">
					<a href="budget.php" class="button">Zaczynamy!</a>
				</div>
			</section>
		</main>
		<footer>
			<p><a href="http://jacekgalka.pl">&copy; 2016 Jacek Gałka</a></p>
		</footer>
	</body>
</html>