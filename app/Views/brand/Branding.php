<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>

<!-- TODO: include javascript here to make it work on OnLoad -->
<div class="container">
    <div class="row">
        <div class="col">

        </div>
        <div class="col">
            <div class="row p-3">
                <div class="col">
                    <button class="btn btn-primary p-3 w-100" type="button" data-toggle="collapse" data-target="#collapseLogo" aria-expanded="false" aria-controls="collapseLogo">Logos</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary p-3 w-100" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">Category Labels</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary p-3 w-100" type="button" data-toggle="collapse" data-target="#collapseBackground" aria-expanded="false" aria-controls="collapseBackground">Background</button>
                </div>
            </div>
            <div class="row p-3">
                <div class="col">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseCollImgLabel" aria-expanded="false" aria-controls="collapseCollImgLabel">Collection & Image Labels</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseDropdown" aria-expanded="false" aria-controls="collapseDropdown">Selection Dropdown</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseCheckmark" aria-expanded="false" aria-controls="collapseCheckmark">Selection Checkmark</button>
                </div>
            </div>
            <div class="row p-3">
                <div class="col">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseImgColl" aria-expanded="false" aria-controls="collapseImgColl">Images & Collections</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseImgCollFrame" aria-expanded="false" aria-controls="collapseImgCollFrame">Images & Collections Frame</button>
                </div>
                <div class="col">
                    <button class="btn btn-primary p-3 w-100" type="button" data-toggle="collapse" data-target="#collapseButton" aria-expanded="false" aria-controls="collapseButton">Button</button>
                </div>
            </div>

            <div class="collapse" id="collapseLogo">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="appIcon">App Icon</label>
                            <input type="file" class="form-control" id="appIcon" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="appLoading">App Loading</label>
                            <input type="file" class="form-control" id="appLoading" />
                        </div>
                        <div class="form-outline">
                            <input type="text" id="appHeader" class="form-control" />
                            <label class="form-label" for="appHeader">App Header</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse" id="collapseCategory">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="categoryColor">Category Icon Color</label>
                            <input type="color" class="form-control" id="categoryColor">
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Font 1</option>
                                <option value="1">font 2</option>
                                <option value="2">font 3</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="categoryFontColor">Font Color</label>
                            <input type="color" class="form-control" id="categoryFontColor">
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Normal</option>
                                <option value="1">Bold</option>
                                <option value="2">Italicized</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoryFontSize">Category Font Size</label>
                            <input type="range" class="custom-range" min="1" max="60" step="1" id="categoryFontSize">
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse" id="collapseBackground">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="backgroundColor">App Background Color</label>
                            <input type="color" class="form-control" id="backgroundColor">
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse" id="collapseCollImgLabel">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Font 1</option>
                                <option value="1">font 2</option>
                                <option value="2">font 3</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="collImgLabelFontColor">Font Color</label>
                            <input type="color" class="form-control" id="collImgLabelFontColor">
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Normal</option>
                                <option value="1">Bold</option>
                                <option value="2">Italicized</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="collImgLabelFontSize">Collection & Image Label Font Size</label>
                            <input type="range" class="custom-range" min="1" max="60" step="1" id="collImgLabelFontSize">
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse" id="collapseDropdown">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="dropdownColor">Dropdown Icon Color</label>
                            <input type="color" class="form-control" id="categoryColor">
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Font 1</option>
                                <option value="1">font 2</option>
                                <option value="2">font 3</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="dropdownFontColor">Font Color</label>
                            <input type="color" class="form-control" id="categoryFontColor">
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Normal</option>
                                <option value="1">Bold</option>
                                <option value="2">Italicized</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dropdownFontSize">Dropdown Font Size</label>
                            <input type="range" class="custom-range" min="1" max="60" step="1" id="dropdownFontSize">
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse" id="collapseCheckmark">
                <div class="card card-body">
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
            <div class="collapse" id="collapseImgColl">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <label for="borderRadius">Border Radius</label>
                            <input type="range" class="custom-range" min="0" max="100" step="1" id="borderRadius">
                        </div>
                        <div class="form-group">
                            <label for="borderWidth">Border Width</label>
                            <input type="range" class="custom-range" min="0" max="100" step="1" id="borderWidth">
                        </div>
                        <div class="form-group">
                            <label for="borderColor">Border Color</label>
                            <input type="color" class="form-control" id="borderColor">
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse" id="collapseImgCollFrame">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <label for="collBackgroundColor">Background Color</label>
                            <input type="color" class="form-control" id="collBackgroundColor">
                        </div>
                        <div class="form-group">
                            <label for="CornerRadius">Corner Radius</label>
                            <input type="range" class="custom-range" min="0" max="100" step="1" id="CornerRadius">
                        </div>
                        <div class="form-group">
                            <label for="collBorderWidth">Border Width</label>
                            <input type="range" class="custom-range" min="0" max="100" step="1" id="collBorderWidth">
                        </div>
                        <div class="form-group">
                            <label for="collBorderColor">Border Color</label>
                            <input type="color" class="form-control" id="collBorderColor">
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse" id="collapseButton">
                <div class="card card-body">
                    <form>
                        <div class="form-group">
                            <label class="form-label" for="buttonColor">Button Background Color</label>
                            <input type="color" class="form-control" id="buttonColor">
                        </div>
                        <div class="form-group">
                            <label for="CornerRadius">Corner Radius</label>
                            <input type="range" class="custom-range" min="0" max="100" step="1" id="CornerRadius">
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Font 1</option>
                                <option value="1">font 2</option>
                                <option value="2">font 3</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="buttonFontColor">Font Color</label>
                            <input type="color" class="form-control" id="buttonFontColor">
                        </div>
                        <div class="form-group">
                            <select class="custom-select">
                                <option selected>Normal</option>
                                <option value="1">Bold</option>
                                <option value="2">Italicized</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="buttonFontSize">Button Font Size</label>
                            <input type="range" class="custom-range" min="1" max="60" step="1" id="buttonFontSize">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>