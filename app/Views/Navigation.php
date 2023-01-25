<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/dashboard">
        <img src="/Icons/Whitewall-LOGO-pos.png" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/categories">Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/collections">Collections</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/images">Images</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/notifications">Notifications</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Search</button>
        </form>

        <div class="dropleft dropdown ml-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="crimson" class="bi bi-person-circle dropdown-toggle" viewBox="0 0 16 16" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="/account">Account</a>
                <a class="dropdown-item" href="#">Billing</a>
                <a class="dropdown-item" href="/settings">Settings</a>
            </div>
        </div>
    </div>
</nav>

<?= $this->renderSection('MainPage') ?>
<?= $this->endSection() ?>