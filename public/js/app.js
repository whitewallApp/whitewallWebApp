$("#ioscompileButton").on("click", function () {
    $("#iosInput").hide();

    //start compile progress
    $.ajax({
        type: "POST",
        url: "app/ios/compile",
        data: { version: $("#iosVersionName").val(), name: $("#iosAppName").val() },
        timeout: 100,
        error: function (jqXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                console.log("timeout");
            }
        }
    });

    pollProgress("ios");
})
$("#androidcompileButton").on("click", function () {

    $("#androidInput").hide();
    //start compile progress
    $.ajax({
        type: "POST",
        url: "app/android/compile",
        data: { version: $("#androidVersionName").val(), name: $("#androidAppName").val() },
        timeout: 100,
        error: function (jqXHR, textStatus, errorThrown) {
            if (textStatus === "timeout") {
                console.log("timeout");
            }
        }
    });

    pollProgress("android");
})
function pollProgress(os){
    $("#" + os + "compileButton").hide();
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "app/" + os + "/progress",
            data: {},
            error: function (jqXHR, textStatus, errorThrown) {
                if (textStatus === "timeout") {
                    console.log("timeout");
                }
            },
            success: function (data, response) {
                progress = JSON.parse(data).progress;
                message = JSON.parse(data).state;

                $("#"+ os + "Status").html(message);

                var bar = $("#"+ os +"Loading");
                bar.parent().parent().show()
                bar.attr("aria-valuenow", progress);
                bar.html(progress + "%")
                bar.css("width", progress + "%")

                if (progress < 100) {
                    pollProgress(os);
                }else{
                    $("#"+ os +"Buttons").show();
                    $("#"+ os +"ModelButton").hide();
                }
            }
        });
    }, 2500)
}

function queryProgress(os){
    
}