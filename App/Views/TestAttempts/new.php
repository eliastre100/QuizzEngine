<div class="row"></div>
<div class="card">
    <div class="card-content">
        <div class="card-title">
            <?= $test->getTitle() ?>
        </div>
        <ul>
            <?php if ($test->getDuration()) { ?>
                <li>You will have <?= $test->getDuration() ?> minutes to complete the test.</li>
            <?php } else { ?>
                <li>There is no time limit for this test</li>
            <?php } ?>
            <li>This test have <?= count($test->getQuestions()) ?> questions.</li>
            <li>You must score at least <?= $test->getPassScore() ?> to pass the test.</li>
            <?php if ($test->getPenalty() != 0) { ?>
                <li>Each bad answer will give you <?= $test->getPenalty() ?> points.</li>
            <?php } ?>
        </ul>
        <form method="post" action="<?= path('/student/test/'.$test->getId()) ?>">
            <div class="input-field">
                <button type="submit" class="btn btn-large darken-4 blue waves-light waves-effect">Start</button>
            </div>
        </form>
    </div>
</div>