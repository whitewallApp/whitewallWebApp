<link rel="stylesheet" href="/css/branding.css">

<div class="m-4">
    <div class="row">
        <div class="col position-sticky">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Collections List</a>
                    <a class="nav-item nav-link" id="nav-profile-img-pg" data-toggle="tab" href="#nav-img-pg" role="tab" aria-controls="nav-img-pg" aria-selected="false">Image List</a>
                    <a class="nav-item nav-link" id="nav-contact-img" data-toggle="tab" href="#nav-img" role="tab" aria-controls="nav-img" aria-selected="false">Wallpaper Preview</a>
                    <!-- <a class="nav-item nav-link" id="nav-contact-menu" data-toggle="tab" href="#nav-menu" role="tab" aria-controls="nav-menu" aria-selected="false">Custom Page</a> -->
                    <a class="nav-item nav-link" id="nav-contact-loading" data-toggle="tab" href="#loading-img" role="tab" aria-controls="loading-img" aria-selected="false">Loading Page</a>
                </div>
            </nav>
            <div class="tab-content" id="myTabContent">
                <!-- Collections -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="phone">
                        <div class="header row">
                            <div class="col text-center my-auto">
                                <img class="header-img" src="<?= ($brandimages["appHeading"] == "") ? ("/Icons/SMALL-Whitewall-LOGO-pos.png") : ($brandimages["appHeading"]) ?>">
                            </div>
                        </div>
                        <div>
                            <?php for ($i = 0; $i < floor(count($collections) / 2); $i += 2) : ?>
                            <div class="d-flex justify-content-around">
                                <div class="phone-card m-2">
                                    <p class="text-center"><?= $collections[$i]["name"] ?></p>
                                    <img src="<?= $collections[$i]["thumbnail"] ?>">
                                </div>
                                <div class="phone-card m-2">
                                    <p class="text-center"><?= $collections[$i + 1]["name"] ?></p>
                                    <img src="<?= $collections[$i + 1]["thumbnail"] ?>">
                                </div>
                            </div>
                            <?php endfor ?>
                        </div>
                    </div>
                </div>

                <!-- Set Image Pane -->
                <div class="tab-pane fade" id="nav-img-pg" role="tabpanel" aria-labelledby="nav-img-pg-tab">
                   <div class="phone">
                        <div class="header row">
                            <div class="col text-center my-auto">
                                <img class="header-img" src="<?= ($brandimages["appHeading"] == "") ? ("/Icons/SMALL-Whitewall-LOGO-pos.png") : ($brandimages["appHeading"]) ?>">
                            </div>
                        </div>
                        <div>
                            <?php for ($i = 0; $i < floor(count($images) / 2); $i += 2) : ?>
                            <div class="d-flex justify-content-around">
                                <div class="phone-card m-2">
                                    <p class="text-center"><?= $images[$i]["name"] ?></p>
                                    <img src="<?= $images[$i]["thumbnail"] ?>">
                                </div>
                                <div class="phone-card m-2">
                                    <p class="text-center"><?= $images[$i + 1]["name"] ?></p>
                                    <img src="<?= $images[$i + 1]["thumbnail"] ?>">
                                </div>
                            </div>
                            <?php endfor ?>
                        </div>
                    </div>
                </div>

                <!-- Wallpaper Pane -->
                <div class="tab-pane fade" id="nav-img" role="tabpanel" aria-labelledby="nav-img-tab">
                   <div class="phone">
                        <div class="header row">
                            <div class="col text-center my-auto">
                                <img class="header-img" src="<?= ($brandimages["appHeading"] == "") ? ("/Icons/SMALL-Whitewall-LOGO-pos.png") : ($brandimages["appHeading"]) ?>">
                            </div>
                        </div>
                        <div>
                           <div>
                                <button class="btn btn-primary btn-branding" id="actionBtn">Call to Action</button>
                                <div id="wallpaper">
                                    <?php if (count($images) > 0) : ?>
                                        <img src="<?= $images[0]["imagePath"] ?>">
                                    <?php endif ?>
                                    <button class="btn btn-primary btn-branding" id="setWallpaper">Set Wallpaper</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading Pane -->
                <div class="tab-pane fade" id="loading-img" role="tabpanel" aria-labelledby="loading-img-tab">
                    <div class="phone" id="loadingct">
                        <div class="loading">
                            <img id="loading" src="<?= $brandimages["appLoading"] ?>">
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
        <div class="col" <?php if (!$view[$pageName]["edit"]) echo 'style="display: none;"' ?>>
            <div class="accordion" id="accordionBranding">
                <div class="card">
                    <div class="card-header" id="logos">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#logosCollapse" aria-expanded="true" aria-controls="collapseOne">
                                <div class="row">
                                    <div class="col-10">
                                        Branding
                                    </div>
                                    <div class="col">
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
                                    <small class="form-text text-danger">This has to be a square larger than 300x300</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="appHeader">App Header</label>
                                    <input type="file" class="form-control" id="appHeader" />
                                    <label class="form-label" for="headerLink">Header Link</label>
                                    <input type="text" class="form-control" id="headerLink" />

                                    <label class="form-label" for="headerSize">Header Size</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" id="headerSize" value="100" />
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="form-label" for="appBanner">App Banner</label>
                                    <input type="file" class="form-control" id="appBanner" />
                                    <small class="form-text text-muted">1080x160 px banner recomended</small>
                                    <label class="form-label" for="bannerLink">Banner Link</label>
                                    <input type="text" class="form-control" id="bannerLink" />
                                </div> -->
                                <div class="form-group">
                                    <label class="form-label" for="appName">App Name</label>
                                    <input type="text" class="form-control" id="appName" />
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
                                    <div class="col-10">
                                        Loading
                                    </div>
                                    <div class="col">
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
                    <div class="card-header" id="background">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#backgroundCollapse" aria-expanded="false" aria-controls="collapseTwo">
                                <div class="row">
                                    <div class="col-10">
                                        Background
                                    </div>
                                    <div class="col">
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
                                    <div class="col-10">
                                        Card Labels
                                    </div>
                                    <div class="col">
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
                                    <select class="custom-select" id="cardFont">
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
                                    <input type="color" class="form-control" id="cardFontColor">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="collImgLabelActionColor">Call To Action Color</label>
                                    <input type="color" class="form-control" id="cardActionColor">
                                </div>
                                <div class="form-group">
                                    <select class="custom-select" id="cardFontStyle">
                                        <option selected value="normal">Normal</option>
                                        <option value="bold">Bold</option>
                                        <option value="italic">Italicized</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="cardFontsize">Font Size</label>
                                    <div class="range">
                                        <input type="range" class="form-range" step="1" min="0" max="60" id="cardFontsize"/>
                                    </div>
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
                                    <div class="col-10">
                                        Card Image Frames
                                    </div>
                                    <div class="col">
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
                                    <div class="col-10">
                                        Card
                                    </div>
                                    <div class="col">
                                        <i class="bi bi-plus" style="color: var(--mdb-btn-color); font-size: 1rem"></i>
                                    </div>
                                </div>
                            </button>
                        </h2>
                    </div>
                    <div id="frameCollapse" class="collapse" aria-labelledby="frame" data-parent="#accordionBranding">
                        <div class="card-body">
                            <form>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="shadowBox" />
                                    <label class="form-check-label" for="shadowBox">Card Drop Shadow</label>
                                </div>
                                <div class="form-group">
                                    <label for="collBackgroundColor">Background Color</label>
                                    <input type="color" class="form-control" id="cardBackgroundColor">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="cardframeRadius">Border Radius</label>
                                    <div class="range">
                                        <input type="range" class="form-range" min="0" max="100" id="cardframeRadius" />
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
                                    <input type="color" class="form-control" id="cardBorderColor">
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
                                    <div class="col-10">
                                        Buttons
                                    </div>
                                    <div class="col">
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
                                        <input type="range" class="form-range" step="0.2" min="0" max="20" id="buttonBorderRadius" />
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
                                    <div class="col-10">
                                        Custom Links
                                    </div>
                                    <div class="col">
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
            branding = json_decode({
                "background": {
                    "color": "#ffffff"
                },
                "cards": {
                    "frames": {
                        "borderRadius": "0",
                        "borderWidth": "0",
                        "borderColor": "#000000"
                    },
                    "images": {
                        "borderRadius": "0",
                        "borderWidth": "0",
                        "borderColor": "#000000"
                    },
                    "backgroundcolor": "#ffffff",
                    "fontcolor": "#000000",
                    "fontstyle": "normal",
                    "fontsize": "8",
                    "font": "Tahoma"
                },
                "dropdowns": {
                    "backgroundcolor": "#000000",
                    "fontcolor": "#000000",
                    "font": "Arial",
                    "fontstyle": "normal",
                    "fontsize": "30"
                },
                "checkmarks": {},
                "buttons": {
                    "fontcolor": "#ffffff",
                    "fontsize": "16",
                    "borderColor": "#ffdf3d",
                    "borderRadius": "7",
                    "font": "Tahoma",
                    "fontstyle": "bold"
                },
                "loading": {
                    "size": "80"
                },
                "appName": "My App",
                "headerSize": "80",
                "bannerLink": ""
            });
        })
    <?php else : ?>
        $(function() {
            branding = <?= $branding ?>;
        })
    <?php endif ?>

    brandingImages = <?= json_encode($brandimages) ?>
</script>
<script src="/js/branding.js"></script>