<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Dark Theme</h5>
                <form>
                    <div class="form-group row">
                        <label for="backgroundColor">Background Color</label>
                        <input type="color" class="form-control" id="backgroundColor">
                    </div>
                    <div class="form-group row">
                        <label for="surfaceColor">On Surface Color</label>
                        <input type="color" class="form-control" id="surfaceColor">
                    </div>
                    <div class="form-group row">
                        <label for="accentColor">Accent Color</label>
                        <input type="color" class="form-control" id="accentColor">
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Light Theme</h5>
                <form>
                    <div class="form-group row">
                        <label for="backgroundColor">Background Color</label>
                        <input type="color" class="form-control" id="backgroundColor">
                    </div>
                    <div class="form-group row">
                        <label for="surfaceColor">On Surface Color</label>
                        <input type="color" class="form-control" id="surfaceColor">
                    </div>
                    <div class="form-group row">
                        <label for="accentColor">Accent Color</label>
                        <input type="color" class="form-control" id="accentColor">
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