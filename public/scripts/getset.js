function getImg(e){
    nameTextBox = $("#imageName");
    linkTextBox = $("#imageLink");
    descTextBox = $("#imageDesc");
    collectionSelectBox = $("#collSelect");
    updatedText = $("#updated");
    filelabel = $("#imageFileText");

    id = e.id;

    $.post("/images", 
    {
        'id': id
    },
    function(data, status){
        image = JSON.parse(data);
        console.log(image);
        nameTextBox.val(image.name);
        descTextBox.val(image.description);

        if (image.externalPath == "1"){
            linkTextBox.val(image.imagePath);
            filelabel.html("")
            $("#linkRadio").prop("checked", true)
            $("#fileRadio").prop("checked", false)
            $("#fileDiv").hide()
            $("#linkDiv").show()
        }else{
            filelabel.html(image.imagePath);
            linkTextBox.val("");
            $("#linkRadio").prop("checked", false)
            $("#fileRadio").prop("checked", true)
            $("#fileDiv").show()
            $("#linkDiv").hide()
        }

        collectionSelectBox.empty();

        image.collectionNames.forEach(element => {
            collectionSelectBox.append("<option>" + element.name + "</option>")
        });

        time = new Date(image.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}

function getColl(e){
    id = e.id
    nameTextBox = $("#collName");
    linkTextBox = $("#collLink");
    descTextBox = $("#collDesc");
    catSelect = $("#catSelect");
    updatedText = $("#updated");
    iconLabel = $("#iconLabel");

    $.post("/collections", 
    {
        'id': id
    },
    function(data, status){
        collection = JSON.parse(data);
        console.log(collection);
        nameTextBox.val(collection.name);
        descTextBox.val(collection.description);
        linkTextBox.val(collection.link);
        iconLabel.html(collection.iconPath);

        catSelect.empty();

        collection.categoryNames.forEach(element => {
            catSelect.append("<option>" + element.name + "</option>")
        });

        time = new Date(collection.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}