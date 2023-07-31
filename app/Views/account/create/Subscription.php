<?= $this->extend('Base') ?>

<?= $this->section('Body') ?>

<div class="container p-3">
    <div class="container mt-2 text-center">
        <div class="alert alert-info" role="alert">
            <h3>No Credit Card Needed to Create Account</h3>
        </div>
    </div>
    <div class="row">
        <!-- <div class="col">
            <div class="card  ">
                <div class="card-body col">
                    <h5 class="fw-bold">Whitewall Fixer-Upper</h5>
                    <p class="fw-light">
                        Some quick example text to build on the card title and make up the bulk of the
                        card's content.
                    </p>

                    <div class="row float-left">
                        <div class="col-sm-7">
                            <h2 class="card-title">$0.00</h2>
                        </div>
                        <div class="col-sm-5">
                            <p class="fw-light">Per Month</p>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100">Subscribe</button>

                    <p class="mt-3 mb-0 pb-0 fw-bold">This Includes:</p>
                    <ol class="list-group list-group-light list-group-numbered">
                        <li class="list-group-item">Up to 1000 Images</li>
                        <li class="list-group-item">No Apps</li>
                        <li class="list-group-item">One user</li>
                        <li class="list-group-item">One Brand</li>
                    </ol>
                </div>
            </div>
        </div> -->
        <div class="col">
            <div class="card  ">
                <div class="card-body col">
                    <h4 class="fw-bold">Whitewall Unicycle</h4>
                    <!-- <p class="fw-light">
                        Some quick example text to build on the card title and make up the bulk of the
                        card's content.
                    </p> -->

                    <div class="row float-left">
                        <div class="col-sm-8">
                            <h1 class="card-title">$24.95</h1>
                        </div>
                        <div class="col-sm-4">
                            <p class="fw-light">Per Month</p>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100" id="<?= $productIds["Whitewall Unicycle"] ?>">Create Account</button>

                    <p class="mt-3 mb-0 pb-0 fw-bold">This Includes:</p>
                    <ol class="list-group list-group-light list-group-numbered">
                        <li class="list-group-item">Up to 1000 Images</li>
                        <li class="list-group-item">Android Apps</li>
                        <li class="list-group-item">One user</li>
                        <li class="list-group-item">One Brand</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card  ">
                <div class="card-body col">
                    <h4 class="fw-bold">Whitewall Sedan</h4>
                    <!-- <p class="fw-light">
                        Some quick example text to build on the card title and make up the bulk of the
                        card's content.
                    </p> -->

                    <div class="row float-left">
                        <div class="col-sm-8">
                            <h1 class="card-title">$49.95</h1>
                        </div>
                        <div class="col-sm-4">
                            <p class="fw-light">Per Month</p>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100" id="<?= $productIds["Whitewall Sedan"] ?>">Create Account</button>

                    <p class="mt-3 mb-0 pb-0 fw-bold">This Includes:</p>
                    <ol class="list-group list-group-light list-group-numbered">
                        <li class="list-group-item">Up to 4000 Images</li>
                        <li class="list-group-item">Android Apps</li>
                        <li class="list-group-item">Up to 4 Users</li>
                        <li class="list-group-item">up to 4 Brands</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card  ">
                <div class="card-body col">
                    <h4 class="fw-bold">Whitewall Unlimited</h4>
                    <!-- <p class="fw-light">
                        Some quick example text to build on the card title and make up the bulk of the
                        card's content.
                    </p> -->

                    <div class="row float-left">
                        <div class="col-sm-8">
                            <h1 class="card-title">$79.95</h1>
                        </div>
                        <div class="col-sm-4">
                            <p class="fw-light">Per Month</p>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary w-100" id="<?= $productIds["Whitewall Unlimited"] ?>">Create Account</button>

                    <p class="mt-3 mb-0 pb-0 fw-bold">This Includes:</p>
                    <ol class="list-group list-group-light list-group-numbered">
                        <li class="list-group-item">Unlimited Images</li>
                        <li class="list-group-item">Android Apps</li>
                        <li class="list-group-item">Unlimited Users</li>
                        <li class="list-group-item">Unlimited Brands</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("button").on("click", function(e) {
        id = e.target.id
        <?php if (isset($credential)) : ?>
            $.post("/account/create", {
                id: id,
                page: "subscription",
                credential: "google"
            }, function(data, status) {
                $("body").html(data);
            });
        <?php else : ?>
            $.post("/account/create", {
                id: id,
                page: "subscription"
            }, function(data, status) {
                $("body").html(data);
            });
        <?php endif ?>
    })
</script>

<?= $this->endSection() ?>