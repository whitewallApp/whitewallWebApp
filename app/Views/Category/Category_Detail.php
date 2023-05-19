<?= $this->extend('Category/Category_List') ?>

<?= $this->section('Detail') ?>
<div class="row">
  <div class="col d-flex justify-content-center">
    <h2 id="data-title" class="mr-4"></h2>
    <button id="add-button" class="btn btn-primary" onclick="showData('/categories');">Add</button>
  </div>
</div>
<div id="form-div" style="display: none">
  <form id="categoryData" class="mr-4">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Category Name">
    </div>
    <div class="form-group">
      <label for="desc">Description</label>
      <input type="text" class="form-control" id="desc" placeholder="This is a cool group of Collections">
    </div>
    <div class="form-group">
      <label for="link">Link to Category</label>
      <input type="text" class="form-control" id="link" placeholder="https://yoursite.com/category">
    </div>
    <div class="form-group">
      <div id="fileDiv" class="custom-file">
        <input type="file" class="custom-file-input" id="file">
        <label class="custom-file-label" for="file">Icon Image</label>
      </div>
      <div id="img-icon" class="row m-2">
        <img id="icon" class="img-sm rounded mr-3">
        <button class="btn btn-primary">Change</button>
      </div>
    </div>
    <div class="float-right">
      <button type="submit" class="btn btn-primary">Save</button>
      <button class="btn btn-danger">Remove</button>
    </div>
  </form>
</div>
<?= $this->endSection() ?>