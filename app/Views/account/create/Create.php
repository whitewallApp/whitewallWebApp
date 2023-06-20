<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>

<div class="container w-50">
    <div class="card p-4 m-3">
        <img id="login_logo" class="img" src="\Icons\Whitewall-LOGO-pos.png">
        <form action="/account/create" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $name ?>">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="email" name="email" value="<?= $email ?>">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="passconf">Confirm Password</label>
                <input type="password" class="form-control" id="passconf" name="passconf">
            </div>
            <button class="btn btn-primary" id="submit">Submit</button>
        </form>
        <?= validation_list_errors() ?>
        <div class="col mt-2 text-center" style="border-top: 1px solid gray;">
            <p>or</p>
        </div>
        <div class="row p-2">
            <div class="col-3">
                <div id="g_id_onload" data-client_id="437362021062-fserfra8i9g6kicf00jvefvhbpbf845l.apps.googleusercontent.com" data-context="signup" data-ux_mode="popup" data-login_uri="http://localhost/account/create" data-auto_prompt="false">
                </div>

                <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline" data-text="signup_with" data-size="large" data-logo_alignment="left">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="/js/create.js"></script>

<?= $this->endSection() ?>