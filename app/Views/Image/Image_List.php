<div class="row m-3">

    <!-- Main Table Column -->
    <div class="col-12 col-md-8 mb-3 mb-md-0">
        <div class="card p-2">

            <!-- Actions & Filters Row -->
            <div class="row m-2 align-items-center">
                <!-- Actions -->
                <div class="col-12 col-md-8">
                    <div id="actions" class="row" style="display: none">
                        <div class="col-12 col-md-2">
                            <p id="infoSelect" class=""></p>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="row justify-content-start align-items-center">
                                <?php if ($view[$pageName]["remove"]) : ?>
                                    <div class="col-auto mb-2 mb-md-0">
                                        <button class="btn btn-danger action-btn" id="delete">Delete</button>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collection Filter Dropdown -->
                <div class="col-6 col-md-2 mt-2 mt-md-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-block action-btn dropdown-toggle" type="button" id="filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                            </svg>
                            Filters
                        </button>
                        <div class="dropdown-menu" aria-labelledby="filters">
                            <?php foreach ($collections as $collection) : ?>
                                <button class="dropdown-item" type="button" collection-id="<?= $collection["id"] ?>"><?= $collection["name"] ?></button>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <!-- OrderBy Dropdown -->
                <div class="col-6 col-md-2 mt-2 mt-md-0">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-block action-btn dropdown-toggle" type="button" id="orderby" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i style="font-size: 16px;" class="bi bi-sort-down"></i>
                            Order By
                        </button>
                        <div class="dropdown-menu" aria-labelledby="orderby">
                            <button class="dropdown-item" type="button" column="name">Name</button>
                            <button class="dropdown-item" type="button" column="dateUpdated">Date Updated</button>
                            <button class="dropdown-item" type="button" column="dateCreated">Date Created</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="header" scope="col"><input id="check-all" type="checkbox" class="checkbox-lg"></th>
                            <th class="header" scope="col">Thumbnail</th>
                            <th class="header" scope="col">Name</th>
                            <th class="header" scope="col">Collection</th>
                            <th class="header" scope="col">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($images)) : ?>
                            <?php foreach ($images as $image) : ?>
                                <tr id="<?= $image["id"] ?>" onclick="getImg(this);">
                                    <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                                    <td class="w-25">
                                        <img class="img-sm rounded" src="<?= $image["path"] ?>">
                                    </td>
                                    <td><?= $image["name"] ?></td>
                                    <td><?= $image["collection"] ?></td>
                                    <td><a href="#"><?= $image["category"] ?></a></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Pagination & Items per page -->
        <div class="m-2">
            <div class="row">
                <div class="col-12 col-md-5 d-flex justify-content-center justify-content-md-start mb-2 mb-md-0">
                    <?= $pager->links() ?>
                </div>
                <div class="col-12 col-md-2 mb-2 mb-md-0">
                    <select class="custom-select w-100" id="items">
                        <option value="5">5</option>
                        <option selected value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-12 col-md-5"></div>
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
<script>
    $("option[value='<?= $pageamount ?>']").attr("selected", true);
</script>
