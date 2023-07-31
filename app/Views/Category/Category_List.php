<div class="row m-3">
    <div class="col-sm-8">
        <div class="card p-2">
            <div class="row m-2">
                <div class="col-sm-10">
                    <div id="actions" class="row" style="display: none">
                        <div class="col-2">
                            <p id="infoSelect" class=""></p>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-1">

                                </div>
                                <div class="col-4 text-center">
                                    <?php if ($view[$pageName]["remove"]) : ?>
                                        <button class="btn btn-danger" id="delete">Delete</button>
                                    <?php endif ?>
                                </div>
                                <div class="col-1">

                                </div>
                                <div class="col-6">

                                </div>
                            </div>
                        </div>
                        <div class="col-4">

                        </div>
                    </div>
                </div>
                <div class="col-sm-2">

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><input id="check-all" type="checkbox" class="checkbox-lg"></th>
                            <th scope="col">Icon</th>
                            <th scope="col">Name</th>
                            <th scope="col">Collections</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                            <tr id="<?= $category["name"] ?>" onclick="getCat(this);">
                                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                                <td class="w-25">
                                    <image class="img-sm" src="<?= $category["iconPath"] ?>">
                                </td>
                                <td><?= $category["name"] ?></td>
                                <td><?= $category["collectionName"] ?></td>
                                <td><?= $category["active"]  ? ("Active") : ("Inactive") ?></td>
                            </tr>
                        <?php endforeach ?>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card p-2">
            <?= $this->renderSection('Detail') ?>
        </div>
    </div>
</div>