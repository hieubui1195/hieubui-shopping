@extends('user.layouts.layout')

@section('content')
<!-- HOME -->
<div id="home">
    <!-- container -->
    <div class="container">
        <!-- home wrap -->
        <!-- <div class="home-wrap"> -->
            <!-- home slick -->
            <div id="home-slick">
                @foreach ($images as $image)
                <div class="banner banner-1">
                    {!! Html::image($image->image) !!}
                    <div class="banner-caption text-center">
                        <h1>{!! Lang::get('custom.header.welcome') !!}</h1>
                        <h3 class="white-color font-weak">{!! Lang::get('custom.common.discount') !!}</h3>
                        {!! Html::link(
                            '#shop-now',
                            Lang::get('custom.common.shopnow'),
                            [
                                'class' => 'primary-btn',
                            ]
                        ) !!}
                    </div>
                </div>
                @endforeach
        <!-- </div> -->
        <!-- /home wrap -->
    </div>
    <!-- /container -->
</div>
<!-- /HOME -->

<!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row" id="shop-now">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        {!! html_entity_decode(
                            Html::linkRoute(
                                'latestproduct',
                                '<h2 class="title">' . Lang::get('custom.common.latestproduct') . ' <i class="fa fa-arrow-right"></i></h2>',
                                [],
                                [
                                    'title' => Lang::get('custom.homepage.more_info'),
                                ]
                            )
                        ) !!}
                    </div>
                </div>
                @include('user.partials.product-list-1', [
                    'products' => $lastest_products,
                ])

                <div class="col-md-12">
                    <div class="section-title">
                        {!! html_entity_decode(
                            Html::linkRoute(
                                'promotionproduct',
                                '<h2 class="title">' . Lang::get('custom.common.discountproduct') . ' <i class="fa fa-arrow-right"></i></h2>',
                                [],
                                [
                                    'title' => Lang::get('custom.homepage.more_info'),
                                ]
                            )
                        ) !!}
                    </div>
                </div>
                @include('user.partials.product-list-2', [
                    'products' => $promotion_products,
                ])

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection
