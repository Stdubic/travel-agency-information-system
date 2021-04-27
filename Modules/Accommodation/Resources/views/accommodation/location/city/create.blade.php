@extends('base::layouts.master')

@section('content')
    @if($city->exists)
        @php $title = 'accommodation::accommodation.location.city.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.location.city.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'flaticon-placeholder-2', 'form' => 'city-form'])
    @if($city->exists)
        {!! Form::open(['id' => 'city-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.location.city.update', $city->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'city-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.location.city.store', 'method' => 'POST']) !!}
    @endif
        <div class="m-portlet__body">
            @csrf
            @if(!$city->exists)
                <div class="form-group m-form__group">
                    {!! Form::label('region_id', __('accommodation::accommodation.location.region')) !!}
                    {!! Form::select('region_id', $regions, '', ['class' => 'bs-select form-control']) !!}
                    @if ($errors->has("region_id"))
                        <div class="form-control-feedback">
                            <strong>{{ $errors->first("region_id") }}</strong>
                        </div>
                    @endif
                </div>
            @endif
            <div class="form-group m-form__group">
                {!! Form::label('city', __('accommodation::accommodation.location.city')) !!}
                @if($city->exists)
                    {!! Form::input('text', 'city', $city->name,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'city', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("city"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("city") }}</strong>
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
