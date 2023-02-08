<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>
<div class="row">
    <div class="col-sm-4">
        <div id="actions" class="row ml-4" style="display: none">
            <p id="infoSelect" class="mr-2"></p>
            <a href="#">Delete</a>
        </div>
        <div class="card m-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col"><input id="check-all" type="checkbox" class="checkbox-lg"></th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                        <td>stuff here</td>
                        <td>Send Date Here</td>
                    </tr>
                    <tr>
                    <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                        <td>stuff here</td>
                        <td>Send Date Here</td>
                    </tr>
                    <tr>
                    <th scope="row"><input type="checkbox" class="checkbox-lg"></th>
                        <td>stuff here</td>
                        <td>Send Date Here</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-8 mt-3">
        <div class="card m-2 p-2">
            <form>
                <div class="form-group row">
                    <label for="title" class="col-sm-3 col-form-label">Notification Title</label>
                    <input type="text" class="form-control col-sm-8" id="title" placeholder="Check out this new thing!">
                </div>
                <div class="form-group row">
                    <label for="text" class="col-sm-3 col-form-label">Notification Description</label>
                    <input type="textarea" class="form-control col-sm-8" id="text" placeholder="New shop item out now! Click to see!" aria-describedby="description">
                    <small id="description" class="form-text text-muted col-sm-1">
                        Optional
                    </small>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-sm-3 col-form-label">Notification Click Action</label>

                    <select class="custom-select col-sm-8">
                        <option selected value="nothing">None</option>
                        <option value="app">Open the App</option>
                        <option value="link">Force Change Wallpaper</option>
                        <option value="link">Go to Custom link</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="custom-control custom-switch col-sm-8">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Force new Wallpaper</label>
                    </div>
                </div>
                <div class="row float-left">
                    <button class="btn btn-primary m-2 ml-3">Notify Now</button>
                    <button class="btn btn-primary m-2">Schedule Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>