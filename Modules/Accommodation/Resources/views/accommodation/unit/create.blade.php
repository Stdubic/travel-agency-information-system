@extends('base::layouts.master')

@section('content')
    @if($accommodationUnit->exists)
        @php $title = 'accommodation::accommodation.unit.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.unit.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'flaticon-home-2', 'form' => 'unit-form'])
    @if($accommodationUnit->exists)
        {!! Form::open(['id' => 'unit-form', 'class' => 'm-form form-notify', 'route' => ['accommodation.unit.update', $accommodationUnit->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'unit-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.unit.store', 'method' => 'POST']) !!}
    @endif
        <div class="m-portlet__body">
            @csrf
            <div class="form-group m-form__group">
                {!! Form::label('accommodation_object', __('accommodation::accommodation.rate.accommodation.object')) !!}
                @if($accommodationUnit->accommodation_object_id)
                    @if($accommodationUnit->imported)
                        {!! Form::select('accommodation_object', $accommodationObjectArray, $accommodationUnit->accommodation_object_id, ['class' => 'bs-select form-control', 'disabled']) !!}
                    @else
                        {!! Form::select('accommodation_object', $accommodationObjectArray, $accommodationUnit->accommodation_object_id, ['class' => 'bs-select form-control']) !!}
                    @endif
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
                {!! Form::label('name', __('accommodation::accommodation.unit.name.form')) !!}
                @if($accommodationUnit->exists)
                    @if($accommodationUnit->imported)
                        {!! Form::input('text', 'name', $accommodationUnit->name,['class' => 'form-control m-input', 'disabled']) !!}
                    @else
                        {!! Form::input('text', 'name', $accommodationUnit->name,['class' => 'form-control m-input']) !!}
                    @endif
                @else
                    {!! Form::input('text', 'name', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("name"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("name") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('unit_type', __('accommodation::accommodation.unit.type.form')) !!}
                <div class="input-group date form_datetime form_datetime bs-datetime">
                    @if($accommodationUnit->accommodation_unit_type_id)
                        {!! Form::select('unit_type', $accommodationUnitTypeArray, $accommodationUnit->accommodation_unit_type_id, ['class' => 'bs-select form-control']) !!}
                    @else
                        {!! Form::select('unit_type', $accommodationUnitTypeArray, '', ['class' => 'bs-select form-control']) !!}
                    @endif
                </div>
                @if ($errors->has("unit_type"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("unit_type") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('basic_bed_num', __('accommodation::accommodation.unit.basic.bed.num')) !!}
                @if($accommodationUnit->basic_bed_number)
                    {!! Form::input('text', 'basic_bed_num', $accommodationUnit->basic_bed_number,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'basic_bed_num', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('basic_bed_num'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('basic_bed_num') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('additional_bed_num', __('accommodation::accommodation.unit.additional.bed.num')) !!}
                @if($accommodationUnit->additional_bed_number)
                    {!! Form::input('text', 'additional_bed_num', $accommodationUnit->additional_bed_number,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'additional_bed_num', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('additional_bed_num'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('additional_bed_num') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('position', __('accommodation::accommodation.unit.position')) !!}
                @if($accommodationUnit->position)
                    {!! Form::select('position', ['nd' => 'Not defined', 'ss' => 'Sea side', 'ps' => 'Park side', 'hs' => 'Hill side'], $accommodationUnit->position, ['class' => 'bs-select form-control']) !!}
                @else
                    {!! Form::select('position', ['nd' => 'Not defined', 'ss' => 'Sea side', 'ps' => 'Park side', 'hs' => 'Hill side'], '', ['class' => 'bs-select form-control']) !!}
                @endif
                @if ($errors->has('position'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('position') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('view', __('accommodation::accommodation.unit.view')) !!}
                @if($accommodationUnit->view)
                    {!! Form::select('view', ['sea' => 'Sea', 'sea-side' => 'Sea (side)', 'lake' => 'Lake', 'river' => 'River', 'mountain' => 'Mountain', 'park' => 'Park', 'forest' => 'Forest', 'center' => 'City center', 'quite' => 'Quite street', 'busy' => 'Busy street', 'garden' => 'Garden', 'backyard' => 'Backyard', 'golf' => 'Golf', 'pool' => 'Pool'], $accommodationUnit->position, ['class' => 'bs-select form-control']) !!}
                @else
                    {!! Form::select('view', ['sea' => 'Sea', 'sea-side' => 'Sea (side)', 'lake' => 'Lake', 'river' => 'River', 'mountain' => 'Mountain', 'park' => 'Park', 'forest' => 'Forest', 'center' => 'City center', 'quite' => 'Quite street', 'busy' => 'Busy street', 'garden' => 'Garden', 'backyard' => 'Backyard', 'golf' => 'Golf', 'pool' => 'Pool'], '', ['class' => 'bs-select form-control']) !!}
                @endif
                @if ($errors->has('view'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('view') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('qty', __('accommodation::accommodation.unit.qty')) !!}
                @if($accommodationUnit->qty)
                    {!! Form::input('text', 'qty', $accommodationUnit->qty,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'qty', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('qty'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('qty') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('rating', __('accommodation::accommodation.unit.rating')) !!}
                @if($accommodationUnit->rating)
                    {!! Form::select('rating', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'], $accommodationUnit->rating, ['class' => 'bs-select form-control']) !!}
                @else
                    {!! Form::select('rating', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'], '', ['class' => 'bs-select form-control']) !!}
                @endif
                @if ($errors->has('rating'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('rating') }}</strong>
                    </div>
                @endif
            </div>
            @if($accommodationUnit->imported)
                <div class="form-group m-form__group">
                    {!! Form::label('code', __('accommodation::accommodation.unit.code')) !!}
                    {!! Form::input('text', 'code', $accommodationUnit->code,['class' => 'form-control m-input', 'disabled']) !!}
                </div>
            @endif
            <div class="form-group m-form__group">
                <div class="row">
                    <div class="col-sm-6">
                        {!! Form::label('active', __('accommodation::accommodation.unit.active')) !!}
                    </div>
                    <div class="col-sm-6">
                        @if($accommodationUnit->is_active)
                            {!! Form::checkbox('active', 1, $accommodationUnit->is_active, ['class' => 'form-control m-input switch']) !!}
                        @else
                            {!! Form::checkbox('active', 1, null, ['class' => 'form-control m-input switch']) !!}
                        @endif
                        @if ($errors->has('active'))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first('active') }}</strong>
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
            $('select').selectpicker();
            $('.switch').bootstrapSwitch();
            $('#accUnitNav').parent().addClass('m-menu__item--open');
        });
    </script>
@endsection
