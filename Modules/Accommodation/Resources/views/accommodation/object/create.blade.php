@extends('base::layouts.master')

@section('content')
    @if($object->exists)
        @php $title = 'accommodation::accommodation.object.update'; @endphp
    @else
        @php $title = 'accommodation::accommodation.object.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'flaticon-home', 'form' => 'object-form'])
    @if($object->exists)
        {!! Form::open(['id' => 'object-form', 'class' => 'm-form form-notify', "onsubmit" => "disableEmptyInputs(this)", 'route' => ['accommodation.object.update', $object->id], 'files' => true, 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'object-form', 'class' => 'm-form form-notify', 'route' => 'accommodation.object.store', 'files' => true, 'method' => 'POST']) !!}
    @endif
    @csrf
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    </head>
    <div class="m-portlet">
        <div class="m-portlet__body">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item"> <a href="#m_tabs_1_1" class="nav-link m-tabs__link active" data-toggle="tab">Basic info</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_2" class="nav-link m-tabs__link" data-toggle="tab">Settings</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_3" class="nav-link m-tabs__link" data-toggle="tab">Owner info</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_4" class="nav-link m-tabs__link" data-toggle="tab">Object amenities</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_5" class="nav-link m-tabs__link" data-toggle="tab">Description</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_6" class="nav-link m-tabs__link" data-toggle="tab">Distances</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_7" class="nav-link m-tabs__link" data-toggle="tab">Channel manager</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_8" class="nav-link m-tabs__link" data-toggle="tab">Map</a></li>
                <li class="nav-item m-tabs__item"><a href="#m_tabs_1_9" class="nav-link m-tabs__link" data-toggle="tab">Images</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                {!! Form::label('name', __('accommodation::accommodation.object.name')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'name', $object->name,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'name', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter name']) !!}
                                @endif
                                @if ($errors->has('name'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('type', __('accommodation::accommodation.object.type')) !!}
                                @if($object->exists)
                                    {!! Form::select('type', ['hotel' => 'Hotel', 'holiday_home' => 'Holiday home', 'apartment_house' => 'Apartment house', 'camp' => 'Camp'], $object->type, ['class' => 'bs-select form-control']) !!}
                                @else
                                    {!! Form::select('type', ['hotel' => 'Hotel', 'holiday_home' => 'Holiday home', 'apartment_house' => 'Apartment house', 'camp' => 'Camp'], '', ['class' => 'bs-select form-control']) !!}
                                @endif
                                @if ($errors->has('type'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('object_category', __('accommodation::accommodation.object.categories')) !!}
                                @if($object->exists)
                                    {!! Form::select('object_category', $categorySelectArray, $selectedCategories, ['name' => 'object_category[]', 'multiple'=>'multiple','class' => 'bs-select form-control']) !!}
                                @else
                                    {!! Form::select('object_category', $categorySelectArray, '', ['name' => 'object_category[]', 'multiple'=>'multiple','class' => 'bs-select form-control']) !!}
                                @endif
                                @if ($errors->has('object_category'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('object_category') }}</strong>
                                    </div>
                                @endif
                                @if ($errors->has('object_category.*'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('object_category.*') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('', 'Stars') !!}
                                <div class="m-radio-inline">
                                    @if($object->exists)
                                        <label class="m-radio m-radio--solid">
                                            @if($object->rating === 1)
                                                {!! Form::radio('object_rating', '1', 1) !!}
                                            @else
                                                {!! Form::radio('object_rating', '1', '') !!}
                                            @endif
                                            1*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            @if($object->rating === 2)
                                                {!! Form::radio('object_rating', '2', 1) !!}
                                            @else
                                                {!! Form::radio('object_rating', '2', '') !!}
                                            @endif
                                            2*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            @if($object->rating === 3)
                                                {!! Form::radio('object_rating', '3', 1) !!}
                                            @else
                                                {!! Form::radio('object_rating', '3', '') !!}
                                            @endif
                                            3*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            @if($object->rating === 4)
                                                {!! Form::radio('object_rating', '4', 1) !!}
                                            @else
                                                {!! Form::radio('object_rating', '4', '') !!}
                                            @endif
                                            4*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            @if($object->rating === 5)
                                                {!! Form::radio('object_rating', '5', 1) !!}
                                            @else
                                                {!! Form::radio('object_rating', '5', '') !!}
                                            @endif
                                            5*
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-radio m-radio--solid">
                                            {!! Form::radio('object_rating', '1', '') !!}
                                            1*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            {!! Form::radio('object_rating', '2', '') !!}
                                            2*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            {!! Form::radio('object_rating', '3', '') !!}
                                            3*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            {!! Form::radio('object_rating', '4', '') !!}
                                            4*
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid">
                                            {!! Form::radio('object_rating', '5', '') !!}
                                            5*
                                            <span></span>
                                        </label>
                                    @endif
                                </div>
                                <span class="m-form__help">Please select object categorisation</span>
                                @if ($errors->has('object_rating'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('object_rating') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                {!! Form::label('contact_person', __('accommodation::accommodation.object.contact.person')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'contact_person', $object->contact_person,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'contact_person', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter contact person']) !!}
                                @endif
                                @if ($errors->has('contact_person'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('contact_person') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('reception_phone', __('accommodation::accommodation.object.reception.phone')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'reception_phone', $object->tel_num,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'reception_phone', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter number']) !!}
                                @endif
                                @if ($errors->has('reception_phone'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('reception_phone') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('reception_email', __('accommodation::accommodation.object.reception.email')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'reception_email', $object->reception_email,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'reception_email', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter email address']) !!}
                                @endif
                                @if ($errors->has('reception_email'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('reception_email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('website', __('accommodation::accommodation.object.owner.website')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'website', $object->website,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'website', '',['class' => 'form-control m-input', 'placeholder' => 'Enter website']) !!}
                                @endif
                                @if ($errors->has('website'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                {!! Form::label('country_id', __('accommodation::accommodation.object.location.country')) !!}
                                @if($object->exists)
                                    {!! Form::select('country_id', $countries, $object->country_id, ['class' => 'bs-select form-control']) !!}
                                @else
                                    {!! Form::select('country_id', $countries, '', ['class' => 'bs-select form-control']) !!}
                                @endif
                                @if ($errors->has('country_id'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('country_id') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('region_id', __('accommodation::accommodation.object.location.region')) !!}
                                @if($object->exists)
                                    {!! Form::select('region_id', $regions, $object->region_id, ['class' => 'bs-select form-control']) !!}
                                @else
                                    {!! Form::select('region_id', [], '', ['class' => 'bs-select form-control']) !!}
                                @endif
                                @if ($errors->has('region_id'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('region_id') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('city_id', __('accommodation::accommodation.object.location.city')) !!}
                                @if($object->exists)
                                    {!! Form::select('city_id',  $cities, $object->city_id, ['class' => 'bs-select form-control']) !!}
                                @else
                                    {!! Form::select('city_id',  [], '', ['class' => 'bs-select form-control']) !!}
                                @endif
                                @if ($errors->has('city_id'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('city_id') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('address', __('accommodation::accommodation.object.location.address')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'address', $object->address,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'address', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter your address']) !!}
                                @endif
                                @if ($errors->has('address'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{--<div class="form-group m-form__group">--}}
                            {{--{!! Form::label('channel_manager_code', __('accommodation::accommodation.object.channel.manager.code')) !!}--}}
                            {{--@if($object->exists)--}}
                                {{--{!! Form::input('text', 'channel_manager_code', $object->channel_manager_code,['class' => 'form-control m-input']) !!}--}}
                            {{--@else--}}
                                {{--{!! Form::input('text', 'channel_manager_code', '',['class' => 'form-control m-input']) !!}--}}
                            {{--@endif--}}
                            {{--@if ($errors->has('channel_manager_code'))--}}
                                {{--<div class="form-control-feedback">--}}
                                    {{--<strong>{{ $errors->first('channel_manager_code') }}</strong>--}}
                                {{--</div>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                {!! Form::label('time_zone', __('accommodation::accommodation.object.time.zone')) !!}
                                @if($object->exists)
                                    {!! Form::select('time_zone',  $timeZones, $object->time_zone, ['class' => 'bs-select form-control']) !!}
                                @else
                                    {!! Form::select('time_zone',  $timeZones, '', ['class' => 'bs-select form-control']) !!}
                                @endif
                                @if ($errors->has('time_zone'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('time_zone') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('currency', __('accommodation::accommodation.object.currency')) !!}
                                @if($object->exists)
                                    {!! Form::select('currency',  ['HRK' => 'HRK', 'EUR' => 'EUR', 'USD' => 'USD', 'GBP' => 'GBP' ], $object->currency, ['class' => 'bs-select form-control']) !!}
                                @else
                                    {!! Form::select('currency',  ['HRK' => 'HRK', 'EUR' => 'EUR', 'USD' => 'USD', 'GBP' => 'GBP' ], '', ['class' => 'bs-select form-control']) !!}
                                @endif
                                @if ($errors->has('currency'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('currency') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('added_tax', __('accommodation::accommodation.object.tax.added')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'added_tax', $object->added_tax,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'added_tax', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter %']) !!}
                                @endif
                                <span class="m-form__help">Please enter PDV, VAT or IVA</span>
                                @if ($errors->has('added_tax'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('added_tax') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                {!! Form::label('booking_email', __('accommodation::accommodation.object.booking.email')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'booking_email', $object->booking_email,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'booking_email', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter email']) !!}
                                @endif
                                <span class="m-form__help">On this email you will recevit all notifications</span>
                                @if ($errors->has('booking_email'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('booking_email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('office_phone', __('accommodation::accommodation.object.office.phone')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'office_phone', $object->office_phone,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'office_phone', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter number']) !!}
                                @endif
                                @if ($errors->has('office_phone'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('office_phone') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('office_tax', __('accommodation::accommodation.object.office.tax')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'office_tax', $object->office_tax,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'office_tax', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter number']) !!}
                                @endif
                                @if ($errors->has('office_tax'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('office_tax') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                {!! Form::label('bank_name', __('accommodation::accommodation.object.bank.name')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'bank_name', $object->bank_name,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'bank_name', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter bank name']) !!}
                                @endif
                                @if ($errors->has('bank_name'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('bank_name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('bank_office', __('accommodation::accommodation.object.bank.office')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'bank_office', $object->bank_office, ['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'bank_office', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter bank office']) !!}
                                @endif
                                @if ($errors->has('bank_office'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('bank_office') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('bank_swift', __('accommodation::accommodation.object.bank.swift')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'bank_swift', $object->bank_swift, ['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'bank_swift', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter bank swift']) !!}
                                @endif
                                @if ($errors->has('bank_swift'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('bank_swift') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                {!! Form::label('account_number', __('accommodation::accommodation.object.acc.number')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'account_number', $object->account_number,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'account_number', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter account number']) !!}
                                @endif
                                @if ($errors->has('account_number'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('company_name', __('accommodation::accommodation.object.company.name')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'company_name', $object->company_name, ['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'company_name', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter company name']) !!}
                                @endif
                                @if ($errors->has('company_name'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                {!! Form::label('bank_iban', __('accommodation::accommodation.object.bank.iban')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'bank_iban', $object->bank_iban, ['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'bank_iban', '', ['class' => 'form-control m-input', 'placeholder' => 'Enter bank iban']) !!}
                                @endif
                                @if ($errors->has('bank_iban'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('bank_iban') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{--<div class="form-group m-form__group">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{!! Form::label('site_visibility', __('accommodation::accommodation.object.site.visibility')) !!}--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--@if($object->exists)--}}
                                        {{--{!! Form::checkbox('site_visibility', 1, $object->settings->front_visibility, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@else--}}
                                        {{--{!! Form::checkbox('site_visibility', 1, null, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@endif--}}
                                    {{--@if ($errors->has('site_visibility'))--}}
                                        {{--<div class="form-control-feedback">--}}
                                            {{--<strong>{{ $errors->first('site_visibility') }}</strong>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group m-form__group">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{!! Form::label('admin_visibility', __('accommodation::accommodation.object.admin.visibility')) !!}--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--@if($object->exists)--}}
                                        {{--{!! Form::checkbox('admin_visibility', 1, $object->settings->admin_visibility, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@else--}}
                                        {{--{!! Form::checkbox('admin_visibility', 1, null, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@endif--}}
                                    {{--@if ($errors->has('admin_visibility'))--}}
                                        {{--<div class="form-control-feedback">--}}
                                            {{--<strong>{{ $errors->first('admin_visibility') }}</strong>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group m-form__group">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{!! Form::label('allow_rating', __('accommodation::accommodation.object.allow.rating')) !!}--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--@if($object->exists)--}}
                                        {{--{!! Form::checkbox('allow_rating', 1, $object->settings->rating, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@else--}}
                                        {{--{!! Form::checkbox('allow_rating', 1, null, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@endif--}}
                                    {{--@if ($errors->has('allow_rating'))--}}
                                        {{--<div class="form-control-feedback">--}}
                                            {{--<strong>{{ $errors->first('allow_rating') }}</strong>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group m-form__group">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{!! Form::label('recommended', __('accommodation::accommodation.object.recommended')) !!}--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--@if($object->exists)--}}
                                        {{--{!! Form::checkbox('recommended', 1, $object->settings->recommendation, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@else--}}
                                        {{--{!! Form::checkbox('recommended', 1, null, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@endif--}}
                                    {{--@if ($errors->has('recommended'))--}}
                                        {{--<div class="form-control-feedback">--}}
                                            {{--<strong>{{ $errors->first('recommended') }}</strong>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group m-form__group">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{!! Form::label('medical', __('accommodation::accommodation.object.medical')) !!}--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--@if($object->exists)--}}
                                        {{--{!! Form::checkbox('medical', 1, $object->settings->medical, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@else--}}
                                        {{--{!! Form::checkbox('medical', 1, null, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@endif--}}
                                    {{--@if ($errors->has('medical'))--}}
                                        {{--<div class="form-control-feedback">--}}
                                            {{--<strong>{{ $errors->first('medical') }}</strong>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group m-form__group">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--{!! Form::label('household', __('accommodation::accommodation.object.household')) !!}--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-6">--}}
                                    {{--@if($object->exists)--}}
                                        {{--{!! Form::checkbox('household', 1, $object->settings->household, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@else--}}
                                        {{--{!! Form::checkbox('household', 1, null, ['class' => 'form-control m-input switch']) !!}--}}
                                    {{--@endif--}}
                                    {{--@if ($errors->has('household'))--}}
                                        {{--<div class="form-control-feedback">--}}
                                            {{--<strong>{{ $errors->first('household') }}</strong>--}}
                                        {{--</div>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_3" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                {!! Form::label('owner', __('accommodation::accommodation.object.owner')) !!}
                                @if($object->exists)
                                    {!! Form::input('text', 'owner', $owner->name,['class' => 'form-control m-input']) !!}
                                @else
                                    {!! Form::input('text', 'owner', '',['class' => 'form-control m-input']) !!}
                                @endif
                                <div id="owners" style="display:none">
                                </div>
                                @if ($errors->has('owner'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('owner') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                {!! Form::label('email', __('accommodation::accommodation.object.owner.email')) !!}
                                @if($object->exists)
                                    {!! Form::input('email', 'email', $owner->email,['class' => 'form-control m-input', 'disabled']) !!}
                                @else
                                    {!! Form::input('email', 'email', '',['class' => 'form-control m-input', 'disabled']) !!}
                                @endif
                                @if ($errors->has('email'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('owner_phone', __('accommodation::accommodation.object.owner.phone')) !!}
                                {!! Form::input('text', 'owner_phone', '',['class' => 'form-control m-input', 'disabled']) !!}
                                @if ($errors->has('owner_phone'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('owner_phone') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('owner_fax', __('accommodation::accommodation.object.owner.fax')) !!}
                                {!! Form::input('text', 'owner_fax', '',['class' => 'form-control m-input', 'disabled']) !!}
                                @if ($errors->has('owner_fax'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('owner_fax') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                {!! Form::label('owner_address', __('accommodation::accommodation.object.owner.address')) !!}
                                {!! Form::input('text', 'owner_address', '',['class' => 'form-control m-input', 'disabled']) !!}
                                @if ($errors->has('owner_address'))
                                    <div class="form-control-feedback">
                                        <strong>{{ $errors->first('owner_address') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_4" role="tabpanel">
                    <div class="m-portlet__body">
                        @foreach($amenitySet as $set)
                            @if($set->id != 2)
                                <div class="m-form__group form-group row">
                                    {!! Form::label('set_' . $set->id, $set->translations->first()->title, ['class' => 'col-2 col-form-label']) !!}
                                        @if($object->exists)
                                            @if(in_array($set->id, $objectSetArray))
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name='set[{{$set->id}}]' value="true" checked onclick="checkAllAmenities(this.checked, 'amenity_div_{{$set->id}}');">
                                                    <span></span>
                                                    <br>
                                                </label>
                                            @else
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name='set[{{$set->id}}]' value="true" onclick="checkAllAmenities(this.checked, 'amenity_div_{{$set->id}}');">
                                                    <span></span>
                                                    <br>
                                                </label>
                                            @endif
                                        @else
                                        <label class="m-checkbox">
                                            <input type="checkbox" name='set[{{$set->id}}]' value="true" onclick="checkAllAmenities(this.checked, 'amenity_div_{{$set->id}}');">
                                            <span></span>
                                            <br>
                                        </label>
                                        @endif
                                    <br>
                                    <br>
                                    <br>
                                    @foreach($set->amenities as $key => $amenity)
                                        @if(($key === 0) && ($key % 8 === 0))
                                            <div class="col-3">
                                                <div class="m-checkbox-inline" id='amenity_div_{{$set->id}}'>
                                        @endif
                                        @if($object->exists)
                                            @if(isset($amenityArray[$amenity->id]))
                                                @if($amenity->text_field === 0)
                                                    <label class="m-checkbox">
                                                        <input type="checkbox" name='amenity[{{$amenity->id}}]' value="true" checked>
                                                        {{$amenity->translations->first()->title}}
                                                        <span></span>
                                                        <br>
                                                    </label>
                                                    <br>
                                                @else
                                                    <div>
                                                        <label class="m-checkbox">
                                                            <input type="checkbox" name='amenity[{{$amenity->id}}]' value="true" checked onclick="textCheckboxClicked(this)">
                                                            {{$amenity->translations->first()->title}}
                                                            <span></span>
                                                            <br>
                                                        </label>
                                                        <br>
                                                        <input type="text" name='amenity[{{$amenity->id}}]' size="5" value="{{$amenityArray[$amenity->id]}}">
                                                    </div>
                                                    <br>
                                                @endif
                                            @else
                                                @if($amenity->text_field === 0)
                                                    <label class="m-checkbox">
                                                        <input type="checkbox" name='amenity[{{$amenity->id}}]' value="true">
                                                        {{$amenity->translations->first()->title}}
                                                        <span></span>
                                                        <br>
                                                    </label>
                                                    <br>
                                                @else
                                                    <div>
                                                        <label class="m-checkbox">
                                                            <input type="checkbox" name='amenity[{{$amenity->id}}]' value="true" onclick="textCheckboxClicked(this)">
                                                            {{$amenity->translations->first()->title}}
                                                            <span></span>
                                                            <br>
                                                        </label>
                                                        <br>
                                                        <input type="text" name='amenity[{{$amenity->id}}]' size="5" value="">
                                                    </div>
                                                    <br>
                                                @endif
                                            @endif
                                        @else
                                            @if($amenity->text_field === 0)
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name='amenity[{{$amenity->id}}]' value="true">
                                                    {{$amenity->translations->first()->title}}
                                                    <span></span>
                                                    <br>
                                                </label>
                                                <br>
                                            @else
                                                <div>
                                                    <label class="m-checkbox">
                                                        <input type="checkbox" name='amenity[{{$amenity->id}}]' value="true" onclick="textCheckboxClicked(this)">
                                                        {{$amenity->translations->first()->title}}
                                                        <span></span>
                                                        <br>
                                                    </label>
                                                    <br>
                                                    <input type="text" name='amenity[{{$amenity->id}}]' size="5" value="">
                                                </div>
                                                <br>
                                            @endif
                                        @endif
                                        @if((($key % 8 === 0) && ($key != 0)) || ($key === (count($set->amenities)-1)))
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_5" role="tabpanel">
                    <div class="m-portlet__body">
                        <ul class="nav nav-tabs" role="tablist">
                            @php $counter = 0; @endphp
                            @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
                                <li class="nav-item">
                                    @if($counter === 0)
                                        <a class="nav-link active" data-toggle="tab" href="#" data-target="#m_tabs_2_{{$lang}}">{{$language}}</a>
                                    @else
                                        <a class="nav-link" data-toggle="tab" href="#" data-target="#m_tabs_2_{{$lang}}">{{$language}}</a>
                                    @endif
                                </li>
                            @php $counter++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @php $counter = 0; @endphp
                            @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
                                @if($counter === 0)
                                    <div id="m_tabs_2_{{$lang}}" class="tab-pane active" role="tabpanel">
                                @else
                                    <div id="m_tabs_2_{{$lang}}" class="tab-pane" role="tabpanel">
                                @endif
                                    <label for="{{$lang}}_textarea">Description</label>
                                    @if($object->exists && isset($object->formattedTranslations[$lang]))
                                        {!! Form::textarea('description_translation[' . $lang . '][description]', $object->formattedTranslations[$lang]->description, ['id' => "{{$lang}}_textarea", 'rows' => 3, 'class' => 'form-control m-input m-input--solid']) !!}
                                    @else
                                        {!! Form::textarea('description_translation[' . $lang . '][description]', null, ['id' => "{{$lang}}_textarea", 'rows' => 3, 'class' => 'form-control m-input m-input--solid']) !!}
                                    @endif
                                </div>
                                @php $counter++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_6" role="tabpanel">
                    <div class="m-portlet__body">
                        @foreach($amenitySet[1]->amenities as $key => $amenity)
                            @if($key === 0)
                                <div class="form-group m-form__group row">
                            @elseif($key % 6 === 0)
                                </div>
                                <div class="form-group m-form__group row">
                            @endif
                                    <div class="col-2">
                                        <label>{{$amenity->translations->first()->title}}</label>
                                        @if(($object->exists()) && (isset($distanceAmenitiesArray[$amenity->id])))
                                            <input class="form-control m-input" placeholder="km" name='distance_amenity[{{$amenity->id}}]' value="{{$distanceAmenitiesArray[$amenity->id]}}">
                                        @else
                                            <input class="form-control m-input" placeholder="km" name='distance_amenity[{{$amenity->id}}]'>
                                        @endif
                                    </div>
                            @if($key === (count($amenitySet[1]->amenities)-1))
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_7" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-3">
                                <label>Select channel manager</label>
                                <div class="">
                                    {!! Form::select('channel_manager',  ['phobs' => 'PHOBS', 'rate_hawk' => 'Rate hawk'], '', ['class' => 'form-control m-input']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="m-radio-inline">
                                    <label class="m-radio m-radio--solid">
                                        {!! Form::radio('manager', '1', '1') !!}
                                        PHOBS
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--solid">
                                        {!! Form::radio('manager', '1', '') !!}
                                        Rate Hawk
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_8" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            {!! Form::label('lat', __('accommodation::accommodation.object.lat')) !!}
                            @if($object->exists)
                                {!! Form::input('text', 'lat', $object->lat,['class' => 'form-control m-input', 'readonly']) !!}
                            @else
                                {!! Form::input('text', 'lat', '43.75919024203899',['class' => 'form-control m-input', 'readonly']) !!}
                            @endif
                            @if ($errors->has('lat'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('lat') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            {!! Form::label('long', __('accommodation::accommodation.object.long')) !!}
                            @if($object->exists)
                                {!! Form::input('text', 'long', $object->long,['class' => 'form-control m-input', 'readonly']) !!}
                            @else
                                {!! Form::input('text', 'long', '16.141654804687505',['class' => 'form-control m-input', 'readonly']) !!}
                            @endif
                            @if ($errors->has('long'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('long') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group m-form__group">
                            <div id="map_canvas" style="width: 500px; height: 250px;"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_9" role="tabpanel">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <div class="container">
                                <div class="card card-body bg-light">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                @php $counter = 0; @endphp
                                                @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
                                                    <div class="col-lg-4">
                                                        {!! Form::label('translation[0][' . $lang . '][alt]', $language . ' alt text') !!}
                                                        {!! Form::input('text','translation[0][' .  $lang . '][alt]', '' ,['class' => 'form-control m-input']) !!}
                                                    </div>
                                                    @php $counter++; @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><input type="file" class="btn blue start files" id="files_0" onchange="previewImage(this)" name="files[]"></span>
                                                        <span class="fileinput-filename"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button type="button" class="btn btn-circle red-mint" id="clear_0" onclick="clearEvent(this)">Clear</button>
                                                    <output id="result_0" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                @foreach (\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
                                                    <div class="col-lg-4">
                                                        {!! Form::label('translation[0][' . $lang . '][description]', $language . ' description') !!}
                                                        {!! Form::input('text','translation[0][' .  $lang . '][description]', '' ,['class' => 'form-control m-input']) !!}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div id="additionalImages">
                            </div>
                            <button type="button" class="btn btn-circle green-haze" id="addMore">Add</button>
                            <div class="container">
                                <div class="row">
                                    @foreach($imageArray as $key => $url)
                                        <div class="col-lg-6">
                                            <div class="clearfix">
                                                <button class="btn btn-danger" type="button" onclick="deleteImage({{$key}})">Delete</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <img src="{{$url}}" alt="-">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="info">
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="m-portlet__body">
            @include('base::layouts.submit_button')
        </div>
    {!! Form::close() !!}
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&sensor=false"></script>
    <script type="text/javascript">
        var products = {};
        @foreach(\Modules\Base\Services\LanguageConfig::get() as $lang => $language)
            products['{{$lang}}'] = '{{$language}}';
        @endforeach

        @if($object->exists)
            lat = '{!! $object->lat !!}';
        long = '{!! $object->long !!}';
        @else
            lat = 43.75919024203899;
        long = 16.141654804687505;
        @endif

        $(document).on('click', "input.files", function() {
            var id = $(this)[0].id;
            var splitted = id.split("_");
            $('#thumbnail_' + splitted[1]).parent().remove();
            $('#result_'  + splitted[1]).hide();
            $('#clear_' + splitted[1]).show();
            $(this).val("");
        });

        var imageFieldNum = 0;

        function disableEmptyInputs(form) {
            var controls = form.elements;
            for (var i=0, iLen=controls.length; i<iLen; i++) {
                controls[i].disabled = controls[i].value == '';
            }
        }

        function textCheckboxClicked(obj) {
            var parentDiv = $(obj).parent().closest('div');
            if($(obj).is(':checked')) {
                $(parentDiv).find('input:text').prop('required',true);
            } else {
                $(parentDiv).find('input:text').prop('required',false);
            }
        }

        function deleteImage(imageId) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{ route('accommodation.object.image.delete') }}",
                method:"POST",
                data:{imageId:imageId, _token:_token},
                success:function(data){
                    var div = '<div class="alert alert-success alert-dismissable">'
                        + '<h1>' + 'Success' + '</h1>' + '<p>' + data + '</p>' + '</div>';
                    $('#info')
                        .append(div);

                    setTimeout(location.reload.bind(location), 600);
                },
                error:function (data) {
                    $('#info').html('');
                    $('#info').append('<div class="alert alert-danger">'+data+'</div>');
                }
            });
        }


        function checkAllAmenities(check, amenity_type_id)
        {
            var amenities = document.getElementById(amenity_type_id).getElementsByTagName("input");

            var i;
            for(i = 0; i < amenities.length; i++) {

                if(amenities[i].type === 'checkbox') {
                    amenities[i].checked = check;
                }

                if(amenities[i].type === 'text') {
                    if(check == true) {
                        amenities[i].required = true;
                    } else {
                        amenities[i].required = false;
                    }
                }
            }
        }



        window.onload = function(){
            $('#clear_0').hide();
        };


        $(document).ready(function(){
            $('.switch').bootstrapSwitch();
            $('select').selectpicker();
            $('#accObjectNav').parent().addClass('m-menu__item--open');

            function initialize() {
                var myLatlng = new google.maps.LatLng(lat, long);

                var myOptions = {
                    zoom: 8,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

                var marker = new google.maps.Marker({
                    draggable: true,
                    position: myLatlng,
                    map: map,
                    title: "Your location"
                });

                google.maps.event.addListener(marker, 'dragend', function (event) {


                    document.getElementById("lat").value = event.latLng.lat();
                    document.getElementById("long").value = event.latLng.lng();
                });
            }
            google.maps.event.addDomListener(window, "load", initialize());


            var ownersGlobal = '';

            $('#owner').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('users.autocomplete') }}",
                        method:"GET",
                        data:{query:query, _token:_token},
                        success:function(data){
                            ownersGlobal = data;
                            var html = '<ul class="dropdown-menu" style="display:block; position:relative">';
                            $.each(data, function( key, value ) {
                                html = html + '<li class="ownerInfo"><a href="#">' + value.value + '</a></li>';
                            });
                            html = html + '</ul>';
                            $('#owners').fadeIn();
                            $('#owners').html(html);
                        }
                    });
                }
            });

            $(document).on('click', '.ownerInfo', function(){
                for (var key in ownersGlobal) {
                    if(ownersGlobal[key].value === $(this).text() ) {
                        $('#email').val(ownersGlobal[key].email);
                    }
                }

                $('#owner').val($(this).text());
                $('#owners').fadeOut();
            });



            $('#addMore').on("click", function() {
                fieldFactory();
            });
        });

        function previewImage(object)
        {
            var files = object.files; //FileList object

            var idObject = object.id;
            var splitted = idObject.split("_");
            var id = splitted[1];
            var output = document.getElementById("result_" + id);

            for(var i = 0; i< files.length; i++)
            {
                var file = files[i];
                if(file.type.match('image.*')){
                    if(files[0].size < 2097152){
                        // continue;
                        var picReader = new FileReader();
                        picReader.addEventListener("load",function(event){
                            var picFile = event.target;
                            var div = document.createElement("div");
                            var thumbnailId = 'thumbnail_' + id;
                            div.innerHTML = "<img id=" + thumbnailId + " src='" + picFile.result + "'" +
                                "title='preview image'/>";
                            output.insertBefore(div,null);
                        });
                        //Read the image
                        $('#clear_' + id).removeAttr("hidden");
                        $('#result_' + id).show();
                        picReader.readAsDataURL(file);
                    }else{
                        alert("Image Size is too big. Minimum size is 2MB.");
                        $(this).val("");
                    }
                }else{
                    alert("You can only upload image file.");
                    $(this).val("");
                }
            }
        }


        function clearEvent(obj) {
            var id = obj.id;
            var splitted = id.split("_");

            $('#thumbnail_' + splitted[1]).parent().remove();
            $('#result_' + splitted[1]).hide();
            $('#files_' + splitted[1]).val("");

            obj.hidden = true;
        }


        function fieldFactory()
        {
            imageFieldNum++;

            var additionalImagesDiv = document.getElementById("additionalImages");

            var wrapperDiv = document.createElement('div');
            wrapperDiv.setAttribute('id', 'wrapper_' + imageFieldNum);

            additionalImagesDiv.appendChild(wrapperDiv);

            var containerDiv = document.createElement('div');
            containerDiv.classList.add('container');

            wrapperDiv.appendChild(containerDiv);

            var cardDiv = document.createElement('div');
            cardDiv.classList.add('card');
            cardDiv.classList.add('card-body');
            cardDiv.classList.add('bg-light');

            containerDiv.appendChild(cardDiv);


            var firstRowDiv = document.createElement('div');
            firstRowDiv.classList.add('row');

            cardDiv.appendChild(firstRowDiv);

            var lgDiv1 = document.createElement('div');
            lgDiv1.classList.add('col-lg-6');

            firstRowDiv.appendChild(lgDiv1);

            var insideRowDiv = document.createElement('div');
            insideRowDiv.classList.add('row');

            lgDiv1.appendChild(insideRowDiv);

            var i = 0;
            var lgDivArray = [];

            for (lang in products) {

                lgDivArray[i]= document.createElement('div');
                lgDivArray[i].classList.add('col-lg-4');

                var fieldLabel = document.createElement('Label');
                fieldLabel.setAttribute('for', 'translation[' + imageFieldNum + '][' + lang + '][alt]');
                fieldLabel.textContent = products[lang] + ' alt text';


                var fieldInput = document.createElement('input');
                fieldInput.setAttribute('type', 'text');
                fieldInput.setAttribute('class', 'form-control m-input');
                fieldInput.setAttribute('id', lang + '[alt]');
                fieldInput.setAttribute('name', 'translation[' + imageFieldNum + '][' + lang + '][alt]');

                lgDivArray[i].appendChild(fieldLabel);
                lgDivArray[i].appendChild(fieldInput);
                insideRowDiv.appendChild(lgDivArray[i]);
            }

            var lgDiv2 = document.createElement('div');
            lgDiv2.classList.add('col-lg-6');

            firstRowDiv.appendChild(lgDiv2);

            var insideRowDiv2 = document.createElement('div');
            insideRowDiv2.classList.add('row');

            lgDiv2.appendChild(insideRowDiv2);

            var lgDivImage1 = document.createElement('div');
            lgDivImage1.classList.add('col-lg-6');

            insideRowDiv2.appendChild(lgDivImage1);

            var fileInputDiv = document.createElement('div');
            fileInputDiv.setAttribute('class', 'fileinput fileinput-new');
            fileInputDiv.setAttribute('data-provides', 'fileinput');

            var fileInputSpan1 = document.createElement('span');
            fileInputSpan1.setAttribute('class', 'btn btn-default btn-file');

            fileInputDiv.appendChild(fileInputSpan1);

            var fileInputSpan2 = document.createElement('span');
            fileInputSpan2.setAttribute('class', 'fileinput-new');
            fileInputSpan2.textContent = 'Select image';

            fileInputSpan1.appendChild(fileInputSpan2);

            var fileInput = document.createElement('input');
            fileInput.setAttribute('type', 'file');
            fileInput.setAttribute('class', 'btn blue start files');
            fileInput.setAttribute('id', 'files_' + imageFieldNum);
            fileInput.setAttribute("onchange", "previewImage(this)");
            fileInput.setAttribute('name', 'files[]');

            fileInputSpan1.appendChild(fileInput);

            var fileInputSpan3 = document.createElement('span');
            fileInputSpan3.setAttribute('class', 'fileinput-filename');

            fileInputDiv.appendChild(fileInputSpan3);

            lgDivImage1.appendChild(fileInputDiv);


            var lgDivImage2 = document.createElement('div');
            lgDivImage2.classList.add('col-lg-6');

            insideRowDiv2.appendChild(lgDivImage2);



            var clearButton = document.createElement('button');
            clearButton.setAttribute('type', 'button');
            clearButton.setAttribute('class', 'btn btn-circle red-mint');
            clearButton.setAttribute('id', 'clear_' + imageFieldNum);
            clearButton.setAttribute("onclick", "clearEvent(this)");
            clearButton.setAttribute('hidden', 'true');
            clearButton.textContent = 'Clear';

            $('#clear').hide();

            lgDivImage2.appendChild(clearButton);

            var outputField = document.createElement('output');
            outputField.setAttribute('id', 'result_' + imageFieldNum);

            lgDivImage2.appendChild(outputField);


            var rowDiv3 = document.createElement('div');
            rowDiv3.classList.add('row');

            cardDiv.appendChild(rowDiv3);

            var lgDiv3 = document.createElement('div');
            lgDiv3.classList.add('col-lg-6');

            rowDiv3.appendChild(lgDiv3);

            var rowDiv4 = document.createElement('div');
            rowDiv4.classList.add('row');

            lgDiv3.appendChild(rowDiv4);

            i = 0;
            lgDivArray = [];

            for (lang in products) {

                lgDivArray[i]= document.createElement('div');
                lgDivArray[i].classList.add('col-lg-4');

                var fieldLabel2 = document.createElement('Label');
                fieldLabel2.setAttribute('for', 'translation[' + imageFieldNum + '][' + lang + '][description]');
                fieldLabel2.textContent = products[lang] + ' description';


                var fieldInput2 = document.createElement('input');
                fieldInput2.setAttribute('type', 'text');
                fieldInput2.setAttribute('class', 'form-control m-input');
                fieldInput2.setAttribute('id', lang + '[description]');
                fieldInput2.setAttribute('name', 'translation[' + imageFieldNum + '][' + lang + '][description]');

                lgDivArray[i].appendChild(fieldLabel2);
                lgDivArray[i].appendChild(fieldInput2);
                rowDiv4.appendChild(lgDivArray[i]);
            }

            var lgDiv4 = document.createElement('div');
            lgDiv4.classList.add('col-lg-6');

            rowDiv3.appendChild(lgDiv4);

            var deleteSectionButton = document.createElement('button');
            deleteSectionButton.setAttribute('class', 'btn btn-circle red-mint');
            deleteSectionButton.setAttribute('type', 'button');
            deleteSectionButton.setAttribute('id', 'delete_' + imageFieldNum);
            deleteSectionButton.setAttribute('onclick', 'removeSection('+ 'wrapper_' + imageFieldNum +')');
            deleteSectionButton.textContent = 'X';


            var horizontalLine = document.createElement('hr');
            wrapperDiv.appendChild(deleteSectionButton);
            wrapperDiv.appendChild(horizontalLine);
        }

        function removeSection(id)
        {
            id.remove();
        }


        $("#country_id").change(function()
        {
            var id=$(this).val();
            var dataString = 'id='+ id;
            $("#region_id").empty();
            $("#city_id").empty();

            if( id > 0) {
                $.ajax
                ({
                    type: "GET",
                    url: '{{ route('countries.regions.select') }}',
                    data: dataString,
                    cache: false,
                    success: function(regions)
                    {
                        $.each(regions, function (key, object) {
                            if(key === 0) {
                                $("#region_id").append($('<option></option>').attr('value', 0).text('Choose'));
                            }

                            $("#region_id").append($('<option></option>').attr('value', object.id).text(object.name));
                        });
                        $("#region_id").selectpicker("refresh");
                    }
                });
            }
        });

        $("#region_id").change(function()
        {
            var id=$(this).val();
            var dataString = 'id='+ id;
            $("#city_id").empty();

            if(id > 0) {
                $.ajax
                ({
                    type: "GET",
                    url: '{{ route('regions.cities.select') }}',
                    data: dataString,
                    cache: false,
                    success: function(regions)
                    {
                        $.each(regions, function (key, object) {
                            if(key === 0) {
                                $("#city_id").append($('<option></option>').attr('value', 0).text('Choose'));
                            }

                            $("#city_id").append($('<option></option>').attr('value', object.id).text(object.name));
                        });

                        $("#city_id").selectpicker("refresh");
                    }
                });
            }

        });
    </script>
@endsection
