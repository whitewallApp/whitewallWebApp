// Adds an entry to our debug area
function ui_add_log(message, color) {
    var d = new Date();

    var dateString = (('0' + d.getHours())).slice(-2) + ':' +
        (('0' + d.getMinutes())).slice(-2) + ':' +
        (('0' + d.getSeconds())).slice(-2);

    color = (typeof color === 'undefined' ? 'muted' : color);

    var template = $('#debug-template').text();
    template = template.replace('%%date%%', dateString);
    template = template.replace('%%message%%', message);
    template = template.replace('%%color%%', color);

    $('#debug').find('li.empty').fadeOut(); // remove the 'no messages yet'
    $('#debug').prepend(template);
}

// Creates a new file and add it to our list
function ui_multi_add_file(id, file) {
    var template = $('#files-template').text();
    template = template.replace('%%filename%%', file.name).replace("%%id%%", id);

    template = $(template);
    template.prop('id', 'uploaderFile' + id);
    template.data('file-id', id);

    $('#files').find('li.empty').fadeOut(); // remove the 'no files yet'
    $('#files').prepend(template);
}

// Changes the status messages on our list
function ui_multi_update_file_status(id, status, message) {
    $('#uploaderFile' + id).find('span').eq(1).html(message).prop('class', 'status text-' + status);
}

// Updates a file progress, depending on the parameters it may animate it or change the color.
function ui_multi_update_file_progress(id, percent, color, active) {
    color = (typeof color === 'undefined' ? false : color);
    active = (typeof active === 'undefined' ? true : active);

    var bar = $('#uploaderFile' + id).find('div.progress-bar');

    bar.width(percent + '%').attr('aria-valuenow', percent);
    bar.toggleClass('progress-bar-striped progress-bar-animated', active);

    if (percent === 0) {
        bar.html('');
    } else {
        bar.html(percent + '%');
    }

    if (color !== false) {
        bar.removeClass('bg-success bg-info bg-warning bg-danger');
        bar.addClass('bg-' + color);
    }
}

function errorAdd(name){
    $("#errors").append(`<li class="status text-danger">ID: ${name}</li>`)
}

function scrollUp(){
    $("#files").parent()[0].scrollBy({
        top: -66,
        behavior: "smooth",
    });
}

function scrollTop(){
    $("#files").parent()[0].scrollBy({
        top: 0,
        behavior: "smooth",
    });
}

function scrollBottom(){
    element = $("#files").parent()[0];
    element.scrollBy({
        top: element.scrollHeight,
        behavior: "smooth",
    });
}

function change(id){
    $('.carousel').carousel(id - 1);
    for (i = 1; i<5; i++){
        if (i == id){
            $("#step" + i).addClass("active");
        }else{
            $("#step" + i).removeClass("active");
        }
    }
}

$(".next").on("click", function(){
    $('.carousel').carousel('next');
    $("#step" + ($(this).attr("set-active") - 1)).removeClass("active");
    $("#step" + $(this).attr("set-active")).addClass("active");
})

$("#download").on("click", function(){
    $('.carousel').carousel('next');
    $("#step2").removeClass("active");
    $("#step3").addClass("active");
})

