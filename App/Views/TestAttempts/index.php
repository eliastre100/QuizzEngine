<div class="card">
    <div class="card-content">
        <div class="card-title">
            Results for the test '<?= $test->getTitle() ?>'
        </div>
        <table>
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last Name</th>
                    <th>Date</th>
                    <th>Score</th>
                    <th class="right-align">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $score) { ?>
                    <tr>
                        <td><?= $score->getUser()->getFirstName() ?></td>
                        <td><?= $score->getUser()->getLastName() ?></td>
                        <td><?= $score->getStartedDate()->format('H:i:s d/m/Y') ?></td>
                        <td class="<?= $score->isPass() ? 'green' : ($score->scoreCanRetry() ? 'red' : '') ?>"><?= $score->getScore() ?></td>
                        <td class="right-align" >
                            <?php if (!$score->canRetry()) { ?>
                                <a href="<?= path('/teacher/test/'.$test->getId().'/attempt/'.$score->getId().'/reopen') ?>" class="btn btn-small white-text"><i class="fas fa-redo"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
