<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>
<title><?= $pageTitle ?></title>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand" href="/dashboard">
            <img src="/Icons/Whitewall-LOGO-pos.png" height="50" alt="Logo Image">
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topNavbarContent" aria-controls="topNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="topNavbarContent">

            <!-- Search Form -->
            <form class="form-inline my-2 my-lg-0 ml-auto" method="get" action="/search">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="query" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" id="submit">Search</button>
            </form>

            <!-- Profile / Brand Dropdown -->
            <div class="dropleft dropdown ml-3">
                <?php if ($userIcon == "") : ?>
                    <svg class="dropdown-toggle" style="cursor:pointer;" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="crimson" viewBox="0 0 16 16" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                <?php else : ?>
                    <div class="dropdown-toggle flex-shrink-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor:pointer;">
                        <img class="profile-photo" src="<?= $userIcon ?>">
                    </div>
                <?php endif ?>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="col">
                        <div class="row rounded bg-light p-2 mb-2">
                            <div class="col-3">
                                <img class="brand-icon-header" src="<?= $brandIcon ?>">
                            </div>
                            <div class="col-9">
                                <p class="mb-0"><?= $brandName ?></p>
                            </div>
                        </div>

                        <?php if ($view["brands"]["view"]) : ?>
                            <a class="dropdown-item" href="/brand">Manage Brands</a>
                        <?php endif ?>
                        <?php if ($admin) : ?>
                            <a class="dropdown-item" href="/brand/users/<?= $brandId ?>">Manage Users</a>
                            <a class="dropdown-item" href="/billing">Billing</a>
                        <?php endif ?>
                        <?php if ($superAdmin) : ?>
                            <a class="dropdown-item" href="/admin">Super Admin</a>
                        <?php endif ?>
                        <a class="dropdown-item" href="/account">Account</a>
                        <a class="dropdown-item" href="/account?logout=true">Logout</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>

<!-- Secondary Navbar -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="/dashboard">Home</a></li>
            <?php if ($view["categories"]["view"]) : ?><li class="nav-item"><a class="nav-link" href="/categories">Categories</a></li><?php endif ?>
            <?php if ($view["collections"]["view"]) : ?><li class="nav-item"><a class="nav-link" href="/collections">Collections</a></li><?php endif ?>
            <?php if ($view["images"]["view"]) : ?><li class="nav-item"><a class="nav-link" href="/images">Images</a></li><?php endif ?>
            <?php if ($view["notifications"]["view"]) : ?><li class="nav-item"><a class="nav-link" href="/notifications">Notifications</a></li><?php endif ?>
            <?php if ($view["menu"]["view"]) : ?><li class="nav-item"><a class="nav-link" href="/menu">Menu Items</a></li><?php endif ?>
            <?php if ($view["branding"]["view"]) : ?><li class="nav-item"><a class="nav-link" href="/brand/branding/<?= $brandId ?>">Branding</a></li><?php endif ?>
            <?php if ($view["builds"]["view"]) : ?><li class="nav-item"><a class="nav-link" href="/app">Versions</a></li><?php endif ?>
        </ul>
    </div>
</nav>

<!-- Page Header / Brand Selector -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mt-4 px-3">
    <div class="flex-shrink-0 mb-2 mb-md-0 mr-md-3">
        <?php if ($pageTitle != "Account Settings" && $pageTitle != "Billing" && $pageTitle != "Brands" && $pageTitle != "Brand Users") : ?>
            <?php if (count($brands) > 1) : ?>
                <select id="brandSelect" class="custom-select w-100 brand-select">
                    <?php foreach ($brands as $brand) : ?>
                        <option <?= ($brand["name"] == $brandName ? 'selected' : '') ?>><?= $brand["name"] ?></option>
                    <?php endforeach ?>
                </select>
            <?php else : ?>
                <h2 class="mb-0"><?= $brands[0]["name"] ?></h2>
            <?php endif ?>
        <?php endif ?>
    </div>

    <div class="flex-grow-1">
        <h2 class="mb-0 text-truncate"><?= $pageTitle ?></h2>
    </div>
</div>

<!-- Page Actions -->
<?php if ($pageName != "nopermission" && isset($actions[0]) && $view[strtolower($pageName)]["add"]) : ?>
    <div class="row px-3 mb-3">
        <!-- <div class="col-6 col-md-2">
            <p>Add <?= $actions[1] ?></p>
        </div> -->
        <!-- <div class="col-6 col-md-2">
            <button class="btn btn-primary w-100" onclick="">Individual</button>
        </div> -->
        <div class="col-8"></div>
        <div class="col-12 col-md-4">
            <button class="btn btn-primary w-100" onclick="window.location = window.origin + window.location.pathname + '/upload'">Bulk Upload / Edit</button>
        </div>
    </div>
<?php endif ?>

<?= $this->endSection() ?>
