<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>
<div class="row m-3">
    <div class="col-sm-8">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col"><input type="checkbox" class="checkbox-lg"></th>
                <th scope="col">Icon</th>
                <th scope="col">Name</th>
                <th scope="col">Images</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                <td>Icon</td>
                <td>Name</td>
                <td>@mdo</td>
                </tr>
                <tr>
                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                </tr>
                <tr>
                <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-4">
        <?= $this->renderSection('Detail') ?>
    </div>
</div>


<?= $this->endSection() ?>