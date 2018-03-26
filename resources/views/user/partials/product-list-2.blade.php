@foreach($products as $pp)
    <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="product product-single">
            <div class="product-thumb">
                {!! html_entity_decode(
                    Html::linkRoute(
                        'product',
                        '<button class="main-btn quick-view"><i class="fa fa-search-plus"></i>' . Lang::get('custom.common.view') . '</button>',
                        $pp->product->id
                    )
                ) !!}
                @php
                    $img = $pp->product->images->first();
                @endphp
                @if (isset($img))
                    {{ Html::image($img->image) }}
                @endif
            </div>
            <div class="product-body">
                <div class="product-label">
                        @if ($pp->percent)
                            <span class="sale">
                                @lang('custom.common.sale_to', ['percent' => $pp->percent])
                            </span>
                        @endif
                </div>
                <h3 class="product-price">
                    {{ ($pp->percent != 0 ) ? number_format(ceil($pp->product->price * (100 - $pp->percent) / 100)) : number_format($pp->product->price) }} @lang('custom.common.currency') 
                        @if ($pp->percent != 0)
                            <del class="product-old-price">{{ number_format($pp->product->price) }} @lang('custom.common.currency')</del>
                        @endif
                </h3>
                <div class="product-rating">
                    @php
                        $count = 0;
                        $rate = 0;

                        foreach( $pp->product->reviews as $review){
                            $rate = $rate + $review->rate;
                        }
                        
                        $totalRate = count($pp->product->reviews);
                        
                        if($totalRate!= 0)
                        $avgVote = floor($rate / $totalRate);
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
                <h2 class="product-name">{{ Html::linkRoute('product', $pp->product->name, $pp->product->id) }}</h2>
                <div class="product-btns">
                    
                    @if ($pp->product->amount > 0)
                        {!! html_entity_decode(
                            Form::button(
                                '<i class="fa fa-shopping-cart"></i>' . Lang::get('custom.common.addcart'),
                                [
                                    'class' => 'primary-btn add-to-cart',
                                    'data-id' => $pp->product->id,
                                    'data-price' => ($pp->percent != 0 ) ? ceil($pp->product->price * (100 - $pp->percent) / 100) : $pp->product->price,
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
