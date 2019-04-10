<div class="row">
    <?php foreach ($question->getAnswers() as $K => $answer) { ?>
        <div class="col s12 m6">
            <label for="answer<?= $K ?>">
                <input type="checkbox" name="answers[]" class="filled-in" value="<?= $answer['answer'] ?>" id="answer<?= $K ?>">
                <span><?= $answer['answer'] ?></span>
            </label>
        </div>
    <?php } ?>
</div>
