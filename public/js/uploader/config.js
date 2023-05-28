$(function () {
    /*
     * For the sake keeping the code clean and the examples simple this file
     * contains only the plugin configuration & callbacks.
     * 
     * UI functions ui_* can be located in: demo-ui.js
     */
    $('#drag-and-drop-zone').dmUploader({ //
        url: '/images/upload',
        maxFileSize: 15000000, // 3 Megs
        onDragEnter: function () {
            // Happens when dragging something over the DnD area
            this.addClass('active');
        },
        onDragLeave: function () {
            // Happens when dragging something OUT of the DnD area
            this.removeClass('active');
        },
        onInit: function () {
            // Plugin is ready to use
            ui_add_log('Plugin Initilized', 'info');
        },
        onComplete: function () {
            // All files in the queue are processed (success or error)
            ui_add_log('All pending tranfers finished');
        },
        onNewFile: function (id, file) {
            // When a new file is added using the file selector or the DnD area
            ui_add_log('New file added ' + file.name + " ID: " + id);
            ui_multi_add_file(id, file);
        },
        onBeforeUpload: function (id) {
            // about tho start uploading a file
            ui_add_log('Starting the upload of #' + id);
            ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            ui_multi_update_file_progress(id, 0, '', true);
        },
        onUploadCanceled: function (id) {
            // Happens when a file is directly canceled by the user.
            ui_multi_update_file_status(id, 'warning', 'Canceled by User');
            ui_multi_update_file_progress(id, 0, 'warning', false);
        },
        onUploadProgress: function (id, percent) {
            // Updating file progress
            ui_multi_update_file_progress(id, percent);
        },
        onUploadSuccess: function (id, data) {
            // A file was successfully uploaded
            ui_add_log('Server Response for file #' + id + ': ' + JSON.stringify(JSON.parse(data)));
            ui_add_log('Upload of file #' + id + ' COMPLETED', 'success');
            ui_multi_update_file_status(id, 'success', 'Upload Complete');
            ui_multi_update_file_progress(id, 100, 'success', false);
        },
        onUploadError: function (id, xhr, status, message) {
            ui_multi_update_file_status(id, 'danger', xhr.responseText);
            ui_multi_update_file_progress(id, 0, 'danger', false);
        },
        onFallbackMode: function () {
            // When the browser doesn't support this plugin :(
            ui_add_log('Plugin cant be used here, running Fallback callback', 'danger');
        },
        onFileSizeError: function (file) {
            ui_add_log('File \'' + file.name + '\' cannot be added: size excess limit', 'danger');
        }
    });

    var uploader = 

    $("#csv-upload").dmUploader({
        url: '/images/upload',
        maxFileSize: 15000000,
        multiple: false,
        extFilter: ["csv", "xlsx"],
        extraData: function() {
            return { overwrite: $("#overwriteRadio").prop("checked")}
        },
        onNewFile: function(id, file){
            var template = $('#files-template').text();
            template = template.replace('%%filename%%', file.name).replace("%%id%%", id);

            template = $(template);
            template.prop('id', 'uploaderFile' + id);
            template.data('file-id', id);

            $('#csvFile').empty();
            $('#csvFile').find('li.empty').fadeOut(); // remove the 'no files yet'
            $('#csvFile').prepend(template);

            ui_multi_update_file_progress(id, 0, '', true);
        },
        onUploadProgress: function(id, percent){
            ui_multi_update_file_progress(id, percent);
        },
        onUploadSuccess: function(id, data){
            ui_multi_update_file_status(id, 'success', 'Upload Complete');
            ui_multi_update_file_progress(id, 100, 'success', true);
        },
        onFileExtError: function(file){
            template = '<li class="media"><span class="status text-danger">File is not the correct type</span></li>'
            $('#csvFile').find('li.empty').fadeOut(); // remove the 'no files yet'
            $('#csvFile').prepend(template);
        },
        onFallbackMode: function () {
            // When the browser doesn't support this plugin :(
            console.log("hello");
        },
        onUploadError: function (id, xhr, status, message){
            errors = JSON.parse(JSON.parse(xhr.responseText));
            ui_multi_update_file_status(id, 'danger', "Error");
            ui_multi_update_file_progress(id, 0, 'danger', false);
            errors.forEach(element => {
                $("#csvFile").append(`<li class="text-danger">Image: ${element.image} Error: ${element.message}</li>`);
            });
        }
    });
});

$("#allRadio").on("click", function(){
    $("#download").prop("href", "/images/upload/csv/all")
    $("#detailRadio").prop("checked", false);
});
$("#detailRadio").on("click", function () {
    $("#download").prop("href", "/images/upload/csv/detail")
    $("#allRadio").prop("checked", false);
});

$("#safeRadio").on("click", function () {
    $("#overwriteRadio").prop("checked", false);
});
$("#overwriteRadio").on("click", function () {
    $("#safeRadio").prop("checked", false);
});