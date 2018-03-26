@extends('admin.layouts.app')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('custom.nav.products')
            </h1>
            <ol class="breadcrumb">
                <li>
                    {!! html_entity_decode(
                        Html::linkRoute(
                            'admin.home',
                            '<i class="fa fa-dashboard"></i> ' . Lang::get('custom.common.dashboard')
                        )
                    ) !!}
                </li>
                <li>
                    {!! Html::linkRoute(
                        'admin.product.index',
                        Lang::get('custom.nav.products')
                    ) !!}
                </li>
                <li class="active">
                    @lang('custom.common.list')
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            {!! Form::hidden('confirm', Lang::get('custom.form.confirm_delete')) !!}
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <div class="pull-left">
                        <h3 class="pull-left">
                            @lang('custom.common.products')
                        </h3>

                        <br />
    
                        {!! Form::select(
                            'filter-product',
                            [
                                '' => Lang::get('custom.common.products'),
                                Lang::get('custom.common.active') => Lang::get('custom.common.active'),
                                Lang::get('custom.common.deleted') => Lang::get('custom.common.deleted'),
                            ],
                            null,
                            [
                                'class' => 'form-control',
                                'id' => 'filter-product',
                            ]
                        ) !!}
                    </div>
                    <div class="pull-right">
                        {!! html_entity_decode(
                            Html::linkRoute(
                                'admin.product.create',
                                '<i class="fa fa-plus"></i> ' . Lang::get('custom.common.create'),
                                [],
                                [
                                    'class' => 'btn btn-success',
                                ]
                            )
                        ) !!}
                    </div>
                    
                    @include('admin.partials.success')
                </div>
                <div class="box-body">
                    <table id="products-table" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('custom.common.image')</th>
                                <th>@lang('custom.common.name')</th>
                                <th>@lang('custom.common.category')</th>
                                <th>@lang('custom.common.qty')</th>
                                <th>@lang('custom.common.price') @lang('custom.common.currency')</th>
                                <th>@lang('custom.common.status')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        {{-- @if ($products[$loop->index]['images'] != null)
                                            {!! Html::image(
                                                $products[$loop->index]['images'][0]['image'],
                                                'Product Image',
                                                [
                                                    'class' => 'img img-thumbnail product-image',
                                                ]
                                            ) !!}
                                        @endif --}}
                                        
                                    </td>
                                    <td>
                                        @if ($product->deleted_at != null)
                                            {{ $product->name }}
                                        @else
                                        {!! Html::linkRoute(
                                            'admin.product.show',
                                            $product->name,
                                            [
                                                'id' => $product->id
                                            ],
                                            [
                                                'style' => 'color: black; text-decoration: underline;',
                                            ]
                                            
                                        ) !!}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $products[$loop->index]['category']['name'] }}
                                    </td>
                                    <td>
                                        {{ $product->amount }}
                                    </td>
                                    <td>
                                        {{ number_format($product->price, 0, '', '.') }}
                                    </td>
                                    <td>
                                        @if ($product->amount == 0)
                                            <p class="label bg-yellow">
                                                @lang('custom.common.sold_out')
                                            </p>
                                        @else
                                            @if ($product->deleted_at != null)
                                                <p class="label bg-red">
                                                    @lang('custom.common.deleted')
                                                </p>
                                            @else
                                            <p class="label bg-green">
                                                @lang('custom.common.active')
                                            </p>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        {!! html_entity_decode(
                                            Html::linkRoute(
                                                'admin.product.edit',
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    'id' => $product->id
                                                ],
                                                [
                                                    'class' => 'btn btn-info'
                                                ]
                                            )
                                        ) !!}

                                        {!! Form::open([
                                            'route' => ['admin.product.destroy', $product->id],
                                            'method' => 'DELETE',
                                            'id' => 'delete-form-' . $product->id,
                                            'style' => 'display: none;',
                                        ]) !!}

                                        {!! Form::close() !!}

                                        {!! html_entity_decode(
                                            Html::link(
                                                null,
                                                '<i class="fa fa-trash"></i>',
                                                [
                                                    'class' => 'btn btn-danger delete-product ' . ($product->deleted_at != null ? 'disabled' : ''),
                                                    'data-id' => $product->id,
                                                ]
                                            )
                                        ) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>@lang('custom.common.image')</th>
                                <th>@lang('custom.common.name')</th>
                                <th>@lang('custom.common.category')</th>
                                <th>@lang('custom.common.qty')</th>
                                <th>@lang('custom.common.price') @lang('custom.common.currency')</th>
                                <th>@lang('custom.common.status')</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    {!! Html::script('js/admin/product.js') !!}
@endsection
