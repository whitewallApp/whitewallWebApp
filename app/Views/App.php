<div class="p-5">
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col" colspan="2"></th>
                <th scope="col" colspan="3">Android</th>
                <th scope="col" colspan="3">IOS</th>
            </tr>
            <tr>
                <th scope="col">Version Name</th>
                <th scope="col" class="border-right">Last Modified Date</th>
                <th scope="col">Action/Status</th>
                <th scope="col">Compiled Date</th>
                <th scope="col" class="border-right">Published Date</th>
                <th scope="col">Action/Status</th>
                <th scope="col">Compiled Date</th>
                <th scope="col">Published Date</th>
            </tr>
        </thead>
        <tbody class="table-group-divider table-divider-color">
            <tr>
                <th scope="row">Workspace</th>
                <td class="border-right">Mar 25 2018</td>
                <td>
                    <div class="row">
                        <div class="col">
                            <p>In Progress</p>
                        </div>
                        <div class="col" id="androidModelButton">
                            <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#androidModal">Compile</button>
                        </div>
                        <div class="row" id="androidButtons" style="display: none;">
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="androidDownloadButton">Download Now</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="androidPublishButton">Mark as Published</button>
                            </div>
                        </div>
                    </div>
                </td>
                <td>N/A</td>
                <td class="border-right">N/A</td>
                <td>
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
                <td>N/A</td>
            </tr>
            <tr>
                <th scope="row">1.2.3</th>
                <td class="border-right">May 10 2015</td>
                <td>Active</td>
                <td>May 25 2015</td>
                <td class="border-right">May 26 2015</td>
                <td>Active</td>
                <td>May 25 2015</td>
                <td>May 26 2015</td>
            </tr>
            <tr>
                <th scope="row">1.1.3</th>
                <td class="border-right">Jan 8 2015</td>
                <td>Inactive</td>
                <td>Jan 9 2015</td>
                <td class="border-right">Jan 10 2015</td>
                <td>Inactive</td>
                <td>Jan 9 2015</td>
                <td>Jan 10 2015</td>
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
                <div class="form-outline" id="androidInput">
                    <input type="text" id="androidVersionName" class="form-control" />
                    <label class="form-label" for="androidVersionName">Version Name</label>
                </div>
                <div class="progress" style="height: 20px; display: none;">
                    <div id="androidLoading" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
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
                <div class="form-outline" id="iosInput">
                    <input type="text" id="iosVersionName" class="form-control" />
                    <label class="form-label" for="iosVersionName">Version Name</label>
                </div>
                <div class="progress" style="height: 20px; display: none;">
                    <div id="iosLoading" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
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