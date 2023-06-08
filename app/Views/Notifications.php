<script>
    categories = <?= json_encode($categories) ?>
</script>

<div class="row">
    <div class="col-sm-4">
        <div class="row m-2">
            <div class="col-sm-8">
                <div id="actions" class="row" style="display: none">
                    <div class="col-2">
                        <p id="infoSelect" class=""></p>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-1">

                            </div>
                            <div class="col-4 text-center">
                                <?php if ($view[$pageName]["remove"]) : ?>
                                    <button class="btn btn-danger" id="delete">Delete</button>
                                <?php endif ?>
                            </div>
                            <div class="col-1">

                            </div>
                            <div class="col-6">
                                <button class="btn btn-info" id="change">Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z" />
                        </svg>
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
        <div class="card m-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><input id="check-all" type="checkbox" class="checkbox-lg"></th>
                        <th scope="col">Title</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notifications as $notification) : ?>
                        <tr id="<?= $notification["id"] ?>" onclick="getNot(this);">
                            <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                            <td><?= $notification["title"] ?></td>
                            <td><?= $notification["sendTime"] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-8 mt-3">
        <div class="card m-2 p-2">
            <form id="notData">
                <div class="text-center">
                    <h2>Add Notification</h2>
                </div>
                <div class="form-group">
                    <label for="title">Notification Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Check out this new thing!">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label for="text">Notification Description</label>
                        </div>
                        <div class="col-2">
                            <small class="form-text text-muted">Optional</small>
                        </div>
                        <div class="col-8">

                        </div>
                    </div>
                    <input type="textarea" class="form-control" id="text" placeholder="New shop item out now! Click to see!" aria-describedby="description">
                </div>
                <div class="form-group">
                    <label for="sendtime">Send Time</label>
                    <input type="datetime-local" id="sendtime" class="form-control" step="1">
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="force-switch" class="col-form-label">Force New Wallpaper</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="custom-control custom-switch mr-3">
                                <input type="checkbox" class="custom-control-input" id="force-switch">
                                <label class="custom-control-label" for="force-switch"></label>
                            </div>
                            <div id="force-select-div" class="col-sm-11" style="display: none;">
                                <select id="force-select" class="custom-select">
                                    <?php foreach ($images as $image) : ?>
                                        <option value="<?= $image["name"] ?>"><?= $image["name"] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="title" class="col-sm-3 col-form-label">Notification Click Action</label>

                    <select id="selections" class="custom-select col-sm-8">
                        <option selected value="None">None</option>
                        <option value="App">Open the App</option>
                        <option value="Wallpaper" id="force-option">Force Change Wallpaper</option>
                        <option value="Link">Go to Custom link</option>
                    </select>
                </div>
                <div>
                    <div class="container row justify-content-center row" id="app-input" style="display: none;">
                        <div class="col-6">
                            <div class="form-check mr-4">
                                <input class="form-check-input" type="radio" name="menuRadio" id="menuRadio">
                                <label class="form-check-label" for="menuRadio">Menu Item</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="appRadio" id="appRadio">
                                <label class="form-check-label" for="appRadio">Category/Collection/Image</label>
                            </div>
                        </div>
                    </div>

                    <div id="menu" class="form-group row" style="display: none;">
                        <label for="menu-select" class="col-sm-3 col-form-label">Menu Item</label>

                        <select id="menu-select" class="custom-select col-sm-8">
                            <?php foreach ($menuItems as $menuItem) : ?>
                                <option value="<?= $menuItem ?>"><?= $menuItem ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div id="app" style="display: none;">
                        <div class="form-group row">
                            <label for="cat-select" class="col-sm-4 col-form-label">Category</label>
                            <select id="cat-select" class="custom-select col-sm-7">
                                <option value="none">None</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="col-select" class="col-sm-4 col-form-label">Collection</label>
                            <select id="col-select" class="custom-select col-sm-7">
                                <option value="link">Link to Parent Category</option>
                            </select>
                        </div>

                        <div id="img-select-group" class=" form-group row">
                            <label for="img-select" class="col-sm-4 col-form-label">Image</label>
                            <select id="img-select" class="custom-select col-sm-7">
                                <option value="link">Link to Parent Collection</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="link-input" class="form-group" style="display: none;">
                    <label for="link">Link</label>
                    <input type="text" class="form-control" id="link" placeholder="https://yoursite.com/image">
                </div>
                <div class="float-right row">
                    <p id="updated" class="mr-2"></p>
                    <?php if ($view[$pageName]["edit"]) : ?>
                        <button class="btn btn-primary m-2">Save</button>
                    <?php endif ?>
                    <button class="btn btn-danger m-2">Remove</button>
                </div>
            </form>
            <div class="alert alert-success" role="alert" style="display: none;">
                Success
            </div>
            <div class="alert alert-danger" role="alert" style="display: none;">
            </div>
        </div>
    </div>
</div>
<script src="/js/notifications.js"></script>