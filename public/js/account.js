$("#userForm").submit(function(e){
    e.preventDefault();
    formData = new FormData(document.getElementById("userForm"));

    $.ajax({
        url: "/account",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data, status) {
            $(".badge").parent().show();
            $(".badge").addClass("badge-success");
            $(".badge").html("Success");
        },
        error: function (data) {
            $(".badge").parent().show();
            $(".badge").addClass("badge-danger");
            $(".badge").html(data);
        }
    });
})