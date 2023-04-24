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
          <label class="form-label">Profile Picture</label>
        </div>
        <div class="col-8">
          <input type="file" class="form-control" id="profilePhoto" />
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-2">
        <label class="form-label">Default Brand</label>
      </div>
      <div class="col-8">
        <select class="form-select" aria-label="Default select example">
          <?php foreach($brands as $brand) : ?>
            <option value="<?=$brand["name"] ?>"><?= $brand["name"] ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2">
        <input type="button" class="form-control btn btn-primary" value="Save">
      </div>
    </div>
  </form>
</div>