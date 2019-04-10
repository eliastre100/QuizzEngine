<div class="row"></div>
<div class="card">
    <div class="card-content">
        <div class="card-title">
            <div class="row">
                <div class="col s12 m9 left-align">
                    <?= $test->getTitle() ?>
                </div>
                <div class="col s12 m3 right-align">
                    <a class="btn orange waves-light waves-effect" href="<?= path('/teacher/test/'.$test->getId().'/edit') ?>">Edit</a>
                    <a class="btn red waves-light waves-effect" href="<?= path('/teacher/test/'.$test->getId().'/destroy') ?>">Delete</a>
                </div>
            </div>
        </div>
        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th>Open</th>
                        <th>Duration</th>
                        <th>Retake limit</th>
                        <th>Score to pass</th>
                        <th>Penalty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= var_export($test->isOpen()) ?></td>
                        <td><?= $test->getDuration() ?></td>
                        <td><?= $test->getRetryMaxScore() ?></td>
                        <td><?= $test->getPassScore() ?></td>
                        <td><?= $test->getPenalty() ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col s12 m12">
                    <h3>Questions</h3>
                </div>

            </div>
            <div class="row">

                <div class="right-align">
                    <a href="<?= path('/teacher/test/'.$test->getId().'/question/new') ?>">Add question</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Questions</th>
                            <th>Answers</th>
                            <th class="right-align">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($test->getQuestions() as $question) { ?>
                            <tr>
                                <td><?= $question->getQuestion() ?></td>
                                <td>
                                    <?php foreach ($question->getAnswers() as $answer) { ?>
                                        <span class="btn btn-small <?= ($answer['valid']) ? 'green' : 'red' ?>"><?= $answer['answer'] ?></span>
                                    <?php } ?>
                                </td>
                                <td class="right-align">
                                    <a href="<?= path('/teacher/test/'.$test->getId().'/question/'.$question->getId().'/edit') ?>"><i class="fas fa-edit"></i></a>
                                    <a href="<?= path('/teacher/test/'.$test->getId().'/question/'.$question->getId().'/destroy') ?>"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


