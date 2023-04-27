function toggleAll(){
    var boxes = document.getElementsByClassName("checkbox-lg");
    var status = document.getElementById("check-all").checked;
    var selectedText = `${boxes.length - 1} Selected`;

    if (status){
        $("#actions").show();
    }else{
        $("#actions").hide();
    }


    for (var i = 1; i < boxes.length; i++){
        boxes[i].checked = status;
    }

    var selectedInfo = document.getElementById("infoSelect");

    if (status){
        selectedInfo.innerHTML = selectedText;
    }else{
        selectedInfo.innerHTML = "";
    }
}

function singlebox(e){
    if ($("#actions").css("display") == "none"){
        $("#actions").toggle();
    }
    var status = e.srcElement.checked
    var text = document.getElementById("infoSelect").innerHTML;
    var num = parseInt(text.charAt(0))
    var output = "";

    if (!status){
        if (document.getElementById("check-all").checked){
            document.getElementById("check-all").checked = false;
        }
    }

    if (status){
        if (text == ""){
            output = "1 Selected"
        }else if (text != ""){
            output = `${num + 1} Selected`
        }
    }else{
        if (num == 1){
            $("#actions").toggle();
            output = ""
        }else if (text != ""){
            output = `${num - 1} Selected`
        }
    }
    document.getElementById("infoSelect").innerHTML = output;
    console.log(output)
}

function changeBrnd(e){
    element = $(e);

    $.post("/brand", {
        id: element.prop('id')
    },
    function (data, state) {
        alert("Success");
    })
}

function login(e) {
    $.post("/", {
        email: $("#InputEmail").val(),
        password: $("#InputPassword").val(),
        google: e
    },
    function (data, status){
        val = JSON.parse(data);
        if (val.success){
            if (!val.hasOwnProperty("prevURL")){
                var url = "/dashboard";
                $(location).attr('href', url);
            }else{
                var url = "/" + val.prevURL;
                $(location).attr('href', url);
            }
        }else{
        }
    })
}