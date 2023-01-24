<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3e3e3">
    <div class="container justify-content-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-plus-circle mr-5 ml-5" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-dash-circle mr-5" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-list-task mr-5" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
            <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
            <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
        </svg>
        <div>
            <input class="checkbox-lg m-0" type="checkbox" value=""/>
        </div>
    </div>
</nav>

<div class="row">
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


<?= $this->endSection() ?>