function getImgData(id) {
    var returnImg;
    $.post("/images", 
    {
        'id': id
    },
    function(data, status){
        if (status == 200){
            returnImg = JSON.parse(data);
        }else{

        }
    });

    return returnImg;
}


function getImg(e){
    $nameTextBox = $("#imageName");
    $linkTextBox = $("#imageLink");
    $collectionSelectBox = $("#collSelect");
}