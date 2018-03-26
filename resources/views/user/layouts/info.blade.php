@extends('user.layouts.layout')
@section('content')
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!--  Product Details -->
                <div class="product product-details clearfix">
                    
                        <div id="avatar">
                            {{-- @if ($user->image)
                                @php
                                    $a = $user->image->image;
                                @endphp
                                {{ Html::image($a, 'a picture') }}
                            @endif --}}

                        </div>
                    
                    <div class="col-md-6">
                        <div class="product-body">
                            
                            <h3 class="product-price" style="color: orange;">
                               {{ Lang::get('custom.common.username') }} :
                            </h3>

                            <h4 class="product-name" style="margin-left: 35px;">
                                {{ $user->name }}
                            </h4>

                            <h3 class="product-price" style="color: orange;">
                               {{ Lang::get('custom.common.email') }} :
                            </h3>

                            <h4 class="product-name" style="margin-left: 35px;">
                                {{ $user->email }}
                            </h4>
                            
                            <h3 class="product-price" style="color: orange;">
                               {{ Lang::get('custom.common.address') }} :
                            </h3>

                            <h4 class="product-name" style="margin-left: 35px;">
                                {{ $user->address }}
                            </h4>

                            <h3 class="product-price" style="color: orange;">
                               {{ Lang::get('custom.common.phone') }} :
                            </h3>

                            <h4 class="product-name" style="margin-left: 35px;">
                                {{ $user->phone }}
                            </h4>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="product-tab">
                            <ul class="tab-nav">
                                <li class="active">
                                    {{ Html::link('#tab1',Lang::get('custom.common.history'),['data-toggle' => 'tab']) }}
                                </li>
                                <li>
                                    {{ Html::link('#tab2',Lang::get('custom.common.update'),['data-toggle' => 'tab']) }}
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab1" class="tab-pane fade in active">
                                    <table class="shopping-cart-table table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="color: orange;" >Order ID</th>
                                                <th></th>
                                                <th class="text-left" style="color: orange;" >Product</th>
                                                <th class="text-center" style="color: orange;" >Quantity</th>
                                                <th class="text-center" style="color: orange;" >Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            if($orders){
                                                foreach ($orders as $order) {
                                                    $details = $order->orderDetails;
                                                    foreach ($details as $detail) {
                                                    @endphp
                                                            <tr>
                                                                <td class="price text-center"><strong>{{ $detail->order_id }}</strong></td>
                                                                <td class="thumb">
                                                                    {{ Html::image($detail->product->images->first()->image, 'a picture') }}
                                                                </td>
                                                                <td class="details">
                                                                    {{ Html::linkRoute('product', $detail->product->name, $detail->product_id)}}
                                                                </td>
                                                                <td class="price text-center"><strong>{{$detail->amount}}</strong></td>
                                                                <td class="price text-center"><strong>{{ number_format($detail->product->price) }}</strong></td>
                                                            </tr>
                                                    @php  
                                                    }
                                                }
                                            }
                                            @endphp
                                        </tbody>
                                    </table>
                                </div>
                                    
                                <div id="tab2" class="tab-pane fade in">
                                    <div class="box-body">
                                        {!! Form::open(
                                            [
                                                'route' => ['userupdate', $user->id],
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
                                                    'class' => 'col-sm-3 col-form-label',
                                                ]
                                            ) !!}

                                            <div class="col-sm-9">
                                                {!! Form::text(
                                                    'email',
                                                    $user->email,
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
                                                    $user->name,
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
                                                    $user->address,
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
                                                    $user->phone,
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
                                                    {{-- @if ($user->image->image)
                                                        {!! Html::image(
                                                            $user->image->image,
                                                            'User Image',
                                                            [
                                                                'class' => 'img img-thumbnail col-xs-4',
                                                            ]
                                                        ) !!}
                                                    @endif --}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                @if (Auth::check() && Auth::user()->id == $user->id)
                                                    {!! Form::submit(
                                                        Lang::get('custom.common.edit'),
                                                        [
                                                            'class' => 'btn btn-primary',
                                                        ]
                                                    ) !!}
                                                @endif

                                                {!! Html::linkRoute(
                                                    'home',
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /section -->
@endsection
