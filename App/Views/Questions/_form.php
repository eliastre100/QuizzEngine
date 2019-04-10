<form method="POST" action="<?= path('/teacher/test/'.$question->getTest()->getId().'/question'.($question->getId() ? '/'.$question->getId() : '')) ?>">
    <div class="row">
        <div class="col s12 m10">
            <?= errors($question->getErrors('question')) ?>
            <div class="input-field">
                <textarea class="materialize-textarea" name="question" id="question"><?= $question->getQuestion() ?></textarea>
                <label for="question">Question</label>
            </div>
        </div>

        <div class="input-field col s12 m2">
            <label for="multiple">
                <input type="checkbox" name="multiple" id="multiple" <?php if ($question->isMultiple()) { ?>checked="checked"<?php } ?>>
                <span>Multiple answer</span>
            </label>
        </div>
    </div>

    <?= errors($question->getErrors('answers')) ?>
    <?php foreach ($question->getAnswers() as $key => $answer) { ?>
        <div class="row">
            <div class="vertical-wrapper">
                <div class="col s1">
                    <div class="input-field">
                        <label for="answers<?= $key ?>">
                            <input type="checkbox" id="answers<?= $key ?>" name="answers[<?= $key ?>][valid]" <?php if($answer['valid']) { ?>checked="checked"<?php } ?>>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="col s11">
                    <div class="input-field">
                        <input type="text" name="answers[<?= $key ?>][answer]" value="<?= $answer['answer'] ?>" placeholder="Answer">
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col s1">
            <div class="input-field">
                <label for="answersnew">
                    <input type="checkbox" id="answersnew" name="answers[new][valid]">
                    <span></span>
                </label>
            </div>
        </div>
        <div class="col s11">
            <div class="input-field">
                <input type="text" name="answers[new][answer]" placeholder="Answer">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s3 left-align">
            <a href="<?= path('/teacher/test/'.$question->getTest()->getId()) ?>" class="btn orange waves-light waves-effect">Cancel</a>
        </div>
        <div class="col s9 right-align">
            <button class="btn blue waves-light waves-effect" type="submit" name="addNewAnswer" value="true">Add an answer</button>
            <button class="btn green waves-light waves-effect" type="submit"><?= (empty($question->getId())) ? 'Save' : 'Update' ?></button>
        </div>
    </div>
</form>
