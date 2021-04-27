@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('base::base.user.list'), 'icon' => 'fa fa-male', 'path' => 'users.create'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.category.list.id') }}</th>
                    <th>{{ __('base::base.user.name') }}</th>
                    <th>{{ __('base::base.user.country') }}</th>
                    <th>{{ __('base::base.user.city') }}</th>
                    <th>{{ __('base::base.user.type') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ @$user->country->name }}</td>
                            <td>{{ $user->city }}</td>
                            <td>{{ $user->type }}</td>
                            <td>
                                @if($user->type != '')
                                    @can('update-user')
                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                @endif
                                @can('delete-user')
                                    <a href="{{ route('users.delete', ['user' => $user->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
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
