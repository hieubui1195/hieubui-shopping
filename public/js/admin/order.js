$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Approve in index
    $('.approve-order').click(function(event) {
        event.preventDefault();
        var orderId = $(this).attr('data-id');
        $.ajax({
            url: '/admin/approve-order',
            type: 'POST',
            dataType: 'JSON',
            data: { orderId: orderId },
            success: function (data) {
                swal({
                    text: data.msg,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.value) {
                        location.reload();
                    }
                })
            }
        })
    })

    $('#reject-order').click(function(event) {
        event.preventDefault();
        var orderId = $(this).attr('data-id');
        $.ajax({
            url: '/admin/order/' + orderId,
            type: 'DELETE',
            dataType: 'JSON',
            data: { orderId: orderId },
            success: function (data) {
                swal({
                    text: data.msg,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.value) {
                        location.href = '/admin/order';
                    }
                })
            }
        })
    })

    $('.reject-order-item').click(function(event) {
        event.preventDefault();
        var orderDetailId = $(this).attr('data-id');
        $.ajax({
            url: '/admin/reject-item',
            type: 'POST',
            dataType: 'JSON',
            data: { orderDetailId: orderDetailId },
            success: function (data) {
                $('#order-items').load(location.href + ' #order-items');
                swal(data.msg);
            }
        })
    })

    $('.reject').click(function(event) {
        event.preventDefault();
        var orderId = $(this).attr('data-id');
        $.ajax({
            url: '/admin/order/' + orderId,
            type: 'DELETE',
            dataType: 'JSON',
            data: { orderId: orderId },
            success: function (data) {
                swal({
                    text: data.msg,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.value) {
                        location.reload();
                    }
                })
            }
        })
    })
})
