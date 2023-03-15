<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Light Theme</h5>
                <form>
                    <div class="form-group row">
                        <label for="backgroundColorLight">Background Color</label>
                        <input type="color" class="form-control" id="backgroundColorLight">
                    </div>
                    <div class="form-group row">
                        <label for="surfaceColorLight">On Surface Color</label>
                        <input type="color" class="form-control" id="surfaceColorLight">
                    </div>
                    <div class="form-group row">
                        <label for="accentColorLight">Accent Color</label>
                        <input type="color" class="form-control" id="accentColorLight">
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Dark Theme</h5>
                <form>
                    <div class="form-group row">
                        <label for="backgroundColorDark">Background Color</label>
                        <input type="color" class="form-control" id="backgroundColorDark">
                    </div>
                    <div class="form-group row">
                        <label for="surfaceColorDark">On Surface Color</label>
                        <input type="color" class="form-control" id="surfaceColorDark">
                    </div>
                    <div class="form-group row">
                        <label for="accentColorDark">Accent Color</label>
                        <input type="color" class="form-control" id="accentColorDark">
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="col">

        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Font</h5>
                <form>
                    <div class="form-group row">
                        <label for="fontSelect">Font</label>
                        <select class="form-control" id="fontSelect">
        
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<?= $this->endSection() ?>