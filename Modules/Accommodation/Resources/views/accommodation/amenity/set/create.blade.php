@extends('base::layouts.master')

@section('content')
    @if($amenitySet->exists)
        @php $title = 'accommodation::accommodation.amenity.set.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.amenity.set.create.name'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-list', 'form' => 'type-form'])
    @if($amenitySet->exists)
        {!! Form::open(['id' => 'type-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.amenity.set.update', $amenitySet->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'type-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.amenity.set.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
            {!! Form::label('title[' . $lang . ']', $language) !!}
            <div class="form-group m-form__group">
                {!! Form::label('title[' . $lang . ']', 'Title') !!}
                @if($amenitySet->exists)
                    {!! Form::input('text', 'translation[' . $lang . '][title]', @$amenitySet->formattedTranslations[$lang]->title  ,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'translation[' . $lang . '][title]', '' ,['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("translation.{$lang}.title"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("translation.{$lang}.title") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('description[' . $lang . ']', 'Description') !!}
                @if($amenitySet->exists)
                    {!! Form::textarea('translation[' . $lang . '][description]', @$amenitySet->formattedTranslations[$lang]->description  ,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::textarea('translation[' . $lang . '][description]', '' ,['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("translation.{$lang}.description"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("translation.{$lang}.description") }}</strong>
                    </div>
                @endif
            </div>
            <hr>
        @endforeach
    @include('base::layouts.submit_button')
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#amenityNav').parent().addClass('m-menu__item--open');
        });
    </script>
@endsection
