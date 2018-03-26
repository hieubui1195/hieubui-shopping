@extends('admin.layouts.app')

@section('style')
    <!-- Google font -->
    {{ Html::style('https://fonts.googleapis.com/css?family=Hind:400,700') }}    
    <!-- Slick -->
    {{ Html::style('assets/css/slick.css') }}
    {{ Html::style('assets/css/slick-theme.css') }}
    
    <!-- nouislider -->
    {{ Html::style('assets/css/nouislider.min.css') }}

    <!-- Font Awesome Icon -->
    {{ Html::style('assets/css/font-awesome.min.css') }}
    
    <!-- Custom stlylesheet -->
    {{ Html::style('assets/css/style.css') }}
@endsection
@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('custom.nav.products')
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
                        'admin.product.index',
                        Lang::get('custom.nav.products')
                    ) !!}
                </li>
                <li class="active">
                    @lang('custom.common.show')
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box" style="padding: 20px">
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
                                    {!! html_entity_decode(
                                        Html::linkRoute(
                                            'admin.product.edit',
                                            Lang::get('custom.common.edit'),
                                            [
                                                'id' => $product->id,
                                            ],
                                            [
                                                'class' => 'btn btn-warning',
                                                'title' => 'Edit Product',
                                            ]
                                        )

                                    ) !!}
                                </div>
                                
                                @include('admin.partials.product-tab')
                            </div>
                        </div>
                        

                    </div>
                    <!-- /Product Details -->
                </div>
                <!-- /row -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    {!! Html::script('assets/js/slick.min.js') !!}
    {!! Html::script('assets/js/nouislider.min.js') !!}
    {!! Html::script('assets/js/jquery.zoom.min.js') !!}
    {!! Html::script('assets/js/main.js') !!}
@endsection
