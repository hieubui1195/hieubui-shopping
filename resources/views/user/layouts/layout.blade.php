<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        
        <title>{!! Lang::get('custom.header.welcome') !!}</title>

        @include('user.layouts.style')
        @section('style')
            @show

    </head>

    <body>
        <!-- HEADER -->
        <header>
            <!-- top Header -->
            <div id="top-header">
                <div class="container">
                    <div class="pull-left">
                        <span>@lang('custom.header.welcome')</span>
                    </div>
                    <div class="pull-right">
                        <ul class="header-top-links">
                            <li class="dropdown default-dropdown">
                                {!! html_entity_decode(
                                    Html::link(
                                        null, 
                                        Lang::get('custom.common.language') . '<i class="fa fa-caret-down"></i>',
                                        [
                                            'class' => 'dropdown-toggle',
                                            'data-toggle' => 'dropdown',
                                            'aria-expanded' => 'true',
                                        ]
                                    )
                                ) !!}
                                <ul class="custom-menu">
                                    <li>
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
                                    </li>
                                    <li>
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
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /top Header -->

            <!-- header -->
            <div id="header">
                <div class="container">
                    <div class="pull-left">
                        <!-- Logo -->
                        <div class="header-logo">
                            {!! html_entity_decode(
                                Html::link(
                                    null, 
                                    Html::image(
                                        'images/bg-login.jpg',
                                        'Logo'
                                    ),  
                                    [
                                        'class' => 'logo'
                                    ]
                                )
                            ) !!}
                        </div>
                        <!-- /Logo -->

                        <!-- Search -->
                        <div class="header-search">
                            {{ Form::open(['route' => 'search', 'method' => 'get']) }}

                            {{ Form::input('text', 'search', isset($search)? $search: '', ['class' => 'input search-input', 'placeholder' => 'Enter your keyword' ]) }}

                                <button class="search-btn"><i class="fa fa-search"></i></button>

                            {{ Form::close() }}                      
                        </div>
                        <!-- /Search -->
                    </div>
                    <div class="pull-right">
                        <ul class="header-btns">
                            <!-- Account -->
                            <li class="header-account dropdown default-dropdown">
                                <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                                    <div class="header-btns-icon">
                                        <i class="fa fa-user-o"></i>
                                    </div>
                                    <strong class="text-uppercase">{!! Lang::get('custom.common.myaccount') !!}<i class="fa fa-caret-down"></i></strong>
                                </div>
                                <span>
                                    @if (Auth::user())
                                        {{ Auth::user()->name }}
                                    @endif
                                </span>
                                <ul class="custom-menu">
                                    @auth
                                    {!! html_entity_decode(
                                        Html::linkRoute(
                                            'information', 
                                            '<li>' .Lang::get('custom.common.myaccount') . '<i class="fa fa-user-o"></i> </li>',
                                            Auth::user()->id
                                        )
                                    ) !!}
                                    
                                    {!! Html::linkRoute(
                                        'logout', 
                                        Lang::get('custom.common.logout_button'), 
                                        [], 
                                        [
                                            'class' => 'logout',
                                        ]
                                    ) !!}
                                    
                                    {!! Form::open([
                                        'id' => 'logout-form', 
                                        'method' => 'POST', 
                                        'route' => 'logout', 
                                        'style' => 'display: none;',
                                        ]
                                    ) !!}
                                    
                                    {!! Form::close() !!}
                                    @endauth

                                    @guest
                                    {!! html_entity_decode(
                                        Html::linkRoute(
                                            'login', 
                                            '<li>' .Lang::get('custom.common.login') . ' <i class="fa fa-unlock-alt"></i> </li>'
                                        )
                                    ) !!}
                                    {!! html_entity_decode(
                                        Html::linkRoute(
                                            'register', 
                                            '<li>' .Lang::get('custom.common.register') . ' <i class="fa fa-user-plus"></i> </li>'
                                        )
                                    ) !!}
                                    @endguest
                                </ul>
                            </li>
                            <!-- /Account -->

                            <!-- Cart -->
                            <li class="header-cart dropdown default-dropdown">
                                @include('user.partials.cart-list')
                            </li>
                            <!-- /Cart -->

                            <!-- Mobile nav toggle-->
                            <li class="nav-toggle">
                                <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                            </li>
                            <!-- / Mobile nav toggle -->
                        </ul>
                    </div>
                </div>
                <!-- header -->
            </div>
            <!-- container -->
        </header>
        <!-- /HEADER -->

        <!-- NAVIGATION -->
        <div id="navigation">
            <!-- container -->
            <div class="container">
                <div id="responsive-nav">
                    <!-- category nav -->

                    <!-- /category nav -->

                    <!-- menu nav -->
                    <div class="menu-nav">
                        <span class="menu-header"><i class="fa fa-bars"></i></span>
                        <ul class="menu-list">
                            <li>
                                {{ Html::linkRoute('home', 'Home')}}
                            </li>
                            @foreach($cates as $cate)
                            <li class="dropdown default-dropdown">
                                {!! html_entity_decode(
                                    Html::link(
                                        null, 
                                        $cate->name . ' <i class="fa fa-caret-down"></i>',
                                        [
                                            'class' => 'dropdown-toggle',
                                            'data-toggle' => 'dropdown',
                                            'aria-expanded' => 'true',
                                        ]
                                    )
                                ) !!}
                                <ul class="custom-menu">
                                @foreach($sub_cates as $sub_cate)
                                    @if( $sub_cate->parent_id == $cate->id)
                                        <li>{{ Html::linkRoute('category', $sub_cate->name, $sub_cate->id) }}</li>
                                    @endif
                                @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- menu nav -->
                </div>
            </div>
            <!-- /container -->
        </div>
        <!-- /NAVIGATION -->

        @section('content')
            @show

        <!-- FOOTER -->
        <footer id="footer" class="section section-grey">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- footer widget -->
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="footer">
                            <!-- footer logo -->
                            <div class="footer-logo">
                                {!! html_entity_decode(
                                    Html::link(
                                        '#',
                                        Html::image('images/bg-login.jpg','logo'),
                                        [
                                            'class' => 'logo'
                                        ]
                                    )
                                ) !!}
                            </div>
                            <!-- /footer logo -->

                            <p>@lang('custom.common.desc')</p>

                            <!-- footer social -->
                            <ul class="footer-social">
                                <li>{!! html_entity_decode(
                                    Html::link(
                                        null, 
                                        '<i class="fa fa-facebook"></i>'
                                    )
                                ) !!}</li>
                                <li>{!! html_entity_decode(
                                    Html::link(
                                        null, 
                                        '<i class="fa fa-twitter"></i>'
                                    )
                                ) !!}</li>
                                <li>{!! html_entity_decode(
                                    Html::link(
                                        null, 
                                        '<i class="fa fa-instagram"></i>'
                                    )
                                ) !!}</li>
                                <li>{!! html_entity_decode(
                                    Html::link(
                                        null, 
                                        '<i class="fa fa-google-plus"></i>'
                                    )
                                ) !!}</li>
                            </ul>
                            <!-- /footer social -->
                        </div>
                    </div>
                    <!-- /footer widget -->

                    <!-- footer widget -->
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-header">@lang('custom.common.myaccount')</h3>
                            <ul class="list-links">
                                @auth
                                    {!! html_entity_decode(
                                        Html::link(
                                            null, 
                                            '<li>' . Lang::get('custom.common.myaccount') . '</li>'
                                        )
                                    ) !!}
                                    {!! html_entity_decode(
                                        Html::linkRoute(
                                            'logout', 
                                            '<li>' . Lang::get('custom.common.logout') . '</li>',
                                            [],
                                            [
                                                'class' => 'logout',
                                            ]
                                        )
                                    ) !!}
                                    {!! Form::open([
                                        'id' => 'logout-form', 
                                        'method' => 'POST', 
                                        'route' => 'logout', 
                                        'style' => 'display: none;',
                                        ]
                                    ) !!}
                                @endauth

                                @guest
                                    {!! html_entity_decode(
                                        Html::linkRoute(
                                            'login', 
                                            '<li>' . Lang::get('custom.common.login') . '</li>'
                                        )
                                    ) !!}
                                    {!! html_entity_decode(
                                        Html::linkRoute(
                                            'register', 
                                            '<li>' . Lang::get('custom.common.register') . '</li>'
                                        )
                                    ) !!}
                                @endguest
                            </ul>
                        </div>
                    </div>
                    <!-- /footer widget -->

                    <div class="clearfix visible-sm visible-xs"></div>

                    <!-- footer widget -->
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-header">@lang('custom.common.customerservice')</h3>
                            <ul class="list-links">
                                <li>{{ Html::link('#', 'About Us')}}</li>
                                <li>{{ Html::link('#', 'FAQ')}}</li>
                            </ul>
                        </div>
                    </div>
                    <!-- /footer widget -->

                    <!-- footer subscribe -->
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-header">@lang('custom.common.news')</h3>
                            <p>@lang('custom.common.desnews')</p>
                            
                            {{ Form::open() }}
                                <div class="form-group">
                                    {{ Form::input(
                                        'text',
                                        'email_input',
                                        null,
                                        [
                                            'class' => 'input',
                                            'placeholder' => 'Enter Email Address',
                                        ]
                                    ) }}
                                </div>
                                <button class="primary-btn">@lang('custom.common.receive')</button>
                            {{ Form::close() }}

                        </div>
                    </div>
                    <!-- /footer subscribe -->
                </div>
                <!-- /row -->
                <hr>
            </div>
            <!-- /container -->
        </footer>
        <!-- /FOOTER -->

        @include('user.layouts.script')
        @section('script')
            @show
    </body>
</html>
