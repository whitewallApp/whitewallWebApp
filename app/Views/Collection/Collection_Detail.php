<?= $this->extend('Collection/Collection_List') ?>

<?= $this->section('Detail') ?>

<div id="form-div" <?php if (!$view[$pageName]["add"]) echo 'style="display: none;"' ?>>
  <div class="row">
    <div class="col-2">

    </div>
    <div class="col d-flex justify-content-center">
      <h2 id="data-title" class="mr-4">Add Collection</h2>
    </div>
    <div class="col d-flex flex-row-reverse">

    </div>
  </div>
  <form class="mr-4" id="collectionData">
    <div class="form-group">
      <label for="collName">Name</label>
      <input type="text" class="form-control" id="collName" aria-describedby="emailHelp" placeholder="Collection Name">
    </div>
    <div class="form-group">
      <label for="collDesc">Description</label>
      <input type="text" class="form-control" id="collDesc" placeholder="This is a cool group of Images">
    </div>
    <div class="form-check form-switch">
      <input class="form-check-input" type="checkbox" role="switch" id="active" />
      <label class="form-check-label" for="active">Active</label>
    </div>
    <div class="form-group">
      <label for="collLink">Link to Collection</label>
      <input type="text" class="form-control" id="collLink" placeholder="https://yoursite.com/Collection">
    </div>
    <div class="form-group">
      <label for="select">Add to Category</label>
      <select class="form-control" id="select">
        <?php foreach ($categories as $category) : ?>
          <option value="<?= $category ?>"><?= $category ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <div id="file-icon" class="custom-file">
        <input type="file" class="custom-file-input" id="collfile">
        <label class="custom-file-label" for="collfile" id="collfileText">Icon Image</label>
      </div>
    </div>
  </form>
  <div class="float-right">
    <p id="updated" class="mr-2"></p>
    <?php if ($view[$pageName]["edit"] || $view[$pageName]["add"]) : ?>
      <button id="save" class="btn btn-primary mr-2" onclick="$('#collectionData').submit();">Add New Collection</button>
    <?php endif ?>
    <?php if ($view[$pageName]["remove"]) : ?>
      <button id="remove" class="btn btn-danger mr-2" style="display: none">Remove</button>
    <?php endif ?>
  </div>
  <div class="alert alert-success" role="alert" style="display: none;">
    Success
  </div>
  <div class="alert alert-danger" role="alert" style="display: none;">
  </div>
</div>
<?= $this->endSection() ?>