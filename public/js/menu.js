$("#linkRadio").on("click", function(){
    $("#customRadio").prop("checked", false);
    $("#linkDiv").show();
    $("#customDiv").hide();
})

$("#customRadio").on("click", function () {
    $("#linkRadio").prop("checked", false);
    $("#linkDiv").hide();
    $("#customDiv").show();
})