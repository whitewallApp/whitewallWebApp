$(function(){
    branding = {
        background: {},
        categories: {},
        cards: {frames: {}, images: {}},
        dropdowns: {},
        checkmarks: {},
        buttons: {}
    };
})
$("#categoryColor").on("input", function(e){
    color = $(this).val();
    branding.categories.backgroundcolor = $(this).val();
})

$("#categoryFontColor").on("input", function (e) {
    color = $(this).val();
    $(".row.bottom-nav").css("color", color)
    branding.categories.fontcolor = $(this).val();
})

$("#catFontSize").on("input", function (e) {
    size = $(this).val();
    $(".row.bottom-nav").css("font-size", size+"px")
    branding.categories.fontsize = $(this).val();
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
    branding.categories.fontstyle = $(this).val();
})

$("#catFont").on("input", function (e) {
    font = $(this).val();
    $(".row.bottom-nav").css("font-family", font)
    branding.categories.font = $(this).val();
})

background = {};
$("#backgroundColor").on("input", function(e){
    color = $(this).val();
    $(".background-phone-collection").css("background-color", color);
    branding.background.color = $(this).val();
})

imagecolLabels = {};
// Collection & Image Labels
$("#imgCollabelFont").on("input", function(){
    $(".collection-title").css("font-family", $(this).val());
    $(".image-title").css("font-family", $(this).val());
    branding.cards.font = $(this).val();
})

$("#collImgLabelFontColor").on("input", function(){
    $(".collection-title").css("color", $(this).val());
    $(".image-title").css("color", $(this).val());
    branding.cards.fontcolor = $(this).val();
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
    branding.cards.fontstyle = $(this).val();
})

$("#imgCollabelFontsize").on("input", function(){
    $(".collection-title").css("font-size", $(this).val()+"px");
    $(".image-title").css("font-size", $(this).val()+"px");
    branding.cards.fontsize = $(this).val();
})

dropdowns = {};
//Dropdown
$("#dropdownFontsize").on("input", function(){
    $(".custom-select-sm").css("font-size", $(this).val()+"px");
    branding.dropdowns.fontsize = $(this).val();
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
    branding.dropdowns.fontstyle = $(this).val();
})

$("#dropdownFontColor").on("input", function(){
    $(".custom-select-sm").css("color", $(this).val());
    branding.dropdowns.fontcolor = $(this).val();
})

$("#dropdownFont").on("input", function(){
    $(".custom-select-sm").css("font-family", $(this).val());
    branding.dropdowns.font = $(this).val();
})

$("#dropdownColor").on("input", function(){
    $(".custom-select-sm").css("background-color", $(this).val());
    branding.dropdowns.backgroundcolor = $(this).val();
})

checkmarks = {};
//checkmark
$("#checkmarkColor").on("input", function(){
 //TODO: make a custom checkbox
})

$("#checkmarkBackground").on("input", function(){
    // console.log($(this).val() + " !important");
    color = $(this).val();
    array = $(".checkbox-branding:checked")
    for (let i = 0; i < array.length; i++) {
        const element = array[i];
        element.style.setProperty('background-color', color, 'important');
        element.style.setProperty('border-color', color, 'important');
    }
    branding.checkmarks.backgroundcolor = $(this).val();
})

imagecol = {};
//image and collection images
$("#imgBorderRadius").on("input", function(){
    $(".img-branding").css("border-radius", $(this).val()+"px");
    branding.cards.images.borderRadius = $(this).val();
})

$("#imgBorderWidth").on("input", function(){
    $(".img-branding").css("border", $(this).val() + "px solid");
    branding.cards.images.borderWidth = $(this).val();
})

$("#borderColor").on("input", function(){
    $(".img-branding").css("border-color", $(this).val());
    branding.cards.images.borderColor = $(this).val();
})

imagecolFrame = {};
//image & collection cards/frams
$("#collBorderColor").on("input", function(){
    $(".card-branding").css("border-color", $(this).val());
    branding.cards.frames.borderColor = $(this).val();
})

$("#frameBorderWidth").on("input", function(){
    $(".card-branding").css("border", $(this).val() + "px solid");
    branding.cards.frames.borderWidth = $(this).val();
})

$("#frameRadius").on("input", function(){
    $(".card-branding").css("border-radius", $(this).val() + "px");
    branding.cards.frames.borderRadius = $(this).val();
})

$("#collBackgroundColor").on("input", function(){
    $(".card-branding").css("background-color", $(this).val());
    branding.cards.backgroundcolor = $(this).val();
})

buttons = {};
//buttons
$("#buttonFontSize").on("input", function(){
    $(".btn-branding").css("font-size", $(this).val() + "px");
    branding.buttons.fontsize = $(this).val();
})

$("#buttonFontStyle").on("input", function(){
    fontType = $(this).val();
    if (fontType == "bold") {
        $(".btn-branding").css("font-weight", fontType)
        $(".btn-branding").css("font-style", "normal")
    } else {
        $(".btn-branding").css("font-weight", "normal")
        $(".btn-branding").css("font-style", fontType)
    }
    branding.buttons.fontstyle = $(this).val();
})

$("#buttonFontColor").on("input", function(){
    $(".btn-branding").css("color", $(this).val());
    branding.buttons.fontcolor = $(this).val();
})

$("#buttonFont").on("input", function(){
    $(".btn-branding").css("font-family", $(this).val());
    branding.buttons.font = $(this).val();
})

$("#buttonBorderRadius").on("input", function(){
    $(".btn-branding").css("border-radius", $(this).val() + "px");
    branding.buttons.borderRadius = $(this).val();
})

$("#buttonColor").on("input", function(){
    $(".btn-branding").css("background-color", $(this).val());
    branding.buttons.borderColor = $(this).val();
})

