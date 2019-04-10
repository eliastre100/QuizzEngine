<div class="row"></div>
<div class="row"></div>
<div class="row"></div>

<div class="row">
    <h5 class="indigo-text">Please, login into your account</h5>
</div>

<div class="row">
    <div style="max-width: 500px; margin: 0 auto">
        <div class="card grey lighten-4">
            <div class="card-content">
                <?php errors($errors) ?>
                <form method="POST" action="<?= path('/login') ?>">
                        <div class="input-field col s12">
                            <label for="username">Username</label>
                            <input id="username" type="text" name="username" value="<?= $user->getUsername() ?>"/>
                        </div>

                        <div class="input-field col s12">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" />
                        </div>

                    <div class="row center">
                        <button type="submit" class="btn btn-large indigo waves-light waves-effect">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <a href="<?= path('/register') ?>">Create an account</a>
</div>