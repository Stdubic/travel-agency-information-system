@extends('base::layouts.master')

@section('content')
    @if($unitType->exists)
        @php $title = 'accommodation::accommodation.unit.type.update.form'; @endphp
    @else
        @php $title = 'accommodation::accommodation.unit.type.create.form'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'flaticon-home-2', 'form' => 'unit-type-form'])
    @if($unitType->exists)
        {!! Form::open(['id' => 'unit-type-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.unit.type.update', $unitType->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'unit-type-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.unit.type.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
            <div class="form-group m-form__group">
                {!! Form::label('title[' . $lang . ']', $language) !!}
                @if($unitType->exists)
                    {!! Form::input('text', 'translation[' . $lang . '][title]', @$unitType->formattedTranslations[$lang]->title  ,['class' => 'form-control m-input']) !!}
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
    @include('base::layouts.submit_button')
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#accUnitNav').parent().addClass('m-menu__item--open');
        });
    </script>
@endsection
