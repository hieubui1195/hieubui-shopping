@extends('admin.layouts.app')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('custom.nav.promotions')
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
                        'admin.promotion.index',
                        Lang::get('custom.nav.promotions')
                    ) !!}
                </li>
                <li class="active">
                    @lang('custom.common.show')
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
                            {{ $promotion->name }}
                        </h3>
                    </div>
                    
                    <div class="alert alert-success alert-dismissible col-sm-3" style="display: none;">
                        {!! Form::button(
                            '&times;',
                            [
                                'class' => 'close',
                                'data-dismiss' => 'alert',
                            ]
                        ) !!}
                        <strong></strong>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <dl class="dl-horizontal">
                            <dt>@lang('custom.common.start_date')</dt>
                            <dd>{{ \Carbon\Carbon::parse($promotion->start_date)->format('d F\, Y') }}</dd>
                            <dt>@lang('custom.common.end_date')</dt>        
                            <dd>{{ \Carbon\Carbon::parse($promotion->end_date)->format('d F\, Y') }}</dd>
                            <dt>@lang('custom.common.status')</dt>
                            <dd>
                                @if ($promotion->deleted_at != null)
                                    <p class="label bg-red">
                                        @lang('custom.common.deleted')
                                    </p>
                                @else
                                    @if (\Carbon\Carbon::parse($promotion->end_date)->isPast())
                                        <p class="label bg-yellow">
                                            @lang('custom.common.finished')
                                        </p>
                                    @elseif (\Carbon\Carbon::parse($promotion->start_date)->isFuture())
                                        <p class="label bg-blue">
                                            @lang('custom.common.comming')
                                        </p>
                                    @else
                                        <p class="label bg-green">
                                            @lang('custom.common.active')
                                        </p>
                                    @endif
                                @endif
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered" id="promotion-items">
                            <thead>
                                <th>
                                    @lang('custom.common.product_id')
                                </th>
                                <th>
                                    @lang('custom.common.product_name')
                                </th>
                                <th>
                                    @lang('custom.common.price')
                                </th>
                                <th>
                                    @lang('custom.common.qty')
                                </th>
                                <th>
                                    @lang('custom.common.product_discount')
                                </th>
                                <th>
                                    @lang('custom.common.total_price')
                                </th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($promotionDetails as $item)
                                    <tr>
                                        <td>
                                            {{ $item['product']['id']}}
                                        </td>
                                        <td>
                                            {{ $item['product']['name'] }}
                                        </td>
                                        <td>
                                            {{ $item['product']['price'] }} @lang('custom.common.currency')
                                        </td>
                                        <td>
                                            {{ $item['product']['amount'] }}
                                        </td>
                                        <td>
                                            {{ $promotionDetails[0]['percent'] }}
                                        </td>
                                        <td>
                                            {{ ceil($item['product']['price'] * (100 - $promotionDetails[0]['percent']) / 100) }} @lang('custom.common.currency')
                                        </td>
                                        <td>
                                            {!! html_entity_decode(
                                                Html::link(
                                                    null,
                                                    '<i class="fa fa-times"></i>',
                                                    [
                                                        'class' => 'btn btn-danger reject-promotion-item',
                                                        'data-id' => $promotionDetails[$loop->index]['id'],
                                                        'title' => Lang::get('custom.common.reject'),
                                                    ]
                                                )
                                            ) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! Html::linkRoute(
                            'admin.promotion.index',
                            Lang::get('custom.common.back'),
                            [],
                            [
                                'class' => 'btn btn-warning',
                            ]
                        ) !!}
                    </div>
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
    {!! Html::script('js/admin/promotion.js') !!}
 @endsection
