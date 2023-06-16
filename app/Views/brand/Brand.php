<div class="card-deck m-2">
    <?php foreach ($brandInfo as $brand) : ?>
        <div class="card text-center">
            <div id="<?= $brand["name"] ?>" style="cursor: pointer;" onclick="changeBrnd(this);">
                <img class="card-img-top img-circle" src="<?= $brand["logo"] ?>" />
                <h1><?= $brand["name"] ?></h1>
            </div>
            <ul class="list-group list-group-flush">
                <?php if ($admin) : ?>
                    <li class="list-group-item"><a href="/brand/users/<?= $brand["id"] ?>" class="badge badge-primary">Manage Users<i class="bi bi-people ml-1"></i></a></li>
                    <li class="list-group-item"><a href="" class="badge badge-info" data-mdb-toggle="modal" data-mdb-target="#brandModel">Edit Brand</a></li>
                <?php endif ?>
                <?php if ($brand["id"] != $default) : ?>
                    <?php if ($admin) : ?>
                        <li class="list-group-item"><a href="" class="badge badge-danger remove-brand" data-mdb-toggle="modal" data-mdb-target="#removebrandModel">Delete<i class="bi bi-trash ml-1"></i></a></i></li>
                    <?php endif ?>
                    <li class="list-group-item"><a href="" set-brand="<?= $brand["id"] ?>" class="badge badge-primary">Make Default</a></li>
                <?php endif ?>
            </ul>
        </div>
    <?php endforeach ?>
    <div class="card text-center" style="cursor: pointer;" onclick="">
        <div class="card-img-top new-brand"><i style="font-size: 250px; color: white;" width="16" height="16" class="bi bi-plus"></i></div>
        <h1>New Brand</h1>
    </div>
</div>

<!-- Edit Brand Modal -->
<div class="modal fade" id="brandModel" tabindex="-1" aria-labelledby="brandModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="brandModelLabel">Edit Brand</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <div class="form-outline">
                            <input type="text" id="brandName" class="form-control" />
                            <label class="form-label" for="brandName">New Brand Name</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="brandIcon">Default file input example</label>
                        <input type="file" class="form-control" id="brandIcon" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateBrand">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Remove Brand Modal -->
<div class="modal fade" id="removebrandModel" tabindex="-1" aria-labelledby="removebrandModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removebrandModelLabel">Remove Brand Confirmation</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <div class="form-outline">
                            <input type="text" id="removebrandName" class="form-control" />
                            <label class="form-label" for="removebrandName">Brand Name</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="removeBrand">Remove</button>
            </div>
        </div>
    </div>
</div>