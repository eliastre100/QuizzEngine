<div class="row"></div>
<div class="card">
    <div class="card-content">
        <div class="card-title left-align">
            <?= $question->getQuestion() ?>
        </div>
        <form method="post" action="<?= path('/student/test/'.$test->getId().'/attempt/'.$attempt->getId()) ?>">

            <?php if ($question->isMultiple()) { ?>
                <?php include('_multiple.php') ?>
            <?php } else { ?>
                <?php include('_simple.php') ?>
            <?php } ?>

            <div class="right-align">
                <div class="input-field">
                    <input type="hidden" name="question_id" value="<?= $question->getId() ?>">
                    <button type="submit" class="btn btn-large green waves-light waves-effect">Answer</button>
                </div>

            </div>
        </form>
    </div>
</div>
