<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>
<div class="container w-50">
    <div class="card p-4 m-5">
        <form class="needs-validation">
            <!-- Email input -->
            <div class="row">
                <div class="col-11">
                    <div class="form-outline mb-4">
                        <input type="password" id="password" class="form-control" />
                        <label class="form-label" for="password">New Password</label>
                    </div>
                </div>
                <div class="col-1">
                    <i id="passwordView" style="font-size:x-large; cursor: pointer;" class="bi bi-eye"></i>
                </div>
            </div>

            <div class="row">
                <div class="col-11">
                    <div class="form-outline mb-4">
                        <input type="password" id="confirmPassword" class="form-control" />
                        <label class="form-label" for="confirmPassword">New Password</label>
                    </div>
                </div>
                <div class="col-1">
                    <i id="confirmView" style="font-size:x-large; cursor: pointer;" class="bi bi-eye"></i>
                </div>
            </div>

            <div class="col mb-4">
                <!-- Checkbox -->
                <div class="form-check" style="pointer-events: none;">
                    <input class="form-check-input" type="checkbox" value="" id="chars" />
                    <label class="form-check-label" for="chars">At least 8 characters</label>
                </div>
                <div class="form-check" style="pointer-events: none;">
                    <input class="form-check-input" type="checkbox" value="" id="symbol" />
                    <label class="form-check-label" for="symbol">At least 1 symbol</label>
                </div>
                <div class="form-check" style="pointer-events: none;">
                    <input class="form-check-input" type="checkbox" value="" id="number" />
                    <label class="form-check-label" for="number">At least 1 number</label>
                </div>
                <div class="form-check" style="pointer-events: none;">
                    <input class="form-check-input" type="checkbox" value="" id="capital" />
                    <label class="form-check-label" for="capital">At least 1 capital letter</label>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block" disabled>Save New Password</button>
        </form>
    </div>
</div>
<script src="/js/reset.js"></script>
<?= $this->endSection(); ?>