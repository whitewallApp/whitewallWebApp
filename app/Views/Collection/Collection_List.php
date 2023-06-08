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
                                    <button class="btn btn-info">Change</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">

                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                            </svg>
                            Filters
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><input id="check-all" type="checkbox" class="checkbox-lg"></th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Images</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($collections as $collection) : ?>
                        <tr id="<?= $collection["name"] ?>" onclick="getColl(this);">
                            <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                            <td class="w-25">
                                <image class="img-sm rounded" src="<?= $collection['iconPath'] ?>">
                            </td>
                            <td><?= $collection['name'] ?></td>
                            <td class="w-25"><a href="#"><?= $collection["category"] ?></a></td>
                            <td><a href="#">Link</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card p-2">
            <?= $this->renderSection('Detail') ?>
        </div>
    </div>
</div>