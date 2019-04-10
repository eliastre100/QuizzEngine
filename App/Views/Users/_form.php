<form action="<?= path('/register') ?>" method="POST">
    <div class="col s12 m6">
        <?php errors($user->getErrors('firstName')) ?>
        <div class="input-field">
            <label for="first_name">First name</label>
            <input type="text" name="first_name" id="first_name" value="<?= $user->getFirstName() ?>"/>
        </div>
    </div>
    <div class="col s12 m6">
        <?php errors($user->getErrors('lastName')) ?>
        <div class="input-field">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?= $user->getLastName() ?>" />
        </div>
    </div>
    <div class="col s12">
        <?php errors($user->getErrors('username')) ?>
        <div class="input-field">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= $user->getUsername() ?>"/>
        </div>
    </div>
    <div class="col s12">
        <?php errors($user->getErrors('password')) ?>
        <div class="input-field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" />
        </div>
    </div>
    <div class="col s12">
        <?php errors($user->getErrors('passwordConfirmation')) ?>
        <div class="input-field">
            <label for="password_confirm">Password confirmation</label>
            <input type="password" name="passwordConfirmation" id="password_confirm"/>
        </div>
    </div>
    <div class="row center">
        <button type="submit" class="btn btn-large indigo waves-light waves-effect">Register</button>
    </div>
</form>