<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>
<div class="container">
    <div class="card p-4 m-3">
        <img class="img" src="Icons\Whitewall-LOGO-pos.png">
        <form>
            <div class="form-group">
                <label for="InputEmail1">Email address</label>
                <input type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="InputPassword1">Password</label>
                <input type="password" class="form-control" id="InputPassword1">
            </div>
        </form>
        <button class="btn btn-primary" onclick="login();">Submit</button>

        <div id="g_id_onload" data-client_id="437362021062-fserfra8i9g6kicf00jvefvhbpbf845l.apps.googleusercontent.com" data-context="signin" data-ux_mode="popup" data-callback="login" data-auto_prompt="false">
        </div>

        <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline" data-text="signin_with" data-size="large" data-logo_alignment="left">
        </div>
    </div>
</div>
<?= $this->endSection() ?>