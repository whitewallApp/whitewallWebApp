<div class="row p-3">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Images</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="header" scope="col">Name</th>
                            <th class="header" scope="col">Description</th>
                            <th class="header" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($images as $image) : ?>
                            <tr>
                                <td><?= $image["name"] ?></td>
                                <td><?= $image["description"] ?></td>
                                <td><a href="#">Edit</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Collections</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="header" scope="col">Name</th>
                            <th class="header" scope="col">Description</th>
                            <th class="header" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($collections as $collection) : ?>
                            <tr>
                                <td><?= $collection["name"] ?></td>
                                <td><?= $collection["description"] ?></td>
                                <td><a href="#">Edit</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Categories</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="header" scope="col">Name</th>
                            <th class="header" scope="col">Description</th>
                            <th class="header" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                            <tr>
                                <td><?= $category["name"] ?></td>
                                <td><?= $category["description"] ?></td>
                                <td><a href="#">Edit</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Notifications</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="header" scope="col">Name</th>
                            <th class="header" scope="col">Description</th>
                            <th class="header" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($notifications as $notification) : ?>
                            <tr>
                                <td><?= $notification["title"] ?></td>
                                <td><?= $notification["description"] ?></td>
                                <td><a href="#">Edit</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>