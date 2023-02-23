<?= $this->extend('Collection/Collection_List') ?>

<?= $this->section('Detail') ?>
<div class="row justify-content-center">
  <h2 id="data-title" class="mr-4"></h2>
  <button id="add-button" class="btn btn-primary" onclick="showData('/collections');">Add</button>
</div>
<form class="mr-4" id="data" style="display: none">
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
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Icon Image</label>
    </div>
  </div>
  <div class="form-group">
    <div id="img-icon" class="row m-2">
        <img id="icon" class="img-sm rounded mr-3">
        <button class="btn btn-primary">Change</button>
    </div>
  </div>
  <div class="float-right row">
    <p id="updated" class="mr-2"></p>
    <button id="submit" class="btn btn-primary mr-2">Save</button>
    <button id="delete" class="btn btn-danger mr-2">Remove</button>
  </div>
</form>
<?= $this->endSection() ?>