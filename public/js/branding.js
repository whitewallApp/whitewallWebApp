// File Uploads
$("#appIcon").on("input", function(){
    formData = new FormData();
    formData.append("appIcon", this.files[0]);

    $.ajax({
        url: "/brand/branding/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status) {
           
        },
        error: function (data) {
           
        }
    });
})

$("#appLoading").on("input", function(){
    formData = new FormData();
    formData.append("appLoading", this.files[0]);

    $.ajax({
        url: "/brand/branding/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status) {

        },
        error: function (data) {

        }
    });
})

$("#appHeader").on("input", function(){
    formData = new FormData();
    formData.append("appHeading", this.files[0]);

    $.ajax({
        url: "/brand/branding/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status) {

        },
        error: function (data) {

        }
    });
})

$("#appBanner").on("input", function(){
    formData = new FormData();
    formData.append("appBanner", this.files[0]);

    $.ajax({
        url: "/brand/branding/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status) {

        },
        error: function (data) {

        }
    });
})

$("#save").on("click", function(){
    formData = new FormData();
    branding.appName = $("#appName").val();
    branding.bannerLink = $("#bannerLink").val();
    branding.headerLink = $("#headerLink").val();
    formData.append("branding", JSON.stringify(branding));
    formData.append("collectionLink", $("#collectionLink").val());
    formData.append("categoryLink", $("#categoryLink").val());
    formData.append("menuLink", $("#menuLink").val());

    console.log(Object.fromEntries(formData));
    

    $.ajax({
        url: "/brand/branding/update",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status) {
            response = JSON.parse(data);
            console.log(status);
            if (response.success) {
                $(".alert-success").show();
                changed = false;
                setTimeout(() => {
                    $(".alert-success").hide();
                }, 1000)
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

changed = false;

// Base App Branding
$("#backgroundColor").on("input", function(){
    color = $(this).val()
    branding.background.color = color;
    updateBranding();
    changed = true;
})

$("#headerSize").on("input", function(){
    size = $(this).val()
    branding.headerSize = size;
    updateBranding();
    changed = true;
})

// Loading
$("#loadingSize").on("input", function(){
    size = $(this).val()
    branding.loading.size = size;
    updateBranding();
    changed = true;
})

$("#loadingcolor").on("input", function(){
    color = $(this).val()
    branding.loading.color = color;
    updateBranding();
    changed = true;
})

// Card Branding
$("#cardFont").on("input", function(){
    family = $(this).val()
    branding.cards.font = family
    updateBranding();
    changed = true;
})

$("#cardFontColor").on("input", function(){
    color = $(this).val()
    branding.cards.fontcolor = color
    updateBranding();
    changed = true;
})

$("#cardFontStyle").on("input", function(){
    style = $(this).val()
    branding.cards.fontstyle = style
    updateBranding();
    changed = true;
})

$("#cardFontsize").on("input", function(){
    size = $(this).val()
    branding.cards.fontsize = size
    updateBranding();
    changed = true;
})

// Card Image Frames
$("#imgBorderRadius").on("input", function(){
    radius = $(this).val()
    branding.cards.images.borderRadius = radius
    updateBranding();
    changed = true;
})

$("#imgBorderWidth").on("input", function(){
    width = $(this).val()
    branding.cards.images.borderWidth = width
    updateBranding();
    changed = true;
})

$("#borderColor").on("input", function(){
    color = $(this).val()
    branding.cards.images.borderColor = color
    updateBranding();
    changed = true;
})

// Cards
$("#shadowBox").on("input", function(){
    shadow = $(this).prop("checked")
    branding.cards.shadow = shadow
    updateBranding();
    changed = true;
})

$("#cardBackgroundColor").on("input", function(){
    color = $(this).val()
    branding.cards.backgroundcolor = color
    updateBranding();
    changed = true;
})

$("#cardframeRadius").on("input", function(){
    radius = $(this).val()
    branding.cards.frames.borderRadius = radius
    updateBranding();
    changed = true;
})

$("#frameBorderWidth").on("input", function(){
    width = $(this).val()
    branding.cards.frames.borderWidth = width
    updateBranding();
    changed = true;
})

$("#cardBorderColor").on("input", function(){
    color = $(this).val()
    branding.cards.frames.borderColor = color
    updateBranding();
    changed = true;
})

// Buttons
$("#buttonColor").on("input", function(){
    color = $(this).val()
    branding.buttons.color= color
    updateBranding();
    changed = true;
})

$("#buttonBorderRadius").on("input", function(){
    radius = $(this).val()
    branding.buttons.borderRadius = radius
    updateBranding();
    changed = true;
})

$("#buttonFont").on("input", function(){
    font = $(this).val()
    branding.buttons.font = font
    updateBranding();
    changed = true;
})

$("#buttonFontColor").on("input", function(){
    fontcolor = $(this).val()
    branding.buttons.fontcolor = fontcolor
    updateBranding();
    changed = true;
})

$("#buttonFontStyle").on("input", function(){
    fontstyle = $(this).val()
    branding.buttons.fontstyle = fontstyle
    updateBranding();
    changed = true;
})

$("#buttonFontSize").on("input", function(){
    fontsize = $(this).val()
    branding.buttons.fontsize = fontsize
    updateBranding();
    changed = true;
})

function updateBranding(){
    // Base App Branding
    $(".phone").css("background-color", branding.background.color);
    $(".header-img").css("width", branding.headerSize + "%");

    // Loading
    $("#loadingct").css("background-color", branding.loading.color);
    $("#loading").css("width", branding.loading.size + "%");

    // Card Branding
    $(".phone-card p").css("color", branding.cards.fontcolor);
    $(".phone-card p").css("font-family", branding.cards.font);

    if (branding.cards.fontstyle == "bold") {
        $(".phone-card p").css("font-weight", branding.cards.fontstyle)
        $(".phone-card p").css("font-style", "normal")
    } else {
        $(".phone-card p").css("font-weight", "normal")
        $(".phone-card p").css("font-style", branding.cards.fontstyle)
        $(".phone-card p").css("font-size", branding.cards.fontsize + "px")
    }

    // Card Image Frames
    $(".phone-card img").css("border-radius", branding.cards.images.borderRadius + "px");
    $(".phone-card img").css("border", branding.cards.images.borderWidth + "px solid");
    $(".phone-card img").css("border-color", branding.cards.images.borderColor);

    // Cards
    $(".phone-card").css("background-color", branding.cards.backgroundcolor);
    $(".phone-card").css("border-radius", branding.cards.frames.borderRadius + "px");
    $(".phone-card").css("border", branding.cards.frames.borderWidth + "px solid");
    $(".phone-card").css("border-color", branding.cards.frames.borderColor);
    if (branding.cards.shadow){
        $(".phone-card").addClass("shadow-effect");
    }else{
        $(".phone-card").removeClass("shadow-effect");
    }

    // Buttons
    $(".btn-branding").each(function() {
        this.style.setProperty("background-color", branding.buttons.color, "important");
    });
    $(".btn-branding").each(function() {
        this.style.setProperty("border-radius", branding.buttons.borderRadius + "px", "important");
    });
    $(".btn-branding").css("font-family", branding.buttons.font);
    $(".btn-branding").css("color", branding.buttons.fontcolor);

    if (branding.buttons.fontstyle == "bold") {
        $(".btn-branding").css("font-weight", branding.buttons.fontstyle)
        $(".btn-branding").css("font-style", "normal")
    } else {
        $(".btn-branding").css("font-weight", "normal")
        $(".btn-branding").css("font-style", branding.buttons.fontstyle)
        $(".btn-branding").css("font-size", branding.buttons.fontsize + "px")
    }

    $(".btn-branding").css("font-size", branding.buttons.fontsize + "px");

}

//load in branding on page load
$(function(){
    // Base App
    $("#backgroundColor").val(branding.background.color);
    $("#headerSize").val(branding.headerSize);
    $("#appName").val(branding.appName);

    // Loading
    $("#loadingSize").val(branding.loading.size)
    $("#loadingcolor").val(branding.loading.color)

    // Cards
    $("#cardFont").val(branding.cards.font);
    $("#cardFontColor").val(branding.cards.fontcolor);
    $("#cardFontStyle").val(branding.cards.fontstyle);
    $("#cardFontsize").val(branding.cards.fontsize);

    // Card Image Frames
    $("#imgBorderRadius").val(branding.cards.images.borderRadius);
    $("#imgBorderWidth").val(branding.cards.images.borderWidth);
    $("#borderColor").val(branding.cards.images.borderColor);

    // Cards
    $("#shadowBox").prop("checked", branding.cards.shadow);
    $("#cardBackgroundColor").val(branding.cards.backgroundcolor);
    $("#cardframeRadius").val(branding.cards.frames.borderRadius);
    $("#frameBorderWidth").val(branding.cards.frames.borderWidth);
    $("#cardBorderColor").val(branding.cards.frames.borderColor);

    // Buttons
    $("#buttonColor").val(branding.buttons.color)
    $("#buttonBorderRadius").val(branding.buttons.borderRadius)
    $("#buttonFont").val(branding.buttons.font)
    $("#buttonFontColor").val(branding.buttons.fontcolor)
    $("#buttonFontStyle").val(branding.buttons.fontstyle)
    $("#buttonFontSize").val(branding.buttons.fontsize)

    updateBranding();
})

$(window).on('beforeunload', function() {
  if (changed)
    return 'Are you sure you want to leave this page? Your changes might not be saved.';
});
