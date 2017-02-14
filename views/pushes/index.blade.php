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
            <p>
                <a href="javascript:void(0);" class="btn btn-primary" id="push_batch" data-target="#push_btn" data-toggle="modal" data-action="/admin/pushes/batch">推送消息</a>
                <a href="javascript:void(0);" class="btn btn-primary" id="push_all" data-target="#push_btn" data-toggle="modal" data-action="/admin/pushes/batch">全局推送</a>
                <a href="javascript:void(0);" class="btn btn-primary" id="push_android" data-target="#push_btn" data-toggle="modal" data-action="/admin/pushes/batch">Android推送</a>
                <a href="javascript:void(0);" class="btn btn-primary" id="push_ios" data-target="#push_btn" data-toggle="modal" data-action="/admin/pushes/batch">iOS推送</a>
            </p>
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-hidden="false" data-widget-togglebutton="false"
                 data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>推送设备列表</h2>
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                    </div>
                    <div class="widget-body no-padding">
                        <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户id</th>
                                <th>设备id</th>
                                <th>平台</th>
                                <th>更新时间</th>
                                <th>选择</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <input type="hidden" id="delete_token" value="{{csrf_token()}}"/>
            </div>
        </article>
        </div>
    </section>
</div>
    <!-- Modal -->
    <div class="modal fade" id="push_btn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">消息内容</h4>
                </div>
                <div class="modal-body custom-scroll terms-body">
                    <div id="left">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="submitPush">提交</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
@endsection

@section('script')
<script>
    $(document).ready(function() {
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
                null,
                { "orderable" : false },
                { "orderable" : false },
                { "orderable" : false },
                { "orderable" : false },
                { "orderable" : false },
            ],
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": '<label class="checkbox"> <input type="checkbox" class="activity_box"><i></i></label>'
            }],
            "ajax": {
                "url": "/admin/pushes/search"
            }
        });
        $('#push_btn').on('show.bs.modal', function(e) {
            var action = $(e.relatedTarget).data('action');
            //populate the div
            loadURL(action, $('#push_btn .modal-content .modal-body #left'));
        });

        var push_type;
        $( "#push_batch" ).on("click", function() {
            var chk_value =[];
            $('input[type="checkbox"]:checked').each(function(){
                var data = table.row($(this).parents('tr')).data();
                chk_value.push(data[0]);
            });
            if(chk_value.length==0){
                alert('请选择推送的用户');
                return false;
            }
            push_type = 'batch';
        });
        $( "#push_all" ).on("click", function() {
            push_type = 'all';
        });
        $( "#push_android" ).on("click", function() {
            push_type = 'android';
        });
        $( "#push_ios" ).on("click", function() {
            push_type = 'ios';
        });

        $("#submitPush").click(function(){
            $("#submitPush").text("正在保存...");
            var $form = $('#push_form');
            var page_info = table.page.info();
            var page = page_info.page;
            var datatable = $('#dt_basic').dataTable();
            var chk_value =[];
            $('input[type="checkbox"]:checked').each(function(){
                var data = table.row($(this).parents('tr')).data();
                chk_value.push(data[0]);
            });
            var data = $form.serializeArray();
            var unique_key = {
                name: "account_ids",
                value: chk_value
            };
            var type_key = {
                name: "push_type",
                value: push_type
            }
            data.push(unique_key);
            data.push(type_key);
            $($form).submit(function(event) {
                var form = $(this);
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: data
                }).done(function(result) {
                    if(result.result) {
                        datatable.fnPageChange(page);
                        $(".tips").html('<div class="alert alert-success fade in">'
                        +'<button class="close" data-dismiss="alert">×</button>'
                        +'<i class="fa-fw fa fa-check"></i>'
                        +'<strong>成功</strong>'+' '+result.content+'。'
                        +'</div>');
                    } else {
                        $(".tips").html('<div class="alert alert-danger fade in">'
                        +'<button class="close" data-dismiss="alert">×</button>'
                        +'<i class="fa-fw fa fa-warning"></i>'
                        +'<strong>失败</strong>' + ' ' + result.content + '。'
                        +'</div>');
                    }
                    $("#submitPush").text("提交");
                    $('#push_btn').modal('hide');
                    $form[0].reset();
                });
                event.preventDefault(); // Prevent the form from submitting via the browser.
            });
            $form.trigger('submit'); // trigger form submit
        });
    });
</script>
@endsection