@extends('user.layouts.product-list')

@section('product-list')
    @section('sortby')
        {!! Form::select(
            'sort',
            [
                '' => Lang::get('custom.common.sel_sort'),
                config('custom.defaultOne') => Lang::get('custom.common.price_asc'),
                config('custom.defaultTwo') => Lang::get('custom.common.price_desc'),
            ],
            null,
            [
                'class' => 'input sort-price',
                'style' => 'width: 200px',
            ]
        ) !!}
        <span style="margin-left: 20px;">
            @lang('custom.common.search_result', [
                'result' => $products->total(),
                'key' => $search,
            ])
        </span>
    @endsection
    
    @section('paginate', $products->links())

    @include('user.partials.product-list-1', [
        'products' => $products,
    ])
@endsection
