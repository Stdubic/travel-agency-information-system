@extends('base::layouts.master')

@section('content')
    @if($category->exists)
        @php $title = 'accommodation::accommodation.category.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.category.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'flaticon-home', 'form' => 'category-form'])
    @if($category->exists)
        {!! Form::open(['id' => 'category-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.category.update', $category->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'category-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.category.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
            <div class="form-group m-form__group">
                {!! Form::label('title[' . $lang . ']', $language) !!}
                @if($category->exists)
                    {!! Form::input('text', 'translation[' . $lang . '][title]', @$category->formattedTranslations[$lang]->title  ,['class' => 'form-control m-input']) !!}
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
        $(document).ready(function() {
            $('#accObjectNav').parent().addClass('m-menu__item--open');
        })
    </script>
@endsection
