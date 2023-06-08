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
        $("#remove").attr("remove-id", menuItem.id);
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

            // $(".fr-wrapper").removeClass("show-placeholder");
            // $(".fr-element").html(menuItem.internalContext);
            $(".note-editable").html(menuItem.internalContext);
        }
    })
}

$("#menuData").submit(function(e){
    e.preventDefault();

    formData = new FormData();

    formData.append("id", $("#menuData").attr("menu-id"));
    formData.append("title", $("#title").val());
    formData.append("sequence", $("#s-select").val());
    if ($("#linkRadio").prop("checked")){
        formData.append("target", 1);
        formData.append("link", $("#link").val());
    }else{
        formData.append("target", 0);
        // formData.append("internalContext", $(".fr-element").html());
        formData.append("internalContext", $(".note-editable").html());
    }

    $.ajax({
        url: "/menu/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            response = JSON.parse(data);
            console.log(response);
            if (response.success) {
                $(".alert-success").show();
            } else {
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        }
    });
})