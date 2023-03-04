<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>
<div class="card-deck m-2">
    <div class="card text-center">
        <img class="card-img-top img-circle" src="https://cdn.logo.com/hotlink-ok/logo-social.png" />
        <h1>Brand 1</h1>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><button class="btn btn-primary">Manage Users<i class="bi bi-people ml-1"></i></button></li>
            <li class="list-group-item"><a href="#" class="badge badge-danger">Delete<i class="bi bi-trash ml-1"></i></a></i></li>
        </ul>
    </div>
    <div class="card text-center">
        <img class="card-img-top img-circle" src="https://cdn.logo.com/hotlink-ok/logo-social.png" />
        <h1>Brand 2</h1>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><button class="btn btn-primary">Manage Users<i class="bi bi-people ml-1"></i></button></li>
            <li class="list-group-item"><a href="#" class="badge badge-danger">Delete<i class="bi bi-trash ml-1"></i></a></li>
        </ul>
    </div>
    <div class="card text-center">
        <div class="card-img-top new-brand"><i style="font-size: 250px" width="16" height="16" class="bi bi-plus"></i></div>
        <h1>New Brand</h1>
    </div>
</div>
<?= $this->endSection() ?>