<?php

use App\Services\FlashService;
use Core\Router;

function path($path) {
    return Router::base().$path;
}

function errors($errors) {
    if (count($errors) != 0) { ?>
        <div class="card red white-text">
            <div class="card-content">
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?= $error ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php }
}

function flashMessages(FlashService $flashService, $scope, $color = 'orange') {
    $messages = $flashService->get($scope);
    if ($flashService != null && count($messages) != 0) { ?>
        <div class="row">
            <div class="col s12">
                <div class="card <?= $color ?> white-text">
                    <div class="card-content">
                        <ul>
                            <?php foreach ($messages as $message) { ?>
                                <li><?= $message ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}