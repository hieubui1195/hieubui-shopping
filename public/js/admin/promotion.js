$(function () {

     // Delete promotion
    $('.delete-promotion').click(function() {
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
                var promotionId = $(this).attr('data-id');
                $("#delete-form-" + promotionId).submit();
                swal(
                    'Deleted!',
                    'The item has been deleted.',
                    'success'
                )
            }
        })
    })
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.reject-promotion-item').click(function(event) {
        event.preventDefault();
        var promotionDetailId = $(this).attr('data-id');
        $.ajax({
            url: '/admin/reject-promotion-item',
            type: 'POST',
            dataType: 'JSON',
            data: { promotionDetailId: promotionDetailId },
            success: function (data) {
                $('#promotion-items').load(location.href + ' #promotion-items');
                $('.alert-success').removeAttr('style');
                $('.alert-success').children().next().text(data.msg);
                $('.alert-success').addClass('alert-blink');
            }
        })
    })
})
