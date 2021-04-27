@extends('base::layouts.master')

@section('content')
    @if($language->exists)
        @php $title = 'base::base.settings.language.update.name'; @endphp
    @else
        @php $title = 'base::base.settings.language.create.name'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-wrench', 'form' => 'language-form'])
    @if($language->exists)
        {!! Form::open(['id' => 'language-form', 'class' => 'm-form form-notify', 'route' => ['language.update', $language->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'language-form', 'class' => 'm-form form-notify', 'route' => 'language.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        <div class="form-group m-form__group">
            {!! Form::label('name', 'Language') !!}
            @if($language->exists)
                {!! Form::input('text', 'name', $language->name  ,['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('text', 'name', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("name"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("name") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('code', 'Language code') !!}
            @if($language->exists)
                {!! Form::input('text', 'code', $language->code  ,['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('text', 'code', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("code"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("code") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('active', 'Active') !!}
            @if($language->exists)
                {!! Form::checkbox('active', 1, $language->active, ['class' => 'form-control m-input switch']) !!}
            @else
                {!! Form::checkbox('active', 1, '', ['class' => 'form-control m-input switch']) !!}
            @endif
            @if ($errors->has("active"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("active") }}</strong>
                </div>
            @endif
        </div>
    @include('base::layouts.submit_button')
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('.switch').bootstrapSwitch();
            $('#langNav').parent().addClass('m-menu__item--open');
        });
    </script>
@endsection
