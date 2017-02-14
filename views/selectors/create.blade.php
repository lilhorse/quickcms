@extends('backend::layouts.master')
@section('style')
    <style>
        .select2-hidden-accessible {
            display: none;
        }
    </style>
@endsection
@section('content')
    <!-- MAIN CONTENT -->
<div id="content">
    <section id="widget-grid" class="">
            <div class="row">
                <article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
                <div class="jarviswidget jarviswidget-sortable" id="wid-id-4" data-widget-hidden="false" data-widget-togglebutton="false"
                     data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
                    <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div><div class="widget-toolbar" role="menu"><a data-toggle="dropdown" class="dropdown-toggle color-box selector" href="javascript:void(0);"></a><ul class="dropdown-menu arrow-box-up-right color-select pull-right"><li><span class="bg-color-green" data-widget-setstyle="jarviswidget-color-green" rel="tooltip" data-placement="left" data-original-title="Green Grass"></span></li><li><span class="bg-color-greenDark" data-widget-setstyle="jarviswidget-color-greenDark" rel="tooltip" data-placement="top" data-original-title="Dark Green"></span></li><li><span class="bg-color-greenLight" data-widget-setstyle="jarviswidget-color-greenLight" rel="tooltip" data-placement="top" data-original-title="Light Green"></span></li><li><span class="bg-color-purple" data-widget-setstyle="jarviswidget-color-purple" rel="tooltip" data-placement="top" data-original-title="Purple"></span></li><li><span class="bg-color-magenta" data-widget-setstyle="jarviswidget-color-magenta" rel="tooltip" data-placement="top" data-original-title="Magenta"></span></li><li><span class="bg-color-pink" data-widget-setstyle="jarviswidget-color-pink" rel="tooltip" data-placement="right" data-original-title="Pink"></span></li><li><span class="bg-color-pinkDark" data-widget-setstyle="jarviswidget-color-pinkDark" rel="tooltip" data-placement="left" data-original-title="Fade Pink"></span></li><li><span class="bg-color-blueLight" data-widget-setstyle="jarviswidget-color-blueLight" rel="tooltip" data-placement="top" data-original-title="Light Blue"></span></li><li><span class="bg-color-teal" data-widget-setstyle="jarviswidget-color-teal" rel="tooltip" data-placement="top" data-original-title="Teal"></span></li><li><span class="bg-color-blue" data-widget-setstyle="jarviswidget-color-blue" rel="tooltip" data-placement="top" data-original-title="Ocean Blue"></span></li><li><span class="bg-color-blueDark" data-widget-setstyle="jarviswidget-color-blueDark" rel="tooltip" data-placement="top" data-original-title="Night Sky"></span></li><li><span class="bg-color-darken" data-widget-setstyle="jarviswidget-color-darken" rel="tooltip" data-placement="right" data-original-title="Night"></span></li><li><span class="bg-color-yellow" data-widget-setstyle="jarviswidget-color-yellow" rel="tooltip" data-placement="left" data-original-title="Day Light"></span></li><li><span class="bg-color-orange" data-widget-setstyle="jarviswidget-color-orange" rel="tooltip" data-placement="bottom" data-original-title="Orange"></span></li><li><span class="bg-color-orangeDark" data-widget-setstyle="jarviswidget-color-orangeDark" rel="tooltip" data-placement="bottom" data-original-title="Dark Orange"></span></li><li><span class="bg-color-red" data-widget-setstyle="jarviswidget-color-red" rel="tooltip" data-placement="bottom" data-original-title="Red Rose"></span></li><li><span class="bg-color-redLight" data-widget-setstyle="jarviswidget-color-redLight" rel="tooltip" data-placement="bottom" data-original-title="Light Red"></span></li><li><span class="bg-color-white" data-widget-setstyle="jarviswidget-color-white" rel="tooltip" data-placement="right" data-original-title="Purity"></span></li><li><a href="javascript:void(0);" class="jarviswidget-remove-colors" data-widget-setstyle="" rel="tooltip" data-placement="bottom" data-original-title="Reset widget color to default">Remove</a></li></ul></div>
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>枚举管理 </h2>
                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
                    <div role="content">
                        <div class="jarviswidget-editbox">
                        </div>
                        <div class="widget-body no-padding">
                            <form action="{{route('admin.selector.store')}}" method="post" id="smart-form-register" class="smart-form" novalidate="novalidate">
                                {!! csrf_field() !!}
                                <header>
                                    添加新枚举
                                </header>
                                <fieldset>
                                    <section>
                                        <label class="input">
                                            <label class="label">名称</label>
                                        @if ($selector->id)
                                            <input type="hidden" name="id" value="{{$selector->id}}" placeholder="">
                                        @endif
                                            <input type="text" name="name" value="{{$selector->name}}" placeholder="名称">
                                        </label>
                                    </section>
                                    <section>
                                        <label class="input">
                                            <label class="label">键名</label>
                                            <input type="text" name="enum_key" value="{{$selector->enum_key}}" placeholder="键名" id="enum_key">
                                        </label>
                                    </section>
                                    <section>
                                        <label class="label">键值类型</label>
                                        <label class="select">
                                            <select name="type" id="value_type">
                                                @if($selector->type == 0)
                                                <option selected value="0">SQL</option>
                                                @else
                                                <option value="0">SQL</option>
                                                @endif
                                                @if($selector->type == 1)
                                                <option selected value="1">JSON</option>
                                                @else
                                                <option value="1">JSON</option>
                                                @endif
                                            </select>
                                            <i></i>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="input">
                                            <label class="label">SQL语法：<span class="span text-primary">select id,name from table</span></label>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="input">
                                            <label class="label">JSON语法：<span class="span text-primary">{"k1":"v1","k2":[1,2,3],"k3":{"0":"v1","1":"v2"}}</span></label>
                                        </label>
                                    </section>
                                    <section>
                                        <label class="input">
                                            <label class="label">键值</label>
                                            <textarea name="enum_value" id="enum_value" style="width: 100%; height:150px">{{$selector->enum_value}}</textarea>
                                        </label>
                                        <button type="button" id="preview"  class="btn btn-primary btn-sm">预览</button>
                                    </section>
                                    <section>
                                        <label class="label">是否有缺省选项</label>
                                        <label class="select">
                                            <select name="default_option" id="default_option">
                                            @if(is_null($selector->default_key) || $selector->default_key == '')
                                                <option value="0" selected>无</option>
                                                <option value="1">有</option>
                                            @else
                                                <option value="0">无</option>
                                                <option value="1" selected>有</option>
                                            @endif
                                            </select>
                                            <i></i>
                                        </label>
                                    </section>
                                    @if(is_null($selector->default_key) || $selector->default_key == '')
                                    <div style="display: none;" id="has_default_option">
                                    @else
                                    <div id="has_default_option">
                                    @endif
                                        <section>
                                            <label class="input">
                                                <label class="label">缺省选项名</label>
                                                <input type="text" name="default_key" id="default_key" value="{{$selector->default_key}}" placeholder="缺省选项名">
                                            </label>
                                        </section>
                                        <section>
                                            <label class="input">
                                                <label class="label">缺省选项值</label>
                                                <input type="text" name="default_value" id="default_value" value="{{$selector->default_value}}" placeholder="缺省选项值">
                                            </label>
                                        </section>
                                    </div>
                                    <section>
                                        <label class="input">
                                            <label class="label">预览</label>
                                            <select style="width:100%" class="select2">
                                                <option value="AK">Alaska</option>
                                                <option value="HI">Hawaii</option>
                                                <option value="CT">Connecticut</option>
                                                <option value="DE">Delaware</option>
                                                <option value="FL">Florida</option>
                                                <option value="GA">Georgia</option>
                                                <option value="IN">Indiana</option>
                                                <option value="ME">Maine</option>
                                                <option value="MD">Maryland</option>
                                                <option value="MA">Massachusetts</option>
                                                <option value="MI">Michigan</option>
                                                <option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
                                                <option value="NY">New York</option>
                                                <option value="NC">North Carolina</option>
                                                <option value="OH">Ohio</option>
                                                <option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
                                                <option value="VT">Vermont</option><option value="VA">Virginia</option>
                                                <option value="WV">West Virginia</option>
                                            </select>
                                        </label>
                                    </section>
                                </fieldset>
                                <footer>
                                    <button type="submit" class="btn btn-primary">
                                        保存
                                    </button>
                                    <a href="/admin/selector" class="btn btn-primary">
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
<script>
    $(document).ready(function() {
        pageSetUp();

        $("#smart-form-register").validate({
            // Rules for form validation
            rules : {
                name : {
                    required : true
                },
                type:{
                    required: true
                },
                enum_key : {
                    required : true,
                    @if (!$selector->id)
                    remote:{
                        url: "/admin/selector/checkKey",     //后台处理程序
                        type: "get",               //数据发送方式
                        dataType: "json",           //接受数据格式
                        data: {                     //要传递的数据
                            enum_key: function() {
                                return $("#enum_key").val();
                            }
                        }
                    }
                    @endif
                },
                enum_vale : {
                    required : true
                }
            },
            // Messages for form validation
            messages : {
                name : {
                    required : '请输入名称'
                },
                enum_key : {
                    required : '请输入 key',
                    remote: '该 key 已存在'
                },
                enum_value : {
                    required : '请输入密码'
                },
                type : {
                    required : '请选择类型'
                }
            },
            // Do not change code below
            errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });

        $('#preview').click(function() {
            var data = $('#enum_value').val();
            var value_type = $('#value_type').val();
            if (value_type == 1) {
                data = eval('(' +data + ')');
            }
            $.ajax({
                type: 'get',
                url: '/admin/selector/preview',
                data: {
                    data: data,
                    type: value_type
                },
                dataType:'json'
            }).done(function(data) {
                var select = $('#select2');
                select.html('');
                var default_key = $('#default_key').val();
                var default_value = $('#default_value').val();
                if ($('#default_option').val() == 1) {
                    select.append('<option value="'+ default_value +'">'+ default_key +'</option>');
                }
                for (var i in data) {
                    select.append('<option value="'+ i +'">'+ data[i] +'</option>');
                }
            });
        });
        $('#default_option').change(function () {
            var flag = $('#default_option').val();
            if (flag == 1) {
                $('#has_default_option').css('display', 'block');
            } else {
                $('#has_default_option').css('display', 'none');
            }
        });
    });
</script>
@endsection
