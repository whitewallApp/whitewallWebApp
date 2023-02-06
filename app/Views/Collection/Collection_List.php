<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>
<div class="row m-3">
    <div class="col-sm-8">
    <div class="row m-2">
            <div class="col-sm-11">
                <div id="actions" class="row" style="display: none">
                    <p id="infoSelect" class="mr-2"></p>
                    <a href="#">Delete</a>
                    <p class="mr-2 ml-2"> | </p>
                    <a href="#">Change Category</a>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                <th scope="col">Category</th>
                <th scope="col">Icon</th>
                <th scope="col">Name</th>
                <th scope="col">Images</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                <td>stuff here</td>
                <td>stuff here</td>
                <td>stuff here</td>
                <td>stuff here</td>
                </tr>
                <tr>
                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                <td>stuff here</td>
                <td>stuff here</td>
                <td>stuff here</td>
                <td>stuff here</td>
                </tr>
                <tr>
                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                <td>stuff here</td>
                <td>stuff here</td>
                <td>stuff here</td>
                <td>stuff here</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-4">
        <?= $this->renderSection('Detail') ?>
    </div>
</div>


<?= $this->endSection() ?>