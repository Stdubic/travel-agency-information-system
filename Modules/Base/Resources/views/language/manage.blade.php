@extends('base::layouts.master')

@section('content')
    @php $title = 'base::base.settings.language.manage.name'; @endphp
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-wrench', 'form' => ''])
        {!! Form::open(['id' => 'category-form', 'class' => 'm-form form-notify', 'route' => 'language.manage.put', 'method' => 'PUT']) !!}
        <div class="m-portlet__body">
            @csrf
            @foreach ($languageArray as $lang => $language)
                <div class="form-group m-form__group">
                    {!! Form::label('title[' . $lang . ']', $language['name']) !!}
                    {!! Form::checkbox('languages[' . $lang . ']', 1, $language['active'], ['class' => 'form-control m-input switch']) !!}
                    @if ($errors->has("languages.{$lang}"))
                        <div class="form-control-feedback">
                            <strong>{{ $errors->first("languages.{$lang}") }}</strong>
                        </div>
                    @endif
                </div>
            @endforeach
        @include('base::layouts.submit_button')
        </div>
    {!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function(){
        $('.switch').bootstrapSwitch();
    });
</script>
@endsection
