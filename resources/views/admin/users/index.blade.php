@extends('admin.layouts.app')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('custom.nav.accounts')
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
                        'admin.user.index',
                        Lang::get('custom.nav.accounts')
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
                <div class="box-header with-buser">
                    <div class="pull-left">
                        <h3 class="pull-left">
                            @lang('custom.common.accounts')
                        </h3>

                        <br />
    
                        {!! Form::select(
                            'filter-user',
                            [
                                '' => Lang::get('custom.common.accounts'),
                                Lang::get('custom.common.admin') => Lang::get('custom.common.admin'),
                                Lang::get('custom.common.user') => Lang::get('custom.common.user'),
                                Lang::get('custom.common.active') => Lang::get('custom.common.active'),
                                Lang::get('custom.common.deleted') => Lang::get('custom.common.deleted'),
                            ],
                            null,
                            [
                                'class' => 'form-control',
                                'id' => 'filter-user',
                            ]
                        ) !!}
                    </div>

                    <div class="pull-right">
                        {!! html_entity_decode(
                            Html::linkRoute(
                                'admin.user.create',
                                '<i class="fa fa-plus"></i> ' . Lang::get('custom.common.create'),
                                [],
                                [
                                    'class' => 'btn btn-success',
                                ]
                            )
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
                    <table id="users-table" class="table table-busered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('custom.common.email')</th>
                                <th>@lang('custom.common.name')</th>
                                <th>@lang('custom.common.role')</th>
                                <th>@lang('custom.common.status')</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr data-id="{{ $user->id }}">
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {!! Html::linkRoute(
                                            'admin.user.show',
                                            $user->name,
                                            [
                                                'id' => $user->id,
                                            ],
                                            [
                                                'style' => 'color: black; text-decoration: underline',
                                                'title' => Lang::get('custom.common.view_detail'),
                                            ]
                                        ) !!}
                                    </td>
                                    <td>
                                        @switch($user->level)
                                            @case(config('custom.defaultOne'))
                                                @lang('custom.common.user')
                                                @break
                                        
                                            @case(config('custom.defaultTwo'))
                                                @lang('custom.common.admin')
                                                @break

                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($user->deleted_at != null)
                                            <p class="label bg-red">
                                                @lang('custom.common.deleted')
                                            </p>
                                        @else
                                            <p class="label bg-green">
                                                @lang('custom.common.active')
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        {!! html_entity_decode(
                                            Html::link(
                                                null,
                                                '<i class="fa fa-trash"></i>',
                                                [
                                                    'class' => 'btn btn-danger delete-user '  . ($user->deleted_at != null ? 'disabled' : ''),
                                                    'data-id' => $user->id,
                                                    'title' => Lang::get('custom.common.delete'),
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
                                <th>@lang('custom.common.email')</th>
                                <th>@lang('custom.common.name')</th>
                                <th>@lang('custom.common.role')</th>
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
    {!! Html::script('js/admin/user.js') !!}
@endsection
