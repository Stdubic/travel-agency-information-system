@extends('base::layouts.master')

@section('content')
    @if($type->exists)
        @php $title = 'accommodation::accommodation.type.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.type.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'flaticon-home', 'form' => 'type-form'])
    @if($type->exists)
        {!! Form::open(['id' => 'type-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.type.update', $type->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'type-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.type.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
            <div class="form-group m-form__group">
                {!! Form::label('title[' . $lang . ']', $language) !!}
                @if($type->exists)
                    {!! Form::input('text', 'translation[' . $lang . '][title]', @$type->formattedTranslations[$lang]->title  ,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'translation[' . $lang . '][title]', '' ,['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("translation.{$lang}.title"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("translation.{$lang}.title") }}</strong>
                    </div>
                @endif
            </div>
        @endforeach
        <div class="form-group m-form__group">
            {!! Form::label('standard_capacity', 'Standard capacity') !!}
            @if($type->exists)
                {!! Form::input('number', 'standard_capacity', $type->standard_capacity, ['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('number', 'standard_capacity', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("standard_capacity"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("standard_capacity") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('max_capacity', 'Maximum capacity') !!}
            @if($type->exists)
                {!! Form::input('number', 'max_capacity', $type->max_capacity, ['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('number', 'max_capacity', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("max_capacity"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("max_capacity") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('min_capacity', 'Minimum capacity') !!}
            @if($type->exists)
                {!! Form::input('number', 'min_capacity', $type->min_capacity, ['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('number', 'min_capacity', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("min_capacity"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("min_capacity") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('max_adults', 'Maximum adults') !!}
            @if($type->exists)
                {!! Form::input('number', 'max_adults', $type->max_adults, ['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('number', 'max_adults', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("max_adults"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("max_adults") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('min_children', 'Minimum children') !!}
            @if($type->exists)
                {!! Form::input('number', 'min_children', $type->min_children, ['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('number', 'min_children', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("min_children"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("min_children") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('description', 'Description') !!}
                </div>
                <div class="col-sm-6">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                        @if($type->exists)
                            {!! Form::checkbox('description', 1, $type->description, ['class' => 'form-control m-input switch']) !!}<span></span>
                        @else
                            {!! Form::checkbox('description', 1, null, ['class' => 'form-control m-input switch']) !!}<span></span>
                        @endif
                    </label>
                    @if ($errors->has("description"))
                        <div class="form-control-feedback">
                            <strong>{{ $errors->first("description") }}</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @include('base::layouts.submit_button')
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#accObjectNav').parent().addClass('m-menu__item--open');
        })
    </script>

@endsection
