@extends('base::layouts.master')

@section('content')
    @include('base::layouts.list_header', ['title' => __('base::base.roles.hierarchy'), 'icon' => 'fa fa-ban'])
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row border border-primary">
                    <div class="row">
                        <div class="col-md-12">
                            <ul id="tree1">
                                @foreach($groups as $group)
                                    <li>
                                        {{ $group->name }}
                                        @if(count($group->roles))
                                            <ul>
                                                @foreach($group->roles as $role)
                                                    @if($role->type === 'manager')
                                                        <li>
                                                            {{ $role->name }} - Admin
                                                            @if(count($role->permissions))
                                                                <ul>
                                                                    @foreach($role->permissions as $permission)
                                                                        <li>
                                                                            {{ $permission->display_name }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @else
                                                        <li>
                                                            {{ $role->name }}
                                                            @if(count($role->permissions))
                                                                <ul>
                                                                    @foreach($role->permissions as $permission)
                                                                        <li>
                                                                            {{ $permission->display_name }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <button id="expandtree" class="btn btn-success m-btn m-btn--icon">
            <span>
                <span>Expand</span>
            </span>
        </button>
        <button id="collapsetree" class="btn btn-success m-btn m-btn--icon">
            <span>
                <span>Collapse</span>
            </span>
        </button>
    </div>
    <script type="text/javascript">
        $.fn.extend({
            treed: function (o) {
                var openedClass = 'glyphicon-chevron-right';
                var closedClass = 'glyphicon-chevron-down';

                if (typeof o != 'undefined'){
                    if (typeof o.openedClass != 'undefined'){
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass != 'undefined'){
                        closedClass = o.closedClass;
                    }
                };

                var tree = $(this);
                tree.addClass("tree");
                tree.find('li').has("ul").each(function () {
                    var branch = $(this); //li with children ul
                    branch.prepend("");
                    branch.addClass('branch');
                    branch.on('click', function (e) {
                        if (this == e.target) {
                            var icon = $(this).children('i:first');
                            icon.toggleClass(openedClass + " " + closedClass);
                            $(this).children().children().toggle(200);
                        }
                    })

                    $("#collapsetree").click(function(){
                        $('[class*=glyphicon-chevron-down]').addClass('').addClass("glyphicon-chevron-right").removeClass("glyphicon-chevron-down");
                        branch.children().children().hide(200);
                    });
                    $("#expandtree").click(function(){
                        $('[class*=glyphicon-chevron-right]').addClass('').addClass("glyphicon-chevron-down").removeClass("glyphicon-chevron-right");
                        branch.children().children().show(200);
                    });
                });
                tree.find('.branch .indicator').each(function(){
                    $(this).on('click', function () {
                        $(this).closest('li').click();
                    });
                });
                tree.find('.branch>a').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
                tree.find('.branch>button').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
            }
        });

        $('#tree1').treed();
    </script>
@endsection
