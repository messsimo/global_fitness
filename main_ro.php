<?php
// Запуск сессии
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Экранирование от XSS
    $name = htmlspecialchars(trim($_POST["name"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));

    $hasError = false;

    // Валидация имени
    if (empty($name)) {
        $_SESSION["error-name"] = "Acesta este un câmp obligatoriu";
        $hasError = true;
    } elseif (mb_strlen($name) < 2) {
        $_SESSION["error-name"] = "Numele este prea scurt";
        $hasError = true;
    }

    // Валидация телефона
    if (empty($phone)) {
        $_SESSION["error-phone"] = "Acesta este un câmp obligatoriu.";
        $hasError = true;
    } elseif (!preg_match('/^\+?\d{8,20}$/', $phone)) {
        $_SESSION["error-phone"] = "Număr de telefon incorect";
        $hasError = true;
    }

    if (!$hasError) {
        $to = "info@globalfitness.md";
        $subject = "Запрос на консультацию с сайта Global Fitness";
        $message = "
                    <html>
                    <head>
                        <title>Заявка с сайта Global Fitness</title>
                    </head>
                    <body>
                        <h2>Новая заявка на консультацию</h2>
                        <p><strong>Имя:</strong> {$name}</p>
                        <p><strong>Телефон:</strong> {$phone}</p>
                    </body>
                    </html>
                    ";
        $headers = "From: no-reply@globalfitness.md\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            $_SESSION["success"] = "Vă mulțumim pentru aplicația dumneavoastră! Vă vom contacta în curând";
        } else {
            $_SESSION["error-send"] = "Eroare la trimiterea e-mailului. Vă rugăm să încercați din nou mai târziu";
        }

        // Редирект для предотвращения повторной отправки
        header("Location: " . $_SERVER["REQUEST_URI"]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <!-- Подключение CSS -->
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="stylesheet" href="src/css/adaptation.css">
    <title>Clubul de fitness Global Fitness la Ciocana — sală de forță, saună, karate pentru copii</title>

    <!-- SEO -->
    <meta name="description"
        content="Sală de forță, antrenamente de grup și individuale, saună, solar, karate pentru copii la clubul de fitness Global Fitness, Chișinău, Țicani.">
    <meta name="keywords"
        content="club de fitness Țicani, sală de forță Chișinău, antrenamente personale pentru bărbați, antrenamente de forță Chișinău, antrenamente de grup pentru bărbați, fitness pentru bărbați 25–35 ani, antrenamente pentru creșterea masei musculare, fitness pentru începători bărbați, antrenamente pentru creșterea masei musculare, sală de forță pentru studenți, cluburi de fitness în Țicani, abonament la sală Chișinău, antrenamente pentru bărbați 18–25 ani, fitness pentru femei Chișinău, antrenamente de grup pentru femei, yoga pentru slăbit, antrenamente pentru femei 18–23 ani, club de fitness Țicani pentru femei, programe de slăbire Chișinău, karate pentru copii Chișinău, secție karate Țicani, antrenamente de karate pentru adolescenți, cluburi de karate în Chișinău, activități de karate pentru copii 12–18 ani, karate pentru începători copii, saună Chișinău, solar în Țicani, cabinet de masaj Chișinău, antrenamente individuale Chișinău, antrenamente de fitness în grup, club de fitness cu saună și solar">
    <link rel="canonical" href="https://globalfitness.md/" />
</head>

<body>
    <!-- Шапка сайта-->
    <header>
        <img class="logo" src="src/images/logo.svg" alt="Global Fitness">

        <div class="side-block">
            <div class="top">
                <div class="block">
                    <img src="src/images/adress-point.svg">
                    <span>str. Mircea cel Bătrân 39, Chișinău</span>
                </div>
                <div class="block">
                    <img src="src/images/phone.svg">
                    <span>+373 788 555 88</span>
                </div>
            </div>

            <div class="bottom">
                <div class="links">
                    <a href="#about">Despre club</a>
                    <a href="#staff">Antrenori</a>
                    <a href="#reviews">Recenzii</a>
                    <a href="#prices">Abonamente</a>
                    <a href="#contacts">Contacte</a>
                </div>
                <div class="language">
                    <a href="/ro" class="active">RO</a>
                    <img src="src/images/bar.svg">
                    <a href="/">RU</a>
                </div>

                <div class="burger">
                    <img class="open-btn" src="src/images/burger.svg">
                    <img class="close-btn" src="src/images/close.svg">
                </div>
            </div>
        </div>
    </header>

    <!-- Выпадающий список бургер меню -->
    <div class="dropdown-burger">
        <div class="line"></div>
        <div class="links">
            <a href="#about">Despre club</a>
            <a href="#staff">Antrenori</a>
            <a href="#reviews">Recenzii</a>
            <a href="#prices">Abonamente</a>
            <a href="#contacts">Contacte</a>
        </div>

        <div class="info">
            <div class="sub-block">
                <img src="src/images/adress-point.svg">
                <span>str. Mircea cel Bătrân 39, Chișinău</span>
            </div>
            <div class="sub-block">
                <img src="src/images/phone.svg">
                <span>+373 788 555 88</span>
            </div>
            <div class="sub-block">
                <img src="src/images/clock.svg">
                <span>Luni–Vineri: 08:00 – 22:00</span>
            </div>
            <div class="sub-block">
                <img src="src/images/clock.svg">
                <span>Sâmbătă: 08:00 – 18:00</span>
            </div>
            <div class="sub-block">
                <img src="src/images/clock.svg">
                <span>Duminică: 09:00 – 15:00</span>
            </div>
        </div>
    </div>

    <!-- Блок Hero -->
    <div class="hero">
        <h1 class="visually-hidden">Clubul de fitness Global Fitness la Ciocana — sală de forță, saună, karate pentru
            copii</h1>
        <h2 class="visually-hidden">Despre clubul de fitness Global Fitness în Ciocana</h2>
        <h2 class="visually-hidden">De ce aleg Global Fitness</h2>
        <h2 class="visually-hidden">Avantajele și caracteristicile noastre</h2>
        <h2 class="visually-hidden">Sală de forță pentru bărbați și femei</h2>
        <h2 class="visually-hidden">Antrenamente de fitness în grup</h2>
        <h2 class="visually-hidden">Antrenamente individuale cu antrenor</h2>
        <h2 class="visually-hidden">Secția de karate pentru copii 12–18 ani</h2>
        <h2 class="visually-hidden">Programe de slăbire și remodelare corporală</h2>
        <h2 class="visually-hidden">Saună și zonă de relaxare</h2>
        <h2 class="visually-hidden">Solar pentru bronzare</h2>
        <h2 class="visually-hidden">Cabinet de masaj și proceduri de recuperare</h2>
        <h2 class="visually-hidden">Tarife flexibile și abonamente</h2>
        <h2 class="visually-hidden">Oferte speciale și promoții</h2>
        <h2 class="visually-hidden">Antrenament de probă gratuit</h2>
        <h2 class="visually-hidden">Recenziile clienților noștri</h2>
        <h2 class="visually-hidden">Povești de succes și transformări</h2>
        <h2 class="visually-hidden">Fotografii ale sălii de forță și bazinului</h2>
        <h2 class="visually-hidden">Video și fotografii de la antrenamente și evenimente</h2>
        <h2 class="visually-hidden">Adresa clubului de fitness în Ciocana, Chișinău</h2>
        <h2 class="visually-hidden">Cum ne poți găsi</h2>
        <h2 class="visually-hidden">Program și înscrieri pentru antrenamente</h2>
        <h2 class="visually-hidden">Întrebări despre antrenamente și abonamente</h2>
        <h2 class="visually-hidden">Întrebări despre siguranță și norme sanitare</h2>


        <div class="text">
            <h2>Devino cel mai bun cu</h2>
            <h2><b>Global Fitness!</b></h2>
            <p>Un club de fitness modern în centrul Chișinăului, cu antrenori profesioniști și abordare individuală!</p>
            <a href="#form">Consultanție gratuită</a>
        </div>
    </div>

    <!-- Блок Преимущества клуба -->
    <div class="benifits" id="about">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>DESPRE NOI</span>
        </div>

        <h2>Avantajele <b>clubului</b></h2>
        <p>Global Fitness înseamnă confort, tehnologie și antrenori care te ajută să obții rezultate cu plăcere.</p>

        <div class="container">
            <div class="top">
                <div class="block-top block-1 active">
                    <img src="src/images/bench.svg">
                    <span>Săli de sport de nouă generație</span>
                </div>
                <div class="block-top block-2">
                    <img src="src/images/blank.svg">
                    <span>Antrenamente individuale și de grup</span>
                </div>
                <div class="block-top block-3">
                    <img src="src/images/trainer.svg">
                    <span>Antrenori certificați cu experiență</span>
                </div>
            </div>
            <div class="bottom">
                <div class="block-bottom block-4">
                    <img src="src/images/place.svg">
                    <span>Locație convenabilă și program flexibil</span>
                </div>
                <div class="block-bottom block-5">
                    <img src="src/images/shower.svg">
                    <span>Dușuri și vestiare confortabile</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок "Как это работает" -->
    <div class="steps">
        <img class="main-img" src="src/images/steps.svg" alt="Global Fitenss">

        <div class="container">
            <div class="nav">
                <img src="src/images/nav-line.svg">
                <span>PAȘII TĂI</span>
            </div>

            <h2><b>Cum</b> functionează</h2>
            <p>Global Fitness combină confortul, tehnologia și susținerea profesională pentru rezultate plăcute și
                eficiente:</p>

            <div class="sub-container">
                <div class="block">
                    <img src="src/images/steps-1.svg">
                    <div class="text">
                        <p class="top-p">Completează formularul</p>
                        <p>Completează formularul scurt – durează mai puțin de un minut.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/steps-2.svg">
                    <div class="text">
                        <p class="top-p">Primești o consultanță gratuită</p>
                        <p>Te sunăm, discutăm obiectivele și răspundem la întrebări.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/steps-3.svg">
                    <div class="text">
                        <p class="top-p">Începi antrenamentele și vezi rezultatele</p>
                        <p>Primele rezultate apar în câteva săptămâni.</p>
                    </div>
                </div>

                <div class="button">
                    <a href="#form">Consultanție gratuită</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок с услугами -->
    <div class="services">
        <h2 class="h2-ro-services">SERVICIILE NOASTRE</h2>

        <div class="container">
            <img src="src/images/ser-1.svg" alt="Antrenament individual cu antrenor personal la clubul Global Fitness">
            <img src="src/images/ser-2.svg"
                alt="Antrenament de grup de yoga și pilates la clubul de fitness Global Fitness, Chișinău">
            <img src="src/images/ser-3.svg" alt="Antrenament de karate pentru copii 12-18 ani la clubul Global Fitness">
            <img src="src/images/ser-4.svg" alt="Saună pentru relaxare la clubul de fitness Global Fitness, Țicani">
        </div>
    </div>

    <!-- Блок с тренерами -->
    <div class="team" id="staff">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>Sprijinul tău</span>
        </div>

        <h2><b>Antrenorii</b> noștri</h2>
        <p>La Global Fitness lucrează specialiști certificați care te ajută să-ți atingi obiectivele în mod sigur și
            eficient. Alegem antrenorul potrivit pentru nivelul, personalitatea și scopurile tale.</p>

        <div class="arrows">
            <img src="src/images/arr-lt.svg" id="arrow-left">
            <img src="src/images/arr-rt.svg" id="arrow-right">
        </div>

        <div class="container" id="slider">
            <div class="block">
                <img src="src/images/tr-1.png"
                    alt="Rusu Diana — antrenor de antrenamente de grup și individuale cu 12 ani experiență">
                <div class="overlay">
                    <p class="name">Rusu Diana</p>
                    <p>Antrenoare de antrenamente de grup și individuale</p>
                    <p>12 ani de experiență</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-2.png" alt="Victor Vasilică — antrenor personal cu 4 ani experiență">
                <div class="overlay">
                    <p class="name">Victor Vasilică</p>
                    <p>Antrenor personal</p>
                    <p>4 ani de experiență</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-3.png" alt="Nicolae Ciustrugă — antrenor de Karate-Do cu 20 de ani experiență">
                <div class="overlay">
                    <p class="name">Nicolae Chistrugă</p>
                    <p>Antrenor de Karate-Do</p>
                    <p>20 de ani de experiență</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-4.png" alt="Maxim Balan — antrenor personal cu 10 ani experiență">
                <div class="overlay">
                    <p class="name">Maxim Balan</p>
                    <p>Antrenor personal</p>
                    <p>10 ani de experiență</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-5.svg" alt="Oleg Abalin — antrenor de Karate-Do cu 36 de ani experiență">
                <div class="overlay">
                    <p class="name">Oleg Abalin</p>
                    <p>Antrenor de Karate-Do</p>
                    <p>36 de ani de experiență</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок с галлерей -->
    <div class="gallery">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>Atmosfera sălii</span>
        </div>

        <h2>Descoperă <b>Global Fitness</b></h2>
        <p>Vezi cum arată drumul tău spre rezultate: săli spațioase, echipamente moderne și zone confortabile.</p>

        <div class="container">
            <div class="block">
                <img src="src/images/gal-2.png" alt="Sălă modernă de fitness a clubului Global Fitness din Chișinău">
                <img src="src/images/gal-1.png" alt="Vestiar curat și spațios al clubului de fitness Global Fitness">
                <img src="src/images/gal-3.png" alt="Saună pentru relaxare la clubul de fitness Global Fitness, Țicani">
            </div>

            <div class="block">
                <img src="src/images/gal-4.png" alt="Sălă modernă de fitness a clubului Global Fitness din Chișinău">
                <img src="src/images/gal-5.png" alt="Sălă modernă de fitness a clubului Global Fitness din Chișinău">
                <img src="src/images/gal-6.png" alt="Sălă modernă de fitness a clubului Global Fitness din Chișinău">
            </div>

            <div class="block">
                <img src="src/images/gal-7.png"
                    alt="Sală pentru antrenamente de karate și pilates la clubul Global Fitness, Țicani">
                <img src="src/images/gal-8.png"
                    alt="Sală pentru antrenamente de karate și pilates la clubul Global Fitness, Țicani">
                <img src="src/images/gal-9.png"
                    alt="Sală pentru antrenamente de karate și pilates la clubul Global Fitness, Țicani">
            </div>
        </div>
    </div>

    <!-- Блок с отзывом -->
    <div class="review" id="reviews">
        <img src="src/images/review.svg" alt="Иван Янаки">
        <div class="text">
            <h3>„Înainte nu aveam energie — acum zbor!”</h3>
            <span>Înainte de antrenamentul de la club mă simțeam leneș și obosit, chiar și după weekend. În doar câteva
                săptămâniDupă ce am terminat cursurile, am observat cum mi-a crescut puterea și cum mi s-a îmbunătățit
                starea de spirit. Antrenorii sunt adevărați profesioniști, atmosfera se încarcă! Acum sportul este cel
                mai bun obicei.</span>
            <p class="name">Ivan Ianaki</p>
            <p>21.01.2025</p>
        </div>
    </div>

    <!-- Блок с абонементами -->
    <div class="prices" id="prices">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>ABONAMENTE</span>
        </div>

        <h2>Alege formatul potrivit <b>pentru tine</b></h2>
        <p>Global Fitness înseamnă confort, tehnologie și antrenori care să vă ajute să obțineți rezultate cu plăcere.
        </p>

        <div class="arrows">
            <img src="src/images/arr-lt.svg" id="arrow-left-2">
            <img src="src/images/arr-rt.svg" id="arrow-right-2">
        </div>

        <div class="container" id="slider-2">
            <!-- Abonamente -->
            <div class="block hot">
                <div class="special">
                    <img src="src/images/hot.svg" alt="HOT">
                </div>

                <h5 class="first-h5">12 LUNI</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Sală de fitness</span>
                </div>

                <ul>
                    <li>12 luni</li>
                    <li>Acces între 08:00 și 17:00</li>
                    <li>Include pauză de până la 2 luni</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">4 200 lei</p>
                </div>
            </div>

            <div class="block hot">
                <div class="special">
                    <img src="src/images/hot.svg" alt="HOT">
                </div>

                <h5 class="first-h5">6 LUNI</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Sală de fitness</span>
                </div>

                <ul>
                    <li>6 luni</li>
                    <li>Acces între 08:00 și 17:00</li>
                    <li>Include pauză de 1 lună</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">2 340 lei</p>
                </div>
            </div>

            <div class="block">
                <h5>3 LUNI</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Sală de fitness</span>
                </div>

                <ul>
                    <li>3 luni</li>
                    <li>Acces între 08:00 și 17:00</li>
                    <li>Include pauză de 2 săptămâni</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">1 260 lei</p>
                </div>
            </div>

            <div class="block">
                <h5>1 LUNĂ</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Sală de fitness</span>
                </div>

                <ul>
                    <li>1 lună</li>
                    <li>Acces între 08:00 și 17:00</li>
                    <li>Fără pauză</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">450 lei</p>
                </div>
            </div>

            <!-- Abonament #2 -->
            <div class="block">
                <h5 class="first-h5">ABONAMENT</h5>
                <h5>DE WEEKEND</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Sală de fitness</span>
                </div>

                <ul>
                    <li>1 lună</li>
                    <li>Sâmbătă între 08:00 și 18:00</li>
                    <li>Duminică între 09:00 și 15:00</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">300 lei</p>
                </div>
            </div>

            <div class="block">
                <h5 class="first-h5">ANTRENAMENTE</h5>
                <h5>PERSONALE</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Sală de fitness</span>
                </div>

                <ul>
                    <li>10 antrenamente personale</li>
                    <li>Fără stretching</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">3 000 lei</p>
                </div>
            </div>

            <div class="block">
                <h5 class="first-h5">ANTRENAMENTE</h5>
                <h5>PERSONALE</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Sală de fitness</span>
                </div>

                <ul>
                    <li>10 antrenamente personale</li>
                    <li>Include stretching</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">3 500 lei</p>
                </div>
            </div>

            <div class="block">
                <h5>YOGA / PILATES</h5>
                <h5>ANTREN. DE GRUP</h5>

                <div class="line">
                    <img src="src/images/group.svg">
                    <span>Antrenamente de grup</span>
                </div>

                <ul>
                    <li>1 lună</li>
                    <li>8 ședințe</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">650 lei</p>
                </div>
            </div>

            <!-- Abonamente #3 -->
            <div class="block">
                <h5 class="first-h5">YOGA / PILATES</h5>
                <h5>ANTREN. DE GRUP</h5>

                <div class="line">
                    <img src="src/images/group.svg">
                    <span>Antrenamente de grup</span>
                </div>

                <ul>
                    <li>1 lună</li>
                    <li>12 ședințe</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">900 lei</p>
                </div>
            </div>

            <div class="block">
                <h5 class="first-h5">KARATE MINI</h5>
                <h5>GRUPĂ</h5>

                <div class="line">
                    <img src="src/images/judo.svg">
                    <span>Antrenamente de grup</span>
                </div>

                <ul>
                    <li>1 lună</li>
                    <li>Vârsta 4–13 ani</li>
                    <li>12 ședințe</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">800 lei</p>
                </div>
            </div>

            <div class="block">
                <h5 class="first-h5">KARATE MEDIU</h5>
                <h5>GRUPĂ</h5>

                <div class="line">
                    <img src="src/images/judo.svg">
                    <span>Antrenamente de grup</span>
                </div>

                <ul>
                    <li>1 lună</li>
                    <li>Vârsta 14–17 ani</li>
                    <li>12 ședințe</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">900 lei</p>
                </div>
            </div>

            <div class="block">
                <h5>KARATE MAXI</h5>
                <h5>GRUPĂ</h5>

                <div class="line">
                    <img src="src/images/judo.svg">
                    <span>Antrenamente de grup</span>
                </div>

                <ul>
                    <li>1 lună</li>
                    <li>18+</li>
                    <li>12 ședințe</li>
                </ul>

                <div class="price">
                    <p>Preț:</p>
                    <p class="value">1 000 lei</p>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Блока "Почему выбирают нас" -->
    <div class="chose steps">
        <img class="main-img" src="src/images/chose-img.svg">

        <div class="container">
            <div class="nav">
                <img src="src/images/nav-line.svg">
                <span>Grijă și rezultate</span>
            </div>

            <h2><b>De ce</b> ne aleg clientii</h2>
            <p>La noi fiecare client contează – din prima clipă până la atingerea obiectivului. Combinăm antrenamente,
                nutriție și suport într-un sistem unic pentru rezultate stabile și motivante.</p>

            <div class="sub-container">
                <div class="block">
                    <img src="src/images/human-ch.svg">
                    <div class="text">
                        <p class="top-p">Abordare individuală</p>
                        <p>Adaptăm programul în funcție de obiective, nivel și preferințe.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/eat-ch.svg">
                    <div class="text">
                        <p class="top-p">Program alimentar</p>
                        <p>Plan echilibrat pentru energie și rezultate vizibile.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/heart-cs.svg">
                    <div class="text">
                        <p class="top-p">Antrenamente sigure</p>
                        <p>Exerciții corecte, fără suprasolicitare sau riscuri.</p>
                    </div>
                </div>

                <div class="button">
                    <a href="#form"> Consultanție gratuită</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок с местоположением (картой) -->
    <div class="maps" id="contacts">
        <div class="container">
            <div class="nav">
                <img src="src/images/nav-line.svg">
                <span>CONTACT</span>
            </div>

            <h2>Adresă și <b>Contacte</b></h2>
            <p>Vino la un antrenament sau pune-ne o întrebare – suntem mereu disponibili.</p>

            <div class="info">
                <span>Adresă: str. Mircea cel Bătrân 39, Chișinău, Moldova</span>
                <span>Telefon: +373 788 555 88</span>
                <span>Telefon: 0 (22) 622-258</span>
                <span>E-mail: info@globalfitness.md</span>
                <span>Luni–Vineri: 08:00 – 22:00</span>
                <span>Sâmbătă: 08:00 – 18:00</span>
                <span>Duminică: 09:00 – 15:00</span>
            </div>
        </div>

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1063.886085475106!2d28.887126810302753!3d47.056692784767314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97cc1fd6e0e81%3A0x542fe265fdaa3a26!2sGlobal%20Fitness%20Club!5e1!3m2!1sru!2s!4v1747913759312!5m2!1sru!2s"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Форма обратной связи -->
    <div class="consultation" id="form">
        <div class="nav">
            <span>Gata să începi?</span>
            <img src="src/images/nav-line.svg">
        </div>

        <h2>Obtine o consultantă</h2>
        <h2>gratuită!<b></b></h2>
        <p>Fără spam. Te contactăm în 15 minute.</p>

        <div class="form">
            <form action="" method="POST">
                <label>Nume*</label>
                <input type="text" placeholder="Nume" name="name">
                <?php if (isset($_SESSION["error-name"])) { ?>
                    <div class="alert"><span><?= $_SESSION["error-name"] ?></span></div>
                    <?php unset($_SESSION["error-name"]); ?>
                <?php } ?>

                <label>Telefon*</label>
                <input type="text" placeholder="Telefon" name="phone">
                <?php if (isset($_SESSION["error-phone"])) { ?>
                    <div class="alert"><span><?= $_SESSION["error-phone"] ?></span></div>
                    <?php unset($_SESSION["error-phone"]); ?>
                <?php } ?>

                <?php if (isset($_SESSION["success"])) { ?>
                    <div class="alert success"><span><?= $_SESSION["success"] ?></span></div>
                    <?php unset($_SESSION["success"]); ?>
                <?php } ?>

                <div class="button">
                    <button type="submit">Tremite</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Футер -->
    <footer>
        <div class="container">
            <div class="block block-1">
                <img class="logo" src="src/images/logo.png" alt="Global Fitness">
                <p>Global Fitness — antrenamente cu confort și rezultate.</p>

                <div class="socials">
                    <a href="https://www.instagram.com/global.fitness.md/"><img src="src/images/instagram.svg"
                            alt="Instagram"></a>
                    <a href="https://www.facebook.com/global.fitness.md/?locale=ru_RU"><img
                            src="src/images/facebook-16.svg" alt="Facebook"></a>
                </div>
            </div>

            <div class="block block-2">
                <a href="#about">Despre club</a>
                <a href="#staff">Antrenori</a>
                <a href="#reviews">Recenzii</a>
                <a href="#prices">Abonamente</a>
            </div>

            <div class="block block-3">
                <div class="sub-block">
                    <img src="src/images/phone.svg">
                    <span>+373 788 555 88</span>
                </div>
                <div class="sub-block">
                    <img src="src/images/phone.svg">
                    <span>0 (22) 622-258</span>
                </div>
                <div class="sub-block">
                    <img src="src/images/adress-point.svg">
                    <span>str. Mircea cel Bătrân 39, Chișinău</span>
                </div>
                <div class="sub-block">
                    <img src="src/images/mail.svg">
                    <span>info@globalfitness.md</span>
                </div>
            </div>

            <div class="block block-3">
                <div class="sub-block">
                    <img src="src/images/clock.svg">
                    <span>Luni–Vineri: 08:00 – 22:00</span>
                </div>
                <div class="sub-block">
                    <img src="src/images/clock.svg">
                    <span>Sâmbătă: 08:00 – 18:00</span>
                </div>
                <div class="sub-block">
                    <img src="src/images/clock.svg">
                    <span>Duminică: 09:00 – 15:00</span>
                </div>
            </div>
        </div>

        <div class="line"></div>

        <div class="second-container">
            <span>© Global Fitness, All Rights Reverved, <a href="https://www.instagram.com/agency.omnify/">Designed &
                    Developed by Omnify Agency</a></span>
            <a href="Regulile clubului Global Fitness.docx" download>Regulamentul intern al clubuluiе</a>
        </div>
    </footer>

    <!-- Подключение JS -->
    <script src="src/js/slider_team.js"></script>
    <script src="src/js/slider_prices.js"></script>
    <script src="src/js/burger.js"></script>
</body>

</html>