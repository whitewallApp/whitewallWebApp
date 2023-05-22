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