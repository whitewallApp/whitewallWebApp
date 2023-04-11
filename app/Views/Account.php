<?= $this->extend('Navigation') ?>
<?= $this->section('MainPage') ?>
<div class="col-sm-8 mt-3">
  <form>
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-2 col-form-label">Chage Email</label>
      <div class="col-sm-8">
        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
      </div>
    </div>
    <div class="form-group" id="photoDiv">
      <div class="row row-col">
        <div class="col-2">
          <label class="form-label">Default file input example</label>
        </div>
        <div class="col-8">
          <input type="file" class="form-control" id="customFile" />
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label for="delete" class="col-sm-2 col-form-label">Delete Account</label>
      <div class="col-sm-2">
        <input type="button" class="form-control btn btn-danger" value="Delete">
      </div>
    </div>

  </form>
</div>
<?= $this->endSection() ?>