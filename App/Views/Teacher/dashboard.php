<h1>Welcome on your teacher dashboard <?= $user->getFirstName() ?>!</h1>

<div class="card">
    <div class="card-content">
        <div class="card-title">
            List of all the tests available
        </div>
        <div class="right-align"><a href="<?= path('/teacher/test/new') ?>">New test</a></div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Open</th>
                    <th>Duration</th>
                    <th>Allow retry up to score</th>
                    <th>Pass score</th>
                    <th>Penalty</th>
                    <th class="right-align">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tests as $test) { ?>
                    <tr>
                        <td><?= $test->getTitle() ?></td>
                        <td><?= var_export($test->isOpen(), true) ?></td>
                        <td><?= $test->getDuration() ?> minutes</td>
                        <td><?= $test->getRetryMaxScore() ?></td>
                        <td><?= $test->getPassScore() ?></td>
                        <td><?= $test->getPenalty() ?></td>
                        <td class="right-align">
                            <a href="<?= path('/teacher/test/'.$test->getId()) ?>" class="btn btn-small"><i class="fas fa-info"></i></a>
                            <a href="<?= path('/teacher/test/'.$test->getId().'/results') ?>" class="btn btn-small"><i class="fas fa-poll"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
