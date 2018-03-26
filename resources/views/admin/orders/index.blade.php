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
                            @lang('custom.common.orders')
                        </h3>

                        <br />
    
                        {!! Form::select(
                            'filter-order',
                            [
                                '' => Lang::get('custom.common.orders'),
                                Lang::get('custom.common.pending') => Lang::get('custom.common.pending'),
                                Lang::get('custom.common.completed') => Lang::get('custom.common.completed'),
                                Lang::get('custom.common.reject') => Lang::get('custom.common.reject'),
                            ],
                            null,
                            [
                                'class' => 'form-control',
                                'id' => 'filter-order',
                            ]
                        ) !!}
                    </div>
                    
                    @include('admin.partials.success')
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
                    <table id="orders-table" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>@lang('custom.common.order_code', ['attr' => ''])</th>
                                <th>@lang('custom.common.email')</th>
                                <th>@lang('custom.common.name')</th>
                                <th>@lang('custom.common.purchase')</th>
                                <th>@lang('custom.common.delivery')</th>
                                <th>@lang('custom.common.status')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        {{ $order->id }}
                                    </td>
                                    <td>
                                        {{ $order->email }}
                                    </td>
                                    <td>
                                        {{ $order->name }}
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
                                        @if ($order->deleted_at != null)
                                            <p class="label bg-red">
                                                @lang('custom.common.deleted')
                                            </p>
                                        @else
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

                                                @case(2)
                                                    <p class="label bg-red">
                                                        @lang('custom.common.reject')
                                                    </p>
                                                    @break
                                            @endswitch
                                        @endif
                                    </td>
                                    <td>
                                        {!! html_entity_decode(
                                            Html::linkRoute(
                                                'admin.order.show',
                                                '<i class="fa fa-info"></i>',
                                                [
                                                    'id' => $order->id
                                                ],
                                                [
                                                    'class' => 'btn btn-success info ' . ($order->deleted_at != null || $order->state == 2 ? 'disabled' : ''),
                                                    'data-id' => $order->id,
                                                    'title' => Lang::get('custom.common.view_detail'),
                                                ]
                                            )
                                        ) !!}

                                        {!! html_entity_decode(
                                            Html::link(
                                                null,
                                                '<i class="fa fa-check"></i>',
                                                [
                                                    'class' => 'btn btn-success approve-order ' . ($order->deleted_at != null || $order->state == (1 || 2) ? 'disabled' : ''),
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
                                                    'class' => 'btn btn-danger reject '  . ($order->deleted_at != null || $order->state == (1 || 2) ? 'disabled' : ''),
                                                    'data-id' => $order->id,
                                                    'title' => Lang::get('custom.common.reject'),
                                                ]
                                            )
                                        ) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>@lang('custom.common.order_code', ['attr' => ''])</th>
                                <th>@lang('custom.common.email')</th>
                                <th>@lang('custom.common.name')</th>
                                <th>@lang('custom.common.purchase')</th>
                                <th>@lang('custom.common.delivery')</th>
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
    {!! Html::script('js/admin/order.js') !!}
 @endsection
