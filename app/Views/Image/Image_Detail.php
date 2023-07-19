<?= $this->extend('Image/Image_List') ?>

<?= $this->section('Detail') ?>

<div id="form-div" <?php if (!$view[$pageName]["add"]) echo 'style="display: none;"' ?>>
  <div class="row">
    <div class="col">

    </div>
    <div class="col d-flex justify-content-center">
      <h2 id="data-title" class="mr-4">Add Image</h2>
    </div>
    <div class="col d-flex flex-row-reverse">

    </div>
  </div>
  <form class="mr-4" id="data" action="/images/update" method="post">
    <div class="form-group">
      <label for="imageName">Name</label>
      <input type="text" class="form-control" id="imageName" aria-describedby="imageName" placeholder="Image Name" data-mdb-toggle="tooltip" data-mdb-placement="top" title="Tooltip on top">
    </div>
    <div class="form-group">
      <label for="imageDesc">Description</label>
      <input type="text" class="form-control" id="imageDesc" aria-describedby="imageDescription" placeholder="Image Description" aria-describedby="imageName" placeholder="Image Name" data-mdb-toggle="tooltip" data-mdb-placement="top" title="Tooltip on top">
    </div>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="form-check mr-4">
            <input class="form-check-input" type="radio" name="exampleRadios" id="linkRadio" value="option1" aria-describedby="imageName">
            <label class="form-check-label" for="linkRadio" placeholder="Image Name" data-mdb-toggle="tooltip" data-mdb-placement="top" title="Tooltip on top">
              External Link
            </label>
          </div>
        </div>
        <div class="col">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="exampleRadios" id="fileRadio" value="option1">
            <label class="form-check-label" for="fileRadio" aria-describedby="imageName" placeholder="Image Name" data-mdb-toggle="tooltip" data-mdb-placement="top" title="Tooltip on top">
              Uploaded File
            </label>
          </div>
        </div>
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

    <div class="card p-3 mt-3 mb-3">
      <h5>Call to Action</h5>
      <div class="form-group">
        <label for="actionText">Call To Action Text</label>
        <input type="text" class="form-control" id="actionText" value="Click here for Details ">

        <label for="actionLink">Call To Action Link</label>
        <input type="text" class="form-control" id="actionLink" placeholder="https://yoursite.com/image">
      </div>
    </div>

    <div class="form-group">
      <label for="select">Add to Collection</label>
      <select class="form-control" id="select" aria-describedby="imageName" placeholder="Image Name" data-mdb-toggle="tooltip" data-mdb-placement="top" title="Tooltip on top">
        <?php foreach ($collections as $collection) : ?>
          <option value="<?= $collection["name"] ?>"><?= $collection["name"] ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </form>
  <div class="float-right">
    <p id="updated" class="mr-2"></p>
    <?php if ($view[$pageName]["edit"] || $view[$pageName]["add"]) : ?>
      <button class="btn btn-primary mr-2" onclick="updateImage();" id="save">Add New Image</button>
    <?php endif ?>
    <?php if ($view[$pageName]["remove"]) : ?>
      <button class="btn btn-danger mr-2" id="remove" style="display: none;">Remove</button>
    <?php endif ?>
  </div>
  <div class="alert alert-success" role="alert" style="display: none;">
    Success
  </div>
  <div class="alert alert-danger" role="alert" style="display: none;">
  </div>
</div>
<?= $this->endSection() ?>