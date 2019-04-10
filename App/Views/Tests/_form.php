<div class="card">
    <div class="card-content">
        <form method="POST" action="<?= path('/teacher/test'.($test->getId() ? '/'.$test->getId() : '')) ?>">
            <div class="row">
                <div class="valign-wrapper">
                    <div class="col s12 m11">
                        <?= errors($test->getErrors('title')) ?>
                        <div class="input-field">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" value="<?= $test->getTitle() ?>">
                        </div>
                    </div>

                    <div class="col s12 m1 right-align">
                        <?= errors($test->getErrors('open')) ?>
                        <label for="open">
                            <input type="checkbox" name="open" id="open" <?php if ($test->isOpen()) { ?>checked="checked"<?php } ?>>
                            <span>Open</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col s12">
                    <?= errors($test->getErrors('duration')) ?>
                    <div class="input-field">
                        <label for="duration">Duration (in minutes, 0 for no limit)</label>
                        <input type="number" name="duration" id="duration" value="<?= $test->getDuration() ?>">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col s12 m6">
                    <?= errors($test->getErrors('retryMaxScore')) ?>
                    <div class="input-field">
                        <label for="retry_score">Max score to retake</label>
                        <input type="number" name="retry_max_score" id="retry_score" value="<?= $test->getRetryMaxScore() ?>">
                    </div>
                </div>

                <div class="col s12 m6">
                    <?= errors($test->getErrors('passScore')) ?>
                    <div class="input-field">
                        <label for="pass_score">Score to pass the test</label>
                        <input type="number" name="pass_score" id="pass_score" value="<?= $test->getPassScore() ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <?= errors($test->getErrors('penalty')) ?>
                    <div class="input-field">
                        <label for="penalty">Penalty on wrong answer</label>
                        <input type="number" name="penalty" id="penalty" value="<?= $test->getPenalty() ?>">
                    </div>
                </div>
            </div>

            <div class="right-align">
                <?php if ($test->getId()) { ?>

                <?php } ?>
                <?php $previous = $test->getId() ? '/teacher/test/'.$test->getId() : '/teacher/dashboard' ?>
                <a href="<?= path($previous) ?>" class="btn orange waves-light waves-effect">Cancel</a>
                <button type="submit" class="btn green waves-light waves-effect"><?= $test->getId() ? 'Update test' : 'Create test' ?></button>

            </div>
    </div>
    </form>
</div>
</div>
