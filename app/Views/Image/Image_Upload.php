<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Image Uploads</title>

    <!-- Custom styles -->
    <link href="/js/uploader/src/css/jquery.dm-uploader.css" rel="stylesheet">
</head>

<body>

    <main role="main" class="m-4">
        <div class="row">
            <div class="col-2">
                <ul class="list-group">
                    <li class="list-group-item active">
                        <h3>Step 1</h3><span class="text-muted">Upload Images</span>
                    </li>
                    <li class="list-group-item">
                        <h3>Step 2</h3><span class="text-muted">Download CSV</span>
                    </li>
                    <li class="list-group-item">
                        <h3>Step 3</h3><span class="text-muted">Edit CSV</span>
                    </li>
                    <li class="list-group-item">
                        <h3>Step 4</h3><span class="text-muted">Upload CSV</span>
                    </li>
                </ul>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-md-6 col-sm-12">

                        <!-- Our markup, the important part here! -->
                        <div id="drag-and-drop-zone" class="dm-uploader p-5">
                            <h3 class="mb-5 mt-5 text-muted">Drag &amp; drop files here</h3>

                            <div class="btn btn-primary btn-block mb-5">
                                <span>Open the file Browser</span>
                                <input type="file" title='Click to add Files' />
                            </div>
                        </div><!-- /uploader -->

                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card h-100">
                            <div class="card-header">
                                File List
                            </div>

                            <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
                                <li class="text-muted text-center empty">No files uploaded.</li>
                            </ul>
                        </div>
                    </div>
                </div><!-- /file list -->

                <div class="row">
                    <div class="col-12 m-4 d-flex justify-content-center">
                        <button class="btn btn-primary w-50">Next</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header">
                                Debug Messages
                            </div>

                            <ul class="list-group list-group-flush" id="debug">
                                <li class="list-group-item text-muted empty">Loading plugin....</li>
                            </ul>
                        </div>
                    </div>
                </div> <!-- /debug -->
            </div>
        </div>

    </main> <!-- /container -->

    <script src="/js/uploader/src/js/jquery.dm-uploader.js"></script>
    <script src="/js/uploader/ui.js"></script>
    <script src="/js/uploader/config.js"></script>

    <!-- File item template -->
    <script type="text/html" id="files-template">
        <li class="media">
            <div class="media-body mb-1">
                <p class="mb-2">
                    <strong>%%filename%%</strong> Id: <span class="text-muted">#%%id%%</span> Status: <span class="text-muted">Waiting</span>
                </p>
                <!-- <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div> -->
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <hr class="mt-1 mb-1" />
            </div>
        </li>
    </script>

    <!-- Debug item template -->
    <script type="text/html" id="debug-template">
        <li class="list-group-item text-%%color%%"><strong>%%date%%</strong>: %%message%%</li>
    </script>
</body>

</html>