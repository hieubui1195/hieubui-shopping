@extends('user.layouts.layout')

@section('content')
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- MAIN -->
                <div id="main" class="col-md-12">
                    <div class="store-filter clearfix">
                        <div class="pull-left">
                            <div class="sort-filter">
                                <span class="text-uppercase">@lang('custom.common.sortby')</span>
                                
                                @yield('sortby')
                                
                            </div>
                        </div>
                        <div class="pull-right">
                            @yield('paginate')
                        </div>
                    </div>
                    <!-- /store top filter -->

                    <!-- STORE -->
                    <div id="store">
                        <!-- row -->
                        <div class="row">
                            @section('product-list')
                                @show
                        </div>
                    <!-- /row -->
                    </div>
                </div>
                <!-- /MAIN -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection

@section('script')
    {!! Html::script('js/user/sort.js') !!}
@endsection
