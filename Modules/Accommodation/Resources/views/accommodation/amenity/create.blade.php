@extends('base::layouts.master')

@section('content')
    @if($amenity->exists)
        @php $title = 'accommodation::accommodation.amenity.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.amenity.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-list', 'form' => 'amenity-form'])
    @if($amenity->exists)
        {!! Form::open(['id' => 'amenity-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.amenity.update', $amenity->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'amenity-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.amenity.store', 'method' => 'POST']) !!}
    @endif
        <div class="m-portlet__body">
            @csrf
            {!! Form::label('amenity_set_id', __('accommodation::accommodation.amenity.set')) !!}
            @if(!$amenity->exists)
                {!! Form::select('amenity_set_id', $setArray, '', ['name' => 'amenity_set_id', 'class' => 'bs-select form-control']) !!}
            @else
                {!! Form::select('amenity_set_id', $setArray, $amenity->amenity_set_id, ['name' => 'amenity_set_id', 'class' => 'bs-select form-control']) !!}
            @endif
            @if ($errors->has("amenity_set"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("amenity_set") }}</strong>
                </div>
            @endif
            @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
                <div class="form-group m-form__group">
                    {!! Form::label('title[' . $lang . ']', $language) !!}
                    @if($amenity->exists)
                        {!! Form::input('text', 'translation[' . $lang . '][title]', @$amenity->formattedTranslations[$lang]->title, ['class' => 'form-control m-input']) !!}
                    @else
                        {!! Form::input('text', 'translation[' . $lang . '][title]', '' ,['class' => 'form-control m-input']) !!}
                    @endif
                    @if ($errors->has("translation.{$lang}.name"))
                        <div class="form-control-feedback">
                            <strong>{{ $errors->first("translation.{$lang}.name") }}</strong>
                        </div>
                    @endif
                </div>
            @endforeach
                <div class="form-group m-form__group">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::label('text_field', 'Text field') !!}
                        </div>
                        <div class="col-sm-6">
                            @if($amenity->exists)
                                {!! Form::checkbox('text_field', 1, $amenity->text_field, ['class' => 'form-control m-input switch']) !!}
                            @else
                                {!! Form::checkbox('text_field', 1, null, ['class' => 'form-control m-input switch']) !!}
                            @endif
                            @if ($errors->has("text_field"))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first("text_field") }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        @include('base::layouts.submit_button')
        </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('.switch').bootstrapSwitch();
            $('#amenityNav').parent().addClass('m-menu__item--open');
        });
    </script>
@endsection
