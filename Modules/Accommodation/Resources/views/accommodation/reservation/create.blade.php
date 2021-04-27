@extends('base::layouts.master')

@section('content')
    @if($reservation->exists)
        @php $title = 'accommodation::accommodation.reservation.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.reservation.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-book', 'form' => 'type-form'])
    @if($reservation->exists)
        {!! Form::open(['id' => 'type-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.reservations.update', $reservation->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'type-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.reservations.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        <div class="form-group m-form__group">
            {!! Form::label('accommodation_object', __('accommodation::accommodation.reservation.accommodation.object')) !!}
            @if($reservation->accommodation_object_id)
                {!! Form::select('accommodation_object', $accommodationObjectArray, $reservation->accommodation_object_id, ['class' => 'bs-select form-control']) !!}
            @else
                {!! Form::select('accommodation_object', $accommodationObjectArray, '', ['class' => 'bs-select form-control']) !!}
            @endif
            @if ($errors->has("accommodation_object"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("accommodation_object") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('accommodation_units', __('accommodation::accommodation.reservation.accommodation.unit')) !!}
            @if($reservation->exists)
                {!! Form::select('accommodation_units', $accommodationUnitArray, $selectedUnits, ['class' => 'bs-select form-control']) !!}
            @else
                {!! Form::select('accommodation_units', $accommodationUnitArray, '', ['class' => 'bs-select form-control']) !!}
            @endif
            @if ($errors->has('accommodation_units'))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first('accommodation_units') }}</strong>
                </div>
            @endif
            @if ($errors->has('accommodation_units.*'))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first('accommodation_units.*') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('rate_plan', __('accommodation::accommodation.reservation.rate.plan')) !!}
            @if($reservation->exists)
                {!! Form::select('rate_plan', $ratePlanArray, $selectedRate, ['class' => 'bs-select form-control']) !!}
            @else
                {!! Form::select('rate_plan', $ratePlanArray, '', ['class' => 'bs-select form-control']) !!}
            @endif
            @if ($errors->has('rate_plan'))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first('rate_plan') }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('date_range', __('accommodation::accommodation.reservation.date.range')) !!}
            <div class="input-group date form_datetime form_datetime bs-datetime">
                @if($reservation->exists)
                    {!! Form::input('text', 'date_range', $reservation->date_range,['class' => 'orm-control m-input chart-daterangepicker']) !!}
                @else
                    {!! Form::input('text', 'date_range', '',['class' => 'form-control m-input chart-daterangepicker']) !!}
                @endif
            </div>
            @if ($errors->has("date_range"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("date_range") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('adult_count', __('accommodation::accommodation.reservation.adult.count')) !!}
            @if($reservation->exists)
                {!! Form::input('text', 'adult_count', $reservation->adult_count,['class' => 'orm-control m-input']) !!}
            @else
                {!! Form::input('text', 'adult_count', '',['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("adult_count"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("adult_count") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('children_under_count', __('accommodation::accommodation.reservation.children.under.12.count')) !!}
            @if($reservation->exists)
                {!! Form::input('text', 'children_under_count', $reservation->children_under_count,['class' => 'orm-control m-input']) !!}
            @else
                {!! Form::input('text', 'children_under_count', '',['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("children_under_count"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("children_under_count") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('children_above_count', __('accommodation::accommodation.reservation.children.above.12.count')) !!}
            @if($reservation->exists)
                {!! Form::input('text', 'children_above_count', $reservation->children_above_count,['class' => 'orm-control m-input']) !!}
            @else
                {!! Form::input('text', 'children_above_count', '',['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("children_above_count"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("children_above_count") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('guestDetails', __('accommodation::accommodation.reservation.guest.details')) !!}
            <br>
            {!! Form::button('Add', ['id' => 'guestDetails']) !!}
        </div>
        @include('base::layouts.submit_button')
    </div>
    {!! Form::close() !!}
@endsection
