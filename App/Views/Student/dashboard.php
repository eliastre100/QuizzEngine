<h1>Welcome on you student dashboard <?= $user->getFirstName() ?>!</h1>

<div class="row">
    <div class="col s12 m6">
        <div class="card">
            <div class="card-content">
                <div class="card-title">
                    Your results
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Test name</th>
                            <th>Date</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scores as $score) { ?>
                            <tr class="<?= $score->isPass() ? 'green' : ($score->getScore() < $score->getTest()->getRetryMaxScore() ? 'red' : '') ?>">
                                <td><?= $score->getTest()->getTitle() ?></td>
                                <td><?= $score->getStartedDate()->format('H:i d/m/Y') ?></td>
                                <td><?= $score->getScore() ?></td>
                            </tr>
                        <?php } ?>
                        <?php if (count($scores) == 0) { ?>
                            <tr>
                                <td>You don't have answered any test yet.</td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card">
            <div class="card-content">
                <div class="card-title">
                    Your awaiting quizzs
                </div>
                <div class="row">
                    <?php foreach ($unansweredTests as $test) { ?>
                        <div class="col s12 m6">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-title">
                                        <?= $test->getTitle() ?>
                                    </div>
                                    <ul>
                                        <li>Duration: <?= $test->getDuration() ?> minutes</li>
                                        <li>Score to pass: <?= $test->getPassScore() ?></li>

                                    </ul>
                                </div>
                                <div class="card-action right-align">
                                    <a class="center-align" href="<?= path('/student/test/'.$test->getId()) ?>" target="popup">Start</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if (count($unansweredTests) == 0) { ?>
                    No quizz awaiting :)
                <?php } ?>
            </div>
        </div>

    </div>
</div>

