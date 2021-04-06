<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo (URLROOT . "public/css/main.css") ?>">
    <script src="https://unpkg.com/vue@next"></script>
    <title>Test 2</title>
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
        <!-- Vue App -->
    
        <main class="main" id="app">
            <section class="card">

                <!-- Form -->

                <div>
                    <h2 class="card__header card__item">Subscribe to newsletter</h2>
                    <h3 class="card__description card__item">Subscribe to our newsletter and get 10% discount on pineapple glasses</h3>
        
                    <!-- Email Input -->
    
                    <form ref='form' v-on:submit.prevent action="<?php echo (URLROOT . "emails/submit") ?>" method="POST">
                        <div class="card__input card__item">
                            <input class="card__input__field" type="text" name="email" placeholder="Type your email address here..." 
                            <?php 
                            
                            // Keep the input after refresh

                            if (isset($data['email']) && (!empty($data['email']))) {
                                echo('value="'. $data['email'] . '"');
                            }

                            ?>>
                            <button @click="validate()" class="card__input__btn" type="button">
                                <img draggable="false" src="<?php echo (URLROOT . "public//img/ic_arrow.svg") ?>" alt="confirm">
                            </button>
                        </div>

                        <!-- Errors Vue -->

                        <div v-if="errors.length">
                            <p v-for="error in errors" class="card__error">{{ error.message }}</p>
                        </div>

                        <!-- Errors PHP -->

                        <div>
                            <?php 
                            if (isset($data['emailError']) && !empty($data['emailError'])) {
                                echo '<p class="card__error">' . $data['emailError'] . '</p>';
                            }
                            if (isset($data['termsError']) && !empty($data['termsError'])) {
                                echo '<p class="card__error">' . $data['termsError'] . '</p>';
                            }
                            ?>
                        </div>
                        
                        <!-- Checkbox -->
    
                        <label class="card__checkbox card__item">
                            <input class="card__checkbox--old" name="terms" type="checkbox" id="toggle" 
                            <?php 
                            
                            // Keep the input after refresh
                            
                            if (isset($data['terms']) && $data['terms']) {
                                echo('checked');
                            }

                            ?>>
                            
                            <span class="card__checkbox--unchecked">
                                <img draggable="false" src="<?php echo (URLROOT . "public/img/unchecked.png") ?>" alt="unchecked">
                            </span>
        
                            <span class="card__checkbox--checked">
                                <img draggable="false" src="<?php echo (URLROOT . "public/img/checked.png") ?>" alt="checked">
                                <img class="card__checkbox__icon" draggable="false" src="<?php echo (URLROOT . "public/img/ic_checkmark.svg") ?>" alt="checkmark">
                            </span>
                        </label>
                        
                        <!-- Terms of Service -->
    
                        <p class="card__terms card__item">I agree to <span><a class="card__terms__link" href="#">terms of service</a></span></p>
                    </form>
                </div>
    
                <hr>

                <!-- Social Icons -->

                <div class="card__social-icons">
                    <a class="card__social-icons__link fb" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic_facebook.svg") ?>" alt="Facebook"></a>
                    <a class="card__social-icons__link ig" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic instagram.svg") ?>" alt="Instagram"></a>
                    <a class="card__social-icons__link tw" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic_twitter.svg") ?>" alt="Twitter"></a>
                    <a class="card__social-icons__link yt" draggable="false" href="#"><img src="<?php echo (URLROOT . "public/img/ic youtube.svg") ?>" alt="Youtube"></a>
                </div>
    
            </section>
        </main>

        <!-- End Of Vue App -->

    </div>

    <!-- Desktop Background -->

    <div class="image">
        &nbsp;
    </div>

</body>

<!-- Vue -->

<script src="<?php echo (URLROOT . "public/js/app.js") ?>"></script>

</html>