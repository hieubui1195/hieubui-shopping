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
                    @lang('custom.common.show')
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            {!! Html::image(
                                $user[0]['image']['image'],
                                'User profile picture',
                                [
                                    'class' => 'profile-user-img img-responsive img-circle',
                                ]
                            ) !!}

                            <h3 class="profile-username text-center">{{ $user[0]['name'] }}</h3>

                            <p class="text-muted text-center">
                                @lang('custom.common.admin')
                            </p>
                            
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('custom.common.contact_me')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i> @lang('custom.common.email')</strong>

                            <p class="text-muted">{!! $user[0]['email'] !!}</p>

                            <hr>

                            <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('custom.common.phone')</strong>

                            <p class="text-muted">{!! $user[0]['phone'] !!}</p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 style="text-align: center;">@lang('custom.common.edit_profile')</h3>
                        </div>
                        <div class="box-body">
                            {!! Form::open(
                                [
                                    'route' => ['admin.user.update', $user[0]['id']],
                                    'method' => 'PUT',
                                    'class' => 'col-md-10 col-md-offset-1',
                                    'enctype' => 'multipart/form-data',
                                ]
                            ) !!}

                            {!! Form::hidden('formType', 'edit') !!}

                            <div class="form-group row">
                                {!! Form::label(
                                    'email',
                                    Lang::get('custom.common.email'),
                                    [
                                        'class' => 'col-sm-3 col-form-label'
                                    ]
                                ) !!}

                                <div class="col-sm-9">
                                    {!! Form::text(
                                        'email',
                                        $user[0]['email'],
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Lang::get('custom.common.email'),
                                            'required' => 'required',
                                            'disabled' => 'disabled',
                                        ]
                                    ) !!}

                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label(
                                    'name',
                                    Lang::get('custom.common.name'),
                                    [
                                        'class' => 'col-sm-3 col-form-label'
                                    ]
                                ) !!}

                                <div class="col-sm-9">
                                    {!! Form::text(
                                        'name',
                                        old('name') ? old('name') : $user[0]['name'],
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Lang::get('custom.common.name'),
                                            'required' => 'required',
                                        ]
                                    ) !!}

                                    @if($errors->first('name'))
                                        <p class="text-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </p>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label(
                                    'address',
                                    Lang::get('custom.common.address'),
                                    [
                                        'class' => 'col-sm-3 col-form-label'
                                    ]
                                ) !!}

                                <div class="col-sm-9">
                                    {!! Form::text(
                                        'address',
                                        old('address') ? old('address') : $user[0]['address'],
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Lang::get('custom.common.address'),
                                        ]
                                    ) !!}

                                    @if($errors->first('address'))
                                        <p class="text-danger">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </p>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label(
                                    'phone',
                                    Lang::get('custom.common.phone'),
                                    [
                                        'class' => 'col-sm-3 col-form-label'
                                    ]
                                ) !!}

                                <div class="col-sm-9">
                                    {!! Form::text(
                                        'phone',
                                        old('phone') ? old('phone') : $user[0]['phone'],
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Lang::get('custom.common.phone'),
                                        ]
                                    ) !!}

                                    @if($errors->first('phone'))
                                        <p class="text-danger">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </p>
                                    @endif

                                </div>
                            </div>
                            
                            <div class="form-group row">
                                {!! Form::label(
                                    'password',
                                    Lang::get('custom.common.password'),
                                    [
                                        'class' => 'col-sm-3 col-form-label'
                                    ]
                                ) !!}

                                <div class="col-sm-9">
                                    {!! Form::password(
                                        'password',
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Lang::get('custom.common.password'),
                                        ]
                                    ) !!}

                                    @if($errors->first('password'))
                                        <p class="text-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </p>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label(
                                    'password_confirmation',
                                    Lang::get('custom.common.re_pass'),
                                    [
                                        'class' => 'col-sm-3 col-form-label'
                                    ]
                                ) !!}

                                <div class="col-sm-9">
                                    {!! Form::password(
                                        'password_confirmation',
                                        [
                                            'class' => 'form-control',
                                            'placeholder' => Lang::get('custom.common.re_pass'),
                                        ]
                                    ) !!}
                                    @if($errors->first('password_confirmation'))
                                        <p class="text-danger">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label(
                                    'avatar',
                                    Lang::get('custom.common.avatar'),
                                    [
                                        'class' => 'col-sm-3 col-form-label'
                                    ]
                                ) !!}

                                <div class="col-sm-9">
                                    {!! Form::file(
                                        'avatar',
                                        [
                                            'id' => 'image',
                                            'accept' => 'image/*',
                                        ]
                                    ) !!}

                                    @if($errors->first('avatar'))
                                        <p class="text-danger">
                                            <strong>{{ $errors->first('avatar') }}</strong>
                                        </p>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <div id="image-preview">
                                        {!! Html::image(
                                            $user[0]['image']['image'],
                                            'User Image',
                                            [
                                                'class' => 'img img-thumbnail col-xs-4',
                                            ]
                                        ) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-9">
                                    @if (Auth::user()->id == $user[0]['id'])
                                        {!! Form::submit(
                                            Lang::get('custom.common.edit'),
                                            [
                                                'class' => 'btn btn-primary',
                                            ]
                                        ) !!}
                                    @endif

                                    {!! Html::linkRoute(
                                        'admin.user.index',
                                        Lang::get('custom.common.back'),
                                        [],
                                        [
                                            'class' => 'btn btn-warning',
                                        ]
                                    ) !!}
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
@endsection
