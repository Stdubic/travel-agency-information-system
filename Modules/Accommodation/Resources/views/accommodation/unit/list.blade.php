@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('accommodation::accommodation.unit.list.title'), 'icon' => 'flaticon-home-2'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.object.id') }}</th>
                    <th>{{ __('accommodation::accommodation.unit.object.name') }}</th>
                    <th>{{ __('accommodation::accommodation.unit.list.name') }}</th>
                    <th>{{ __('accommodation::accommodation.unit.list.code') }}</th>
                    <th>{{ __('accommodation::accommodation.unit.list.synced') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($units as $unit)
                        <tr>
                            <td>{{ $unit->id }}</td>
                            <td>{{ $unit->object->name }}</td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->code }}</td>
                            @if($unit->imported === 1)
                                <td>Synced with channel manager</td>
                            @else
                                <td>Custom</td>
                            @endif
                            <td>
                                @can('update-accommodation-unit')
                                    <a href="{{ route('accommodation.unit.edit', ['accommodationUnit' => $unit->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @if(!$unit->imported)
                                    @can('delete-accommodation-unit')
                                        <a href="{{ route('accommodation.unit.delete', ['id' => $unit->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{--{{ $units->links() }}--}}
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
