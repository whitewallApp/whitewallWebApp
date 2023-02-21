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

  <div class="container row justify-content-center">
    <div class="form-check mr-4">
      <input class="form-check-input" type="radio" name="exampleRadios" id="linkRadio" value="option1">
      <label class="form-check-label" for="linkRadio">
        Link
      </label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="exampleRadios" id="fileRadio" value="option1">
      <label class="form-check-label" for="fileRadio">
        File
      </label>
    </div>
  </div>

    <div class="form-group" id="linkDiv" style="display: none">
      <input type="text" class="form-control" id="imageLink" placeholder="https://yoursite.com/Image">
    </div>
    <div class="form-group" id="fileDiv" style="display: none">
      <div class="custom-file">
          <input type="file" class="custom-file-input" id="imageFile">
          <label id="imageFileText" class="custom-file-label" for="imageFile">File Upload</label>
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