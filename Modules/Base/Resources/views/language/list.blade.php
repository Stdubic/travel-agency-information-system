@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('base::base.settings.language.list.title'), 'icon' => 'fa fa-wrench'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.object.id') }}</th>
                    <th>{{ __('base::base.settings.language.code') }}</th>
                    <th>{{ __('base::base.settings.language.name') }}</th>
                    <th>{{ __('base::base.settings.language.active') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($languages as $language)
                        <tr>
                            <td>{{ $language->id }}</td>
                            <td>{{ $language->code }}</td>
                            <td>{{ $language->name }}</td>
                            <td>{{ $language->active }}</td>
                            <td>
                                @can('update-language')
                                    <a href="{{ route('language.edit', ['language' => $language->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-language')
                                    <a href="{{ route('language.delete', ['language' => $language->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('success') !!}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('error') !!}
        </div>
    @endif
    @if ($errors->has("error"))
        <div class="form-control-feedback">
            <strong>{{ $errors->first("error") }}</strong>
        </div>
    @endif
@endsection
