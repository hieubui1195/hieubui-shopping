@extends('admin.layouts.app')

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('custom.nav.promotions')
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
                        'admin.promotion.index',
                        Lang::get('custom.nav.promotions')
                    ) !!}
                </li>
                <li class="active">
                    @lang('custom.common.edit')
                </li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    @include('admin.partials.success')
                        
                    <h3 style="text-align: center;">
                        @lang('custom.common.edit_promotion')
                    </h3>
                </div>
                <div class="box-body">
                    {!! Form::open(
                        [
                            'route' => ['admin.promotion.update', $promotion->id],
                            'method' => 'PUT',
                            'class' => 'col-md-6 col-md-offset-3',
                            'enctype' => 'multipart/form-data',
                        ]
                    ) !!}

                    {!! Form::hidden('formType', 'edit') !!}

                    <div class="form-group row">
                        {!! Form::label(
                            'name',
                            Lang::get('custom.common.promotion'),
                            [
                                'class' => 'col-sm-3 col-form-label'
                            ]
                        ) !!}

                        <div class="col-sm-9">
                            {!! Form::text(
                                'name',
                                old('name') ? old('name') : $promotion->name,
                                [
                                    'class' => 'form-control',
                                    'placeholder' => Lang::get('custom.common.promotion'),
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
                            'promotionRage',
                            Lang::get('custom.common.promotion_date'),
                            [
                                'class' => 'col-sm-3 col-form-label'
                            ]
                        ) !!}


                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!! Form::text(
                                    'promotionRage',
                                    old('promotionRage') ? old('promotionRage') : $promotion->start_date,
                                    [
                                        'class' => 'form-control pull-right',
                                        'placeholder' => Lang::get('custom.common.promotion_date'),
                                        'required' => 'required',
                                        'id' => 'promotion-range',
                                    ]
                                ) !!}
                            </div>
                            {!! Form::hidden(
                                null,
                                $promotion->start_date,
                                [
                                    'id' => 'start-date',
                                ]
                            ) !!}

                            {!! Form::hidden(
                                null,
                                $promotion->end_date,
                                [
                                    'id' => 'end-date',
                                ]
                            ) !!}

                            @if($errors->first('daterangepicker_start'))
                                <p class="text-danger">
                                    <strong>{{ $errors->first('daterangepicker_start') }}</strong>
                                </p>
                            @endif

                            @if($errors->first('daterangepicker_end'))
                                <p class="text-danger">
                                    <strong>{{ $errors->first('daterangepicker_end') }}</strong>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label(
                            'products',
                            Lang::get('custom.common.select_product'),
                            [
                                'class' => 'col-sm-3 col-form-label'
                            ]
                        ) !!}

                        <div class="col-sm-9">
                            {!! Form::select(
                                'products[]',
                                $products,
                                $promotionDetails,
                                [
                                    'class' => 'form-control select2',
                                    'multiple' => 'multiple',
                                    'style' => 'width: 100%;',
                                    'required' => 'required',
                                ]
                            ) !!}

                            @if($errors->first('products'))
                                <p class="text-danger">
                                    <strong>{{ $errors->first('products') }}</strong>
                                </p>
                            @endif
                        </div> 
                    </div>

                    <div class="form-group row">
                        {!! Form::label(
                            'percent',
                            Lang::get('custom.common.percent'),
                            [
                                'class' => 'col-sm-3 col-form-label'
                            ]
                        ) !!}

                        <div class="col-sm-9">
                            {!! Form::input(
                                'number',
                                'percent',
                                old('percent') ? old('percent') : $percent,
                                [
                                    'class' => 'form-control',
                                    'placeholder' => Lang::get('custom.common.percent'),
                                    'required' => 'required',
                                ]
                            ) !!}

                            @if($errors->first('percent'))
                                <p class="text-danger">
                                    <strong>{{ $errors->first('percent') }}</strong>
                                </p>
                            @endif

                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label(
                            'image',
                            Lang::get('custom.common.image'),
                            [
                                'class' => 'col-sm-3 col-form-label'
                            ]
                        ) !!}

                        <div class="col-sm-9">
                            {!! Form::file(
                                'image',
                                [
                                    'id' => 'image',
                                    'accept' => 'image/*',
                                ]
                            ) !!}

                            @if($errors->first('image'))
                                <p class="text-danger">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </p>
                            @endif

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div id="image-preview">
                                {!! Html::image(
                                    $image,
                                    'Promotion Image',
                                    [
                                        'class' => 'img img-thumbnail col-xs-4',
                                    ]
                                ) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-9">
                            {!! Form::submit(
                                Lang::get('custom.common.edit'),
                                [
                                    'id' => 'btn-edit-promotion',
                                    'class' => 'btn btn-primary',
                                ]
                            ) !!}

                            {!! Html::linkRoute(
                                'admin.promotion.index',
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
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
    {!! Html::script('js/admin/promotion.js') !!}
@endsection
