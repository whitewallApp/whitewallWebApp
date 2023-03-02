function notifications_start() {
    $("#force-switch").on("click", function () {
        var checked = $("#force-switch")[0].checked;

        if (checked) {
            $("#force-option").hide();
            $("#force-select-div").show();
        } else {
            $("#force-option").show();
            $("#force-select-div").hide();
        }
    })

    $("#selections").on("click", function () {
        var option = $("#selections").val();

        if (option == "App") {
            $("#app-input").show();
        } else {
            $("#app-input").hide();
        }

        if (option == "Wallpaper") {
            $("#app-input").show();
            $(".form-check").hide();
            $("#app").show();

            categoryNames = Object.getOwnPropertyNames(categories);
            collectionNames = Object.getOwnPropertyNames(categories[categoryNames[0]])
            imageNames = categories[categoryNames[0]][collectionNames[0]]

            categoryNames.forEach(element => {
                $("#cat-select").append('<option value="' + element + '">' + element + "</option>")
            });

            collectionNames.forEach(element => {
                $("#col-select").append('<option value="' + element + '">' + element + "</option>")
            })

            imageNames.forEach(element => {
                $("#img-select").append('<option value="' + element + '">' + element + "</option>")
            })

        } else {
            $("#app-input").hide();
        }

        if (option == "Link") {
            $("#link-input").show();
        } else {
            $("#link-input").hide();
        }

    })

    $("#menuRadio").on("click", function(){
        $("#app").hide();
        $("#menu").show();
        $("#appRadio").prop("checked", false);
    });

    $("#appRadio").on("click", function(){
        $("#app").show();
        $("#menu").hide();
        $("#menuRadio").prop("checked", false);

        categoryNames = Object.getOwnPropertyNames(categories);
        collectionNames = Object.getOwnPropertyNames(categories[categoryNames[0]])
        imageNames = categories[categoryNames[0]][collectionNames[0]]

        categoryNames.forEach(element => {
            $("#cat-select").append('<option value="' + element + '">' + element + "</option>")
        });

        collectionNames.forEach(element => {
            $("#col-select").append('<option value="' + element + '">' + element + "</option>")
        })

        imageNames.forEach(element => {
            $("#img-select").append('<option value="' + element + '">' + element + "</option>")
        })
    });

    $("#cat-select").on("click", function () {
        option = $("#cat-select").val();
        categoryNames = Object.getOwnPropertyNames(categories);

        categoryNames.forEach(catName => {
            if (catName == option){
                collectionNames = Object.getOwnPropertyNames(categories[option]);

                $("#col-select").empty();
                $("#img-select").empty();
                $("#col-select").append('<option value="Link">' + "Link to Parent Category" + "</option>")
                collectionNames.forEach(colName => {
                    $("#col-select").append('<option value="' + colName + '">' + colName + "</option>")
                });
            }
        })

    })

    $("#col-select").on("click", function(){
        option = $("#col-select").val();
        collectionNames = Object.getOwnPropertyNames(categories[$("#cat-select").val()])
        
        collectionNames.forEach(colName => {
            if (colName == option){
                imageNames = categories[$("#cat-select").val()][option]
                
                $("#img-select").empty();
                $("#img-select").append('<option value="Link">' + "Link to Parent Collection" + "</option>")
                imageNames.forEach(imgName => {
                    $("#img-select").append('<option value="' + imgName + '">' + imgName + "</option>")
                })
            }
        })
    })
}