$("#selections").on("change", function(){
    selected = $("#selections").val();
    
    if (selected == "Link"){
        $("#link-input").show();
        $("#app-input").hide();
        $("#app").hide();
    }

    if (selected == "App"){
        $("#link-input").hide();
        $("#app-input").show();
        $("#app").hide();
    }

    if (selected == "Wallpaper"){
        $("#link-input").hide();
        $("#app-input").hide();
        $("#app").show();

        //load in defaults
        categoryNames = Object.keys(categories);
        categoryNames.forEach(name => {
            $("#cat-select").append(`<option value="${name}">${name}</option>`);
        });
    }

    if (selected == "None"){
        $("#link-input").hide();
        $("#app-input").hide();
        $("#app").hide();
        $("#menu").hide();
    }
})

$("#appRadio").on('click', function(){
    $("#menuRadio").prop("checked", false);
    $("#menu").hide();
    $("#app").show();

    //clear the select box
    $("#img-select").empty();
    $("#img-select").append(`<option value="parent">Link to Parent Collection</option>`);

    //clear the select box
    $("#col-select").empty();
    $("#col-select").append(`<option value="parent">Link to Parent Category</option>`);

    //load in defaults
    categoryNames = Object.keys(categories);
    categoryNames.forEach(name => {
        $("#cat-select").append(`<option value="${name}">${name}</option>`);
    });

});

$("#menuRadio").on('click', function(){
    $("#appRadio").prop("checked", false);
    $("#menu").show();
    $("#app").hide();
})

$("#cat-select").on("change", function(){
    category = $("#cat-select").val();
    collections = Object.keys(categories[category]);

    //clear the select box
    $("#col-select").empty();
    $("#col-select").append(`<option value="parent" selected>Link to Parent Category</option>`);

    //clear the select box
    $("#img-select").empty();
    $("#img-select").append(`<option value="parent" selected>Link to Parent Collection</option>`);

    //load in defaults
    collections.forEach(name => {
        $("#col-select").append(`<option value="${name}">${name}</option>`);
    });
})

$("#col-select").on("change", function(){
    collection = $("#col-select").val();
    category = $("#cat-select").val();

    images = categories[category][collection];

    //clear the select box
    $("#img-select").empty();
    $("#img-select").append(`<option value="parent">Link to Parent Collection</option>`);

    //load in defaults
    images.forEach(name => {
        $("#img-select").append(`<option value="${name}">${name}</option>`);
    });
})

$("#force-switch").on("change", function(){
    checked = $("#force-switch").prop("checked");

    if (checked){
        $("#force-select-div").show();
        $("#force-option").hide();
        if ($("#selections").val() == "Wallpaper"){
            $('#selections>option[value=None]').prop("selected", true);
            $("#app").hide();
        }
    }else{
        $("#force-select-div").hide();
        $("#force-option").show();
    }
})