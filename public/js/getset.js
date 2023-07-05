lastElement = "";

$(function () {
    children = $(".pagination").children()

    for (let i = 0; i < children.length; i++) {
        const element = $(children[i]);
        element.addClass("page-item");
        element.children().addClass("page-link");
    }
})

//IMAGES
function getImg(e) {

    tableRow = $(e);
    nameTextBox = $("#imageName");
    linkTextBox = $("#imageLink");
    descTextBox = $("#imageDesc");
    collectionSelectBox = $("#select");
    updatedText = $("#updated");
    filelabel = $("#imageFileText");

    $(".alert-success").hide();
    $(".alert-danger").hide();
    $("#remove").show();
    $("#form-div").show();
    $("#save").html("Save");
    $("#data-title").html("Edit Image");

    $(".flex-row-reverse").html('<i style="font-size: 1.75rem; cursor: pointer;" onclick="window.location.reload()" class="bi bi-x-circle"></i>');

    if (lastElement != "") {
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    id = e.id;

    $.post("/images",
        {
            'id': id
        },
        function (data, status) {
            image = JSON.parse(data);

            $("#data").attr("image-id", image.id);
            $("#remove").attr("remove-id", image.id)

            nameTextBox.val(image.name);
            descTextBox.val(image.description);

            if (image.externalPath == "1") {
                linkTextBox.val(image.imagePath);
                filelabel.html("")
                $("#linkRadio").prop("checked", true)
                $("#fileRadio").prop("checked", false)
                $("#fileDiv").hide()
                $("#linkDiv").show()
            } else {
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

$("#data").submit(function (e) {
    e.preventDefault();

    var formData = new FormData(e[0]);
    formData.append("id", $("#data").attr("image-id"))
    formData.append("name", $("#imageName").val())
    formData.append("description", $("#imageDesc").val());

    if ($("#imageLink").val() != "") {
        formData.append("link", $("#imageLink").val())
        formData.append("externalPath", 1);
    }

    if ($("#imageFile")[0].files.length > 0) {
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
        success: function (data, status) {
            response = JSON.parse(data);
            console.log(status);
            if (response.success) {
                $(".alert-success").show();
                window.location.reload();
            } else {
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        },
        error: function (data) {
            response = JSON.parse(data.responseText)

            $(".alert-danger").html(response.message);
            $(".alert-danger").show();
        }
    });
});

function updateImage() {
    $("#data").submit();
}

$("#imageFile").on("change", function (e) {
    imageName = $("#imageFile")[0].files[0].name;
    $("#imageFileText").html(imageName);
})

//COLLECTIONS
function getColl(e) {
    tableRow = $(e);

    if (lastElement != "") {
        lastElement.css("background-color", "white");
    }

    id = e.id

    $(".alert-success").hide();
    $(".alert-danger").hide();
    $("#remove").show();
    $("#form-div").show();
    $("#save").html("Save");
    $("#data-title").html("Edit Collection");

    $(".flex-row-reverse").html('<i style="font-size: 1.75rem; cursor: pointer;" onclick="window.location.reload()" class="bi bi-x-circle"></i>');

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
        function (data, status) {
            collection = JSON.parse(data);
            nameTextBox.val(collection.name);
            descTextBox.val(collection.description);
            linkTextBox.val(collection.link);
            $("#active").prop("checked", collection.active);

            $("#collectionData").attr("collection-id", collection.id);
            $("#remove").attr("remove-id", collection.id)

            $("#collfileText").html(collection.iconPath);

            catSelect.empty();

            collection.categoryNames.forEach(element => {
                catSelect.append('<option value="' + element + '">' + element + "</option>")
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

$("#collectionData").submit(function (e) {
    e.preventDefault();

    var formData = new FormData(e[0]);
    formData.append("id", $("#collectionData").attr("collection-id"))
    formData.append("name", $("#collName").val())
    formData.append("description", $("#collDesc").val());
    formData.append("link", $("#collLink").val())
    formData.append("active", $("#active").prop("checked"));


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
                window.location.reload();
            } else {
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        },
        error: function (data) {
            response = JSON.parse(data.responseText)

            $(".alert-danger").html(response.message);
            $(".alert-danger").show();
        }
    });
})

//CATEGORIES
function getCat(e) {
    id = e.id
    tableRow = $(e);

    if (lastElement != "") {
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    $(".alert-success").hide();
    $(".alert-danger").hide();
    $("#remove").show();
    $("#form-div").show();
    $("[type='submit']").html("Save");
    $("#data-title").html("Edit Category");

    $(".flex-row-reverse").html('<i style="font-size: 1.75rem; cursor: pointer;" onclick="window.location.reload()" class="bi bi-x-circle"></i>');

    $.post("/categories",
        {
            "id": id
        },
        function (data, status) {
            category = JSON.parse(data);

            $("#categoryData").attr("category-id", category.id);
            $("#remove").attr("remove-id", category.id)
            $("#link").val(category.link);
            $("#name").val(category.name);
            $("#desc").val(category.description);

            catname = category.iconPath.split("category/")[1];
            if (catname == null) {
                $("[for=file]").html("File Icon");
            } else {
                $("[for=file]").html(catname);
            }

        });
}

$("#file").on("change", function (e) {
    filename = $("#file")[0].files[0].name;
    $("[for=file]").html(filename);
})

$("#categoryData").submit(function (e) {
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
            if (response.success) {
                $(".alert-success").show();
                window.location.reload();
            } else {
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        },
        error: function (data) {
            response = JSON.parse(data.responseText)

            $(".alert-danger").html(response.message);
            $(".alert-danger").show();
        }
    });
})

//NOTIFICATIONS
function getNot(e) {

    tableRow = $(e);

    if (lastElement != "") {
        lastElement.css("background-color", "white");
    }

    tableRow.css("background-color", "#c8cbcf");
    lastElement = tableRow;

    $("#remove").show();
    $("#notData").show();
    $("#save").html("Save");
    $("#data-title").html("Edit Notification");
    $("#form-div").show();
    $(".flex-row-reverse").html('<i style="font-size: 1.75rem; cursor: pointer;" onclick="window.location.reload()" class="bi bi-x-circle"></i>');


    id = e.id;
    $.post("/notifications",
        {
            "id": id
        },
        function (data, status) {
            notifcation = JSON.parse(data);

            $("#notData").attr("not-id", notifcation.id);
            $("#remove").attr("remove-id", notifcation.id)

            $("#link-input").hide();
            $("#app").hide();

            $("#title").val(notifcation.title);
            $("#text").val(notifcation.description);

            $("#sendtime").val(notifcation.sendTime);

            data = notifcation.data;
            $(`#selections>option[value="${data.clickAction.type}"]`).prop("selected", true);

            //reset all inputs
            $("#app-input").hide();
            $("#menu").hide();
            $("#menuRadio").prop("checked", false);
            $("#appRadio").prop("checked", false);
            $("#force-select-div").hide();
            $("#link-input").hide();
            $("#app").hide();
            $("#img-select-group").hide();

            //force switch
            $("#force-switch").prop("checked", data.forceAction.activated);
            if (data.forceAction.activated){
                $("#force-select-div").show();
                $(`#force-select[value='${data.forceAction.imageId}']`).prop("selected", true);
            }

            if (data.clickAction.type == "App" || data.clickAction.type == "Wallpaper") {
                if (data.clickAction.type == "App"){
                    $("#app-input").show();
                    $("#appRadio").prop("checked", true);
                }
                $("#app").show();

                console.log(data.clickAction);


                if (data.clickAction.idType == "category") {
                    
                    $("#cat-select").empty();
                    categoryNames = Object.keys(categories);

                    categoryNames.forEach(name => {
                        $("#cat-select").append(`<option value="${name}">${name}</option>`);
                    })

                    $(`#cat-select>option[value="${data.clickAction.data}"]`).prop("selected", true);

                    $("#col-select").empty();
                    $("#col-select").append(`<option value="parent" selected>Link to parent Category</option>`);
                    collectionNames = Object.keys(categories[data.clickAction.data])
                    collectionNames.forEach(name => {
                        $("#col-select").append(`<option value="${name}">${name}</option>`);
                    })

                }
                if (data.clickAction.idType == "collection") {
                    categoryName = "";

                    $("#cat-select").empty();
                    $("#col-select").empty();
                    $("#img-select").empty();
                    $("#img-select-group").show();

                    //populate categories and find category Name
                    Object.keys(categories).forEach(category => {
                        $("#cat-select").append(`<option value="${category}">${category}</option>`);
                        Object.keys(categories[category]).forEach(collection => {
                            if (collection == data.clickAction.data){
                                categoryName = category;
                            }
                        })
                    })

                    //populate collections
                    Object.keys(categories[categoryName]).forEach(collection => {
                        $("#col-select").append(`<option value="${collection}">${collection}</option>`);
                    })
                    $("#col-select").append(`<option value="parent">Link to Parent Category</option>`);

                    //populate images
                    categories[categoryName][data.clickAction.data].forEach(image => {
                        $("#img-select").append(`<option value="${image}">${image}</option>`);
                    })
                    $("#img-select").append(`<option value="parent" selected>Link to Parent Collection</option>`);

                    $(`#cat-select>option[value="${categoryName}"]`).prop("selected", true);
                    $(`#col-select>option[value="${data.clickAction.data}"]`).prop("selected", true);
                }
                if (data.clickAction.idType == "image") {
                    $("#cat-select").empty();
                    $("#col-select").empty();
                    $("#img-select").empty();
                    $("#img-select-group").show();

                    categoryName = "";
                    collectionName = "";

                    Object.keys(categories).forEach(category => {
                        $("#cat-select").append(`<option value="${category}">${category}</option>`);
                        Object.keys(categories[category]).forEach(collection => {
                            categories[category][collection].forEach(image => {
                                if (image == data.clickAction.data) {
                                    collectionName = collection;
                                    categoryName = category
                                }
                            })
                        })
                    })

                    //add parents back in
                    $("#col-select").append(`<option value="parent">Link to Parent Category</option>`);
                    $("#img-select").append(`<option value="parent" selected>Link to Parent Collection</option>`);

                    Object.keys(categories[categoryName]).forEach(collection => {
                        $("#col-select").append(`<option value="${collection}">${collection}</option>`);
                        categories[categoryName][collection].forEach(image => {
                            $("#img-select").append(`<option value="${image}" >${image}</option>`);
                        })
                    })

                    $(`#cat-select>option[value="${categoryName}"]`).prop("selected", true);
                    $(`#col-select>option[value="${collectionName}"]`).prop("selected", true);
                    $(`#img-select>option[value="${data.clickAction.data}"]`).prop("selected", true);
                }
            }

            if (data.clickAction.type == "Menu") {
                $("#app-input").show();
                $("#menu").show();
                $("#menuRadio").prop("checked", true);
                $(`[value="App"]`).prop("selected", true);
                $(`#menu-select[value='${data.clickAction.data}']`).prop("selected", true);
            }

            if (data.clickAction.type == "Link"){
                $(`[value="Link"]`).prop("selected", true);
                $("#link-input").show();
                $("#link").val(data.clickAction.data);
            }
        });
}

$("#notData").submit(function (e) {
    e.preventDefault();

    formData = new FormData();

    formData.append("id", $("#notData").attr("not-id"));
    formData.append("title", $("#title").val());
    formData.append("description", $("#text").val());
    formData.append("forceSwitch", $("#force-switch").prop("checked"));
    formData.append("sendtime", $("#sendtime").val());

    data = {
        clickAction: {},
        forceAction: {}
    };

    if ($("#force-switch").prop("checked")) {
        data.forceAction.activated = true;
        data.forceAction.imageId = $("#force-select").val();
    } else {
        data.forceAction.activated = false;
    }

    selection = $("#selections").val();
    data.clickAction.type = selection;

    if (selection == "Link") {
        data.clickAction.type = selection;
        data.clickAction.data = $("#link").val();
    }

    if (selection == "Wallpaper") {

        if ($("#col-select").val() == "parent") {
            data.clickAction.idType = "category"
            data.clickAction.data = $("#cat-select").val();
        } else if ($("#img-select").val() == "parent") {
            data.clickAction.idType = "collection"
            data.clickAction.data = $("#col-select").val();
        } else {
            data.clickAction.idType = "image"
            data.clickAction.data = $("#img-select").val();
        }
    }

    if (selection == "App") {
        if ($("#menuRadio").prop("checked")) {
            data.clickAction.type = "Menu";
            data.clickAction.data = $("#menu-select").val();
        }

        if ($("#appRadio").prop("checked")) {
            data.clickAction.type = "App";

            if ($("#col-select").val() == "parent") {
                data.clickAction.idType = "category"
                data.clickAction.data = $("#cat-select").val();
            } else if ($("#img-select").val() == "parent") {
                data.clickAction.idType = "collection"
                data.clickAction.data = $("#col-select").val();
            } else {
                data.clickAction.idType = "image"
                data.clickAction.data = $("#img-select").val();
            }
        }
    }

    formData.append("data", JSON.stringify(data));


    $.ajax({
        url: "/notifications/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            response = JSON.parse(data);
            console.log(response);
            if (response.success) {
                $(".alert-success").show();
                window.location.reload();
            } else {
                $(".alert-danger").html(response.message);
                $(".alert-danger").show();
            }
        },
        error: function (data) {
            response = JSON.parse(data.responseText)

            $(".alert-danger").html(response.message);
            $(".alert-danger").show();
        }
    });
});