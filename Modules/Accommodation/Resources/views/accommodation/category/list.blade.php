@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('accommodation::accommodation.category.title'), 'icon' => 'flaticon-home', 'path' => 'accommodation.category.create'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                    <tr>
                        <th>{{ __('accommodation::accommodation.category.list.id') }}</th>
                        <th>{{ __('accommodation::accommodation.category.list.title') }}</th>
                        <th>{{ __('global.created-at') }}</th>
                        <th>{{ __('global.updated-at') }}</th>
                        <th>{{ __('global.actions') }}</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->translations->first()->title }}</td>
                            <td>{{ $category->translations->first()->created_at }}</td>
                            <td>{{ $category->translations->first()->updated_at }}</td>
                            <td>
                                @can('update-accommodation-object-category')
                                    <a href="{{ route('accommodation.category.edit', ['$category' => $category->id]) }}" title="{{ __('global.edit') }}" data-container="body" data-toggle="m-tooltip" data-placement="left" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete-accommodation-object-category')
                                    <a href="{{ route('accommodation.category.delete', ['id' => $category->id]) }}" title="{{ __('global.delete') }}" data-container="body" data-method="delete" data-token="{{ csrf_token() }}" data-toggle="m-tooltip" data-placement="right" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{--{{ $categories->links() }}--}}
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
