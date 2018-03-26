<!-- container -->
<div class="container">
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="order-summary clearfix">
                <div class="section-title">
                    <h3 class="title">{{ Lang::get('custom.common.orderreview') }}</h3>
                </div>
                @if (Cart::count() == 0)
                    <h4>
                        @lang('custom.common.no_cart')
                    </h4>
                @else
                    @include('user.partials.checkout-list')
                @endif
            </div>
        </div>
        @if (Cart::count() > 0)
            {{ Form::open(['class' => 'clearfix', 'id' => 'checkout-form']) }}
                <div class="col-md-6">
                    <div class="section-title">
                        <h3 class="title">@lang('custom.common.order_info')</h3>
                    </div>
                    @if (Auth::check())
                        <div class="form-group">
                            {!! Form::text(
                                'name',
                                Auth::check() ? Auth::user()->name : '', 
                                [
                                    'id' => 'name',
                                    'class' => 'form-control', 
                                    'autofocus' => 'autofocus',
                                    'placeholder' => Lang::get('custom.common.name'),
                                    'disabled' => 'disabled',
                                ]
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::email(
                                'email', 
                                Auth::check() ? Auth::user()->email : '', 
                                [
                                    'id' => 'email',
                                    'class' => 'form-control', 
                                    'required' => 'required',
                                    'autofocus' => 'autofocus', 
                                    'placeholder' => Lang::get('custom.admin_login.email_placeholder'),
                                    'disabled' => 'disabled',
                                ]
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::text(
                                'phone',
                                Auth::check() ? Auth::user()->phone : '', 
                                [ 
                                    'class' => 'form-control', 
                                    'required' => 'required', 
                                    'autofocus' => 'autofocus', 
                                    'placeholder' => Lang::get('custom.common.phone'),
                                    'disabled' => 'disabled',
                                ]
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::textarea( 
                                'address',
                                Auth::check() ? Auth::user()->address : '', 
                                [ 
                                    'class' => 'form-control',
                                    'required' => 'required', 
                                    'autofocus' => 'autofocus', 
                                    'placeholder' => Lang::get('custom.common.address'),
                                    'disabled' => 'disabled',
                                ]
                            ) !!}
                        </div>
                    @else
                        <div class="form-group">
                            {!! Form::text(
                                'name',
                                Auth::check() ? Auth::user()->name : '', 
                                [
                                    'id' => 'name',
                                    'class' => 'form-control', 
                                    'autofocus' => 'autofocus',
                                    'placeholder' => Lang::get('custom.common.name')
                                ]
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::email(
                                'email', 
                                Auth::check() ? Auth::user()->email : '', 
                                [
                                    'id' => 'email',
                                    'class' => 'form-control', 
                                    'required' => 'required',
                                    'autofocus' => 'autofocus', 
                                    'placeholder' => Lang::get('custom.admin_login.email_placeholder')
                                ]
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::text(
                                'phone',
                                Auth::check() ? Auth::user()->phone : '', 
                                [ 
                                    'class' => 'form-control', 
                                    'required' => 'required', 
                                    'autofocus' => 'autofocus', 
                                    'placeholder' => Lang::get('custom.common.phone')
                                ]
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::textarea( 
                                'address',
                                Auth::check() ? Auth::user()->address : '', 
                                [ 
                                    'class' => 'form-control',
                                    'required' => 'required', 
                                    'autofocus' => 'autofocus', 
                                    'placeholder' => Lang::get('custom.common.address'),
                                ]
                            ) !!}
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit(
                                Lang::get('custom.common.placeorder'),
                                [
                                    'class' => 'primary-btn',
                                ]
                            ) !!}
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        @endif
    </div>
    <!-- /row -->
</div>
<!-- /container -->
