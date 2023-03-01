function notifications_start() {
    $("#force-switch").on("click", function () {
        var checked = $("#force-switch")[0].checked;

        if (checked) {
            $("#force-option").hide();
            $("#force-select-div").show();
        } else {
            $("#force-option").show();
            $("#force-select-div").hide();
        }
    })

    $("#selections").on("click", function () {
        var option = $("#selections").val();

        if (option == "App") {
            $("#app-input").show();
        } else {
            $("#app-input").hide();
        }

        if (option == "Wallpaper") {
            $("#wall-select").show();
        } else {
            $("#wall-select").hide();
        }

        if (option == "Link") {
            $("#link-input").show();
        } else {
            $("#link-input").hide();
        }

    })

    $("#menuRadio").on("click", function(){
        $("#app").hide();
        $("#menu").show();
        $("#appRadio").prop("checked", false);
    });

    $("#appRadio").on("click", function(){
        $("#app").show();
        $("#menu").hide();
        $("#menuRadio").prop("checked", false);
    });
}