<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>
<div class="row m-3">
    <div class="col-sm-8">
        <div class="list-group col-sm-8 m-5">
            <div class="row">
                <a href="#" class="list-group-item list-group-item-action col-sm-9">Category</a>
                <input class="col-sm-2 checkbox-sm" type="checkbox" value=""/>
            </div>
            <div class="row">
                <a href="#" class="list-group-item list-group-item-action col-sm-9">Category</a>
                <input class="col-sm-2 checkbox-sm" type="checkbox" value=""/>
            </div>
            <div class="row">
                <a href="#" class="list-group-item list-group-item-action col-sm-9">Category</a>
                <input class="col-sm-2 checkbox-sm" type="checkbox" value=""/>
            </div>
            <div class="row">
                <a href="#" class="list-group-item list-group-item-action col-sm-9">Category</a>
                <input class="col-sm-2 checkbox-sm" type="checkbox" value=""/>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <?= $this->renderSection('Detail') ?>
    </div>
</div>


<?= $this->endSection() ?>