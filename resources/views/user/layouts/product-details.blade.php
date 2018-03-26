@extends('user.layouts.layout')

@section('style')
    {!! Html::style('css/user/main.css') !!}
    {!! Html::style('css/user/review.css') !!}
@endsection

@section('content')
<!-- section -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!--  Product Details -->
            <div class="product product-details clearfix">
                <div class="col-md-6">
                    <div id="product-main-view">
                        @foreach ($arrImg as $element)
                            <div class="product-view">
                                {{ Html::image($element, 'a picture') }}
                            </div>
                        @endforeach
                    </div>
                    <div id="product-view">
                        @foreach ($arrImg as $element)
                            <div class="product-view">
                                {{ Html::image($element, 'a picture') }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-body">
                        {!! Form::hidden(
                            'productIdCart',
                            $product->id,
                            [
                                'id' => 'product-id-cart',
                            ]
                        ) !!}
                        <div class="product-label">
                            @if ($promotion)
                                <span class="sale">
                                    @lang('custom.common.sale_to',['percent' => $promotion->percent])
                                </span>
                            @endif
                            @if ($product->deleted_at != null)
                                <p class="label bg-red">
                                    @lang('custom.common.deleted')
                                </p>
                            @endif
                        </div>
                        <h2 class="product-name">
                            {{ $product->name }}
                        </h2>
                        <h3 class="product-price">
                            {{ ($promotion) ? number_format(ceil($product->price * (100 - $promotion->percent)) / 100, 0, '', '.') : number_format($product->price, 0, '', '.') }} @lang('custom.common.currency') 
                            @if ($promotion)
                                <del class="product-old-price">{{ number_format($product->price, 0, '', '.') }} @lang('custom.common.currency')</del>
                            @endif
                            {!! Form::hidden(
                                'price',
                                ($promotion) ? ceil($product->price * (100 - $promotion->percent)) / 100 : number_format($product->price, 0, '', '.'),
                                [
                                    'id' => 'price',
                                ]
                            ) !!}
                        </h3>
                        <div>
                            <div class="product-rating">
                                @if ($avgVote > 0)
                                    @for ($i = 0; $i < $avgVote; $i++)
                                        @if ($i < $avgVote)
                                            <i class="fa fa-star"></i>
                                        @endif
                                    @endfor
                                    @for ($i = $avgVote; $i < 5; $i++)
                                        <i class="fa fa-star-o empty"></i>
                                    @endfor
                                @endif
                            </div>
                            {{ $countVote }} @lang('custom.common.votes')
                            <br />
                            @if ($product->amount > 0)
                                <div class="product-btns">
                                    <div class="qty-input">
                                        <span class="text-uppercase">{{ Lang::get('custom.common.qty') }}</span>
                                        {!! Form::number(
                                            'qty',
                                            1,
                                            [
                                                'class' => 'input qty-checkout',
                                                'data-product-id' => $product->id,
                                                'min' => 1,
                                                'max' => $product->amount,
                                                'id' => 'qty',
                                            ]
                                        ) !!}

                                        {!! Form::hidden('qtyAvailable', $product->amount) !!}
                                    </div>
                                    {!! html_entity_decode(
                                        Form::button(
                                            '<i class="fa fa-shopping-cart"></i> ' . Lang::get('custom.common.addcart'),
                                            [
                                                'class' => 'primary-btn add-to-cart',
                                                'data-id' => $product->id,
                                                'data-price' => ($promotion) ? ceil($product->price * (100 - $promotion->percent)) / 100 : $product->price,
                                            ]
                                        )
                                    ) !!}
                                    <br />
                                    <p class="qty-available" data-product-id="{{ $product->id }}" style="display: inline-block;">
                                        @lang('custom.common.availability', ['qty' => $product->amount])
                                    </p>
                                </div>
                            @else
                                <h4 style="font-weight: bold; color: red;" class="text-uppercase">
                                    @lang('custom.common.sold_out')
                                </h4>                                
                            @endif
                            
                            <h4>
                                @lang('custom.common.description')
                            </h4>
                            <p>{{ $product->description }}</p>
                            <h4>
                                @lang('custom.common.qty')
                            </h4>
                            <p>{{ $product->amount }}</p>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="text-uppercase">{{ Lang::get('custom.common.review') }}</h4>
                            @if (count($reviewLimits) > 0)
                                <div class="product-reviews">
                                    @include('user.partials.review')
                                </div>
                            @else
                                <p>
                                    @lang('custom.common.no_reviews')
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6 col-review">
                            <h4 class="text-uppercase">{{ Lang::get('custom.common.writereview') }}</h4>
                            {{ Form::open([
                                'class' => 'review-form',
                                'id' => 'review-form',
                            ]) }}
                                {!! Form::hidden(
                                    'reviewId',
                                    0,
                                    [
                                        'id' => 'review-id',
                                    ]
                                ) !!}
                                {!! Form::hidden(
                                    'productId',
                                    $product->id,
                                    [
                                        'id' => 'product-id',
                                    ]
                                ) !!}
                                {!! Form::hidden(
                                    'userId',
                                    (Auth::check()) ? Auth::user()->id : 0,
                                    [
                                        'id' => 'user-id',
                                    ]
                                ) !!}
                                <div class="form-group">
                                    {!! Form::email(
                                        'email', 
                                        (Auth::check()) ? Auth::user()->email : null, 
                                        [
                                            'id' => 'email', 
                                            'class' => 'form-control', 
                                            'required' => 'required', 
                                            'autofocus' => 'autofocus', 
                                            'disabled' => 'disabled',
                                            'placeholder' => Lang::get('custom.admin_login.email_placeholder')
                                        ]
                                    ) !!}                                                
                                </div>
                                <div class="form-group">
                                    {!! Form::text(
                                        'title', 
                                        null, 
                                        [
                                            'id' => 'title', 
                                            'class' => 'form-control', 
                                            'required' => 'required', 
                                            'autofocus' => 'autofocus', 
                                            'placeholder' => Lang::get('custom.common.title_review')
                                        ]
                                    ) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::textarea(
                                        'content', 
                                        null, 
                                        [
                                            'id' => 'content', 
                                            'class' => 'form-control', 
                                            'required' => 'required', 
                                            'autofocus' => 'autofocus', 
                                            'placeholder' => Lang::get('custom.common.content_review')
                                        ]
                                    ) !!}
                                </div>
                                <div class="form-group">
                                    <div class="input-rating">
                                        <ul>
                                            <li style="list-style: none; display: inline-block;">
                                                <strong class="text-uppercase">{{Lang::get('custom.common.yourrate')}}</strong>
                                            </li>
                                            <li style="list-style: none; display: inline-block;">
                                                <div class='rating-stars text-center'>
                                                    <ul id='stars'>
                                                        <li class='star' title='Poor' data-value='1'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='Fair' data-value='2'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='Good' data-value='3'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='Excellent' data-value='4'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        <li class='star' title='WOW!!!' data-value='5'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                    </ul>
                                                </div>                                                    
                                            </li>
                                        </ul>
                                    </div>
                                    {!! Form::hidden(
                                        'rate',
                                        0,
                                        [
                                            'id' => 'rate',
                                        ]
                                    ) !!}
                                </div>
                                <div class="form-group">
                                    @auth
                                        <ul>
                                            <li style="list-style: none; display: inline-block;">
                                                {!! Form::submit(
                                                    Lang::get('custom.common.submit'),
                                                    [
                                                        'id' => 'send-review',
                                                        'class' => 'primary-btn',
                                                    ]
                                                ) !!}
                                            </li>
                                            <li style="list-style: none; display: inline-block;">
                                                {!! Form::reset(
                                                    Lang::get('custom.common.cancel'),
                                                    [
                                                        'id' => 'cancel-review',
                                                        'class' => 'main-btn',
                                                    ]
                                                ) !!}
                                            </li>
                                        </ul>
                                    @endauth
                                    @guest
                                        <p>
                                            @lang('custom.common.require_login')
                                        </p>
                                    @endguest
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /section -->
@endsection

@section('script')
    {!! Html::script('js/user/review.js') !!}
@endsection
