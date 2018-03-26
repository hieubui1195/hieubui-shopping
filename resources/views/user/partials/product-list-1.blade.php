@foreach($products as $lp)
    <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="product product-single">
            <div class="product-thumb">
                {!! html_entity_decode(
                    Html::linkRoute(
                        'product',
                        '<button class="main-btn quick-view"><i class="fa fa-search-plus"></i>' . Lang::get('custom.common.view') . '</button>',
                        $lp->id
                    )
                ) !!}
                @php
                    $img = $lp->images->first();
                @endphp
                @if (isset($img))
                    {{ Html::image($img->image) }}
                @endif
            </div>
            <div class="product-body">
                <div class="product-label">
                    @php
                        $km = $lp->promotionDetail;
                    @endphp
                        @if ($km)
                            <span class="sale">
                                @lang('custom.common.sale_to', ['percent' => $km->percent])
                            </span>
                        @endif
                </div>
                <h3 class="product-price">
                    {{ ($km) ? number_format(ceil($lp->price * (100 - $km->percent) / 100)) : number_format($lp->price)}} @lang('custom.common.currency') 
                        @if ($km)
                            <del class="product-old-price">{{ number_format($lp->price) }} @lang('custom.common.currency')</del>
                        @endif
                </h3>
                <h3 class="product-price"></h3>
                <div class="product-rating">
                    @php
                        $count = 0;
                        $rate = 0;

                        foreach( $lp->reviews as $review){
                            $rate = $rate + $review->rate;
                        }
                        
                        $totalRate = count($lp->reviews);
                        if($totalRate!= 0)
                        $avgVote = round($rate / $totalRate,0);
                        else $avgVote = 0;

                    @endphp
                    
                    @if ($avgVote >= 0)
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
                <h2 class="product-name">{{ Html::linkRoute('product', $lp->name, $lp->id)}}</h2>
                <div class="product-btns">
                    @if ($lp->amount > 0)
                        {!! html_entity_decode(
                            Form::button(
                                '<i class="fa fa-shopping-cart"></i>' . Lang::get('custom.common.addcart'),
                                [
                                    'class' => 'primary-btn btn-group add-to-cart',
                                    'data-id' => $lp->id,
                                    'data-price' => ($km) ? ceil($lp->price * (100 - $km->percent) / 100) : $lp->price,
                                    'style' => 'width: 100%;',
                                ]
                            )
                        ) !!}
                    @else
                        {!! html_entity_decode(
                            Form::button(
                                Lang::get('custom.common.sold_out'),
                                [
                                    'class' => 'primary-btn',
                                    'style' => 'background: red; width: 100%;',
                                ]
                            )
                        ) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
