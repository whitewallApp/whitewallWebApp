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
        console.log(image);
        nameTextBox.val(image.name);
        descTextBox.val(image.description);

        if (image.externalPath == "1"){
            linkTextBox.val(image.imagePath);
        }else{
            linkTextBox.val("");
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

    $.post("/collections", 
    {
        'id': id
    },
    function(data, status){
        collection = JSON.parse(data);
        console.log(collection);
        nameTextBox.val(collection.name);
        descTextBox.val(collection.description);

        catSelect.empty();

        collection.categoryNames.forEach(element => {
            catSelect.append("<option>" + element.name + "</option>")
        });

        time = new Date(collection.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}