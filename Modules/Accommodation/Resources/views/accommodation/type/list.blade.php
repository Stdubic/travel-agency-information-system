@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('accommodation::accommodation.type.list.name'), 'icon' => 'flaticon-home', 'path' => 'accommodation.type.create'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.type.list.id') }}</th>
                    <th>{{ __('accommodation::accommodation.type.list.title') }}</th>
                    <th>{{ __('accommodation::accommodation.type.list.capacity') }}</th>
                    <th>{{ __('accommodation::accommodation.type.list.max.capacity') }}</th>
                    <th>{{ __('accommodation::accommodation.type.list.min.capacity') }}</th>
                    <th>{{ __('accommodation::accommodation.type.list.max.adults') }}</th>
                    <th>{{ __('accommodation::accommodation.type.list.min.children') }}</th>
                    <th>{{ __('accommodation::accommodation.type.list.description') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($types as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->translations->first()->title }}</td>
                            <td>{{ $type->standard_capacity }}</td>
                            <td>{{ $type->max_capacity }}</td>
                            <td>{{ $type->min_capacity }}</td>
                            <td>{{ $type->max_adults }}</td>
                            <td>{{ $type->min_children }}</td>
                            <td>{{ $type->description }}</td>
                            <td>
                                @can('update-accommodation-object-type')
                                    <a href="{{ route('accommodation.type.edit', ['type' => $type->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-accommodation-object-type')
                                    <a href="{{ route('accommodation.type.delete', ['id' => $type->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{--{{ $types->links() }}--}}
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
