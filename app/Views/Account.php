<div class="col-sm-8 mt-3">
  <form id="userForm" action="/account" method="post">
    <div class=" form-group row">
      <label for="email" class="col-sm-2 col-form-label"><?= PHP_OS ?></label>
      <div class="col-sm-8">
        <input type="email" class="form-control" id="email" value="<?= $email ?>" name="email">
      </div>
    </div>
    <div class="form-group" id="photoDiv">
      <div class="row row-col">
        <div class="col-2">
          <label class="form-label" for="profilePhoto">Profile Picture</label>
        </div>
        <div class="col-8">
          <input type="file" class="form-control" id="profilePhoto" name="profilePhoto" />
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-2">
        <label class="form-label">Default Brand</label>
      </div>
      <div class="col-8">
        <select class="form-select" aria-label="Default select example" name="brand">
          <?php foreach ($brands as $brand) : ?>
            <?php if ($brand["name"] == $default_brand) : ?>
              <option value="<?= $brand["name"] ?>" selected><?= $brand["name"] ?></option>
            <?php else : ?>
              <option value="<?= $brand["name"] ?>"><?= $brand["name"] ?></option>
            <?php endif ?>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2">
        <input type="submit" class="btn btn-primary" value="Submit">
      </div>
    </div>
  </form>
  <?php if ($success) : ?>
    <h1><span class="badge badge-success">Success</span></h1>
  <?php endif ?>
</div>