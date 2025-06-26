<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Подключение автозагрузчика Composer
require 'vendor/autoload.php';

// Запуск сессии
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $hasError = false;

    // Валидация имени
    if (empty($name)) {
        $_SESSION["error-name"] = "Это обязательное поле";
        $hasError = true;
    } elseif (mb_strlen($name) < 2) {
        $_SESSION["error-name"] = "Имя слишком короткое";
        $hasError = true;
    }

    // Валидация телефона (9 цифр)
    if (empty($phone)) {
        $_SESSION["error-phone"] = "Это обязательное поле";
        $hasError = true;
    } elseif (!preg_match('/^\d{9}$/', $phone)) {
        $_SESSION["error-phone"] = "Некорректный номер телефона";
        $hasError = true;
    }

    if (!$hasError) {
        $mail = new PHPMailer(true);

        try {
            // Настройки сервера
            $mail->isSMTP();
            $mail->Host       = 'smtp.globalfitness.md'; // SMTP-сервер
            $mail->SMTPAuth   = true;
            $mail->Username   = 'globalfitnessmd@mail.ru'; // Почта
            $mail->Password   = 'saladeforta201814';       // Пароль от почты
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // От кого и кому
            $mail->setFrom('noreply@globalfitness.md', 'Global Fitness');
            $mail->addAddress('info@globalfitness.md');

            // Контент письма
            $mail->isHTML(true);
            $mail->Subject = 'Запрос на консультацию с сайта Global Fitness';
            $mail->Body    = "
                <h2>Новая заявка на консультацию</h2>
                <p><strong>Имя:</strong> {$name}</p>
                <p><strong>Телефон:</strong> {$phone}</p>
            ";
            $mail->CharSet = 'UTF-8';

            $mail->send();
            $_SESSION["success"] = "Спасибо за заявку! Мы скоро с вами свяжемся.";
        } catch (Exception $e) {
            $_SESSION["error-send"] = "Ошибка при отправке письма: " . $mail->ErrorInfo;
        }

        session_write_close(); // Завершение сессии перед редиректом
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
    <title>Фитнес клуб Global Fitness в Чеканах — тренажерный зал, сауна, каратэ для детей</title>

    <!-- SEO -->
    <meta name="description"
        content="Тренажерный зал, групповые и индивидуальные тренировки, сауна, солярий, каратэ для детей в фитнес клубе Global Fitness, Кишинёв, Чеканы.">
    <meta name="keywords"
        content="фитнес клуб Чеканы, тренажерный зал Кишинёв, персональные тренировки для мужчин, силовые тренировки Кишинёв, групповые тренировки для мужчин, фитнес для мужчин 25–35 лет, тренировки для набора массы, фитнес для начинающих мужчин, тренировки для набора мышечной массы, тренажерный зал для студентов, фитнес клубы в Чеканах, абонемент в спортзал Кишинёв, тренировки для мужчин 18–25 лет, фитнес для женщин Кишинёв, групповые тренировки для женщин, йога для похудения, тренировки для женщин 18–23 лет, фитнес клуб Чеканы для женщин, программы похудения Кишинёв, каратэ для детей Кишинёв, секция каратэ Чеканы, тренировки по каратэ для подростков, каратэ клубы в Кишинёве, занятия каратэ для детей 12–18 лет, каратэ для начинающих детей, сауна Кишинёв, солярий в Чеканах, массажный кабинет Кишинёв, индивидуальные тренировки Кишинёв, групповые фитнес-занятия, фитнес клуб с сауной и солярием">
    <link rel="canonical" href="https://globalfitness.md/" />

    <meta property="og:title"
        content="Фитнес клуб Global Fitness в Чеканах — тренажерный зал, сауна, каратэ для детей" />
    <meta property="og:description"
        content="Страница фитнес клуба, показаны тренера, сам зал и услуги, а также есть запись на консультацию" />
    <meta property="og:image" content="https://globalfitness.md/assets/preview.jpg" />
    <meta property="og:url" content="https://globalfitness.md" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Global Fitness" />
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
                    <a href="#about">О клубе</a>
                    <a href="#staff">Тренеры</a>
                    <a href="#reviews">Отзывы</a>
                    <a href="#prices">Абонементы</a>
                    <a href="#contacts">Контакты</a>
                </div>
                <div class="language">
                    <a href="/main_ro.php">RO</a>
                    <img src="src/images/bar.svg">
                    <a href="/" class="active">RU</a>
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
            <a href="#about">О клубе</a>
            <a href="#staff">Тренеры</a>
            <a href="#reviews">Отзывы</a>
            <a href="#prices">Абонементы</a>
            <a href="#contacts">Контакты</a>
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
                <span>Пн-Пт: 08:00 – 22:00</span>
            </div>
            <div class="sub-block">
                <img src="src/images/clock.svg">
                <span>Суббота: 08:00 – 18:00</span>
            </div>
            <div class="sub-block">
                <img src="src/images/clock.svg">
                <span>Воскресенье: 09:00 – 15:00</span>
            </div>
        </div>
    </div>

    <!-- Блок Hero -->
    <div class="hero">
        <h1 class="visually-hidden">Фитнес клуб Global Fitness в Чеканах — тренажерный зал, сауна, каратэ для детей</h1>
        <h2 class="visually-hidden">О фитнес клубе Global Fitness в Чеканах</h2>
        <h2 class="visually-hidden">Почему выбирают Global Fitness</h2>
        <h2 class="visually-hidden">Наши преимущества и особенности</h2>
        <h2 class="visually-hidden">Тренажерный зал для мужчин и женщин</h2>
        <h2 class="visually-hidden">Групповые фитнес тренировки</h2>
        <h2 class="visually-hidden">Индивидуальные тренировки с тренером</h2>
        <h2 class="visually-hidden">Секция каратэ для детей 12–18 лет</h2>
        <h2 class="visually-hidden">Программы похудения и коррекции веса</h2>
        <h2 class="visually-hidden">Сауна и релакс-зона</h2>
        <h2 class="visually-hidden">Солярий для загара</h2>
        <h2 class="visually-hidden">Массажный кабинет и процедуры восстановления</h2>
        <h2 class="visually-hidden">Гибкие тарифы и абонементы</h2>
        <h2 class="visually-hidden">Специальные предложения и акции</h2>
        <h2 class="visually-hidden">Пробная тренировка бесплатно</h2>
        <h2 class="visually-hidden">Отзывы наших клиентов</h2>
        <h2 class="visually-hidden">Истории успеха и трансформации</h2>
        <h2 class="visually-hidden">Фото тренажерного зала и бассейна</h2>
        <h2 class="visually-hidden">Видео и фото с тренировок и мероприятий</h2>
        <h2 class="visually-hidden">Адрес фитнес клуба в Чеканах, Кишинёв</h2>
        <h2 class="visually-hidden">Как до нас добраться</h2>
        <h2 class="visually-hidden">График работы и запись на тренировку</h2>
        <h2 class="visually-hidden">Вопросы о тренировках и абонементах</h2>
        <h2 class="visually-hidden">Вопросы по безопасности и санитарным нормам</h2>

        <div class="text">
            <h2>Стань лучшей версией</h2>
            <h2>себя с <b>Global Fitness!</b></h2>
            <p>Современный фитнес-клуб в секторе Чеканы — с современным оборудованием и внимательным подходом!</p>
            <a href="#form">Бесплатная консультация</a>
        </div>
    </div>

    <!-- Блок Преимущества клуба -->
    <div class="benifits" id="about">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>O НАС</span>
        </div>

        <h2>Преимущества <b>клуба</b></h2>
        <p>Global Fitness — это комфорт, технологии и тренеры, которые помогут достичь результата с удовольствием.</p>

        <div class="container">
            <div class="top">
                <div class="block-top block-1">
                    <div class="img"></div>
                    <span>Тренажёрные залы нового поколения</span>
                </div>
                <div class="block-top block-2">
                    <div class="img"></div>
                    <span>Персональные и групповые тренировки</span>
                </div>
                <div class="block-top block-3">
                    <div class="img"></div>
                    <span>Сертифицированные тренеры с опытом</span>
                </div>
            </div>
            <div class="bottom">
                <div class="block-bottom block-4">

                    <div class="img"></div>
                    <span>Удобное расположение и гибкий график</span>
                </div>
                <div class="block-bottom block-5">

                    <div class="img"></div>
                    <span>Комфортные душевые и раздевалки</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок "Как это работает" -->
    <div class="steps">
        <img class="main-img" src="src/images/steps2.svg" alt="Global Fitenss">

        <div class="container">
            <div class="nav">
                <img src="src/images/nav-line.svg">
                <span>ТВОИ ШАГИ</span>
            </div>

            <h2><b>Как</b> это работает</h2>
            <p>Global Fitness — это комфорт, технологии и тренеры, которые помогут достичь результата с удовольствием.
            </p>

            <div class="sub-container">
                <div class="block">
                    <img src="src/images/steps-1.svg">
                    <div class="text">
                        <p class="top-p">Оставляешь заявку</p>
                        <p>Заполни короткую форму — это займёт меньше минуты.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/steps-2.svg">
                    <div class="text">
                        <p class="top-p">Получаешь бесплатную консультацию</p>
                        <p>Мы перезвоним, уточним цели и ответим на вопросы.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/steps-3.svg">
                    <div class="text">
                        <p class="top-p">Начинаешь тренироваться и видеть результат</p>
                        <p>Первые результаты — уже через пару недель.</p>
                    </div>
                </div>

                <div class="button">
                    <a href="#form">Бесплатная консультация</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок с услугами -->
    <div class="services">
        <h2>НАШИ УСЛУГИ</h2>

        <div class="container">
            <img src="src/images/ser-1.svg"
                alt="Индивидуальная тренировка с персональным тренером в клубе Global Fitness">
            <img src="src/images/ser-2.svg"
                alt="Групповое занятие по йоге и пилатесу в фитнес клубе Global Fitness, Кишинёв">
            <img src="src/images/ser-3.svg" alt="Тренировка по каратэ для детей 12-18 лет в клубе Global Fitness">
            <img src="src/images/ser-4.svg" alt="Сауна для релаксации в фитнес клубе Global Fitness, Чеканы">
        </div>
    </div>

    <!-- Блок с тренерами -->
    <div class="team" id="staff">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>Твоя опора</span>
        </div>

        <h2>Наши <b>тренера</b></h2>
        <p>В Global Fitness работают сертифицированные специалисты, которые помогут достичь цели безопасно и эффективно.
            Мы подберём тренера под ваш уровень, характер и задачи.</p>

        <div class="arrows">
            <img src="src/images/arr-lt.svg" id="arrow-left">
            <img src="src/images/arr-rt.svg" id="arrow-right">
        </div>

        <div class="container" id="slider">
            <div class="block">
                <img src="src/images/tr-1.png"
                    alt="Русу Диана — тренер групповых и индивидуальных тренировок с 12-летним опытом">
                <div class="overlay">
                    <p class="name">Русу Диана</p>
                    <p>Тренер групповых и индивидуальных тренировок</p>
                    <p>12 лет опыта</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-2.png" alt="Виктор Василика — персональный тренер с 4-летним опытом">
                <div class="overlay">
                    <p class="name">Виктор Василика</p>
                    <p>Персональный тренер</p>
                    <p>4 года опыта</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-3.png" alt="Максим Балан — персональный тренер с 10-летним опытом">
                <div class="overlay">
                    <p class="name">Максим Балан</p>
                    <p>Персональный тренер</p>
                    <p>10 лет опыта</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-4.png" alt="Николае Кистругэ — тренер по Karate-Do с 20-летним опытом">
                <div class="overlay">
                    <p class="name">Николае Кистругэ</p>
                    <p>Тренер по Karate-Doр</p>
                    <p>20 лет опыта</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-5.png" alt="Олег Абалин — тренер по Karate-Do с 36-летним опытом">
                <div class="overlay">
                    <p class="name">Олег Абалин</p>
                    <p>Тренер по Karate-Do</p>
                    <p>36 лет опыта</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-6.svg" alt="Шиву Валерия — администратор">
                <div class="overlay">
                    <p class="name">Скиву Валерия</p>
                    <p>Администратор</p>
                </div>
            </div>

            <div class="block">
                <img src="src/images/tr-7.svg" alt="Намолован Санда — администратор">
                <div class="overlay">
                    <p class="name">Намолован Санда</p>
                    <p>Администратор</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок с галлерей -->
    <div class="gallery">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>Атмосфера клуба</span>
        </div>

        <h2>Загляни внутрь <b>Global Fitness</b></h2>
        <p>Посмотри, где проходит твой путь к результату — просторные залы, современное оборудование и уют в каждой
            зоне.</p>

        <div class="arrows">
            <img src="src/images/arr-lt.png" id="arrow-left-3">
            <img src="src/images/arr-rt.png" id="arrow-right-3">
        </div>

        <div class="container" id="slider-3">
            <div class="block slide active">
                <img src="src/images/gal-2.png" alt="Современный тренажерный зал фитнес клуба Global Fitness в Кишинёве">
                <img src="src/images/gal-1.png" alt="Чистая и просторная раздевалка фитнес клуба Global Fitness">
                <img src="src/images/gal-3 1.png" alt="Сауна для релаксации в фитнес клубе Global Fitness, Чеканы">
            </div>

            <div class="block slide">
                <img src="src/images/gal-4.png" alt="Современный тренажерный зал фитнес клуба Global Fitness в Кишинёве">
                <img src="src/images/gal-5.png" alt="Современный тренажерный зал фитнес клуба Global Fitness в Кишинёве">
                <img src="src/images/gal-6.png" alt="Современный тренажерный зал фитнес клуба Global Fitness в Кишинёве">
            </div>

            <div class="block slide">
                <img src="src/images/gal-7.png" alt="Зал для занятий каратэ и пилатесом в клубе Global Fitness, Чеканы">
                <img src="src/images/gal-8.png" alt="Зал для занятий каратэ и пилатесом в клубе Global Fitness, Чеканы">
                <img src="src/images/gal-9.png" alt="Зал для занятий каратэ и пилатесом в клубе Global Fitness, Чеканы">
            </div>
        </div>
    </div>

    <!-- Блок с отзывом -->
    <div class="review" id="reviews">
        <img src="src/images/review.svg" alt="Иван Янаки">
        <div class="text">
            <h3>“Раньше не было энергии — теперь летаю!”</h3>
            <span>До тренировок в клубе чувствовал себя вялым и уставшим, даже после выходных. Уже через пару недель
                занятий заметил, как прибавилось сил и улучшилось настроение. Тренеры — настоящие профи, атмосфера
                заряжает! Теперь спорт — моя лучшая привычка.</span>
            <p class="name">Иван Янаки</p>
            <p>21.01.2025</p>
        </div>
    </div>

    <!-- Блок с абонементами -->
    <div class="prices" id="prices">
        <div class="nav">
            <img src="src/images/nav-line.svg">
            <span>АБОНЕМЕНТЫ</span>
        </div>

        <h2>Выбери формат, который <b>подходит тебе</b></h2>
        <p>Global Fitness — это комфорт, технологии и тренеры, которые помогут достичь результата с удовольствием.</p>

        <div class="arrows">
            <img src="src/images/arr-lt.png" id="arrow-left-2">
            <img src="src/images/arr-rt.png" id="arrow-right-2">
        </div>

        <a href="https://imgur.com/a/2Tp2ApE" target="_blank" class="grafic">График групповых занятий</a>

        <div class="container" id="slider-2">
            <!-- Абонементы -->
            <div class="block hot">
                <div class="special">
                    <img src="src/images/hot.svg" alt="HOT">
                </div>

                <h5 class="first-h5">12 МЕСЯЦЕВ</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>12 месяцев</li>
                    <li>Вход с 08:00 до 17:00</li>
                    <li>Включает заморозку на 2 месяца</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">4 200 лей</p>
                </div>
            </div>

            <div class="block hot">
                <div class="special">
                    <img src="src/images/hot.svg" alt="HOT">
                </div>

                <h5 class="first-h5">6 МЕСЯЦЕВ</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>6 месяцев</li>
                    <li>Вход с 08:00 до 17:00</li>
                    <li>Включает заморозку на 1 месяца</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">2 340 лей</p>
                </div>
            </div>
            <div class="block">
                <h5>3 МЕСЯЦЕВ</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>3 месяцев</li>
                    <li>Вход с 08:00 до 17:00</li>
                    <li>Включает заморозку на 2 недели</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">1 260 лей</p>
                </div>
            </div>
            <div class="block">
                <h5>1 МЕСЯЦ</h5>
                <h5>DAY CARD</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>Вход с 08:00 до 17:00</li>
                    <li>Без заморозки</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">450 лей</p>
                </div>
            </div>

            <!-- Безлимитные абонементы -->
            <div class="block">
                <h5 class="first-h5">12 МЕСЯЦЕВ</h5>
                <h5>NO LIMIT</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>12 месяцев</li>
                    <li>Вход с 08:00 до 22:00</li>
                    <li>Включает заморозку на 2 месяца</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">4 800 лей</p>
                </div>
            </div>

            <div class="block">
                <h5 class="first-h5">6 МЕСЯЦЕВ</h5>
                <h5>NO LIMIT</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>6 месяцев</li>
                    <li>Вход с 08:00 до 22:00</li>
                    <li>Включает заморозку на 1 месяца</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">2 700 лей</p>
                </div>
            </div>
            <div class="block">
                <h5>3 МЕСЯЦЕВ</h5>
                <h5>NO LIMIT</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>3 месяцев</li>
                    <li>Вход с 08:00 до 22:00</li>
                    <li>Включает заморозку на 2 недели</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">1 500 лей</p>
                </div>
            </div>
            <div class="block">
                <h5>1 МЕСЯЦ</h5>
                <h5>NO LIMIT</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>Вход с 08:00 до 22:00</li>
                    <li>Без заморозки</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">550 лей</p>
                </div>
            </div>

            <!-- Абонементы #2 -->
            <div class="block">
                <h5 class="first-h5">АБОНЕМЕНТ</h5>
                <h5>ВЫХОДНОГО ДНЯ</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>Суббота с 08:00 до 18:00</li>
                    <li>Воскресенье с 09:00 до 15:00</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">300 лей</p>
                </div>
            </div>

            <div class="block">
                <h5 class="first-h5">ПЕРСОНАЛЬНЫЕ</h5>
                <h5>ТРЕНИРОВКИ</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>10 персональных тренировок</li>
                    <li>Без растяжки</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">3 000 лей</p>
                </div>
            </div>
            <div class="block">
                <h5 class="first-h5">ПЕРСОНАЛЬНЫЕ</h5>
                <h5>ТРЕНИРОВКИ</h5>

                <div class="line">
                    <img src="src/images/dumbbell-pr.svg">
                    <span>Фитнесс зал</span>
                </div>

                <ul>
                    <li>10 персональных тренировок</li>
                    <li>Включает растяжку</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">3 500 лей</p>
                </div>
            </div>
            <div class="block">
                <h5>ЙОГА / ПИЛАТЕС</h5>
                <h5>ГРУПП. ТРЕН.</h5>

                <div class="line">
                    <img src="src/images/group.svg">
                    <span>Групповые тренировки</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>8 занятий</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">650 лей</p>
                </div>
            </div>

            <!-- Абонементы #3 -->
            <div class="block">
                <h5 class="first-h5">ЙОГА / ПИЛАТЕС</h5>
                <h5>ГРУПП. ТРЕН.</h5>

                <div class="line">
                    <img src="src/images/group.svg">
                    <span>Групповые тренировки</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>12 занятий</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">900 лей</p>
                </div>
            </div>

            <div class="block">
                <h5 class="first-h5">КАРАТЭ МИНИ</h5>
                <h5>ГРУППА</h5>

                <div class="line">
                    <img src="src/images/judo.svg">
                    <span>Групповые тренировки</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>Для 4–13 лет</li>
                    <li>12 занятий</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">800 лей</p>
                </div>
            </div>
            <div class="block">
                <h5 class="first-h5">КАРАТЭ СРЕДНЯЯ</h5>
                <h5>ГРУППА</h5>

                <div class="line">
                    <img src="src/images/judo.svg">
                    <span>Групповые тренировки</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>Для 14–17 лет</li>
                    <li>12 занятий</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">900 лей</p>
                </div>
            </div>
            <div class="block">
                <h5>КАРАТЭ МАКСИ</h5>
                <h5>ГРУППA</h5>

                <div class="line">
                    <img src="src/images/judo.svg">
                    <span>Групповые тренировки</span>
                </div>

                <ul>
                    <li>1 месяц</li>
                    <li>18+</li>
                    <li>12 занятий</li>
                </ul>

                <div class="price">
                    <p>Цена:</p>
                    <p class="value">1 000 лей</p>
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
                <span>Забота и результат</span>
            </div>

            <h2><b>Почему</b> выбирают нас</h2>
            <p>У нас важен каждый клиент — от первого шага до достижения цели. Мы объединяем тренировки, питание и
                поддержку в единую систему, чтобы результат был стабильным и вдохновляющим.</p>

            <div class="sub-container">
                <div class="block">
                    <img src="src/images/human-ch.svg">
                    <div class="text">
                        <p class="top-p">Индивидуальный подход</p>
                        <p>Подбираем программу с учётом целей, уровня и предпочтений.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/eat-ch.svg">
                    <div class="text">
                        <p class="top-p">Программа питания</p>
                        <p>Сбалансированный рацион для энергии и результата.</p>
                    </div>
                </div>
                <div class="block">
                    <img src="src/images/heart-cs.svg">
                    <div class="text">
                        <p class="top-p">Безопасные тренировки</p>
                        <p>Тренируемся грамотно, без перегрузок и травм.</p>
                    </div>
                </div>

                <div class="button">
                    <a href="#form">Бесплатная консультация</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Блок с местоположением (картой) -->
    <div class="maps" id="contacts">
        <div class="container">
            <div class="nav">
                <img src="src/images/nav-line.svg">
                <span>Связь с нами</span>
            </div>

            <h2><b>Контакты</b> и локация</h2>
            <p>Приходи на тренировку или задай вопрос — мы всегда на связи и рады помочь.</p>

            <div class="info">
                <span>Адрес: str. Mircea cel Bătrân 39, Chișinău, Moldova</span>
                <span>Телефон: +373 788 555 88</span>
                <span>Телефон: 0 (22) 622-258</span>
                <span>Почта: globalfitnessmd@mail.ru</span>
                <span>Пн-Пт: 08:00 – 22:00</span>
                <span>Суббота: 08:00 – 18:00</span>
                <span>Воскресенье: 09:00 – 15:00</span>
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
            <span>ГОТОВ НАЧАТЬ?</span>
            <img src="src/images/nav-line.svg">
        </div>

        <h2>Получи <b>бесплатную</b></h2>
        <h2>консультацию!</h2>
        <p>Без спама. Мы свяжемся с вами в течение 15 минут.</p>

        <div class="form">
            <form action="" method="POST">
                <label>Имя*</label>
                <input type="text" placeholder="Имя" name="name">
                <?php if (isset($_SESSION["error-name"])) { ?>
                    <div class="alert"><span><?= $_SESSION["error-name"] ?></span></div>
                    <?php unset($_SESSION["error-name"]); ?>
                <?php } ?>

                <label>Телефон*</label>
                <input type="text" placeholder="Телефон" name="phone">
                <?php if (isset($_SESSION["error-phone"])) { ?>
                    <div class="alert"><span><?= $_SESSION["error-phone"] ?></span></div>
                    <?php unset($_SESSION["error-phone"]); ?>
                <?php } ?>

                <?php if (isset($_SESSION["success"])) { ?>
                    <div class="alert success"><span><?= $_SESSION["success"] ?></span></div>
                    <?php unset($_SESSION["success"]); ?>
                <?php } ?>

                <?php if (isset($_SESSION["error-send"])) { ?>
                    <div class="alert"><span><?= $_SESSION["error-send"] ?></span></div>
                    <?php unset($_SESSION["error-send"]); ?>
                <?php } ?>

                <div class="button">
                    <button type="submit">Отправить</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Футер -->
    <footer>
        <div class="container">
            <div class="block block-1">
                <img class="logo" src="src/images/logo.svg" alt="Global Fitness">
                <p>Global Fitness — тренировки c комфортом и результатом.</p>

                <div class="socials">
                    <a href="https://www.instagram.com/global.fitness.md/"><img src="src/images/instagram.svg"
                            alt="Instagram"></a>
                    <a href="https://www.facebook.com/global.fitness.md/?locale=ru_RU"><img
                            src="src/images/facebook-16.svg" alt="Facebook"></a>
                </div>
            </div>

            <div class="block block-2">
                <a href="#about">О клубе</a>
                <a href="#staff">Тренеры</a>
                <a href="#reviews">Отзывы</a>
                <a href="#prices">Абонементы</a>
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
                    <span>globalfitnessmd@mail.ru</span>
                </div>
            </div>

            <div class="block block-3">
                <div class="sub-block">
                    <img src="src/images/clock.svg">
                    <span>Пн-Пт: 08:00 – 22:00</span>
                </div>
                <div class="sub-block">
                    <img src="src/images/clock.svg">
                    <span>Суббота: 08:00 – 18:00</span>
                </div>
                <div class="sub-block">
                    <img src="src/images/clock.svg">
                    <span>Воскресенье: 09:00 – 15:00</span>
                </div>
            </div>
        </div>

        <div class="line"></div>

        <div class="second-container">
            <span>© Global Fitness, All Rights Reverved, <a href="https://www.instagram.com/agency.omnify/">Designed &
                    Developed by Omnify Agency</a></span>
            <a href="Regulile clubului Global Fitness.docx" download>Правила поведения в клубе</a>
        </div>
    </footer>

    <!-- Подключение JS -->
    <script src="src/js/slider_team.js"></script>
    <script src="src/js/slider_prices.js"></script>
    <script src="src/js/slider_gallery.js"></script>
    <script src="src/js/burger.js"></script>
</body>

</html>