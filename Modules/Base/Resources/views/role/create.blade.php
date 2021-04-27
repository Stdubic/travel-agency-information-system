@extends('base::layouts.master')

@section('content')
    @if($role->exists)
        @php $title = 'base::base.roles.update'; @endphp
    @else
        @php $title = 'base::base.roles.create.name'; @endphp
    @endif
    @include('base::layouts.single_header', ['title' => __($title), 'icon' => 'fa fa-ban', 'form' => 'role-form'])
    @if($role->exists)
        {!! Form::open(['id' => 'role-form', 'class' => 'm-form form-notify', 'route' => ['roles.update', $role->id] , 'method' => 'PUT']) !!}
    @else
        {!! Form::open(['id' => 'role-form', 'class' => 'm-form form-notify', 'route' => 'roles.store', 'method' => 'POST']) !!}
    @endif
    <div class="m-portlet__body">
        @csrf
        <div class="form-group m-form__group">
            {!! Form::label('name', 'Role name') !!}
            @if($role->exists)
                {!! Form::input('text', 'name', $role->name  ,['class' => 'form-control m-input']) !!}
            @else
                {!! Form::input('text', 'name', '' ,['class' => 'form-control m-input']) !!}
            @endif
            @if ($errors->has("name"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("name") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('type', 'Role type') !!}
            @if($role->exists)
                {!! Form::select('type', ['user' => 'Regular user', 'manager' => 'Manager'], $role->type, ['class' => 'bs-select form-control']) !!}
            @else
                {!! Form::select('type', ['user' => 'Regular user', 'manager' => 'Manager'], '', ['class' => 'bs-select form-control']) !!}
            @endif
            @if ($errors->has("type"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("type") }}</strong>
                </div>
            @endif
        </div>
        <div class="form-group m-form__group">
            {!! Form::label('group_id', 'Role group') !!}
            @if($role->group_id)
                {!! Form::select('group_id', $roleGroup, $role->group_id, ['class' => 'bs-select form-control', 'id' => 'userType']) !!}
            @else
                {!! Form::select('group_id', $roleGroup, '', ['class' => 'bs-select form-control', 'id' => 'userType']) !!}
            @endif
            @if ($errors->has("group_id"))
                <div class="form-control-feedback">
                    <strong>{{ $errors->first("group_id") }}</strong>
                </div>
            @endif
        </div>
        {!! Form::label('permission', 'Permissions') !!}
        <div class="form-group m-form__group">
            @if($role->exists)
                @foreach($permissionGroup as $group)
                    <div class="row">
                        <div class="col col-md-6">
                            {!! Form::label('groups[' . $group->id . ']', $group->name) !!}
                        </div>
                    @if(in_array($group->id, $permissionGroupArray))
                        <div class="col col-md-6">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                                {!! Form::checkbox('groups[' . $group->id . ']', 1, 1, ['class' => 'form-control m-input', 'onclick' => "checkAllPermissions(this.checked, 'permission_div_{$group->id}' );"]) !!}<span></span>
                            </label>
                        </div>
                    @else
                        <div class="col col-md-6">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                                {!! Form::checkbox('groups[' . $group->id . ']', 1, '', ['class' => 'form-control m-input', 'onclick' => "checkAllPermissions(this.checked, 'permission_div_{$group->id}' );"]) !!}<span></span>
                            </label>
                        </div>
                    @endif
                    </div>
                    <div id='permission_div_{{$group->id}}'>
                        <div class="row border border-primary">
                            @foreach($group->permissions as $permission)
                                @if(isset($permissionArray[$permission->id]))
                                    <div class="col col-md-1">
                                        {!! Form::label('permission[' . $permission->name . ']', $permission->display_name) !!}
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                                            {!! Form::checkbox('permission[' . $permission->name . ']', 'true', true, ['class' => 'form-control m-input']) !!}<span></span>
                                        </label>
                                    </div>
                                @else
                                    <div class="col col-md-1">
                                        {!! Form::label('permission[' . $permission->name . ']', $permission->display_name) !!}
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                                            {!! Form::checkbox('permission[' . $permission->name . ']', 'true', '', ['class' => 'form-control m-input']) !!}<span></span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                @foreach($permissionGroup as $group)
                    <div class="row">
                        <div class="col col-md-6">
                            {!! Form::label('groups[' . $group->id . ']', $group->name) !!}
                        </div>
                        <div class="col col-md-6">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                                {!! Form::checkbox('groups[' . $group->id . ']', 1, '', ['class' => 'form-control m-input', 'onclick' => "checkAllPermissions(this.checked, 'permission_div_{$group->id}' );"]) !!}<span></span>
                            </label>
                        </div>
                    </div>
                    <div id='permission_div_{{$group->id}}'>
                        <div class="row border border-primary">
                            @foreach($group->permissions as $permission)
                                <div class="col col-md-1">
                                    {!! Form::label('permission[' . $permission->name . ']', $permission->display_name) !!}
                                    <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                                        {!! Form::checkbox('permission[' . $permission->name . ']', 'true', '', ['class' => 'form-control m-input']) !!}<span></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
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
            $('.switch').bootstrapSwitch();
            $('select').selectpicker();
            $('#rolesNav').parent().addClass('m-menu__item--open');
        });


        function checkAllPermissions(check, permission_group_id)
        {
            var permissions = document.getElementById(permission_group_id).getElementsByTagName("input");
            var i;
            for(i = 0; i < permissions.length; i++) {
                permissions[i].checked = check;
            }
        }
    </script>
@endsection
