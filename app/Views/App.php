<div class="p-5">
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col" colspan="2"></th>
                <th scope="col" colspan="3">Android</th>
                <!-- <th scope="col" colspan="3">IOS</th> -->
            </tr>
            <tr>
                <th scope="col" class="border-right">Version Name</th>
                <th scope="col" class="border-right">Action/Status</th>
                <th scope="col">Compiled Date</th>
                <!-- <th scope="col">Action/Status</th>
                <th scope="col">Compiled Date</th>
                <th scope="col">Published Date</th> -->
            </tr>
        </thead>
        <tbody class="table-group-divider table-divider-color">
            <tr>
                <th scope="row">Workspace</th>
                <td>
                    <div class="row">
                        <div class="col">
                            <p>In Progress</p>
                        </div>
                        <div class="col" id="androidModelButton">
                            <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#androidModal">Compile</button>
                        </div>
                        <?php if ($admin) : ?><a href="/app/logs">View Log Fiile</a><?php endif ?>
                    </div>
                </td>
                <td>Why Not Today</td>
                <!-- <td>
                    <div class="row">
                        <div class="col">
                            <p>In Progress</p>
                        </div>
                        <div class="col" id="iosModelButton">
                            <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#iosModal">Compile</button>
                        </div>
                        <div class="row" id="iosButtons" style="display: none;">
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="iosDownloadButton">Download Now</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="iosPublishButton">Mark as Published</button>
                            </div>
                        </div>
                    </div>
                </td>
                <td>N/A</td>
                <td>N/A</td> -->
            </tr>
            <tr <?= !$aabExists ? ('style="display: none;"') : ('') ?>>
                <th scope="row"><?= $name ?></th>
                <td>
                    <div class="row">
                        <div class="col">
                            <p>Download Now</p>
                        </div>
                        <div class="row" id="androidButtons">
                            <div class="col" <?= !$apkExists ? ('style="display: none;"') : ('') ?>>
                                <a href="/assets/app/release/apk" download="app-release.apk"><button type="button" class="btn btn-primary" id="androidDownloadButton">Download Test APK</button></a>
                            </div>
                            <div class="col" <?= !$aabExists ? ('style="display: none;"') : ('') ?>>
                                <a href="/assets/app/release/aab" download="app-release.aab"><button type="button" class="btn btn-primary" id="androidPublishButton">Download App Bundle (aab)</button></a>
                            </div>
                        </div>
                    </div>
                </td>
                <td><?= $updatedDate ?></td>
                <!-- <td>
                    <div class="row">
                        <div class="col">
                            <p>In Progress</p>
                        </div>
                        <div class="col" id="iosModelButton">
                            <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#iosModal">Compile</button>
                        </div>
                        <div class="row" id="iosButtons" style="display: none;">
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="iosDownloadButton">Download Now</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="iosPublishButton">Mark as Published</button>
                            </div>
                        </div>
                    </div>
                </td>
                <td>N/A</td>
                <td>N/A</td> -->
            </tr>
        </tbody>
    </table>
</div>

<!-- Android Modal -->
<div class="modal right fade" id="androidModal" tabindex="-1" aria-labelledby="androidModalLabel" aria-hidden="true" data-mdb-backdrop="false" data-mdb-keyboard="true">
    <div class="modal-dialog modal-side modal-top-right ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="androidModalLabel">Compile For Android</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="androidInput">
                    <div class="form-outline">
                        <input type="text" id="androidVersionName" class="form-control" />
                        <label class="form-label" for="androidVersionName">Version Name</label>
                    </div>
                    <!-- <div class="form-outline">
                        <input type="text" id="androidAppName" class="form-control" />
                        <label class="form-label" for="androidAppName">App Name</label>
                    </div> -->
                </div>
                <div class="col" style="display: none;">
                    <p id="androidStatus"></p>
                    <div class="progress" style="height: 20px;">
                        <div id="androidLoading" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="androidcompileButton">Compile Now</button>
            </div>
        </div>
    </div>
</div>

<!-- IOS Modal -->
<div class="modal right fade" id="iosModal" tabindex="-1" aria-labelledby="iosModalLabel" aria-hidden="true" data-mdb-backdrop="false" data-mdb-keyboard="true">
    <div class="modal-dialog modal-side modal-top-right ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iosModalLabel">Compile for IOS</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="iosInput">
                    <div class="form-outline">
                        <input type="text" id="iosVersionName" class="form-control" />
                        <label class="form-label" for="iosVersionName">Version Name</label>
                    </div>
                    <div class="form-outline">
                        <input type="text" id="iosAppName" class="form-control" />
                        <label class="form-label" for="iosAppName">App Name</label>
                    </div>
                </div>
                <div class="col" style="display: none;">
                    <p id="iosStatus"></p>
                    <div class="progress" style="height: 20px">
                        <div id="iosLoading" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                    Close
                </button>
                <button id="ioscompileButton" type="button" class="btn btn-primary">Compile Now</button>
            </div>
        </div>
    </div>
</div>

<?php if ($subStatus == "active") : ?>
    <script src="js/app.js"></script>
<?php else : ?>
    <script>
        $("button").on("click", function() {
            window.location.href = "/billing"
        })
    </script>
<?php endif ?>