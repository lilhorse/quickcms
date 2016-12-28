@extends('backend::layouts.master')

@section('content')
    <!-- MAIN CONTENT -->
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row tips">
                @include('backend::layouts.message')
            </div>
            <div class="row">
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @if(isset($custom_id))
                        <p><a href="{{ $custom_id_back_url }}" class="btn btn-primary">返回</a></p>
                    @endif
                    @if($curd_action['create'])
                        <p>
                            @if(isset($custom_id))
                                <a href="{{ $route_path . '/create' }}"
                                   id="create_btn" class="btn btn-primary" permission="admin.{{ $route_name }}.create">新增{{ $model_name }}</a>
                            @else
                                <a href="{{ '/admin/' . $route_name . '/create' }}"
                                   id="create_btn" class="btn btn-primary" permission="admin.{{ $route_name }}.create">新增{{ $model_name }}</a>
                            @endif
                        </p>
                    @endif

                        {{--<fieldset>--}}
                            {{--<div class="row">--}}
                                {{--<section class="col col-3">--}}
                                    {{--<label class="input">--}}
                                        {{--<input type="text" placeholder="3/12" class="column_filter" id="col0_filter" data-column="0">--}}
                                    {{--</label>--}}
                                {{--</section>--}}
                                {{--<section class="col col-3">--}}
                                    {{--<label class="input">--}}
                                        {{--<input type="text" placeholder="3/12" class="column_filter" id="col1_filter" data-column="1">--}}
                                    {{--</label>--}}
                                {{--</section>--}}
                                {{--<section class="col col-3">--}}
                                    {{--<label class="input">--}}
                                        {{--<input type="text" placeholder="3/12" class="column_filter" id="col2_filter" data-column="2">--}}
                                    {{--</label>--}}
                                {{--</section>--}}
                                {{--<section class="col col-3">--}}
                                    {{--<label class="input">--}}
                                        {{--<input type="text" placeholder="3/12" class="column_filter" id="col3_filter" data-column="3">--}}
                                    {{--</label>--}}
                                {{--</section>--}}
                            {{--</div>--}}
                        {{--</fieldset>--}}

                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>@if(isset($custom_id)) {{ $custom_id . ' -' }} @endif{{ $model_name }}列表</h2>
                        </header>
                        <div>
                            <div class="jarviswidget-editbox">
                            </div>
                            <div class="widget-body no-padding">
                                <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                    <tr>
                                        @if(isset($index_column_name))
                                            @foreach($index_column_name as $name)
                                                <th>{{ $name }}</th>
                                            @endforeach
                                        @else
                                            @foreach($index_column as $column)
                                                <th>{{ $column_names[$column] }}</th>
                                            @endforeach
                                        @endif
                                        @if(isset($actions) || $curd_action['edit'] || $curd_action['delete'] || $curd_action['detail'])
                                            <th>操作</th>
                                        @endif
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" id="delete_token" value="{{ csrf_token() }}"/>
                    </div>
                </article>
            </div>
        </section>
    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('script')
    <script>


        $(document).ready(function() {
            var route_name = '{{ $route_name }}';
            var table = $('#dt_basic').DataTable({
                "processing": false,
                "serverSide": true,
                "bStateSave": true,
                "language": {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上一页",
                        "sNext": "下一页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },
                "columns" : [
                    @foreach($index_column as $index => $column)
                        @if (count($index_column_name) != $index)
                            @if(isset($table_sort[$column]) && $table_sort[$column])
                            { "orderable" : true },
                            @else
                            { "orderable" : false },
                            @endif
                        @endif
                    @endforeach
                    @if(isset($actions) || $curd_action['edit'] || $curd_action['delete'] || $curd_action['detail'])
                        { "orderable" : false },
                    @endif
                ],
                @if(isset($table_order))
                "order": [
                        @foreach($table_order as $order_key => $order_value)
                        [{{ $order_key }}, '{{ $order_value }}'],
                        @endforeach
                ],
                @endif
                "lengthMenu": [10, 25, 50, 100],
                "pageLength": 25,
                "columnDefs": [
                    @if(isset($table_column_width))
                        @foreach($table_column_width as $width_key => $width_value)
                            {"targets": {{ $width_key }}, "width": "{{ $width_value }}"},
                        @endforeach
                    @endif
                @if(isset($actions) || $curd_action['edit'] || $curd_action['delete'] || $curd_action['detail'])
                    {
                    "targets": -1,
                    "data": null,
                    "defaultContent":
                            ''
                    @if($table_action_line)
                        @if($curd_action['edit'])
                            + '<a name="edit_btn" class="btn btn-primary" permission="admin.{{ $route_name }}.edit">编辑</a>&nbsp;'
                        @endif
                        @if($curd_action['delete'])
                            + '<a name="delete_btn" class="btn btn-primary" permission="admin.{{ $route_name }}.delete">删除</a>&nbsp;'
                        @endif
                        @if($curd_action['detail'])
                            + '<a name="detail_btn" class="btn btn-primary" permission="admin.{{ $route_name }}.detail">详情</a>&nbsp;'
                        @endif
                        @if(isset($actions))
                            @foreach($actions as $index => $action)
                               + '<a name="{{ $action['name'] }}" permission="{{ $action['permission'] or '' }}" class="btn btn-primary">{{ $action['display_name'] }}</a>&nbsp;'
                            @endforeach
                        @endif

                    @else
                        @if($curd_action['edit'] || $curd_action['delete'] || $curd_action['detail'] || isset($actions))
                        + '<div class="btn-group">' +
                        '<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">操作 ' +
                        '<span class="caret"></span></button>' +
                        '<ul class="dropdown-menu">' +
                        @if($curd_action['edit'])
                            '<li class="edit_btn">' +
                            '<a href="javascript:void(0);" name="edit_btn" permission="admin.{{ $route_name }}.edit">编辑</a>' +
                            '</li>'+
                        @endif
                        @if($curd_action['edit'])
                            '<li class="divider"></li>' +
                        @endif
                        @if($curd_action['delete'])
                            '<li class="delete_btn">' +
                            '<a href="javascript:void(0);" name="delete_btn" permission="admin.{{ $route_name }}.delete">删除</a>' +
                            '</li>'+
                        @endif
                        @if($curd_action['delete'])
                            '<li class="divider"></li>' +
                        @endif
                        @if($curd_action['detail'])
                            '<li class="detail_btn">' +
                            '<a href="javascript:void(0);" name="detail_btn" permission="admin.{{ $route_name }}.show">详情</a>' +
                            '</li>'+
                        @endif
                        @if($curd_action['detail'])
                            '<li class="divider"></li>' +
                        @endif
                        @if(isset($actions))
                            @foreach($actions as $index => $action)
                                '<li class="' + '{{ $action['name'] }}' + '">' +
                                '<a href="javascript:void(0);" name="' + '{{ $action['name'] }}' + '" permission="{{ $action['permission'] or '' }}">' + '{{ $action['display_name'] }}' + '</a>'+
                                '</li>'+
                            @if($index != count($actions) - 1)
                                '<li class="divider"></li>' +
                            @endif
                            @endforeach
                        @endif
                        '</ul>'+
                        '</div>'
                        @endif
                    @endif
                    }
                @endif
                ],
                @if(isset($custom_id))
                "ajax": {
                    "url": "{{ $route_path }}" + "/search"
                }
                @else
                "ajax": {
                    "url": "/admin/" + route_name + "/search"
                }
                @endif

            });

            $('input.column_filter').on( 'keyup', function () {
                var index = $(this).attr('data-column');
                table.column(index).search($('#col' + index + '_filter').val()).draw();
                console.log('draw done');
            } );

            table.on( 'draw.dt', function () {
                var $data = table.data();
                for (var i=0; i < $data.length; i++) {
                    @if(isset($actions))
                    @foreach($actions as $action)
                    @if($action['type'] == 'confirm' || $action['type'] == 'dialog')
                    @if(isset($action['where']))
                    @foreach($action['where'] as $where_key => $where_val)
                    {{ $list_td = array_flip($index_column)[$where_key]}}
                    var flag = false;
                    @foreach($where_val as $val)
                    if($data[i][parseInt('{{ $list_td }}')] == parseInt('{{ $val }}')) {
                        flag = true;
                    }
                    @endforeach
                    if(!flag) {
                        $('tr:eq('+(i+1)+') '+'a[name={{ $action['name'] }}]').hide();
                        $('tr:eq('+(i+1)+') '+'.divider:last').hide();
                    }
                    @endforeach
                    @endif
                    @endif
                @endforeach
                @endif

                @if(is_array($index_column_rename))
                @foreach($index_column_rename as $column => $rename)
                    {{$column_no = array_flip($index_column)[$column]}}
                    @if($rename['type'] == 'normal')
                        @foreach($rename['param'] as $key => $value)
                        if($data[i][parseInt('{{$column_no}}')] == parseInt('{{$key}}')) {
                            $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html('{!! $value !!}');
                        } else if($data[i][parseInt('{{$column_no}}')] == '{{$key}}') {
                            $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html('{!! $value !!}');
                        }
                        @endforeach
                    @elseif($rename['type'] == 'dialog')
                        var html = '<a href="javascript:void(0);" name="{{$rename['param']['name']}}">' + $data[i][parseInt('{{$column_no}}')] + '</a>';
                        $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html(html);
                    @elseif($rename['type'] == 'html')
                        var html = sprintf('{!! $rename["param"] !!}', 1, $data[i][parseInt('{{$column_no}}')]);
                        $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html(html);
                    @elseif($rename['type'] == 'image')
                    var html = '<a href="' + $data[i][parseInt('{{$column_no}}')] + '" target="_blank"><img style="width:50px;height:50px" src="'
                            + $data[i][parseInt('{{$column_no}}')] + '" alt=""></a>';
                    $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html(html);
                    @elseif($rename['type'] == 'images')
                    var images = '';
                    for(var images_index = 0; images_index < $data[i][parseInt('{{$column_no}}')].length; images_index++ ) {
                        images += '<a href="' + $data[i][parseInt('{{$column_no}}')][images_index] + '" target="_blank"><img style="width:50px;height:50px" src="'
                        + $data[i][parseInt('{{$column_no}}')][images_index] + '" alt=""></a>&nbsp;';
                    }
                    $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html(images);
                    @elseif($rename['type'] == 'selector')
                        var html = $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html();
                        var selector_val = JSON.parse('{!! $selector_data[$column] !!}');
                        $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html(selector_val[html]);

                    @elseif($rename['type'] == 'limit')
                        var html = $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html();
                        $('tr').eq(i+1).children('td').eq(parseInt('{{$column_no}}')).html(html.slice(0, parseInt('{{ $rename['param'] }}')));
                    @endif
                @endforeach
            @endif
        }
                permission();
            });

            if('{!! $curd_action["edit"] !!}') {
                $('#dt_basic tbody').on('click', 'a[name=edit_btn]', function () {
                    if(isDisabled($(this))) {
                        var data = table.row($(this).parents('tr')).data();
                        var url = '/admin/' + route_name + '/' + data[0] + '/edit/';
                        @if(isset($custom_id))
                        url = '{{ $route_path }}' + '/' + data[0] + '/edit/';
                        @endif
                        window.location = url;
                    }
                });
            }

            if('{!! $curd_action['delete'] !!}') {
                $('#dt_basic tbody').on('click', 'a[name=delete_btn]', function () {
                    if(isDisabled($(this))) {
                        var data = table.row($(this).parents('tr')).data();
                        var delete_token = $('#delete_token').val();
                        var data_table = $('#dt_basic').dataTable();
                        var page_info = table.page.info();
                        var page = page_info.page;
                        if (page_info.length == 1 && page_info.page != 0) {
                            page = page - 1;
                        }
                        var url = '/admin/' + route_name + '/' + data[0];
                        @if(isset($custom_id))
                        url = '{{ $route_path }}' + '/' + data[0];
                        @endif
                        if(confirm('删除这条记录?')) {
                            $.ajax({
                                type: "DELETE",
                                data: { '_token' : delete_token },
                                url: url,
                                success: function(result) {
                                    if (result == 1 || result.result == true) {
                                        data_table.fnPageChange(page);
                                        $(".tips").html('<div class="alert alert-success fade in">'
                                        + '<button class="close" data-dismiss="alert">×</button>'
                                        + '<i class="fa-fw fa fa-check"></i>'
                                        + '<strong>成功</strong>' + ' ' + '删除成功。'
                                        + '</div>');
                                    } else {
                                        $(".tips").html('<div class="alert alert-danger fade in">'
                                        + '<button class="close" data-dismiss="alert">×</button>'
                                        + '<i class="fa-fw fa fa-warning"></i>'
                                        + '<strong>失败</strong>' + ' ' + '删除失败。'
                                        + '</div>');
                                    }
                                }
                            });
                            hideTips();
                        }
                    }
                });
            }

            if('{!! $curd_action['detail'] !!}') {
                $('#content').after(
                        '<div class="modal fade" id="detail_dialog' + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
                        '<div class="modal-dialog" style="{{ isset($detail_style['width']) ? "width:" . $detail_style['width'] : ''}};">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">' +
                        '&times;' +
                        '</button>' +
                        '<h4 class="modal-title"></h4>' +
                        '</div>' +
                        '<div class="modal-body custom-scroll terms-body" style="{{ isset($detail_style['height']) ? "max-height:" . $detail_style['height'] : ''}}">' +
                        '<div id="left">' +
                        '</div>' +
                        '</div>' +

                        '</div>' +
                        '</div>' +
                        '</div>'
                );

                $('#dt_basic tbody').on('click', 'a[name=detail_btn]', function () {
                    if(isDisabled($(this))) {
                        var data = table.row($(this).parents('tr')).data();
                        $("#detail_dialog .modal-title").html('查看详情');
                        $(this).attr("data-toggle", "modal");
                        $(this).attr("data-target", "#detail_dialog");
                        $(this).attr("data-action", "/admin/" + "{{ $route_name }}/" + data[0]);
                        $(this).attr("data-id",data[0]);
                    }
                });

                $('#detail_dialog').on('show.bs.modal', function(e) {
                    var action = $(e.relatedTarget).data('action');
                    //populate the div
                    loadURL(action, $('#detail_dialog' + ' .modal-content .modal-body #left'));
                });
            }

            @if(!empty($actions))
            @foreach($actions as $action)
            @if ($action['type'] == 'redirect_with_id')
            $('#dt_basic tbody').on('click', 'a[name=' + '{{ $action['name'] }}' + ']', function () {
                var data = table.row($(this).parents('tr')).data();
                if ('{{$action['url']}}'.indexOf("{custom_id}") == -1) {
                    window.location = '{{$action['url']}}' + '/' + data[0];
                } else {
                    window.location = '{{$action['url']}}'.replace('{custom_id}', data[0]);
                }
            });
            @endif
            @if($action['type'] == 'confirm')
            $('#dt_basic tbody').on('click', 'a[name=' + '{{ $action['name'] }}' + ']', function () {
                if(isDisabled($(this))) {
                    console.log($(this).attr('permission'));
                    var data = table.row($(this).parents('tr')).data();
                    var page_info = table.page.info();
                    var page = page_info.page;
                    var data_table = $('#dt_basic').dataTable();
                    if (page_info.end - page_info.start == 1) {
                        page -= 1;
                    }
                    function isObject(obj){
                        return (typeof obj=='object')&&obj.constructor==Object;
                    }
                    if (confirm('{{{ $action['confirm_msg'] or '是否继续操作?' }}}')) {
                        $.ajax({
                            type: '{{{ $action['method'] or 'post' }}}',
                            @if(isset($action['data']))
                            data: {
                                @foreach($action['data'] as $data_key => $data_val)
                                '{{ $data_key }}' : '{{ $data_val }}',
                                @endforeach
                            },
                            @endif
                            url: '{{ $action['url'] }}' + '/' + data[0],
                            success: function(result) {
                                var html = '';
                                if (result == 1 || result.result == true) {
                                    data_table.fnPageChange(page);
                                    html = '<div class="alert alert-success fade in">'
                                    +'<button class="close" data-dismiss="alert">×</button>'
                                    +'<i class="fa-fw fa fa-check"></i>';
                                    if (isObject(result)) {
                                        html += '<strong>成功</strong>'+' '+ result.content +'。'
                                        +'</div>';
                                    } else {
                                        html += '<strong>成功</strong>'+' '+ '{{{ $action['success_msg'] or '操作成功' }}}' + '。'
                                        +'</div>';
                                    }
                                    $(".tips").html(html);
                                } else {
                                    html = '<div class="alert alert-danger fade in">'
                                    +'<button class="close" data-dismiss="alert">×</button>'
                                    +'<i class="fa-fw fa fa-warning"></i>';
                                    if (isObject(result)) {
                                        html += '<strong>失败</strong>'+' '+ result.content +'。'
                                        +'</div>';
                                    } else {
                                        html += '<strong>失败</strong>'+' '+ '{{{ $action['failure_msg'] or '操作失败' }}}' + '。'
                                        +'</div>';
                                    }
                                    $(".tips").html(html);
                                }
                            }
                        });
                        hideTips();
                    }
                }
            });
            @endif
            //
            @if($action['type'] == 'dialog')
            $('#content').after(
                    '<div class="modal fade" id="' + '{{ $action['target'] }}' + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
                    '<div class="modal-dialog" style="{{ isset($action['width']) ? "width:".$action['width'] : ''}};">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">' +
                    '&times;' +
                    '</button>' +
                    '<h4 class="modal-title"></h4>' +
                    '</div>' +
                    '<div class="modal-body custom-scroll terms-body" style="{{ isset($action['height']) ? "max-height:".$action['height'] : ''}};">' +
                    '<div id="left">' +
                    '</div>' +
                    '</div>' +

                    '</div>' +
                    '</div>' +
                    '</div>'
            );

            $('#dt_basic tbody').on('click', 'a[name=' + '{{isset($action['btn_name']) ? $action['btn_name'] : $action['name']}}' + ']', function () {
                if(isDisabled($(this))) {
                    var data = table.row($(this).parents('tr')).data();
                    $("#" + '{{$action['target']}}' + ' .modal-title').html('{{$action['dialog_title']}}');
                    $(this).attr("data-toggle", "modal");
                    $(this).attr("data-target", "#{{$action['target']}}");
                    $(this).attr("data-action", "{{$action['url']}}" + data[0]);
                    $(this).attr("data-id", data[0]);
                }
            });

            $('#' + '{{$action['target']}}').on('show.bs.modal', function(e) {
                var action = $(e.relatedTarget).data('action');
                //populate the div
                loadURL(action, $('#' + '{{$action['target']}}' + ' .modal-content .modal-body #left'));
            });

            @if(!empty($action['form']))
            $('#' + '{{$action['target']}}' + " .modal-body").after(
                    '<div class="modal-footer">' +
                    '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
                    '<button type="button" class="btn btn-primary" id="' + '{{$action['form']['submit_id']}}' +'"><i class="fa fa-check"></i>提交</button>' +
                    '</div>'
            );

            $('#' + '{{$action['form']['submit_id']}}').click(function(){
                var $form = $("#" + '{{$action['form']['form_id']}}');
                var page_info = table.page.info();
                var page = page_info.page;
                var data_table = $('#dt_basic').dataTable();
                $($form).submit(function(event) {
                    var form = $(this);
                    $.ajax({
                        type: form.attr('method'),
                        url: form.attr('action'),
                        data: form.serialize()
                    }).done(function(result) {
                        var html = '';
                        if (result == 1 || result.result == true) {
                            data_table.fnPageChange(page);
                            html = '<div class="alert alert-success fade in">'
                            +'<button class="close" data-dismiss="alert">×</button>'
                            +'<i class="fa-fw fa fa-check"></i>';
                            if (isObject(result)) {
                                html += '<strong>成功</strong>'+' '+ result.content +'。'
                                +'</div>';
                            } else {
                                html += '<strong>成功</strong>'+' '+ '{{isset($action['form']['success_msg']) ? $action['form']['success_msg'] : '操作成功'}}'+'。'
                                +'</div>';
                            }
                            $(".tips").html(html);
                        } else {
                            html = '<div class="alert alert-danger fade in">'
                            +'<button class="close" data-dismiss="alert">×</button>'
                            +'<i class="fa-fw fa fa-warning"></i>';
                            if (isObject(result)) {
                                html += '<strong>失败</strong>'+' '+ result.content +'。'
                                +'</div>';
                            } else {
                                html += '<strong>失败</strong>'+' '+ '{{isset($action['form']['failure_msg']) ? $action['form']['failure_msg'] : '操作失败'}}'+'。'
                                +'</div>';
                            }
                            $(".tips").html(html);
                        }
                        $('#' + '{{$action['form']['submit_id']}}').text("提交");
                        $('#' + '{{$action['target']}}').modal('hide');
                        $form[0].reset();
                        hideTips();
                    });
                    event.preventDefault(); // Prevent the form from submitting via the browser.
                });
                function isObject(obj){
                    return (typeof obj=='object')&&obj.constructor==Object;
                }
                $form.trigger('submit'); // trigger form submit
            });
            @endif

        @endif
        @endforeach
        @endif

        @foreach($index_column_rename as $column => $rename)
            @if($rename['type'] == 'dialog')
            $('#content').after(
                    '<div class="modal fade" id="' + '{{$rename['param']['target']}}' + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
                    '<div class="modal-dialog" style="{{isset($rename['param']['width']) ? "width: ".$rename['param']['width'] : ""}}">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">' +
                    '&times;' +
                    '</button>' +
                    '<h4 class="modal-title"></h4>' +
                    '</div>' +
                    '<div class="modal-body custom-scroll terms-body"  style="{{isset($rename['param']['height']) ? "max-height: " . $rename['param']['height'] : "min-height: 280px;"}}">' +
                    '<div id="left">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
            );

            $('#dt_basic tbody').on('click', 'a[name=' + '{{$rename['param']['name']}}' + ']', function () {
                var data = table.row($(this).parents('tr')).data();
                $("#" + '{{$rename['param']['target']}}' + " .modal-title").html('{{$rename['param']['dialog_title']}}');
                $(this).attr("data-toggle", "modal");
                $(this).attr("data-target", "#{{$rename['param']['target']}}");
                $(this).attr("data-action","{{$rename['param']['url']}}"+data[0]);
                $(this).attr("data-id",data[0]);
            });

            $('#' + '{{$rename['param']['target']}}').on('show.bs.modal', function(e) {
                var action = $(e.relatedTarget).data('action');
                loadURL(action, $('#' + '{{$rename['param']['target']}}' + ' .modal-content .modal-body #left'));
            });
            @endif
        @endforeach

	    });
        function sprintf()
        {
            var arg = arguments,
                    str = arg[0] || '',
                    i, n;
            for (i = 1, n = arg.length; i < n; i++) {
                str = str.replace(/%s/, arg[2]);
            }
            return str;
        }
    </script>
@endsection