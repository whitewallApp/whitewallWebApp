<?= $this->extend('Collection/Collection_List') ?>

<?= $this->section('Detail') ?>
<div class="row">
  <?php if ($view[$pageName]["add"]) : ?>
    <div class="col d-flex justify-content-center">
      <h2 id="data-title" class="mr-4"></h2>
      <button id="add-button" class="btn btn-primary" onclick="showData('/collections');">Add</button>
    </div>
  <?php endif ?>
</div>
<div id="form-div" style="display: none">
  <form class="mr-4" id="collectionData">
    <div class="form-group">
      <label for="collName">Name</label>
      <input type="text" class="form-control" id="collName" aria-describedby="emailHelp" placeholder="Collection Name">
    </div>
    <div class="form-group">
      <label for="collDesc">Description</label>
      <input type="text" class="form-control" id="collDesc" placeholder="This is a cool group of Images">
    </div>
    <div class="form-group">
      <label for="collLink">Link to Collection</label>
      <input type="text" class="form-control" id="collLink" placeholder="https://yoursite.com/Collection">
    </div>
    <div class="form-group">
      <label for="select">Add to Category</label>
      <select class="form-control" id="select">

      </select>
    </div>
    <div class="form-group">
      <div id="file-icon" class="custom-file">
        <input type="file" class="custom-file-input" id="collfile">
        <label class="custom-file-label" for="collfile" id="collfileText">Icon Image</label>
      </div>
    </div>
    <div class="form-group">
      <div id="img-icon" class="row m-2">
        <img id="icon" class="img-sm rounded mr-3">
        <button class="btn btn-primary">Change</button>
      </div>
    </div>
  </form>
  <div class="float-right">
    <p id="updated" class="mr-2"></p>
    <?php if ($view[$pageName]["edit"]) : ?>
      <button id="submit" class="btn btn-primary mr-2" onclick="$('#collectionData').submit();">Save</button>
    <?php endif ?>
    <?php if ($view[$pageName]["remove"]) : ?>
      <button id="remove" class="btn btn-danger mr-2">Remove</button>
    <?php endif ?>
  </div>
  <div class="alert alert-success" role="alert" style="display: none;">
    Success
  </div>
  <div class="alert alert-danger" role="alert" style="display: none;">
  </div>
</div>
<?= $this->endSection() ?>