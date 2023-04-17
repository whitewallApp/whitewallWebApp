<div class="card-deck m-2">
    <?php foreach ($brandInfo as $brand) : ?>
        <div class="card text-center">
            <div id="<?= $brand["name"] ?>" style="cursor: pointer;" onclick="changeBrnd(this);">
                <img class="card-img-top img-circle" src="<?= $brand["logo"] ?>" />
                <h1><?= $brand["name"] ?></h1>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="/brand/users/<?= $brand["id"] ?>" class="badge badge-primary">Manage Users<i class="bi bi-people ml-1"></i></a></li>
                <li class="list-group-item"><a href="#" class="badge badge-danger">Delete<i class="bi bi-trash ml-1"></i></a></i></li>
            </ul>
        </div>
    <?php endforeach ?>
    <div class="card text-center" style="cursor: pointer;" onclick="changeBrnd(this);">
        <div class="card-img-top new-brand"><i style="font-size: 250px; color: white;" width="16" height="16" class="bi bi-plus"></i></div>
        <h1>New Brand</h1>
    </div>
</div>