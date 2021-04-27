@extends('base::layouts.master')

@section('content')
    @if($roleGroup->exists)
        @php $title = 'base::base.roles.group.update'; @endphp
    @else
        @php $title = 'base::base.roles.group.create.name'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-ban', 'form' => 'role-group-form'])
    @if($roleGroup->exists)
        {!! Form::open(['id' => 'role-group-form', 'class' => 'm-form form-notify', 'route' => ['roles.group.update', $roleGroup->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'role-group-form', 'class' => 'm-form form-notify', 'route' => 'roles.group.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        <div class="form-group m-form__group">
            {!! Form::label('name', 'Group name') !!}
            @if($roleGroup->exists)
                {!! Form::input('text', 'name', $roleGroup->name  ,['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('text', 'name', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("name"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("name") }}</strong>
                </div>
            @endif
        </div>
    @include('base::layouts.submit_button')
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#rolesNav').parent().addClass('m-menu__item--open');
        });
    </script>
@endsection
