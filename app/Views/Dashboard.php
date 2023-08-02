<div class="col p-3">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h4>Getting Started</h4>
                    <ul class="list-unstyled">
                        <li class="mb-1"><?= $process["images"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Upload Images</li>
                        <li class="mb-1"><?= $process["image_details"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Upload Image Details</li>
                        <li class="mb-1"><?= $process["cat_icons"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Set Cateogory Icons</li>
                        <li class="mb-1"><?= $process["col_icons"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Set Collection Thumbnails</li>
                        <li class="mb-1"><?= $process["activate"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Activate Collections & Categories</li>
                        <li class="mb-1"><?= $process["branding"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Update Branding</li>
                        <li class="mb-1"><?= $process["compile"] ? ('<i class="bi bi-check-circle-fill mr-2"></i>') : ('<i class="bi bi-circle mr-2"></i>') ?>Compile the App</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card p-3 text-center">
                <div class="row">
                    <div class="col-sm-8">
                        <h4>Account Limits</h4>
                        <div id="limitsChart"></div>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Current Count</th>
                                    <th scope="col">Limit</th>
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
                                    <td scope="row"><?= $limits["brands"]["count"] ?></td>
                                    <td><?= $limits["brands"]["limit"] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-4">
        <div class="col">
            <div class="card p-3 text-center">
                <h4>Wallpapers Set</h4>
                <div id="wallpaperChart"></div>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-3 text-center">
                <h4>Action Links Clicked</h4>
                <div id="linkChart"></div>
            </div>
        </div>
        <div class="col">

        </div>
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