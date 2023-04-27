<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>

<nav class="navbar navbar-expand-lg">
    <div class="col-sm-2">
        <a class="navbar-brand" href="/dashboard">
            <img src="/Icons/Whitewall-LOGO-pos.png" height="50" alt="Logo Image">
        </a>
    </div>

    <div class="collapse navbar-collapse " id="navbarSupportedContent"></div>


    <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Search</button>
    </form>

    <div class="dropleft dropdown ml-3 p-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php if ($userIcon == "") : ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="crimson" class="bi bi-person-circle dropdown-toggle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
            </svg>
        <?php else : ?>
            <img class="profile-photo" src="<?= $userIcon ?>">
        <?php endif ?>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="col">
                <div class="row rounded" style="background-color: lightgray;">
                    <div class="col-3">
                        <img class="brand-icon-header" src="<?= $brandIcon ?>">
                    </div>
                    <div class="col-9">
                        <p style="font-size: medium;"><?= $brandName ?></p>
                    </div>
                </div>

                <?php if ($view["brands"]["p_view"]) : ?>
                    <a class="dropdown-item" href="/brand">Manage Brands</a>
                <?php endif ?>

                <?php if ($admin) : ?>
                    <a class="dropdown-item" href="/brand/users/<?= $brandId ?>">Manage Users</a>
                <?php endif ?>
                <a class="dropdown-item" href="/account">Account</a>
                <a class="dropdown-item" href="/billing">Billing</a>
            </div>
        </div>
    </div>

</nav>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">Home</a>
            </li>

            <?php if ($view["categories"]["p_view"]) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/categories">Categories</a>
                </li>
            <?php endif ?>

            <?php if ($view["collections"]["p_view"]) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/collections">Collections</a>
                </li>
            <?php endif ?>

            <?php if ($view["images"]["p_view"]) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/images">Images</a>
                </li>
            <?php endif ?>

            <?php if ($view["notifications"]["p_view"]) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/notifications">Notifications</a>
                </li>
            <?php endif ?>

            <?php if ($view["menu"]["p_view"]) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/menu">Menu Items</a>
                </li>
            <?php endif ?>

            <?php if ($view["builds"]["p_view"]) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/app">Versions</a>
                </li>
            <?php endif ?>

            <?php if ($view["branding"]["p_view"]) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/brand/branding/<?= $brandId ?>">Branding</a>
                </li>
            <?php endif ?>
        </ul>
</nav>

<div class="row">
    <div class="col-4">
        <div class="row">
            <div class="col-sm-6 text-center">
                <p class="breadcrumbs p-3"><?= $pageTitle ?></p>
            </div>
            <div class="col-sm-6 pl-0">
                <?php if ($pageTitle != "Account Settings" && $pageTitle != "Billing") : ?>
                    <div class="mt-3">
                        <select id="brandSelect" style="max-width: fit-content; font-size: 1.5rem;" class="h-50 custom-select">
                            <?php foreach ($brands as $brand) : ?>
                                <?php if ($brand["name"] == $brandName) : ?>
                                    <option selected><?= $brand["name"] ?></option>
                                <?php else : ?>
                                    <option><?= $brand["name"] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="col-8">
        <?php if (isset($actions[0])) : ?>
            <div class="row row-cols-3 float-right p-3">
                <div class="col p-3">
                    <p>Add <?= $actions[1] ?></p>
                </div>
                <div class="col">
                    <button class="btn btn-primary m-2">Individual</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary m-2">Bulk Upload</button>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<?= $this->endSection() ?>