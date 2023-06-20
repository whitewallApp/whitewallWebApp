<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>

<div class="container w-50">
    <div class="card p-4 m-3">
        <img id="login_logo" class="img" src="\Icons\Whitewall-LOGO-pos.png">
        <form action="/account/create" method="post">
            <div class="form-group">
                <label for="name">New Brand Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="brandName">
            </div>
            <?php if (isset($credential)) : ?>
                <input type="text" class="form-control" name="credential" value="<?= $credential ?>" style="display: none;">
            <?php endif ?>
            <button class="btn btn-primary" id="submit">Submit</button>
        </form>
    </div>
</div>

<script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="/js/create.js"></script>

<?= $this->endSection() ?>