<div class="container-fluid p-3">
    <div class="row">
        <!-- Getting Started -->
        <div class="col-12 col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h4>Getting Started</h4>
                    <ul class="list-unstyled">
                        <li class="mb-1"><?= $process["images"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Upload Images</li>
                        <li class="mb-1"><?= $process["image_details"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Upload Image Details</li>
                        <li class="mb-1"><?= $process["cat_icons"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Set Category Icons</li>
                        <li class="mb-1"><?= $process["col_icons"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Set Collection Thumbnails</li>
                        <li class="mb-1"><?= $process["activate"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Activate Collections & Categories</li>
                        <li class="mb-1"><?= $process["branding"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Update Branding</li>
                        <li class="mb-1"><?= $process["compile"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Compile the App</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Account Limits -->
<div class="col-12 col-md-8 mb-3">
    <div class="card p-3 text-center h-100 d-flex flex-column">
        <div class="row flex-grow-1">
            <div class="col-12 col-lg-8 mb-3 mb-lg-0 d-flex flex-column">
                <h4>Account Limits</h4>
                <div id="limitsChart" class="chart-container"></div>
            </div>
            <div class="col-12 col-lg-4 d-flex flex-column">
                <div class="table-responsive flex-grow-1">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Current</th>
                                <th>Limit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Images</th>
                                <td><?= $limits["images"]["count"] ?></td>
                                <td><?= $limits["images"]["limit"] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Users</th>
                                <td><?= $limits["users"]["count"] ?></td>
                                <td><?= $limits["users"]["limit"] ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Brand</th>
                                <td><?= $limits["brands"]["count"] ?></td>
                                <td><?= $limits["brands"]["limit"] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row -->
<div class="row mt-4">
    <div class="col-12 col-lg-4 mb-3 d-flex flex-column">
        <div class="card p-3 text-center h-100 d-flex flex-column">
            <h4>Wallpapers Set</h4>
            <div id="wallpaperChart" class="chart-container flex-grow-1"></div>
        </div>
    </div>
    <div class="col-12 col-lg-4 mb-3 d-flex flex-column">
        <div class="card p-3 text-center h-100 d-flex flex-column">
            <h4>Action Links Clicked</h4>
            <div id="linkChart" class="chart-container flex-grow-1"></div>
        </div>
    </div>
    <div class="col-12 col-lg-4 mb-3">
        <!-- Empty column reserved -->
    </div>
</div>



<script src="https://www.gstatic.com/charts/loader.js">
</script>
<script>
    const linkData = <?= $links ?>;
    const wallpaperData = <?= $wallpapers ?>;

    const limitData = [
        ["Data", "Amount", "Amount Left", {
            role: 'annotation'
        }],
        ['Images', <?= $limits["images"]["count"] ?>, <?= ($limits["images"]["limit"] == "Unlimited" ? (0) : ($limits["images"]["limit"])) ?>, ""],
        ['Users', <?= $limits["users"]["count"] ?>, <?= ($limits["users"]["limit"] == "Unlimited" ? (0) : ($limits["users"]["limit"])) ?>, ""],
        ['Brands', <?= $limits["brands"]["count"] ?>, <?= ($limits["brands"]["limit"] == "Unlimited" ? (0) : ($limits["brands"]["limit"])) ?>, ""]
    ];
</script>
<script src="js/dashboard.js"></script>