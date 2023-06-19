<?= $this->extend('Category/Category_List') ?>

<?= $this->section('Detail') ?>

<div id="form-div" <?php if (!$view[$pageName]["add"]) echo 'style="display: none;"' ?>>
  <div class="row">
    <div class="col-2">

    </div>
    <div class="col d-flex justify-content-center">
      <h2 id="data-title" class="mr-4">Add Category</h2>
    </div>
    <div class="col d-flex flex-row-reverse">

    </div>
  </div>
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
    </div>
  </form>
  <div class="float-right">
    <?php if ($view[$pageName]["edit"] || $view[$pageName]["add"]) : ?>
      <button type="submit" class="btn btn-primary" onclick="$('#categoryData').submit();">Add New Category</button>
    <?php endif ?>
    <?php if ($view[$pageName]["remove"]) : ?>
      <button class="btn btn-danger" id="remove" style="display: none;">Remove</button>
    <?php endif ?>
  </div>
  <div class="alert alert-success" role="alert" style="display: none;">
    Success
  </div>
  <div class="alert alert-danger" role="alert" style="display: none;">
  </div>
</div>
<?= $this->endSection() ?>