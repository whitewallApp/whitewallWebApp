$("#categoryColor").on("input", function(e){
    color = $(this).val();
})

$("#categoryFontColor").on("input", function (e) {
    color = $(this).val();
    $(".row.bottom-nav").css("color", color)
})

$("#catFontSize").on("input", function (e) {
    size = $(this).val();
    $(".row.bottom-nav").css("font-size", size+"px")
})

$("#catFontStyle").on("input", function (e) {
    fontType = $(this).val();
    if (fontType == "bold"){
        $(".row.bottom-nav").css("font-weight", fontType)
        $(".row.bottom-nav").css("font-style", "normal")
    }else{
        $(".row.bottom-nav").css("font-weight", "normal")
        $(".row.bottom-nav").css("font-style", fontType)
    }
})

$("#catFont").on("input", function (e) {
    font = $(this).val();
    $(".row.bottom-nav").css("font-family", font)
})

$("#backgroundColor").on("input", function(e){
    color = $(this).val();
    $(".background-phone-collection").css("background-color", color);
})

// Collection & Image Labels
$("#imgCollabelFont").on("input", function(){
    $(".collection-title").css("font-family", $(this).val());
    $(".image-title").css("font-family", $(this).val());
})

$("#collImgLabelFontColor").on("input", function(){
    $(".collection-title").css("color", $(this).val());
    $(".image-title").css("color", $(this).val());
})

$("#imgCollabelFontStyle").on("input", function(){
    fontType = $(this).val();
    if (fontType == "bold") {
        $(".collection-title").css("font-weight", fontType)
        $(".collection-title").css("font-style", "normal")

        $(".image-title").css("font-weight", fontType)
        $(".image-title").css("font-style", "normal")
    } else {
        $(".collection-title").css("font-weight", "normal")
        $(".collection-title").css("font-style", fontType)

        $(".image-title").css("font-weight", "normal")
        $(".image-title").css("font-style", fontType)
    }
})

$("#imgCollabelFontsize").on("input", function(){
    $(".collection-title").css("font-size", $(this).val()+"px");
    $(".image-title").css("font-size", $(this).val()+"px");
})

//Dropdown
$("#dropdownFontsize").on("input", function(){
    $(".custom-select-sm").css("font-size", $(this).val()+"px");
})

$("#dropdownFontStyle").on("input", function(){
    fontType = $(this).val();
    if (fontType == "bold") {
        $(".custom-select-sm").css("font-weight", fontType)
        $(".custom-select-sm").css("font-style", "normal")
    } else {
        $(".custom-select-sm").css("font-weight", "normal")
        $(".custom-select-sm").css("font-style", fontType)
    }
})

$("#dropdownFontColor").on("input", function(){
    $(".custom-select-sm").css("color", $(this).val());
})

$("#dropdownFont").on("input", function(){
    $(".custom-select-sm").css("font-family", $(this).val());
})

$("#dropdownColor").on("input", function(){
    $(".custom-select-sm").css("background-color", $(this).val());
})

//checkmark
