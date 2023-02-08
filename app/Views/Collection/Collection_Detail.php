<?= $this->extend('Collection/Collection_List') ?>

<?= $this->section('Detail') ?>
<form class="mr-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Collection Name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Description</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="This is a cool group of Images">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Link to Collection</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="https://yoursite.com/Collection">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Add to Category</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Icon Image</label>
    </div>
  </div>
  <div class="float-right">
    <button type="submit" class="btn btn-primary">Save</button>
    <button class="btn btn-danger">Remove</button>
  </div>
</form>
<?= $this->endSection() ?>