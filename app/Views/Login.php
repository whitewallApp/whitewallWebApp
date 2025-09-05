<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 m-3 w-100" style="max-width: 500px;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img id="login_logo" class="img-fluid" src="Icons/Whitewall-LOGO-pos.png" alt="Whitewall Logo">
        </div>

        <!-- Login Form -->
        <form id="loginForm">
            <div class="form-group">
                <label for="InputEmail">Email address</label>
                <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" required>
                <small id="emailHelp" class="form-text text-muted">
                    We'll never share your email with anyone else.
                </small>
            </div>
            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input type="password" class="form-control" id="InputPassword" required>
            </div>
            <button type="button" class="btn btn-primary btn-block mt-3" onclick="login();">Submit</button>
        </form>

        <!-- Error Alert -->
        <div class="alert alert-danger mt-3" role="alert" style="display: none;">
            Your Email or Password was Incorrect
        </div>

        <!-- Extra Options -->
        <div class="row text-center mt-4">
            <div class="col-3 text-center">
                <div id="g_id_onload"
                    data-client_id="437362021062-fserfra8i9g6kicf00jvefvhbpbf845l.apps.googleusercontent.com"
                    data-context="signin"
                    data-ux_mode="popup"
                    data-callback="login"
                    data-auto_prompt="false">
                </div>
                <div class="g_id_signin"
                    data-type="icon"
                    data-shape="square"
                    data-theme="outline"
                    data-size="large">
                </div>
            </div>
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <a href="/account/create" class="badge badge-primary p-2" style="cursor: pointer;">Create Account</a>
            </div>
            <div class="col-12 col-md-4">
                <span class="badge badge-primary p-2" style="cursor: pointer;"
                      data-toggle="modal" data-target="#resetModal">
                    Forgot Password
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetModalLabel">Reset Your Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="resetForm" class="was-validated">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" required>
                        <div class="invalid-feedback" id="msg">Please provide a valid email.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="resetBtn">Reset</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
