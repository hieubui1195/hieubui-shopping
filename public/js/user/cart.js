$(document).ready(function() {
    var qty = 1,
        qtyAvailable = parseInt($('input[name="qtyAvailable"]').val());
    $('.add-to-cart').click(function(event) {
        var productId = $(this).attr('data-id'),
            price = $(this).attr('data-price'),
            sumQty = parseInt($('#cart-qty').text()) + parseInt($('#qty').val());

        if ($('#qty').val()) {
            qty = $('#qty').val();
        }

        if (qtyAvailable) {
            if (qty > qtyAvailable) {
                qty = qtyAvailable;
                $('#qty').val(qty);
            }

            if (qty <= 0) {
                qty = 1;
                $('#qty').val(qty);
            }

            if (sumQty <= qtyAvailable) {
                addCart(productId, qty, price);
            } else {
                swal({
                    type: 'error',
                    title: 'The cart has the maximum number of products available'
                })
            }
        } else {
            addCart(productId, qty, price);
        }

    });

    $('.header-cart').on('click', '.cancel-btn', function(event) {
        event.preventDefault();
        var rowId = $(this).attr('data-id');
        removeItem(rowId);
    })

    $('.shopping-cart-table').on('click', '.cancel-btn', function(event) {
        event.preventDefault();
        var rowId = $(this).attr('data-id');
        removeItem(rowId);
    })

    $('.qty-checkout').change(function(event) {
        event.preventDefault();
        var rowId = $(this).attr('data-id');
        var qty = $(this).val();
        var productId = $(this).attr('data-product-id');
        if (qty <= 0) {
            qty = 1;
            $(this).val(qty);
        }
        if (rowId) {
            checkQtyProuct(rowId, productId, qty);
            updateCart(rowId, qty);
        }
        checkQty(productId, qty);
    });


    $('#checkout-form').submit(function(event) {
        event.preventDefault();
        var email = $('input[name="email"]').val();
        var name = $('input[name="name"]').val();
        var phone = $('input[name="phone"]').val();
        var address = $('textarea[name="address"]').val();

        checkout(email, name, phone, address);
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function addCart(productId, qty, price) {
        $.ajax({
            url: '/cart',
            type: 'POST',
            datatype: 'JSON',
            data: { productId: productId, qty: qty, price: price },
            success: function(data) {
                $('.header-cart').html(data);
                swal({
                    text: 'Add to cart success',
                    type: 'success',
                })
            }
        })
    }

    function removeItem(rowId) {
        $.ajax({
            url: '/remove-item',
            type: 'POST',
            datatype: 'JSON',
            data: { rowId: rowId },
            success: function(data) {
                $('.header-cart').html(data);
                $("tr[data-id=" + rowId + "]").load(location.href+" tr[data-id=" + rowId + "]>*","");
                $('#total-cart').load(location.href + ' #total-cart');
                $('.product-btns').load(location.href + ' .product-btns');
            }
        })
    }

    function updateCart(rowId, qty) {
        $.ajax({
            url: '/update-cart',
            type: 'POST',
            datatype: 'JSON',
            data: { rowId: rowId, qty: qty },
            success: function(data) {
                location.reload();
            }
        })
    }

    function checkQtyProuct(rowId, id, qtyCompare) {
        $.ajax({
            url: '/check-qty',
            type: 'POST',
            datatype: 'JSON',
            data: { id: id, qtyCompare: qtyCompare },
            success: function(data) {
                if (data.status == false) {
                    $('input[data-product-id="' + id + '"]').val(data.qty);
                    $('p[data-product-id="' + id + '"]').text('Availability: ' + data.qty);
                    updateCart(rowId, data.qty);
                }
            }
        })
    }

    function checkQty(id, qtyCompare) {
        $.ajax({
            url: '/check-qty',
            type: 'POST',
            datatype: 'JSON',
            data: { id: id, qtyCompare: qtyCompare },
            success: function(data) {
                if (data.status == false) {
                    $('input[data-product-id="' + id + '"]').val(data.qty);
                    $('p[data-product-id="' + id + '"]').text('Availability: ' + data.qty);
                }
            }
        })
    }

    function checkout(email, name, phone, address) {
        $.ajax({
            url: '/checkout',
            type: 'POST',
            datatype: 'JSON',
            data: { email: email, name: name, phone: phone, address: address },
            success: function(data) {
                $('#checkout-content').html(data);
            }
        })
    }
})

