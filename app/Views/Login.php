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
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>