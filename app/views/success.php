<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo (URLROOT . "public/css/main.css") ?>">
    <title>Success!</title>
</head>
<body>
<div class="container">

<!-- Navigation -->

<nav class="nav">

    <!-- Logo -->

    <a class="logo" draggable="false" href="#"><img draggable="false" src="<?php echo (URLROOT . "public/img/logo_pineapple.svg") ?>" alt="logo"></a>
    <a class="nav__link" draggable="false" href="#"><img draggable="false" src="<?php echo (URLROOT . "public/img/pineapple..png") ?>" alt="Pineapple."></a>
    <ul class="nav-left">

        <!-- Left Side of Nav -->

        <li class="nav-left__item">
            <a href="<?php echo (URLROOT . "emails") ?>" class="nav-left__link">Table</a>
        </li>
        <li class="nav-left__item">
            <a href="#" class="nav-left__link">About</a>
        </li>

        <li class="nav-left__item">
            <a href="#" class="nav-left__link">How it works</a>
        </li>

        <li class="nav-left__item">
            <a href="#" class="nav-left__link">Contact</a>
        </li>
    </ul>
</nav>

<!-- Main Content -->

<main class="main">
    <section class="card">

        <!-- Success Message -->

        <div>
            <img class="card__cup" draggable="false" src="<?php echo (URLROOT . "public/img/ic_success.svg") ?>" alt="Success">
            <div class="card__success">
                <h2 class="card__header card__item">Thanks for subscribing!</h2>
                <div class="success-margin">&nbsp;</div>
                <h3 class="card__description card__item">You have successfully subscribed to our email listing. Check your email for the discount code.</h3>
            </div>
        </div>

        <hr>

        <!-- Social Icons -->

        <div class="card__social-icons">
            <a class="card__social-icons__link fb" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic_facebook.svg") ?>" alt="Facebook"></a>
            <a class="card__social-icons__link ig" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic instagram.svg") ?>" alt="Instagram"></a>
            <a class="card__social-icons__link tw" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic_twitter.svg") ?>" alt="Twitter"></a>
            <a class="card__social-icons__link yt" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic youtube.svg") ?>" alt="Youtube"></a>
        </div>

        <div class="desktop-margin">
            &nbsp;
        </div>

    </section>
</main>

</div>

<!-- Desktop Background -->

<div class="image">
&nbsp;
</div>

</body>
</html>

