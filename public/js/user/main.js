$(document).ready(function(event) {
    $('.logout').click(function(event) {
        event.preventDefault();
        $('#logout-form').submit();
    })

    $('#image').change(function () {
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $('#image-preview');
            dvPreview.html('');
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = $("<img />");
                        img.attr("src", e.target.result);
                        img.attr("class", "col-xs-4 img img-thumbnail");
                        dvPreview.append(img);
                    }
                    reader.readAsDataURL(file[0]);
                } else {
                    swal(file[0].name + " is not a valid image file.");
                    dvPreview.html('');
                    return false;
                }
            });
        } else {
            swal('This browser does not support HTML5 FileReader.');
        }
    });
})
