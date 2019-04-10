<html>
    <head>
        <title><?= isset($title) ? $title : 'Quizz Engine - Student' ?></title>
        <meta charset="UTF-8">
        <base href="/">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href='<?= path('/css/materialize.min.css') ?>'>
    </head>
    <body>
        <nav>
            <div class="nav-wrapper blue">
                <div class="row">
                    <div class="col s12">
                        <a href="#" class="brand-logo">QuizzEngine</a>
                        <ul id="nav-mobile" class="right hide-on-med-and-down">
                            <li>
                                <?php if (isset($attempt) && isset($test) && $test->getDuration()) { ?>
                                    <?php $remaining = $test->getDuration() * 60 - ((new DateTime(date('Y-m-d H:i:s')))->getTimestamp() - $attempt->getStartedDate()->getTimestamp()) ?>
                                    <?= date('i:s', $remaining) ?> Minutes remaining
                                <?php } else if (isset($test) && $test->getDuration()) { ?>
                                    <?= $test->getDuration() ?> Minutes
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <?= flashMessages($flash, 'notice', 'orange') ?>
        <?= flashMessages($flash, 'success', 'green') ?>

        <div class="container center">
            <?= $viewContent ?>
        </div>
        <script src="<?= path('/js/materialize.js') ?>"></script>
    </body>
</html>
