<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>

<div class="col container">
    <ul class="nav nav-pills mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="pill" href="#home" role="tab" aria-controls="home" aria-selected="true">List</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="pill" href="#graphs" role="tab" aria-controls="graphs" aria-selected="false">Graphs</a>
        </li>
    </ul>
    <!-- Pills navs -->

    <!-- Pills content -->
    <div class="tab-content" id="ex1-content">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="ex1-tab-1">
            <?php foreach ($accounts as $account) : ?>
                <div class="card m-4">
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-sm-3">
                                <h5 class="card-title">Account: <?= $account["account_id"] ?> | Status: <?= $account["subscription"] ?></h5>
                            </div>
                            <div class="col-sm-9">
                                <button account-id="<?= $account["account_id"] ?>" class="btn btn-info">Check Folder Size</button>
                            </div>
                        </div>
                        <table class="table text-center table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="1"></th>
                                    <?php foreach ($account["brands"] as $brand) : ?>
                                        <th scope="col" colspan="1"><?= $brand["identity"]["name"] ?></th>
                                    <?php endforeach ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Categories</td>
                                    <?php foreach ($account["brands"] as $brand) : ?>
                                        <td><?= $brand["categories"] ?></td>
                                    <?php endforeach ?>
                                </tr>
                                <tr>
                                    <td>Collections</td>
                                    <?php foreach ($account["brands"] as $brand) : ?>
                                        <td><?= $brand["collections"] ?></td>
                                    <?php endforeach ?>
                                </tr>
                                <tr>
                                    <td>Images</td>
                                    <?php foreach ($account["brands"] as $brand) : ?>
                                        <td><?= $brand["images"] ?></td>
                                    <?php endforeach ?>
                                </tr>
                                <tr>
                                    <td>Users</td>
                                    <?php foreach ($account["brands"] as $brand) : ?>
                                        <td><?= $brand["users"] ?></td>
                                    <?php endforeach ?>
                                </tr>
                                <tr>
                                    <td>Wallpapers</td>
                                    <?php foreach ($account["brands"] as $brand) : ?>
                                        <td><?= $brand["wallpapers"] ?></td>
                                    <?php endforeach ?>
                                </tr>
                                <tr>
                                    <td>Links</td>
                                    <?php foreach ($account["brands"] as $brand) : ?>
                                        <td><?= $brand["links"] ?></td>
                                    <?php endforeach ?>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="tab-pane fade" id="graphs" role="tabpanel" aria-labelledby="ex1-tab-2">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="card p-2 text-center">
                            <h4>Amount Paying</h4>
                            <div id="paying"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-2 text-center">
                            <h4>Storage</h4>
                            <div id="storage"></div>
                        </div>
                    </div>
                    <div class="col">

                    </div>
                </div>
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col">

                    </div>
                    <div class="col">

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        packages: ['corechart']
    });

    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        const payingdata = google.visualization.arrayToDataTable(<?= json_encode($chartData["paying"]) ?>);

        const payingoptions = {

        };

        const payingchart = new google.visualization.PieChart(document.getElementById('paying'));
        payingchart.draw(payingdata, payingoptions);

        //storage
        const storagedata = google.visualization.arrayToDataTable(<?= json_encode($chartData["storage"]) ?>);

        const storageoptions = {};

        const storagechart = new google.visualization.PieChart(document.getElementById('storage'));
        storagechart.draw(storagedata, storageoptions);
    }

    $("[account-id]").on("click", function(e){
        id = $(e.currentTarget).attr("account-id");

        $.post("/admin/account/size", {
            id: id
        }, function(data, status){
            alert("Filesize for account " + id + ": " + data);
        })
    })
</script>

<?= $this->endSection(); ?>