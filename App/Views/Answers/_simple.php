<div class="row">
    <?php foreach ($question->getAnswers() as $k => $answer) { ?>
        <div class="col s12 m6">
            <label for="answer<?= $k ?>">
                <input class="with-gap" type="radio" name="answer" value="<?= $answer['answer'] ?>" id="answer<?= $k ?>">
                <span><?= $answer['answer'] ?></span>
            </label>
        </div>
    <?php } ?>
</div>


