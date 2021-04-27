@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('base::base.user.assign.role'), 'icon' => 'fa fa-ban'])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>{{ __('accommodation::accommodation.category.list.id') }}</th>
                    <th>{{ __('base::base.user.name') }}</th>
                    <th>{{ __('base::base.user.role') }}</th>
                    <th>{{ __('global.actions') }}</th>
                </tr>
                </thead>
                <tbody align="center">
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            @if($user->roleExists())
                                <td>{{ $user->roles->first()->name }}</td>
                            @else
                                <td></td>
                            @endif
                            <td>
                                @can('assign-role')
                                    <a href="#" title="{{ __('global.edit') }}" class="editButton m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Role modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <label data-error="wrong" data-success="right" for="user">User</label>
                            <input id="modalName" type="text" disabled/>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col col-md-12">
                            <label data-error="wrong" data-success="right" for="productsDropdown">Roles</label>
                            <select class="mdb-select" id="roleDropdown">
                                @foreach($roleGroups as $id => $roleGroup)
                                    <optgroup label="{{$roleGroup->name}}">
                                        @foreach($roleGroup->roles as $id => $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div id="info">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="saveModal" type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
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
    <script type="text/javascript">
        $(document).ready(function() {

            $(".editButton").on("click", function(){
                var rowArray = $(this).closest('tr').find('td').map(function() {
                    return $(this).text();
                });
                openModal(rowArray[1], rowArray[0]);
            });
        });

        function openModal(name, id) {
            $('#modalName').val(name);
            $("#roleModal").modal();
            $( "#saveModal" ).bind( "click", function() {
                console.log($('#roleDropdown').val());
                $.ajax({
                    url: '/user/' + id +'/assign/role',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'role': $('#roleDropdown').val()
                    },
                    success: function(data) {
                        var div = '<div class="alert alert-success alert-dismissable">'
                            + '<h1>' + 'Success' + '</h1>' + '<p>' + data.message + '</p>' + '</div>';
                        $('#info')
                            .append(div);

                        setTimeout(location.reload.bind(location), 600);
                    },
                    error: function(data) {
                        $('#info').html('');
                        $.each(data.responseJSON.errors, function(key,value) {
                            $('#info').append('<div class="alert alert-danger">'+value+'</div>');
                        });
                    },
                    type: 'POST'
                });
            });
        }
    </script>
@endsection
