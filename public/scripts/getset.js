lastElement = "";

function getImg(e){
    
    tableRow = $(e);
    nameTextBox = $("#imageName");
    linkTextBox = $("#imageLink");
    descTextBox = $("#imageDesc");
    collectionSelectBox = $("#select");
    updatedText = $("#updated");
    filelabel = $("#imageFileText");

    if (lastElement != ""){
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    id = e.id;

    showData("/images");

    $.post("/images", 
    {
        'id': id,
        "collectionReq": false
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
            collectionSelectBox.append('<option value="' + element.name +'">' + element.name + "</option>")
        });

        $('#select>option[value="' + image.collection_id + '"]').prop("selected", true);

        time = new Date(image.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}

function getColl(e){
    tableRow = $(e);

    if (lastElement != ""){
        lastElement.css("background-color", "white");
    }

    id = e.id

    showData("func");

    nameTextBox = $("#collName");
    linkTextBox = $("#collLink");
    descTextBox = $("#collDesc");
    catSelect = $("#select");
    updatedText = $("#updated");
    file = $("#file-icon");
    img = $("#icon");


    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    $.post("/collections", 
    {
        'id': id,
        "collectionReq": false
    },
    function(data, status){
        collection = JSON.parse(data);
        nameTextBox.val(collection.name);
        descTextBox.val(collection.description);
        linkTextBox.val(collection.link);

        console.log(collection);

        if (collection.iconPath != null){
            img.attr("src", collection.iconPath);
            file.hide();
        }


        catSelect.empty();

        collection.categoryNames.forEach(element => {
            catSelect.append('<option value="' + element.name +'">' + element.name + "</option>")
        });

        $('#select>option[value="' + collection.category_id + '"]').prop("selected", true);

        time = new Date(collection.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}

function getCat(e){
    id = e.id
    tableRow = $(e);

    showData("/categories");

    $("#img-icon").hide();
    $("#fileDiv").hide();

    if (lastElement != ""){
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    $.post("/categories",
    {
        "id": id
    },
    function (data, status){
        category = JSON.parse(data);
        console.log(category);

        $("#link").val(category.link);
        $("#name").val(category.name);
        $("#desc").val(category.description);

        if (category.iconPath != ""){
            $("#fileDiv").hide();
            $("#img-icon").show();
            $("#icon").prop("src", category.iconPath);
        }else{
            $("#fileDiv").show();
        }
    });
}

function getNot(e){
    id = e.id;
    $.post("/notifications", 
    {
        "id": id
    },
    function(data, status){
        notification = JSON.parse(data);
        notification = notification[0]

        $("#title").val(notification.title);
        $("#text").val(notification.description);

        console.log(notification);

        $("#link-input").hide();
        $("#wall-select").hide();

        if (notification.forceWall == '1'){
            $("#force-switch")[0].checked = true;
            $("#force-option").hide();
            $("#wall-select").show();
            $('#select>option[value="' + notification.forceId + '"]').prop("selected", true);
        }else{
            $("#force-switch")[0].checked = false;
        }

        if (notification.clickAction == "Wallpaper"){
            $("#wall-select").show();
            $('#select>option[value="' + notification.data + '"]').prop("selected", true);
            $('#selections>option[value="' + notification.clickAction + '"]').prop("selected", true);
        }

        if (notification.clickAction == "Link"){
            $("#link-input").show();
            $('#selections>option[value="' + notification.clickAction + '"]').prop("selected", true);
            $("#link").val(notification.data)
        }

        if (notification.clickAction == "None"){
            $('#selections>option[value="' + notification.clickAction + '"]').prop("selected", true);
        }
    });
}

function showData(link){
    form = $("#data");
    title = $("#data-title");
    button = $("#add-button");

    button.hide();
    title.html("Edit " + link.substring(1, link.length));


    catSelect = $("#select");
    catSelect.empty();
    form.show();
;   
    if (link != "func"){
        $("#img-icon").hide();

        $.post(link, 
        {
            "UpperReq": true
        }, 
        function(data, status){
            collection = JSON.parse(data);
            console.log(collection);
            collection.forEach(element => {
                console.log(element);
                catSelect.append("<option>" + element + "</option>")
            });
        })
    }

    
}