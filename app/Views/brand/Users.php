<div class="row m-3">
    <div class="col-6">
        <div class="card p-2">
            <div class="row m-2">
                <div class="col-sm-10">
                    <div id="actions" class="row" style="display: none">
                        <div class="col-2">
                            <p id="infoSelect" class="mr-2"></p>
                        </div>
                        <div class="col-2">
                            <a href="#">Delete</a>
                        </div>
                        <div class="col-2">
                            <p class="mr-2 ml-2"> | </p>
                        </div>
                        <div class="col-2">
                            <a href="#">Change User</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><input id="check-all" type="checkbox" class="checkbox-lg"></th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr id="<?= $user["id"] ?>" onclick="getUser(this);">
                            <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                            <td><?= $user["name"] ?></td>
                            <td><?= $user["email"] ?></td>
                            <td>Active</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6">
        <form id="permissionsForm" method="post">
            <!-- User Info -->
            <div class="card p-2 mb-5">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Example input placeholder">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Another input placeholder">
                </div>
                <div class="form-group row">
                    <div class="col-3">
                        <label class="mr-3">Active</label>
                    </div>
                    <div class="col-8">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" name="active">
                            <label class="custom-control-label" for="active"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select class="custom-select" name="brand">
                        <?php foreach ($brandNames as $name) : ?>
                            <option value="<?= $name["name"] ?>"><?= $name["name"] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <!-- Permissions Table -->
            <div class="row ml-3">
                <div class="col-2">
                    <label class="mr-3">Admin</label>
                </div>
                <div class="col-10">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="admin" name="admin">
                        <label class="custom-control-label" for="admin"></label>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">

                    </div>
                    <div class="col">
                        <p>View</p>
                    </div>
                    <div class="col">
                        <p>Add</p>
                    </div>
                    <div class="col">
                        <p>Edit</p>
                    </div>
                    <div class="col">
                        <p>Remove</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Select All</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[all][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[all][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[all][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[all][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Categories</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[categories][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[categories][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[categories][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[categories][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Collections</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[collections][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[collections][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[collections][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[collections][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Images</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[images][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[images][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[images][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[images][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Notifications</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[notifications][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[notifications][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[notifications][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[notifications][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Menu Items</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[menu][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[menu][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[menu][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[menu][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Branding</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[branding][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[branding][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[branding][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[branding][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>Brands</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[brands][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[brands][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[brands][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[brands][remove][]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <p>App Builds</p>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[versions][view][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[versions][add][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[versions][edit][]">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[versions][remove][]">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <button class="btn btn-primary" id="savePermissions">Save Permissions</button>
    </div>
</div>