@extends('base::layouts.master')

@section('content')
    @if($rate->exists)
        @php $title = 'accommodation::accommodation.rate.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.rate.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-hotel', 'form' => 'main-form'])
    @if($rate->exists)
        {!! Form::open(['id' => 'main-form', 'class' => 'm-form form-notify rate-form', 'route' => ['accommodation.rate.plan.update', $rate->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'main-form', 'class' => 'm-form form-notify rate-form', 'route' => 'accommodation.rate.plan.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet">
        <div class="m-portlet__body">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item"> <a href="#m_tabs_1_1" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-cogs"></i> Configuration</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_2" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-calendar-alt"></i> Pricelist</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                    <div class="m-portlet__body">
                        @csrf

                        <div class="form-group m-form__group">
                            {!! Form::label('accommodation_object', __('accommodation::accommodation.rate.accommodation.object')) !!}
                            @if($rate->accommodation_object_id)
                                @if($rate->imported)
                                    {!! Form::select('accommodation_object', $accommodationObjectArray, $rate->accommodation_object_id, ['class' => 'bs-select form-control', 'disabled']) !!}
                                @else
                                    {!! Form::select('accommodation_object', $accommodationObjectArray, $rate->accommodation_object_id, ['class' => 'bs-select form-control']) !!}
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
                            {!! Form::label('name', __('accommodation::accommodation.rate.name')) !!}
                            @if($rate->exists)
                                @if($rate->imported)
                                    {!! Form::input('text', 'name', $rate->name,['class' => 'form-control m-input', 'disabled']) !!}
                                @else
                                    {!! Form::input('text', 'name', $rate->name,['class' => 'form-control m-input', 'required']) !!}
                                @endif
                            @else
                                {!! Form::input('text', 'name', '',['class' => 'form-control m-input', 'required']) !!}
                            @endif
                            @if ($errors->has("name"))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first("name") }}</strong>
                                </div>
                            @endif
                        </div>

						<div class="form-group m-form__group">
                            {!! Form::label('type', __('accommodation::accommodation.rate.type')) !!}
                            @if($rate->exists)
                                @if($rate->imported)
                                    {!! Form::select('type', ['rate-one-time' => 'One time', 'rate-per-person-per-night' => 'Per person per night', 'rate-per-person' => 'Per person', 'rate-per-night' => 'Per night', 'rate-per-unit-occupancy' => 'Per unit occupancy'], $rate->type, ['class' => 'bs-select form-control', 'disabled']) !!}
                                @else
                                    {!! Form::select('type', ['rate-one-time' => 'One time', 'rate-per-person-per-night' => 'Per person per night', 'rate-per-person' => 'Per person', 'rate-per-night' => 'Per night', 'rate-per-unit-occupancy' => 'Per unit occupancy'], $rate->type, ['class' => 'bs-select form-control']) !!}
                                @endif
                            @else
                                {!! Form::select('type', ['rate-one-time' => 'One time', 'rate-per-person-per-night' => 'Per person per night', 'rate-per-person' => 'Per person', 'rate-per-night' => 'Per night', 'rate-per-unit-occupancy' => 'Per unit occupancy'], '', ['class' => 'bs-select form-control']) !!}
                            @endif
                            @if ($errors->has('type'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </div>
                            @endif
                        </div>

						<div class="form-group m-form__group">
							<div>
								<label>Pricelist types</label>
								<div id="pricelist-types-container"></div>
								{!! Form::input('hidden', 'pricelist_types_json', '', ['id' => 'pricelist-types-json']) !!}
								@if ($errors->has('pricelist_types_json'))
									<div class="form-control-feedback">
										<strong>{{ $errors->first('pricelist_types_json') }}</strong>
									</div>
								@endif
							</div>
							<div class="row">
								<div class="col">
									<button type="button" class="btn btn-success m-btn m-btn--icon" onclick="addPriceListRow();">
										<span>
											<i class="fa fa-plus"></i>
											<span>Add</span>
										</span>
									</button>
								</div>
							</div>
						</div>

                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
                    <div class="m-portlet__body">
                        <div>
                            <div class="row">
                                <div class="col col-md-12">
                                    <div class="form-row">
                                        <div class="form-group mx-1 col-md-2">
                                            <label for="dateRange">Date range</label>
                                            {!! Form::input('text', 'dateRange', '', ['id' => 'dateRange', 'class' => 'form-control m-input chart-daterangepicker']) !!}
                                        </div>
                                        <div class="form-group mx-1 col-md-2">
                                            <label for="price">Price per night</label>
                                            <input id="price" class="form-control m-imput" type="number" min="0">
                                        </div>
                                        <div class="form-group mx-1 col-md-2">
                                            <label for="roomsToSell">Rooms to sell</label>
                                            <input id="roomsToSell" class="form-control m-imput" type="number" min="0">
                                        </div>
                                        <div class="form-group mx-1 col-md-2">
                                            <label for="minDays">Minimum stay</label>
                                            <input id="minDays" class="form-control m-imput" type="number" min="0">
                                        </div>
										<div class="form-group mx-1 col-md-2">
											<button type="button" onclick="updateTable()" class="btn btn-primary float-right m-btn--icon">
												<span>
													<i class="fa fa-sync"></i>
													<span>Update</span>
												</span>
											</button>
										</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-md-2">
                                    <table class="table months months--ghost">
                                        <thead>
                                        <tr>
                                            <th>Day</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Price (HRK)</td>
                                        </tr>
                                        <tr>
                                            <td>Rooms to sell</td>
                                        </tr>
                                        <tr>
                                            <td>Minimum stay</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col col-md-10">
                                    <div class="row">

                                        <button type="button"
                                            onclick="handlePreviousMonth()"
                                            class="btn btn-success m-btn m-btn--icon"
                                        >
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <table class="table months col col-md-10">
                                            <thead id="months-names"></thead>
                                            <tbody id="months-data"></tbody>
                                        </table>
                                        <button type="button"
                                            onclick="handleNextMonth()"
                                            class="btn btn-success m-btn m-btn--icon"
                                        >
											<i class="fa fa-chevron-right"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="col col-md-10">
                                    <div class="row">
                                        <div class="col col-md-6">
                                        </div>
                                        <div class="col col-md-4">
                                            <button type="button"
                                                    class="btn btn-secondary m-btn"
                                                    id="year"
                                            >
                                            </button>
                                            <button type="button"
                                                    class="btn btn-secondary m-btn"
                                                    id="month"
                                            >
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('base::layouts.submit_button')
    </div>

	<template id="pricelist-types-template">
		<div class="row m--margin-bottom-10 pricelist-types-item">
			<div class="col-lg-3">
				{!! Form::select('price_type', ['' => 'Price type', 'individual' => 'Individual', 'allotment' => 'Allotment'], '', ['class' => 'form-control m-input m-bootstrap-select pricelist-types-item-price-type', 'required']) !!}
			</div>
			<div class="col-lg-3">
				{!! Form::select('service_type', ['' => 'Service type', 'full_pension' => 'Full pension', 'half_pension' => 'Half pension', 'bed_breakfast' => 'Bed & breakfast', 'nigth' => 'Just night'], '', ['class' => 'form-control m-input m-bootstrap-select pricelist-types-item-service-type', 'required']) !!}
			</div>
			<div class="col-lg-2">
				<div class="input-group m-input-group">
					{!! Form::input('number', 'percentage', '', ['class' => 'form-control m-input pricelist-types-item-percentage', 'placeholder' => 'Percentage', 'min' => 0, 'max' => 100, 'required']) !!}
					<div class="input-group-append">
						<span class="input-group-text">
							<i class="fa fa-percent"></i>
						</span>
					</div>
				</div>
			</div>
			<div class="col-lg-2" align="center">
				{!! Form::checkbox('active', 1, true, ['class' => 'form-control m-input pricelist-types-item-active', 'data-switch' => 'true']) !!}
			</div>
			<div class="col-lg-2" align="center">
				<button type="button" class="btn btn-danger m-btn m-btn--icon" onclick="removePriceListRow(this);">
					<span>
						<i class="fa fa-trash-alt"></i>
						<span>Remove</span>
					</span>
				</button>
			</div>
		</div>
	</template>

    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('select').selectpicker();
            $('.switch').bootstrapSwitch();

            $('#calculateRate').click(function() {
               var basePrice = $('#basePrice').val();
               var marginType = $('#marginType').val();
               var margin = $('#margin').val();
               var final = 0;

               if(basePrice == '' || margin == '') {
                   alert('Base price and margin should be filled.')
               } else {
                   if(marginType == 'percent') {
                       final = parseFloat(basePrice * (margin/100)) + parseFloat(basePrice);
                   } else {
                       final = parseFloat(basePrice) + parseFloat(margin);
                   }

                   $('#finalPrice').val(final);
               }
            });

            populateTable();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-range/4.0.1/moment-range.js" onl></script>
    <script>
        var momentWithRange = window['moment-range'].extendMoment(moment);
    </script>
@endsection
