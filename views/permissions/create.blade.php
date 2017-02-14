@extends('backend::layouts.master')
@section('content')
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-6">
                    @include('backend::layouts.message')
                    <div class="jarviswidget" id="wid-id-4" data-widget-hidden="false" data-widget-togglebutton="false"
                         data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                            <h2>新增权限</h2>
                        </header>
                        <div>
                            <div class="jarviswidget-editbox">
                            </div>
                            <div class="widget-body no-padding">
                                <form action="{{ $action }}" method="post" id="smart-form-register" class="smart-form client-form">
                                    {!! csrf_field() !!}
                                    <fieldset>
                                        <section>
                                            <label class="input"> <i class="icon-append fa fa-envelope"></i>
                                                <input type="text" name="name" placeholder="权限名称 如：admin.permissions.create或者permissions#" value="{{$permission->name}}">
                                                <b class="tooltip tooltip-bottom-right">权限标示</b> </label>
                                        </section>
                                        <section>
                                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                <input type="text" name="display_name" placeholder="显示名称" id="display_name" value="{{$permission->display_name}}">
                                                <b class="tooltip tooltip-bottom-right">权限显示名称</b> </label>
                                        </section>
                                        <section>
                                            <label class="label">父权限</label>

                                            <select name="parent_id" class="select2">
                                                <option value="0">无</option>
                                                @foreach($parent_permission_list as $parent_permission)
                                                    <option value="{{ $parent_permission->id }}" @if($permission->parent_id == 0 && isset($permission->id)) disabled @endif @if($parent_permission->id == $permission->parent_id) selected @endif>
                                                        {{ $parent_permission->display_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </section>
                                        <section>
                                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                <input type="text" name="route" placeholder="权限路由 如：admin/permissions/create,如果为一级菜单可以为：#" id="route" value="{{$permission->route}}">
                                                <b class="tooltip tooltip-bottom-right">路由</b> </label>
                                        </section>
                                        <section>
                                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                <input type="text" name="sort" placeholder="排序" id="sort" value="{{$permission->sort}}">
                                                <b class="tooltip tooltip-bottom-right">排序</b> </label>
                                        </section>
                                        <section>
                                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                <input type="text" name="icon" placeholder="显示图标 如：fa-desktop" id="icon" value="{{$permission->icon}}">
                                                <b class="tooltip tooltip-bottom-right">显示图标</b> </label>
                                        </section>
                                        <section>
                                            <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                <input type="text" name="description" placeholder="描述" value="{{$permission->description}}">
                                                <b class="tooltip tooltip-bottom-right">权限描述</b> </label>
                                        </section>
                                        @if(!isset($permission->id))
                                        <section>
                                            <div class="inline-group">
                                                        <label class="radio">
                                                            <input type="radio" name="operation_permission" checked="checked" value="Y">
                                                            <i></i>默认操作功能数据</label>
                                                        <label class="radio">
                                                            <input type="radio" name="operation_permission" value="N">
                                                            <i></i>无</label>
                                                    </div> 
                                        </section>
                                        @endif
                                    </fieldset>
                                    <footer>
                                        <button type="submit" class="btn btn-primary">
                                            保存
                                        </button>
                                        <a href="{{route('admin.permissions.index')}}" class="btn btn-primary">
                                            返回
                                        </a>
                                    </footer>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend/js/plugin/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var $registerForm = $("#smart-form-register").validate({
                // Rules for form validation
                rules : {
                    name : {
                        required : true
                    },display_name : {
                        required : true
                    },route : {
                        required : true
                    }
                },

                // Messages for form validation
                messages : {
                    name : {
                        required : '必须填写权限名称'
                    },display_name : {
                        required : '必须填写显示名称'
                    },route : {
                        required : '必须填写路由'
                    }
                },

                // Do not change code below
                errorPlacement : function(error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    </script>
@endsection
