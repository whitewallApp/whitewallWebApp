function getImg(e){
    nameTextBox = $("#imageName");
    linkTextBox = $("#imageLink");
    descTextBox = $("#imageDesc");
    collectionSelectBox = $("#collSelect");
    updatedText = $("#updated");

    id = e.id;

    $.post("/images", 
    {
        'id': id
    },
    function(data, status){
        image = JSON.parse(data);
        nameTextBox.val(image.name);
        descTextBox.val(image.description);

        if (image.externalPath == "1"){
            linkTextBox.val(image.imagePath);
        }else{
            linkTextBox.val("");
        }

        image.collectionNames.forEach(element => {
            collectionSelectBox.append("<option>" + element + "</option>")
        });

        time = new Date(image.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}