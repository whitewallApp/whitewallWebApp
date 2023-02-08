function notifications_start() {
    $("#force-switch").on("click", function () {
        var checked = $("#force-switch")[0].checked;

        if (checked) {
            $("#force-option").hide();
            $("#wall-select").show();
        } else {
            $("#force-option").show();
            $("#wall-select").hide();
        }
    })

    $("#selections").on("click", function () {
        var option = $("#selections").val();
        if (option == "force") {
            $("#wall-select").show();
        } else {
            $("#wall-select").hide();
        }

        if (option == "link") {
            $("#link-input").show();
        } else {
            $("#link-input").hide();
        }
    })
}