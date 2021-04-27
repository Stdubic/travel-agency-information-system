@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('accommodation::accommodation.object.list.title'), 'icon' => 'flaticon-home', 'path' => 'accommodation.object.create'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            {{--<table id="accommodationObjectList" width="100%" class="table table-bordered table-striped table-hover js-datatable">--}}
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.object.id') }}</th>
                    <th>{{ __('accommodation::accommodation.object.name') }}</th>
                    <th>{{ __('accommodation::accommodation.object.location.location') }}</th>
                    <th>{{ __('accommodation::accommodation.object.location.address') }}</th>
                    {{--<th>{{ __('accommodation::accommodation.object.location.region') }}</th>--}}
                    {{--<th>{{ __('accommodation::accommodation.object.location.city') }}</th>--}}
                    <th>{{ __('accommodation::accommodation.object.owner') }}</th>
                    <th>{{ __('accommodation::accommodation.object.unit.number') }}</th>
                    <th>{{ __('accommodation::accommodation.object.type') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($objects as $object)
                        {{--@php dd($object); @endphp--}}
                        <tr>
                            <td>{{ $object->id }}</td>
                            <td>{{ $object->name }}</td>
                            <td>{{ $object->country->name }}</td>
                            <td>{{ $object->city->name }}</td>
                            {{--<td>{{ $object->region->name }}</td>--}}
                            {{--<td>{{ $object->city->name }}</td>--}}
                            <td>{{ $object->owner->name }}</td>
                            <td>{{ $object->units->count()}}</td>
                            <td>
                                @if($object->type === 'hotel')
                                    <span class="m-badge  m-badge--primary m-badge--wide">Hotel</span>
                                @elseif($object->type === 'holiday_home')
                                    <span class="m-badge  m-badge--primary m-badge--wide">Holiday home</span>
                                @elseif($object->type === 'apartment_house')
                                    <span class="m-badge  m-badge--primary m-badge--wide">Apartment home</span>
                                @elseif($object->type === 'camp')
                                    <span class="m-badge  m-badge--primary m-badge--wide">Camp</span>
                                @endif
                            </td>
                            <td>
                                @if($object->is_synced == 0 && $object->channel_manager_code != null)
                                    @can('sync-accommodation-object')
                                        {!! Form::open(['class' => 'm-form form-notify', 'route' => ['accommodation.object.sync', $object->id] , 'method' => 'POST']) !!}
                                            {!! Form::submit('Sync with channel manager') !!}
                                        {!! Form::close() !!}
                                    @endcan
                                @endif
                                @can('update-accommodation-object')
                                    <a href="{{ route('accommodation.object.edit', ['object' => $object->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-accommodation-object')
                                    <a href="{{ route('accommodation.object.delete', ['id' => $object->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{--{{ $objects->links() }}--}}
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
