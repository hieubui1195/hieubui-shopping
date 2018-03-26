@extends('admin.layouts.app')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('custom.nav.orders')
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
                        'admin.order.index',
                        Lang::get('custom.nav.orders')
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
                            @lang('custom.common.order_code', ['attr' => ':']) {{ $order->id }}
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
                    <div class="col-md-6">
                        <strong>
                            @lang('custom.common.email_detail')
                        </strong>
                        {{ $order->email }}

                        <br />

                        <strong>
                            @lang('custom.common.purchase_detail')
                        </strong>
                        {{ \Carbon\Carbon::parse($order->purchase_date)->format('d F\, Y') }}
                    </div>
                    <div class="col-md-6">
                        <strong>
                            @lang('custom.common.shipping_address')
                        </strong>

                        <br />

                        @lang('custom.common.name_detail') {{ $order->name }}

                        <br />

                        @lang('custom.common.address_detail') {{ $order->address }}
                        
                        <br />

                        @lang('custom.common.mobile_detail') {{ $order->phone }}
                        
                        <br />

                    </div>

                    <div class="col-md-12">
                        <table class="table table-bordered" id="order-detail">
                            <thead>
                                <tr>
                                    <th>
                                        @lang('custom.common.order_total')
                                    </th>
                                    <th>
                                        @lang('custom.common.purchase')
                                    </th>
                                    <th>
                                        @lang('custom.common.delivery')
                                    </th>
                                    <th>
                                        @lang('custom.common.status')
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php 
                                            $totalOrder = 0;
                                        ?>
                                        @foreach ($orderDetails as $item)
                                            <?php
                                            $totalOrder += ceil(($item['product']['price'] * $item->amount) * (100 - $promotions[$loop->index]) / 100);
                                            ?>
                                        @endforeach

                                        {{ number_format($totalOrder, 0, '', '.') }} @lang('custom.common.currency') 
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($order->purchase_date)->format('d F\, Y') }}
                                    </td>
                                    <td>
                                        @if ($order->deliver_date != null)
                                            {{ \Carbon\Carbon::parse($order->deliver_date)->format('d F\, Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @switch($order->state)
                                            @case(0)
                                                <p class="label bg-yellow">
                                                    @lang('custom.common.pending')
                                                </p>
                                                @break
                                        
                                            @case(1)
                                                <p class="label bg-green">
                                                    @lang('custom.common.completed')
                                                </p>
                                                @break

                                            @case(0)
                                                <p class="label bg-red">
                                                    @lang('custom.common.reject')
                                                </p>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        {!! html_entity_decode(
                                            Html::link(
                                                null,
                                                '<i class="fa fa-check"></i>',
                                                [
                                                    'id' => 'approve-order',
                                                    'class' => 'btn btn-success approve-order ' . ($order->state == (1 || 2) ? 'disabled' : ''),
                                                    'data-id' => $order->id,
                                                    'title' => Lang::get('custom.common.approve'),
                                                ]
                                            )
                                        ) !!}

                                        {!! html_entity_decode(
                                            Html::link(
                                                null,
                                                '<i class="fa fa-times"></i>',
                                                [
                                                    'id' => 'reject-order',
                                                    'class' => 'btn btn-danger reject-order ' . ($order->state == (1 || 2) ? 'disabled' : ''),
                                                    'data-id' => $order->id,
                                                    'title' => Lang::get('custom.common.reject'),
                                                ]
                                            )
                                        ) !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h3>
                            @lang('custom.common.items')
                        </h3>

                        <table class="table table-bordered" id="order-items">
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
                            </thead>
                            <tbody>
                                @foreach ($orderDetails as $item)
                                    <tr>
                                        <td>
                                            {{ $item->product_id }}
                                        </td>
                                        <td>
                                            {{ $item['product']['name'] }}
                                        </td>
                                        <td>
                                            {{ number_format($item['product']['price'], 0, '', '.') }} @lang('custom.common.currency')
                                        </td>
                                        <td>
                                            {{ $item->amount }}
                                        </td>
                                        <td>
                                            {{ $promotions[$loop->index] }}
                                        </td>
                                        <td>
                                            {{ number_format(ceil(($item['product']['price'] * $item->amount) * (100 - $promotions[$loop->index]) / 100), 0, '', '.') }} @lang('custom.common.currency')
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! Html::linkRoute(
                            'admin.order.index',
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
    {!! Html::script('js/admin/order.js') !!}
@endsection
