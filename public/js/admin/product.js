$(function () {

    var formType = $('input[name="formType"]').val();

    // Delete product
    $('.delete-product').click(function() {
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
                var productId = $(this).attr('data-id');
                $("#delete-form-" + productId).submit();
            }
        })
    })

    // Check form type
    // If type is reuse then disabled
    if (formType != 'reuse') {
        $('[data-quantity="plus"]').click(function(e){
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            var currentVal = parseInt($('input[name='+fieldName+']').val());
            if (!isNaN(currentVal)) {
                $('input[name='+fieldName+']').val(currentVal + 1);
            } else {
                $('input[name='+fieldName+']').val(0);
            }
        });
        $('[data-quantity="minus"]').click(function(e) {
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            var currentVal = parseInt($('input[name='+fieldName+']').val());
            if (!isNaN(currentVal) && currentVal > 0) {
                $('input[name='+fieldName+']').val(currentVal - 1);
            } else {
                $('input[name='+fieldName+']').val(0);
            }
        });
    }

    // Ajax

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Reuse product
    if (formType == 'reuse') {
        // Disable form element
        $('#form-edit-product').find('select, input, textarea, span').attr('disabled', 'disabled');
        // Enable button reuse
        $('#btn-reuse').removeAttr('disabled');

        // Request reuse
        $('#form-edit-product').submit(function(event) {
            event.preventDefault();
            var name = $('#name').val();
            $.ajax({
                url: '/admin/reuse-product',
                type: 'POST',
                dataType: 'JSON',
                data: { name: name },
                success: function (data) {
                    console.log(data.statusReuse);
                    if (data.statusReuse == 1) {
                        $('.alert-success').removeAttr('style');
                        $('.alert-success').children().next().text('The item has been reuse');
                        $('.alert-success').addClass('alert-blink');
                        $('#box-edit-product').load(location.href + ' #box-edit-product');
                        $('input').select2();
                    }

                }
            })
        })
    }
});
