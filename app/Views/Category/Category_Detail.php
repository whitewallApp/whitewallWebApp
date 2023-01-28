<?= $this->extend('Category/Category_List') ?>

<?= $this->section('Detail') ?>
<form class="mr-4">
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Category Name">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Description</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="This is a cool group of Collections">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Link to Category</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="https://yoursite.com/category">
  </div>
  <div class="form-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Icon Image</label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <button class="btn btn-primary">View Collections in Category</button>
</form>
<?= $this->endSection() ?>