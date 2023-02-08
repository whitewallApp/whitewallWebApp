window.onload = function(){
    
    breadcrumbs();

    startCheckBoxes();
}

function startCheckBoxes(){
    document.getElementById("check-all").addEventListener("click", toggleAll); //for starting checkboxes
    var boxes = document.getElementsByClassName("checkbox-lg");

    for (i = 1; i < boxes.length; i++){
        var element = boxes[i];
        element.addEventListener("click", singlebox.bind(boxes[i])); //for starting checkboxes
    }
}

function breadcrumbs(){
    var breadcrumbs = document.getElementById("breadcrumbs");
    var url = document.URL;
    var url = url.replace("http://", "");
    var page = url.split("/")[1];

    var html;
    var link = page.charAt(0).toUpperCase() + page.slice(1);


    breadcrumbs.innerHTML = link;
}