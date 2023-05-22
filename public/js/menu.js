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

function getMenu(e){

    $.post("/menu", {
        id: e.id
    }, function(data, status){
        menuItem = JSON.parse(data);

        $("#menuData").attr("menu-id", menuItem.id);
        $("#title").val(menuItem.title);
        $(`#s-select>option[value="${menuItem.sequence}"`).prop("selected", true);

        if (menuItem.target == "1"){
            $("#customRadio").prop("checked", false);
            $("#customDiv").hide();

            $("#linkRadio").prop("checked", true);
            $("#linkDiv").show();

            $("#link").val(menuItem.externalLink);
        }else{
            $("#customRadio").prop("checked", true);
            $("#customDiv").show();

            $("#linkRadio").prop("checked", false);
            $("#linkDiv").hide();

            $(".fr-wrapper").removeClass("show-placeholder");
            $(".fr-element").html(menuItem.internalContext);
        }
    })
}