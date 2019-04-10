<div class="card">
    <div class="card-content">
        <div class="card-title">
            Your result for the test '<?= $attempt->getTest()->getTitle() ?>'
        </div>
        <h3>You scored <?= $attempt->getScore() ?>!</h3>
        <div class="row">
            <?php if ($attempt->isPass()) { ?>
                You passed this test !
            <?php } else { ?>
                Saddly you didn't passed this test...
                <?php if ($attempt->canRetry()) { ?>
                    But you qualify to retake this test!
                <?php } ?>
            <?php } ?>
        </div>
        <div>
            <button class="btn btn-large indigo waves-light waves-effect" onclick="window.close()">Close</button>
        </div>
    </div>
</div>



