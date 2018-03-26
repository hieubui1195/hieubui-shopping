// Main js
$(function () {

    // Rember login
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });

});

$(document).ready(function() {

    $('.delete-category').click(function() {
        event.preventDefault();
        var strConfirm = $('input[name="confirm"]').val();
        swal({
            title: strConfirm,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                var categoryId = $(this).attr('data-id');
                $("#delete-form-" + categoryId).submit();
            }
        })
    })
    
    $('.select2').select2();

    $('#promotion-range').daterangepicker({ 
        timePicker: true, 
        timePickerIncrement: 30, 
        locale: {
          format: 'YYYY-MM-DD HH:mm:ss'
        },
        startDate: $('#start-date').val(),
        endDate: $('#end-date').val(), 
        function(start, end, label) {
            swal("A new date range was chosen: " + start.format('YYYY-MM-DD HH:mm:ss') + ' to ' + end.format('YYYY-MM-DD HH:mm:ss'));
        }
    });

    var categoriesTable = $('#categories-table').DataTable();

    $('#filter-category').change(function() {
        categoriesTable.search(this.value).draw();   
    })

    var productsTable = $('#products-table').DataTable();

    $('#filter-product').change(function() {
        productsTable.search(this.value).draw();   
    })

    var ordersTable = $('#orders-table').DataTable({
        'order': []
    });

    $('#filter-order').change(function() {
        ordersTable.search(this.value).draw();   
    })

    var promotionsTable = $('#promotions-table').DataTable({
        'order': []
    });

    $('#filter-promotion').change(function() {
        promotionsTable.search(this.value).draw();   
    })

    var userTable = $('#users-table').DataTable({
        'order': []
    });

    $('#filter-user').change(function() {
        userTable.search(this.value).draw();   
    })

    $('.alert-blink').fadeOut('slow');
    $('.alert-blink').fadeOut(5000);
    setInterval(function() {
        $('.alert-blink').remove();
    }, 5000);

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
