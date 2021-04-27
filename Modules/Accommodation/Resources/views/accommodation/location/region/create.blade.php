@extends('base::layouts.master')

@section('content')
    @if($region->exists)
        @php $title = 'accommodation::accommodation.location.region.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.location.region.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'flaticon-placeholder-2', 'form' => 'region-form'])
    @if($region->exists)
        {!! Form::open(['id' => 'region-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.location.region.update', $region->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'region-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.location.region.store', 'method' => 'POST']) !!}
    @endif
        <div class="m-portlet__body">
            @csrf
            @if(!$region->exists)
                <div class="form-group m-form__group">
                    {!! Form::label('country', __('accommodation::accommodation.location.country')) !!}
                    {!! Form::select('country', $countries, '', ['class' => 'bs-select form-control']) !!}
                    @if ($errors->has("country"))
                        <div class="form-control-feedback">
                            <strong>{{ $errors->first("country") }}</strong>
                        </div>
                    @endif
                </div>
            @endif
            <div class="form-group m-form__group">
                {!! Form::label('region', __('accommodation::accommodation.location.region')) !!}
                @if($region->exists)
                    {!! Form::input('text', 'region', $region->name,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'region', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("region"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("region") }}</strong>
                    </div>
                @endif
            </div>

        @include('base::layouts.submit_button')
        </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#locationNav').parent().addClass('m-menu__item--open');
        });
    </script>
@endsection
