lastElement = "";


function getUser(e) {
    var id = e.id;
    var tableRow = $(e);

    if (lastElement != "") {
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    $("#userPrompt").hide();
    $("#userForm").show();

    $.get("user", {
        id: id
    }, function(data, status){
        if (status == "success"){
            user = JSON.parse(data).user
            permissions = JSON.parse(data).permissions

            $("#name").val(user.name);
            $("#email").val(user.email);
            $("#admin").prop("checked", Boolean(Number(permissions.admin)));
            $("#active").prop("checked", Boolean(Number(user.status)));

            //set permissons

            for (const key in permissions){
                $(`[name = permissions\\[${key}\\]\\[view\\]\\[\\]]`).prop("checked", Boolean(Number(permissions[key].view)))
                $(`[name = permissions\\[${key}\\]\\[add\\]\\[\\]]`).prop("checked", Boolean(Number(permissions[key].add)))
                $(`[name = permissions\\[${key}\\]\\[edit\\]\\[\\]]`).prop("checked", Boolean(Number(permissions[key].edit)))
                $(`[name = permissions\\[${key}\\]\\[remove\\]\\[\\]]`).prop("checked", Boolean(Number(permissions[key].remove)))
            }
            
        }else{
            alert(JSON.parse(data).msg)
        }
    })
}

//IMAGES
function getImg(e){
    
    tableRow = $(e);
    nameTextBox = $("#imageName");
    linkTextBox = $("#imageLink");
    descTextBox = $("#imageDesc");
    collectionSelectBox = $("#select");
    updatedText = $("#updated");
    filelabel = $("#imageFileText");

    $(".alert-success").hide();
    $(".alert-danger").hide();

    if (lastElement != ""){
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    id = e.id;

    $.post("/images", 
    {
        'id': id,
        "UpperReq": false
    },
    function(data, status){
        image = JSON.parse(data);

        $("#data").attr("image-id", image.id);
        
        nameTextBox.val(image.name);
        descTextBox.val(image.description);
        showData("/images", false);

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
            collectionSelectBox.append('<option value="' + element + '">' + element + "</option>")
        });

        $('#select>option[value="' + image.collection_id + '"]').prop("selected", true);

        time = new Date(image.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}

$("#data").submit(function(e){
    e.preventDefault();

    var formData = new FormData(e[0]);
    formData.append("id", $("#data").attr("image-id"))
    formData.append("name", $("#imageName").val())
    formData.append("description", $("#imageDesc").val());

    if ($("#imageLink").val() != ""){
        formData.append("link", $("#imageLink").val())
        formData.append("externalPath", 1);
    }
    
    if ($("#imageFile")[0].files.length > 0){
        file = $("#imageFile")[0].files[0];
        formData.append("file", file.slice(0, file.size), $("#imageFile")[0].files[0].name)
        formData.append("type", file.type)
        formData.append("externalPath", 0);
    }

    formData.append("collection", $("#select").val())

    $.ajax({
        url: "/images/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            response = JSON.parse(data);
            if (response.success) {
                $(".alert-success").show();
            } else {
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        }
    });
});

function updateImage(){
    $("#data").submit();
}

$("#imageFile").on("change", function(e){
    imageName = $("#imageFile")[0].files[0].name;
    $("#imageFileText").html(imageName);
})

//COLLECTIONS
function getColl(e){
    tableRow = $(e);

    if (lastElement != ""){
        lastElement.css("background-color", "white");
    }

    id = e.id

    showData("/collections", false);

    $(".alert-success").hide();
    $(".alert-danger").hide();

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
        "UpperReq": false
    },
    function(data, status){
        collection = JSON.parse(data);
        nameTextBox.val(collection.name);
        descTextBox.val(collection.description);
        linkTextBox.val(collection.link);

        $("#collectionData").attr("collection-id", collection.id);

        $("#collfileText").html(collection.iconPath);

        catSelect.empty();

        collection.categoryNames.forEach(element => {
            catSelect.append('<option value="' + element +'">' + element + "</option>")
        });

        $('#select>option[value="' + collection.category_id + '"]').prop("selected", true);

        time = new Date(collection.dateUpdated);

        updatedText.html("Date Updated: " + time.toLocaleString());
    });
}
$("#collfile").on("change", function (e) {
    filename = $("#collfile")[0].files[0].name;
    $("#collfileText").html(filename);
})

$("#collectionData").submit(function(e){
    e.preventDefault();

    var formData = new FormData(e[0]);
    formData.append("id", $("#collectionData").attr("collection-id"))
    formData.append("name", $("#collName").val())
    formData.append("description", $("#collDesc").val());
    formData.append("link", $("#collLink").val())


    if ($("#collfile")[0].files.length > 0) {
        file = $("#collfile")[0].files[0];
        formData.append("file", file.slice(0, file.size), $("#collfile")[0].files[0].name)
        formData.append("type", file.type)
    }

    formData.append("category", $("#select").val())

    $.ajax({
        url: "/collections/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            response = JSON.parse(data);
            if (response.success) {
                $(".alert-success").show();
            } else {
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        }
    });
})

//CATEGORIES
function getCat(e){
    id = e.id
    tableRow = $(e);

    showData("/categories");

    if (lastElement != ""){
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    $(".alert-success").hide();
    $(".alert-danger").hide();

    $.post("/categories",
    {
        "id": id
    },
    function (data, status){
        category = JSON.parse(data);
        
        $("#categoryData").attr("category-id", category.id);
        $("#link").val(category.link);
        $("#name").val(category.name);
        $("#desc").val(category.description);

        catname = category.iconPath.split("category/")[1];
        if (catname == null){
            $("[for=file]").html("File Icon");
        }else{
            $("[for=file]").html(catname);
        }
        
    });
}

$("#file").on("change", function (e) {
    filename = $("#file")[0].files[0].name;
    $("[for=file]").html(filename);
})

$("#categoryData").submit(function(e){
    e.preventDefault();

    var formData = new FormData(e[0]);
    formData.append("id", $("#categoryData").attr("category-id"))
    formData.append("name", $("#name").val())
    formData.append("description", $("#desc").val());
    formData.append("link", $("#link").val())


    if ($("#file")[0].files.length > 0) {
        file = $("#file")[0].files[0];
        formData.append("file", file.slice(0, file.size), $("#file")[0].files[0].name)
        formData.append("type", file.type)
    }

    $.ajax({
        url: "/categories/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            response = JSON.parse(data);
            if(response.success){
                $(".alert-success").show();
            }else{
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        }
    });
})

function getNot(e){

    tableRow = $(e);

    if (lastElement != "") {
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;


    id = e.id;
    $.post("/notifications", 
    {
        "id": id
    },
    function(data, status){
        notifcation = JSON.parse(data);
        console.log(notifcation);

        $("#link-input").hide();
        $("#app").hide();

        $("#title").val(notifcation.title);
        $("#text").val(notifcation.description);

        if(notifcation.forceWall == "1"){
            $("#force-switch").prop("checked", true);
            $("#force-select-div").show();
            $(`#force-select>option[value=${notifcation.forceId}]`).prop("selected", true);
        }else{
            $("#force-switch").prop("checked", false);
            $("#force-select-div").hide();
        }

        $(`#selections>option[value=${notifcation.clickAction}]`).prop("selected", true);

        if (notifcation.clickAction == "Link"){
            $("#link-input").show();
            $("#link").val(notifcation.data);
        }

        if (notifcation.clickAction == "Wallpaper"){
            $("#app").show();

            imageCategory = "";
            imageCollection = "";

            console.log(categories);
            // get where the image is from
            Object.keys(categories).forEach(category => {
                $("#cat-select").append(`<option value="${category}">${category}</option>`);
                Object.keys(categories[category]).forEach(collection => {
                    categories[category][collection].forEach(image => {
                        if (image == notifcation.data){
                            imageCollection = collection;
                            imageCategory = category
                        }
                    })
                })
            })

            Object.keys(categories[imageCategory]).forEach(collection => {
                $("#col-select").append(`<option value="${collection}">${collection}</option>`);
                categories[imageCategory][collection].forEach(image => {
                    $("#img-select").append(`<option value="${image}" >${image}</option>`);
                })
            })

            $(`#cat-select>option[value="${imageCategory}"]`).prop("selected", true);
            $(`#col-select>option[value="${imageCollection}"]`).prop("selected", true);
            $(`#img-select>option[value="${notifcation.data}"]`).prop("selected", true);
        }

        if (notifcation.clickAction == ""){

        }
    });
}

function showData(link, list=true){
    form = $("#form-div");
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
            
            if (list){
                catSelect.empty();
                collection.forEach(element => {
                    catSelect.append('<option value="' + element +'">' + element + "</option>")
                });
            }
        })
    }

    
}