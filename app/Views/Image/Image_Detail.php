<?= $this->extend('Image/Image_List') ?>

<?= $this->section('Detail') ?>
<form class="mr-4">
  <div class="form-group">
    <label for="imageName">Name</label>
    <input type="text" class="form-control" id="imageName" aria-describedby="imageName" placeholder="Image Name">
  </div>
  <div class="form-group">
    <label for="imageDesc">Description</label>
    <input type="text" class="form-control" id="imageDesc" aria-describedby="imageDescription" placeholder="Image Name">
  </div>
  <div class="form-group">
    <label for="imageLink">Link to Image</label>
    <input type="text" class="form-control" id="imageLink" placeholder="https://yoursite.com/Image">
  </div>
  <div class="form-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="imageFile">
        <label class="custom-file-label" for="imageFile">File Upload</label>
    </div>
  </div>
  <div class="form-group">
    <label for="collSelect">Add to Collection</label>
    <select class="form-control" id="collSelect">
      
    </select>
  </div>
  <div class="float-right row">
    <p id="updated" class="mr-2"></p>
    <button id="submit" class="btn btn-primary mr-2">Save</button>
    <button id="delete" class="btn btn-danger mr-2">Remove</button>
  </div>
</form>
<?= $this->endSection() ?>