<?php use app\core\Application; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title><?= $this->title; ?></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <p class="navbar-brand">Netflips</p>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if(!Application::getInstance()->session->getAttribute("loggedIn")): ?>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="navbar-text" href="/login">Login <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/selectplan">Register</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <?php

                        if(isset($_POST['Logout'])) {
                            session_destroy();
                            Application::getInstance()->response->redirect('/login');

                        }
                        ?>
                        <form method="post">
                        <input type="submit" name="Logout"
                               class="btn btn-light" value="Logout" />
                    </li>
                </ul>
            <?php endif ?>
        </div>
    </nav>
     
    <div class="container">
        <?php if(Application::getInstance()->session->getFlashMessage("success")): ?>
            <div class="alert alert-success">
                <?= Application::getInstance()->session->getFlashMessage("success") ?>
            </div>
        <?php endif; ?>
        {{content}}
    </div>

    <script src="assets/js/libs/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>