<html>
    <head>
        <title><?= isset($title) ? $title : 'Quizz Engine' ?></title>
        <meta charset="UTF-8">
        <base href="/">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href='<?= path('/css/materialize.min.css') ?>'>
    </head>
    <body>
        <div class="row"></div>
        <div class="row"></div>
        <div class="row"></div>

        <?= flashMessages($flash, 'notice', 'orange') ?>
        <?= flashMessages($flash, 'success', 'green') ?>

        <div class="container center">
            <?= $viewContent ?>
        </div>
        <script src="<?= path('/js/materialize.js') ?>"></script>
    </body>
</html>
