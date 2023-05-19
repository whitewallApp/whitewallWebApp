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
    }

    if (selected == "None"){
        $("#link-input").hide();
        $("#app-input").hide();
        $("#app").hide();
    }
})