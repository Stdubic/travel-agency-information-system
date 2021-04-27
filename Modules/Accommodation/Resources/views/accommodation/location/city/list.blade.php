@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('accommodation::accommodation.location.city.list.title'), 'icon' => 'flaticon-placeholder-2', 'path' => 'accommodation.location.city.create'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.location.list.id') }}</th>
                    <th>{{ __('accommodation::accommodation.location.list.country') }}</th>
                    <th>{{ __('accommodation::accommodation.location.list.region') }}</th>
                    <th>{{ __('accommodation::accommodation.location.list.city') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($cities as $city)
                        <tr>
                            <td>{{ $city->id }}</td>
                            <td>{{ $city->region->country->global_name }}</td>
                            <td>{{ $city->region->name }}</td>
                            <td>{{ $city->name }}</td>
                            <td>
                                @can('update-city')
                                    <a href="{{ route('accommodation.location.city.edit', ['category' => $city->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-city')
                                    <a href="{{ route('accommodation.location.city.delete', ['id' => $city->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{--{{ $cities->links() }}--}}
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
