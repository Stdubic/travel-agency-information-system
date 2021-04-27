@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('accommodation::accommodation.rate.plan.list.title'), 'icon' => 'fa fa-money-bill'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.object.id') }}</th>
                    <th>{{ __('accommodation::accommodation.rate.plan.object.name') }}</th>
                    <th>{{ __('accommodation::accommodation.rate.plan.list.name') }}</th>
                    <th>{{ __('accommodation::accommodation.rate.plan.list.code') }}</th>
                    <th>{{ __('accommodation::accommodation.rate.plan.list.synced') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($rates as $rate)
                        <tr>
                            <td>{{ $rate->id }}</td>
                            <td>{{ $rate->object->name }}</td>
                            <td>{{ $rate->name }}</td>
                            <td>{{ $rate->code }}</td>
                            @if($rate->imported === 1)
                                <td>Synced with channel manager</td>
                            @else
                                <td>Custom</td>
                            @endif
                            <td>
                                @can('update-rate-plan')
                                    <a href="{{ route('accommodation.rate.plan.edit', ['rate' => $rate->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan

                                @if(!$rate->imported)
                                    @can('delete-rate-plan')
                                        <a href="{{ route('accommodation.rate.plan.delete', ['id' => $rate->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{--{{ $rates->links() }}--}}
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
