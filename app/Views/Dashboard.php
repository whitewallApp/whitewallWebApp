<div class="col p-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <table class="table">
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
        <div class="col">
            <div class="card p-3 text-center">
                <h4>Action Links Clicked</h4>
                <div id="linkChart" style="max-width:700px; height:200px"></div>
            </div>
        </div>
        <div class="col">

        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card p-3 text-center">
                <h4>Wallpapers Set</h4>
                <div id="wallpaperChart" style="max-width:700px; height:200px"></div>
            </div>
        </div>
        <div class="col">

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
</script>
<script src="js/dashboard.js"></script>