<div class="row m-3">

    <!-- Main Table Column -->
    <div class="col-12 col-md-8 mb-3 mb-md-0">
        <div class="card p-2">

            <!-- Actions Row -->
            <div class="row m-2 align-items-center">
                <div class="col-12 col-md-10">
                    <div id="actions" class="row" style="display: none">
                        <div class="col-6 col-md-2">
                            <p id="infoSelect" class=""></p>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="row justify-content-start">
                                <?php if ($view[$pageName]["remove"]) : ?>
                                    <div class="col-auto">
                                        <button class="btn btn-danger action-btn" id="delete">Delete</button>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"></div>
                    </div>
                </div>

                <div class="col-12 col-md-2 mt-2 mt-md-0 text-md-right">
                    <button class="btn btn-info action-btn" id="setactive">Set All Active</button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"><input id="check-all" type="checkbox" class="checkbox-lg"></th>
                            <th scope="col">Thumbnail</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Images</th>
                            <th scope="col">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($collections as $collection) : ?>
                            <tr id="<?= $collection["name"] ?>" onclick="getColl(this);">
                                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                                <td class="w-25">
                                    <img class="img-sm rounded" src="<?= $collection['iconPath'] ?>" alt="<?= $collection['name'] ?> Thumbnail">
                                </td>
                                <td><?= $collection['name'] ?></td>
                                <td class="w-25"><a href="#"><?= $collection["category"] ?></a></td>
                                <td><?= $collection["imageCount"] ?></td>
                                <td><?= $collection["active"] ? "Active" : "Inactive" ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Detail Column -->
    <div class="col-12 col-md-4">
        <div class="card p-2 header">
            <?= $this->renderSection('Detail') ?>
        </div>
    </div>

</div>
