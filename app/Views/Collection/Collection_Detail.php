<?= $this->extend('Collection/Collection_List') ?>

<?= $this->section('Detail') ?>
<form class="mr-4">
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
    <label for="catSelect">Add to Category</label>
    <select class="form-control" id="catSelect">

    </select>
  </div>
  <div class="form-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label id="iconLabel" class="custom-file-label" for="customFile">Icon Image</label>
    </div>
  </div>
  <div class="float-right row">
    <p id="updated" class="mr-2"></p>
    <button id="submit" class="btn btn-primary mr-2">Save</button>
    <button id="delete" class="btn btn-danger mr-2">Remove</button>
  </div>
</form>
<?= $this->endSection() ?>