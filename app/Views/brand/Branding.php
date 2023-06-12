<div class="m-4">
    <div class="row">
        <div class="col-5">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Collections List</a>
                    <a class="nav-item nav-link" id="nav-profile-img-pg" data-toggle="tab" href="#nav-img-pg" role="tab" aria-controls="nav-img-pg" aria-selected="false">Image List</a>
                    <a class="nav-item nav-link" id="nav-contact-img" data-toggle="tab" href="#nav-img" role="tab" aria-controls="nav-img" aria-selected="false">Wallpaper Preview</a>
                    <a class="nav-item nav-link" id="nav-contact-menu" data-toggle="tab" href="#nav-menu" role="tab" aria-controls="nav-menu" aria-selected="false">Custom Page</a>
                    <a class="nav-item nav-link" id="nav-contact-loading" data-toggle="tab" href="#loading-img" role="tab" aria-controls="loading-img" aria-selected="false">Loading Page</a>
                </div>
            </nav>
            <div class="tab-content" id="myTabContent">
                <!-- Collections -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="phone">
                        <img class="phone-img" src="/Icons/phone.png">
                        <div class="background-phone-collection">
                            <div class="col top-nav">
                                <img class="menu-img" src="/Icons/SMALL-Whitewall-LOGO-pos.png">
                                <div class="row">
                                    <div class="col-9">
                                        <select class="custom-select custom-select-sm" style="font-size: x-small;">
                                            <option selected>Change: Never</option>
                                            <option value="1">Change Every: Day</option>
                                            <option value="2">Change Every: Other Day</option>
                                            <option value="3">Change Every: Week</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <i class="bi bi-list menu-icon" style="top: -5px;"></i>
                                    </div>
                                </div>
                            </div>
                            <?php for ($i = 0; $i < floor(count($collections) / 2); $i += 2) : ?>
                                <div class="row m-2">
                                    <div class="col-sm-6">
                                        <div class="card card-branding">
                                            <input type="checkbox" class="form-check-input checkbox-branding" checked>
                                            <img class="card-img-top img-branding p-2" src="<?= $collections[$i]["iconPath"] ?>">
                                            <div class="collection-title">
                                                <p><?= $collections[$i]["name"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card card-branding">
                                            <input type="checkbox" class="form-check-input checkbox-branding">
                                            <img class="card-img-top p-2 img-branding" src="<?= $collections[$i + 1]["iconPath"] ?>">
                                            <div class="collection-title">
                                                <p><?= $collections[$i + 1]["name"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor ?>
                            <?php if (count($collections) % 2 != 0) : ?>
                                <div class="col-sm-6">
                                    <div class="card card-branding">
                                        <img class="card-img-top p-2 img-branding" src="<?= $collections[count($collections) - 1]["iconPath"] ?>">
                                        <div class="collection-title">
                                            <p><?= $collections[count($collections) - 1]["name"] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="row bottom-nav">
                                <?php foreach ($categories as $category) : ?>
                                    <div class="col text-center">
                                        <!-- <i class="bi bi-palette-fill"></i> -->
                                        <img class="category-img" src="<?= $category["iconPath"] ?>">
                                        <p><?= $category["name"] ?></p>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Set Image Pane -->
                <div class="tab-pane fade" id="nav-img-pg" role="tabpanel" aria-labelledby="nav-img-pg-tab">
                    <div class="phone">
                        <img class="phone-img" src="/Icons/phone.png">
                        <div class="background-phone-image">
                            <div class="col top-nav mt-2 mb-2">
                                <button class="btn btn-primary w-100 btn-branding">Back</button>
                            </div>
                            <?php for ($i = 0; $i < floor(count($images) / 2); $i += 2) : ?>
                                <div class="row m-2">
                                    <div class="col-sm-6">
                                        <div class="card card-branding p-2">
                                            <img class="img-branding" src="<?= $images[$i]["thumbnail"] ?>" alt="Card image cap">
                                            <div class="image-title">
                                                <p><?= $images[$i]["name"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="card card-branding p-2">
                                            <img class="img-branding" src="<?= $images[$i + 1]["thumbnail"] ?>" alt="Card image cap">
                                            <div class="image-title">
                                                <p><?= $images[$i + 1]["name"] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor ?>
                            <?php if (count($collections) % 2 != 0) : ?>
                                <div class="col-sm-6">
                                    <div class="card card-branding p-2">
                                        <img class="img-branding" src="<?= $images[count($images) - 1]["thumbnail"] ?>" alt="Card image cap">
                                        <div class="image-title">
                                            <p><?= $images[count($images) - 1]["name"] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <!-- Wallpaper Pane -->
                <div class="tab-pane fade" id="nav-img" role="tabpanel" aria-labelledby="nav-img-tab">
                    <div class="phone">
                        <img class="phone-img" src="/Icons/phone.png">
                        <img class="phone-wallpaper" src="<?= $images[0]["thumbnail"] ?>">
                        <button class="btn btn-primary btn-branding" id="setWallpaper">Set Wallpaper</button>
                    </div>
                </div>

                <!-- Loading Pane -->
                <div class="tab-pane fade" id="loading-img" role="tabpanel" aria-labelledby="loading-img-tab">
                    <div class="phone">
                        <img class="phone-img" src="/Icons/phone.png">
                        <div class="background-phone-loading row">
                            <div class="col-sm-12 my-auto text-center">
                                <img class="phone-loading" src="<?= $brandimages["appLoading"] ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Pane -->
                <div class="tab-pane fade" id="nav-menu" role="tabpanel" aria-labelledby="nav-menu-tab">
                    <div class="phone">
                        <img class="phone-img" src="/Icons/phone.png">
                        <i class="bi bi-list menu-icon" style="top:-455px; left: 188px;"></i>
                        <div class="list-group list-group-light menu-list">
                            <?php foreach ($menu as $item) : ?>
                                <a href="#" class="list-group-item list-group-item-action px-3 border-0"><?= $item ?></a>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branding Buttons -->
        <div class="col-6">
            <div class="accordion" id="accordionBranding">
                <div class="card">
                    <div class="card-header" id="logos">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#logosCollapse" aria-expanded="true" aria-controls="collapseOne">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Logos
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>

                    <div id="logosCollapse" class="collapse" aria-labelledby="logos" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="appIcon">App Icon</label>
                                    <input type="file" class="form-control" id="appIcon" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="appHeader">App Header</label>
                                    <input type="file" class="form-control" id="appHeader" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="appBanner">App Banner</label>
                                    <input type="file" class="form-control" id="appBanner" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="loading">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#loadingCollapse" aria-expanded="true" aria-controls="collapseOne">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Loading
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>

                    <div id="loadingCollapse" class="collapse" aria-labelledby="loading" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="appLoading">App Loading Image</label>
                                    <input type="file" class="form-control" id="appLoading" />
                                    <div class="form-text">
                                        Animated GIF Preferred
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="loadingSize">Loading Image Size</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" value="100" id="loadingSize" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="loadingcolor">Loading Page Background color</label>
                                    <input type="color" class="form-control" id="loadingcolor">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="catLabels">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#catLabelscollapse" aria-expanded="true" aria-controls="collapseOne">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Category Labels
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>

                    <div id="catLabelscollapse" class="collapse" aria-labelledby="catLabels" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="categoryColor">Category Icon Color</label>
                                    <input type="color" class="form-control" id="categoryColor">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="catFont">
                                        <option value="Arial">Arial (sans-serif)</option>
                                        <option value="Verdana">Verdana (sans-serif)</option>
                                        <option value="Tahoma">Tahoma (sans-serif)</option>
                                        <option value="Trebuchet MS">Trebuchet MS (sans-serif)</option>
                                        <option value="Times New Roman">Times New Roman (serif)</option>
                                        <option value="Georgia">Georgia (serif)</option>
                                        <option value="Garamond">Garamond (serif)</option>
                                        <option value="Courier New">Courier New (monospace)</option>
                                        <option value="Brush Script MT, cursive">Brush Script MT (cursive)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="categoryFontColor">Font Color</label>
                                    <input type="color" class="form-control" id="categoryFontColor">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="catFontStyle">
                                        <option selected value="normal">Normal</option>
                                        <option value="bold">Bold</option>
                                        <option value="italic">Italicized</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="catFontSize">Category Font Size</label>
                                    <div class="range">
                                        <input type="range" class="form-range" step="1" min="0" max="60" id="catFontSize" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="background">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#backgroundCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Background
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="backgroundCollapse" class="collapse" aria-labelledby="background" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="backgroundColor">App Background Color</label>
                                    <input type="color" class="form-control" id="backgroundColor">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="colImgLabels">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#colImgLabelsCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Collection & Image Labels
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="colImgLabelsCollapse" class="collapse" aria-labelledby="colImgLabels" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <select class="custom-select" id="imgCollabelFont">
                                        <option value="Arial">Arial (sans-serif)</option>
                                        <option value="Verdana">Verdana (sans-serif)</option>
                                        <option value="Tahoma">Tahoma (sans-serif)</option>
                                        <option value="Trebuchet MS">Trebuchet MS (sans-serif)</option>
                                        <option value="Times New Roman">Times New Roman (serif)</option>
                                        <option value="Georgia">Georgia (serif)</option>
                                        <option value="Garamond">Garamond (serif)</option>
                                        <option value="Courier New">Courier New (monospace)</option>
                                        <option value="Brush Script MT, cursive">Brush Script MT (cursive)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="collImgLabelFontColor">Font Color</label>
                                    <input type="color" class="form-control" id="collImgLabelFontColor">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="imgCollabelFontStyle">
                                        <option selected value="normal">Normal</option>
                                        <option value="bold">Bold</option>
                                        <option value="italic">Italicized</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="imgCollabelFontsize">Font Size</label>
                                    <div class="range">
                                        <input type="range" class="form-range" step="1" min="0" max="60" id="imgCollabelFontsize" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="selection">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#sellectionCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Selection Dropdown
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="sellectionCollapse" class="collapse" aria-labelledby="selection" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="dropdownColor">Dropdown Icon Color</label>
                                    <input type="color" class="form-control" id="dropdownColor">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="dropdownFont">
                                        <option value="Arial">Arial (sans-serif)</option>
                                        <option value="Verdana">Verdana (sans-serif)</option>
                                        <option value="Tahoma">Tahoma (sans-serif)</option>
                                        <option value="Trebuchet MS">Trebuchet MS (sans-serif)</option>
                                        <option value="Times New Roman">Times New Roman (serif)</option>
                                        <option value="Georgia">Georgia (serif)</option>
                                        <option value="Garamond">Garamond (serif)</option>
                                        <option value="Courier New">Courier New (monospace)</option>
                                        <option value="Brush Script MT, cursive">Brush Script MT (cursive)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="dropdownFontColor">Font Color</label>
                                    <input type="color" class="form-control" id="dropdownFontColor">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="dropdownFontStyle">
                                        <option selected value="normal">Normal</option>
                                        <option value="bold">Bold</option>
                                        <option value="italic">Italicized</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="dropdownFont">Font Size</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="60" id="dropdownFontsize" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="checkmark">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#checkmarkCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Selection Checkmark
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="checkmarkCollapse" class="collapse" aria-labelledby="checkmark" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="checkmarkBackground">Background Color</label>
                                    <input type="color" class="form-control" id="checkmarkBackground">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="checkmarkColor">Checkmark Color</label>
                                    <input type="color" class="form-control" id="checkmarkColor">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="imgCol">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#imgColCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Images & Collections
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="imgColCollapse" class="collapse" aria-labelledby="imgCol" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="imgBorderRadius">Border Radius</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" id="imgBorderRadius" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="imgBorderWidth">Border Width</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" id="imgBorderWidth" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="borderColor">Border Color</label>
                                    <input type="color" class="form-control" id="borderColor">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="frame">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#frameCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Images & Collections Frame
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="frameCollapse" class="collapse" aria-labelledby="frame" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label for="collBackgroundColor">Background Color</label>
                                    <input type="color" class="form-control" id="collBackgroundColor">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="frameRadius">Border Radius</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" id="frameRadius" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="frameBorderWidth">Border Width</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" id="frameBorderWidth" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="collBorderColor">Border Color</label>
                                    <input type="color" class="form-control" id="collBorderColor">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="button">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#buttonCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Buttons
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="buttonCollapse" class="collapse" aria-labelledby="button" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="buttonColor">Button Background Color</label>
                                    <input type="color" class="form-control" id="buttonColor">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="buttonBorderRadius">Border Radius</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" id="buttonBorderRadius" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="buttonFont">
                                        <option value="Arial">Arial (sans-serif)</option>
                                        <option value="Verdana">Verdana (sans-serif)</option>
                                        <option value="Tahoma">Tahoma (sans-serif)</option>
                                        <option value="Trebuchet MS">Trebuchet MS (sans-serif)</option>
                                        <option value="Times New Roman">Times New Roman (serif)</option>
                                        <option value="Georgia">Georgia (serif)</option>
                                        <option value="Garamond">Garamond (serif)</option>
                                        <option value="Courier New">Courier New (monospace)</option>
                                        <option value="Brush Script MT, cursive">Brush Script MT (cursive)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="buttonFontColor">Font Color</label>
                                    <input type="color" class="form-control" id="buttonFontColor">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="buttonFontStyle">
                                        <option selected value="normal">Normal</option>
                                        <option value="bold">Bold</option>
                                        <option value="italic">Italicized</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="buttonFontSize">Font Size</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="60" id="buttonFontSize" value="0" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="button">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#linkCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-sm-11">
                                        Custom Links
                                    </div>
                                    <div class="col-sm-1">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="linkCollapse" class="collapse" aria-labelledby="button" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-text">
                                    Avalible placeholders: {{collection_id}}, {{collection_name}}, {{category_id}}, {{category_name}}
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="collectionLinkTitle">Collections</span>
                                    <input type="text" class="form-control" id="collectionLink" aria-describedby="collectionLinkTitle" placeholder="?collection={{collection_id}}" />
                                </div>

                                <div class="form-text">
                                    Avalible placeholders: {{category_id}}, {{category_name}}
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="categoryLinkTitle">Categories</span>
                                    <input type="text" class="form-control" id="categoryLink" aria-describedby="categoryLinkTitle" placeholder="?category={{category_id}}" />
                                </div>

                                <div class="form-text">
                                    Avalible placeholders: {{menu_id}}, {{menu_title}}
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="menuLinkTitle">Menu Items</span>
                                    <input type="text" class="form-control" id="menuLink" aria-describedby="menuLinkTitle" placeholder="?menu_item={{menu_id}}" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right m-3">
                <button class="btn btn-primary" id="save">Save</button>
            </div>
            <div class="alert alert-success" role="alert" style="display: none;">
                Success
            </div>
            <div class="alert alert-danger" role="alert" style="display: none;">
            </div>
        </div>
    </div>
</div>
<script>
    <?php if ($branding == "") : ?>
        $(function() {
            branding = {
                background: {},
                categories: {},
                cards: {
                    frames: {},
                    images: {}
                },
                dropdowns: {},
                checkmarks: {},
                buttons: {}
            };
        })
    <?php else : ?>
        $(function() {
            branding = <?= $branding ?>;
        })
    <?php endif ?>
</script>
<script src="/js/branding.js"></script>