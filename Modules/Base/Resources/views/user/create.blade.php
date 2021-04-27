@extends('base::layouts.master')

@section('content')
    @if($user->exists)
        @php $title = 'base::base.user.update'; @endphp
    @else
        @php $title = 'base::base.user.create'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-male', 'form' => 'user-form'])
    @if($user->exists)
        {!! Form::open(['id' => 'user-form', 'class' => 'm-form form-notify', 'route' => ['users.update', $user->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'user-form', 'class' => 'm-form form-notify', 'route' => 'users.store', 'method' => 'POST']) !!}
    @endif
        <div class="m-portlet__body">
            @csrf
            <div class="form-group m-form__group">
                {!! Form::label('type', __('base::base.user.type')) !!}
                @if($user->exists)
                    {!! Form::select('type', ['legal' => 'Legal subject', 'private' => 'Private user'], $user->type, ['class' => 'bs-select form-control', 'id' => 'userType', 'disabled']) !!}
                    <input type="hidden" name="type" value="{{$user->type}}">
                @else
                    {!! Form::select('type', ['legal' => 'Legal subject', 'private' => 'Private user'], '', ['class' => 'bs-select form-control', 'id' => 'userType']) !!}
                @endif
                @if ($errors->has('type'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('type') }}</strong>
                    </div>
                @endif
            </div>
            @if($user->exists)
                @if ($user->type === 'legal')
                    <div id="legalUser" style="display: block">
                @else
                    <div id="legalUser" style="display: none">
                @endif
            @else
                <div id="legalUser" style="display: block">
            @endif
                    <div class="form-group m-form__group">
                        {!! Form::label('name', __('base::base.user.name')) !!}
                        @if($user->exists)
                            {!! Form::input('text', 'name', $user->name,['class' => 'form-control m-input']) !!}
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
                        {!! Form::label('legal_id', __('base::base.user.legal.id')) !!}
                        @if($user->exists && $user->type === 'legal')
                            {!! Form::input('text', 'legal_id', $user->userable->legal_id,['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'legal_id', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("legal_id"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("legal_id") }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            @if ($user->type === 'private')
                <div id="privateUser" style="display: block">
            @else
                <div id="privateUser" style="display: none">
            @endif
                    <div class="form-group m-form__group">
                        {!! Form::label('first_name', __('base::base.user.first.name')) !!}
                        @if($user->exists && $user->userable->first_name)
                            {!! Form::input('text', 'first_name', $user->userable->first_name,['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'first_name', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("first_name"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("first_name") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('middle_name', __('base::base.user.middle.name')) !!}
                        @if($user->exists && $user->userable->middle_name)
                            {!! Form::input('text', 'middle_name', $user->userable->middle_name,['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'middle_name', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("middle_name"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("middle_name") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('last_name', __('base::base.user.last.name')) !!}
                        @if($user->exists && $user->userable->last_name)
                            {!! Form::input('text', 'last_name', $user->userable->last_name,['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'last_name', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("last_name"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("last_name") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('id_num', __('base::base.user.id.num')) !!}
                        @if($user->exists && $user->userable->id_num)
                            {!! Form::input('text', 'id_num', $user->userable->id_num,['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'id_num', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("id_num"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("id_num") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('birth_date', __('base::base.user.birth.date')) !!}
                        @if($user->exists && $user->userable->birth_date)
                            {!! Form::input('text', 'birth_date', $user->userable->birth_date,['class' => 'form-control m-input chart-datepicker']) !!}
                        @else
                            {!! Form::input('text', 'birth_date', '',['class' => 'form-control m-input chart-datepicker']) !!}
                        @endif
                        @if ($errors->has("birth_date"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("birth_date") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('passport_num', __('base::base.user.passport.num')) !!}
                        @if($user->exists && $user->userable->passport_num)
                            {!! Form::input('text', 'passport_num', $user->userable->passport_num,['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'passport_num', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("passport_num"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("passport_num") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('passport_issued_at', __('base::base.user.passport.issued')) !!}
                        @if($user->exists && $user->userable->passport_issued_at)
                            {!! Form::input('text', 'passport_issued_at', $user->userable->passport_issued_at,['class' => 'form-control m-input chart-datepicker']) !!}
                        @else
                            {!! Form::input('text', 'passport_issued_at', '',['class' => 'form-control m-input chart-datepicker']) !!}
                        @endif
                        @if ($errors->has("passport_issued_at"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("passport_issued_at") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('passport_expired_at', __('base::base.user.passport.expired')) !!}
                        @if($user->exists && $user->userable->passport_expired_at)
                            {!! Form::input('text', 'passport_expired_at', $user->userable->passport_expired_at,['class' => 'form-control m-input chart-datepicker']) !!}
                        @else
                            {!! Form::input('text', 'passport_expired_at', '',['class' => 'form-control m-input chart-datepicker']) !!}
                        @endif
                        @if ($errors->has("passport_expired_at"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("passport_expired_at") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('nationality', __('base::base.user.nationality')) !!}
                        @if($user->exists && $user->userable->nationality)
                            {!! Form::input('text', 'nationality', $user->userable->nationality, ['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'nationality', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("nationality"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("nationality") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('sex', __('base::base.user.sex')) !!}
                        @if($user->exists && $user->userable->sex)
                            {!! Form::select('sex', ['m' => 'Male', 'f' => 'Female'], $user->userable->sex, ['class' => 'bs-select form-control']) !!}
                        @else
                            {!! Form::select('sex', ['m' => 'Male', 'f' => 'Female'], '', ['class' => 'bs-select form-control']) !!}
                        @endif
                        @if ($errors->has("sex"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("sex") }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group m-form__group">
                        {!! Form::label('website', __('base::base.user.website')) !!}
                        @if($user->exists && $user->userable->website)
                            {!! Form::input('text', 'website', $user->userable->website, ['class' => 'form-control m-input']) !!}
                        @else
                            {!! Form::input('text', 'website', '',['class' => 'form-control m-input']) !!}
                        @endif
                        @if ($errors->has("website"))
                            <div class="form-control-feedback">
                                <strong>{{ $errors->first("website") }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            <div class="form-group m-form__group">
                {!! Form::label('email', __('base::base.user.email')) !!}
                @if($user->email)
                    {!! Form::input('text', 'email', $user->email,['class' => 'form-control m-input' ,'disabled']) !!}
                @else
                    {!! Form::input('text', 'email', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("email"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("email") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('password', __('base::base.user.password')) !!}
                @if($user->password)
                    {!! Form::input('text', 'password', $user->password,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'password', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("password"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("password") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('oib', __('base::base.user.oib')) !!}
                @if($user->oib)
                    {!! Form::input('text', 'oib', $user->oib,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'oib', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("oib"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("oib") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('address', __('base::base.user.address')) !!}
                @if($user->address)
                    {!! Form::input('text', 'address', $user->address,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'address', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("address"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("address") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('city', __('base::base.user.city')) !!}
                @if($user->city)
                    {!! Form::input('text', 'city', $user->city,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'city', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("city"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("city") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('postal_code', __('base::base.user.postal.code')) !!}
                @if($user->postal_code)
                    {!! Form::input('text', 'postal_code', $user->postal_code,['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'postal_code', '',['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has("postal_code"))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first("postal_code") }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('country_id', __('base::base.user.country')) !!}
                @if($user->country_id)
                    {!! Form::select('country_id', $countries, $user->country_id, ['class' => 'bs-select form-control']) !!}
                @else
                    {!! Form::select('country_id', $countries, '', ['class' => 'bs-select form-control']) !!}
                @endif
                @if ($errors->has('country_id'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('country_id') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('tel_num', __('base::base.user.tel')) !!}
                @if($user->tel_num)
                    {!! Form::input('text', 'tel_num', $user->tel_num, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'tel_num', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('tel_num'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('tel_num') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('mobile_num', __('base::base.user.mobile')) !!}
                @if($user->tel_num)
                    {!! Form::input('text', 'mobile_num', $user->mobile_num, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'mobile_num', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('mobile_num'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('mobile_num') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('fax', __('base::base.user.fax')) !!}
                @if($user->tel_num)
                    {!! Form::input('text', 'fax', $user->fax, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'fax', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('fax'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('fax') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('skype', __('base::base.user.skype')) !!}
                @if($user->tel_num)
                    {!! Form::input('text', 'skype', $user->skype, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'skype', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('skype'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('skype') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('bank_name', __('base::base.user.bank')) !!}
                @if($user->tel_num)
                    {!! Form::input('text', 'bank_name', $user->bank_name, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'bank_name', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('bank_name'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('bank_name') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('iban', __('base::base.user.iban')) !!}
                @if($user->iban)
                    {!! Form::input('text', 'iban', $user->iban, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'iban', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('iban'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('iban') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('swift', __('base::base.user.swift')) !!}
                @if($user->swift)
                    {!! Form::input('text', 'swift', $user->swift, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'swift', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('swift'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('swift') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('affiliate_num', __('base::base.user.affiliate.num')) !!}
                @if($user->affiliate_num)
                    {!! Form::input('text', 'affiliate_num', $user->affiliate_num, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::input('text', 'affiliate_num', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('affiliate_num'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('affiliate_num') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group m-form__group">
                {!! Form::label('description', __('base::base.user.description')) !!}
                @if($user->description)
                    {!! Form::textarea('description', $user->description, ['class' => 'form-control m-input']) !!}
                @else
                    {!! Form::textarea('description', '', ['class' => 'form-control m-input']) !!}
                @endif
                @if ($errors->has('description'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('description') }}</strong>
                    </div>
                @endif
            </div>
            @include('base::layouts.submit_button')
        </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#userType').change(function()
            {
                changeForm(jQuery(this).val());
            });

        });

        function changeForm(dropdownVal)
        {
            if(dropdownVal === 'private') {
                $('#privateUser').show();
                $('#legalUser').hide();
            } else {
                $('#privateUser').hide();
                $('#legalUser').show();
            }
        }
    </script>
@endsection
