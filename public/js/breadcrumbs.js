$("document").ready(function(){
    // setImageStart();

    selectBrand();

    //saveAccount();

    startCheckBoxes();
});

function setUser(){
    $("#savePermissions").on("click", function () {
        var form = $("form#permissionsForm");
        $.ajax({
            url: "user/" + form.attr("userid"),
            type: "post",
            dataType: 'application/x-www-form-urlencoded',
            data: $("form#permissionsForm").serialize(),
            success: function (data, status) {
                console.log(data);
            }
        })

        console.log($("form#permissionsForm").serialize());

    });
}

function selectBrand(){
    $("#brandSelect").change(function(){
        var brand_name = $("#brandSelect").val();

        $.post("/brand", {
            name: brand_name
        }, function(data, state){
            if (state == "success"){
                location.reload()
            }
        })
    })
}

function startCheckBoxes(){
    document.getElementById("check-all").addEventListener("click", toggleAll); //for starting checkboxes
    var boxes = document.getElementsByClassName("checkbox-lg");

    for (i = 1; i < boxes.length; i++){
        var element = boxes[i];
        element.addEventListener("click", singlebox.bind(boxes[i])); //for starting checkboxes
    }
}

function setImageStart(){
    $("#linkRadio").on("click", function(){
        $("#fileDiv").hide();
        $("#linkDiv").show();
    });
    $("#fileRadio").on("click", function(){
        $("#fileDiv").show();
        $("#linkDiv").hide();
    });

    var url = document.URL;
    var url = url.replace("http://", "");
    var page = url.split("/")[1];
    var link = page.charAt(0).toUpperCase() + page.slice(1);
    
    $("#data-title").html("Add " + link)
}

