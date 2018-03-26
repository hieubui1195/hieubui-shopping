<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@lang('custom.common.title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <!-- Bootstrap -->
        {!! Html::style('assets/bootstrap-3.3.7-dist/css/bootstrap.min.css') !!}
        <!-- Ionicons -->
        {!! Html::style('assets/Ionicons/css/ionicons.min.css') !!}
        <!-- Theme style -->
        {!! Html::style('dist/css/AdminLTE.min.css') !!}
        <!-- iCheck -->
        {!! Html::style('assets/iCheck/skins/square/blue.css') !!}
        <!-- Google Font -->
        {!! Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic') !!}

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                {!! Html::linkRoute('home', Lang::get('custom.common.title')) !!}
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">
                    @lang('custom.admin_login.title')
                </p>

                @if (session('status'))
                    <ul>
                        <li class="text-danger" style="list-style-type: none;">{{ session('status') }}</li>
                    </ul>
                @endif
                
                {!! Form::open([
                    'method' => 'POST', 
                    'route' => 'admin.getLogin'
                ]) !!}

                    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!! Form::email(
                            'email', 
                            session('email'), 
                            [
                                'id' => 'email', 
                                'class' => 'form-control', 
                                'required' => 'required', 
                                'autofocus' => 'autofocus', 
                                'placeholder' => Lang::get('custom.admin_login.email_placeholder')
                            ]
                        ) !!}
                        
                    </div>

                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        {!! Form::password(
                            'password', 
                            [
                                'id' => 'password', 
                                'class' => 'form-control', 
                                'required' => 'required', 
                                'autofocus' => 'autofocus', 
                                'placeholder' => Lang::get('custom.admin_login.password_placeholder')
                            ]
                        ) !!}
                        
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                {!! Form::checkbox('remember', old('remember') ? true : false ) !!}
                                {!! Form::label(Lang::get('custom.admin_login.remember_me')) !!}
                            </div>
                        </div>
                        <div class="col-xs-4">
                            {!! Form::submit(Lang::get('custom.admin_login.sign_in_button'), ['class' => 'btn btn-primary btn-block btn-flat']) !!}
                        </div>
                    </div>
                    
                {!! Form::close() !!}
                
                {!! html_entity_decode(
                    Html::linkRoute(
                        'change-language', 
                        Html::image('images/en.png') . Lang::get('custom.common.en'), 
                        [
                            'lang' => 'en'
                        ], 
                        [
                            'style' => 'color:black'
                        ]
                    )
                ) !!}

                {!! html_entity_decode(
                    Html::linkRoute(
                        'change-language', 
                        Html::image('images/vi.png') . Lang::get('custom.common.vi'), 
                        [
                            'lang' => 'vi'
                        ], 
                        [
                            'style' => 'color:black'
                        ]
                    )
                ) !!}

            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        {!! Html::script('assets/jquery/dist/jquery.min.js') !!}
        <!-- Bootstrap -->
        {!! Html::script('assets/bootstrap-3.3.7-dist/js/bootstrap.min.js') !!}
        <!-- iCheck -->
        {!! Html::script('assets/iCheck/icheck.min.js') !!}
        <!-- Main js -->
        {!! Html::script('js/admin/main.js') !!}
    </body>
</html>
