<div class="container">
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="order-summary clearfix">
                <div class="section-title">
                    <h3 class="title">{{ Lang::get('custom.common.orderreview') }}</h3>
                    <a href="{{ route('pdfview',['download'=>'pdf']) }}">Download PDF</a>
                </div>
                <table class="shopping-cart-table table table-responsive">
                    <thead>
                        <tr>
                            <th>@lang('custom.common.product')</th>
                            <th class="text-center">@lang('custom.common.price')</th>
                            <th class="text-center">@lang('custom.common.qty')</th>
                            <th class="text-center">@lang('custom.common.total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr data-id="{{ $item->rowId }}">
                                <td class="details">
                                    {!! Html::linkRoute(
                                        'product',
                                        $item->name,
                                        $item->id
                                    ) !!}
                                </td>
                                <td class="price text-center">
                                    <strong>{{ number_format($item->price, 0, '', '.') }} @lang('custom.common.currency')</strong>
                                    @if ($item->price != $item->options->intPrice)
                                        <br>
                                        <del class="font-weak">
                                            <small>{{ number_format($item->options->intPrice, 0, '', '.') }} @lang('custom.common.currency')</small>
                                        </del>
                                    @endif
                                </td>
                                <td class="qty text-center">
                                    {{ $item->qty }}
                                </td>
                                <td class="total text-center">
                                    <strong class="primary-color">{{ number_format($item->subtotal, 0, '', '.') }} @lang('custom.common.currency')</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="empty"></th>
                            <th>@lang('custom.common.total')</th>
                            <th class="total" id="total-cart">{{ Cart::total() }} @lang('custom.common.currency')</th>
                        </tr>
                    </tfoot>
                </table>

                {{ \Carbon\Carbon::now() }}
            </div>
        </div>
    </div>
</div>
