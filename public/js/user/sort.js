$(document).ready(function() {
    var type = 0;
    var pathname = window.location.pathname;
    var page = 0;
    $('body').on('change', '.sort-price', function(event) {
        type = parseInt($(this).val());
        $('.sort-price').val(type);
        sortPrice(type, pathname, page);
        paginate(type, pathname, page);
    })

    paginate(type, pathname, page);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function sortPrice(type, pathname, page) {
        var search = getParameterByName('search', window.location.href);
        var url = pathname + '?page=' + page;
        if (search != null) {
            url = pathname + '?search=' + search + '&page=' + page;
        }
        $.ajax({
            url: url,
            type: 'GET',
            datatype: 'JSON',
            data: { type: type },
            success: function(data) {
                $('body').html(data);
                $('.dropdown-toggle').dropdown();
            }
        })
    }

    function paginate(type, pathname, page) {
        $('body').on('click', '.pagination a', function(e){
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            sortPrice(type, pathname, page);
        });
    }

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
});
