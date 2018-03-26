$(document).ready(function() {

    $('#stars li').on('mouseover', function(){
        var onStar = parseInt($(this).data('value'), 10); 
       
        $(this).parent().children('li.star').each(function(e){
          if (e < onStar) {
            $(this).addClass('hover');
          }
          else {
            $(this).removeClass('hover');
          }
        });
        
    }).on('mouseout', function(){
        $(this).parent().children('li.star').each(function(e){
            $(this).removeClass('hover');
        });
    });
      
    $('#stars li').on('click', function(){
        var onStar = parseInt($(this).data('value'), 10);
        var stars = $(this).parent().children('li.star');

        $('#rate').val(onStar);
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }
        
        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
        
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/check-review',
        type: 'POST',
        datatype: 'JSON',
        data: {productId: $('#product-id').val(), userId: $('#user-id').val()},
        success: function(data) {
            if (data.status == false) {
                productId = $('#product-id').val();
                userId = $('#user-id').val();
                $('.col-review').on('submit', '#review-form', function (event) {
                    event.preventDefault();
                    title = $('#title').val();
                    content = $('#content').val();
                    rate = $('#rate').val();
                    sendReview(productId, userId, title, content, rate);
                })
            } else {
                $('#send-review').attr('style', 'display: none;');
                $('#cancel-review').attr('style', 'display: none;');
            }
        }
    })

    $('#cancel-review').click(function() {
        clearForm();
        getReview($('#review-id').val());
    })

    $('.product-reviews').on('click', '.edit-review', function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        $('#review-id').val(id);
        getReview(id);
    })

    $('.col-review').on('submit', '.form-edit', function (event) {
        event.preventDefault();
        var id = $('#review-id').val();
        var productId = $('#product-id').val();
        var title = $('#title').val();
        var content = $('#content').val();
        var rate = $('#rate').val();
        editReview(id, productId, title, content, rate);
    })

    $('.product-reviews').on('click', '.delete-review', function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var productId = $('#product-id').val();
        swal({
            text: 'Do you want delete this review?',
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/delete-review/' + id,
                    method: 'DELETE',
                    dataType: 'TEXT',
                    data: { id: id, productId: productId },
                    success: function (data) {
                        // $('.product-reviews').html(data);
                        $('.product-reviews').load(location.href + ' .product-reviews');
                        swal({
                            text: 'Review has been deleted.',
                            type: 'success'
                        })
                        clearForm();
                        checkReview(productId, userId);
                    },
                    error: function (request, status, error) {
                        swal({
                            text: request.responseText,
                            type: 'error'
                        })
                    }
                })
            }
        })
    })

    $('.product-reviews').on('click', '#btn-more',function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var productId = $('#product-id').val();
        $('#btn-more').html('Loading....');
        $.ajax({
            url: '/load-data',
            method: 'POST',
            data: { id: id, productId: productId },
            dataType: 'TEXT',
            success: function (data) {
                if(data != '') {
                    $('#remove-row').remove();
                    $('.product-reviews').append(data);
                } else {
                    $('#btn-more').html('No Data');
                }
            }
        });
    });
});

function checkReview(productId, userId) {
    $.ajax({
        url: '/check-review',
        type: 'POST',
        datatype: 'JSON',
        data: {productId: $('#product-id').val(), userId: $('#user-id').val()},
        success: function(data) {
            if (data.status == false) {
                $('#send-review').attr('style', 'display: block;').addClass('edit-review');
                $('#cancel-review').attr('style', 'display: block;');
            } else {
                $('#send-review').attr('style', 'display: none;');
                $('#cancel-review').attr('style', 'display: none;');
            }
        }
    })
}

function sendReview(productId, userId, title, content, rate) {
    $.ajax({
        url: '/review',
        type: 'POST',
        datatype: 'JSON',
        data: { productId: productId, userId: userId, title: title, content: content, rate: rate },
        success: function(data) {
            $('.product-reviews').html(data);
            $('.product-reviews').load(location.href + ' .product-reviews');
            clearForm();
            checkReview(productId, userId)
        }
    })
}

function getReview(id) {
    $.ajax({
        url: '/get-review/' + id,
        type: 'POST',
        datatype: 'JSON',
        data: {id: id},
        success: function(data) {
            $('#review-form').addClass('form-edit');
            $('#product-id').val(data.productId);
            $('#title').val(data.title);
            $('#content').val(data.content);
            setStar(data.rate);
            $('#send-review').attr('style', 'display: block;');
            $('#cancel-review').attr('style', 'display: block;');
        }
    })
}

function setStar(value) {
    for (i = 0; i < value; i++) {
        $('#stars li').eq(i).addClass('selected');
    }
    $('#rate').val(value);
}

function editReview(id, productId, title, content, rate) {
    $.ajax({
        url: '/edit-review',
        type: 'POST',
        datatype: 'JSON',
        data: {id: id, productId: productId, title: title, content: content, rate: rate},
        success: function(data) {
            clearForm();
            $('.product-reviews').html(data);
            $('#send-review').attr('style', 'display: none;');
            $('#cancel-review').attr('style', 'display: none;');
        }
    })
}

function clearForm() {
    $('#review-form').trigger('reset');
    $('.star').removeClass('selected');
}
