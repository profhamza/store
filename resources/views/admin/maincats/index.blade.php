@extends('layouts.admin')

@section('content')
   <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الاقسام الرئيسيه </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> الاقسام
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع الاقسام الرئيسيه </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row mr-2 ml-2">
                                    <button type="text" class="ajax_success hidden btn btn-lg btn-block btn-outline-success mb-2"
                                            id="type-success">
                                    </button>
                                </div>
                                <div class="row mr-2 ml-2">
                                    <button type="text" class="ajax_error hidden btn btn-lg btn-block btn-outline-danger mb-2"
                                            id="type-error">
                                    </button>
                                </div>
                                @include('alerts.success')
                                @include('alerts.error')
                                <div class="row mr-2 ml-2">
                                    <button type="text" class="success d-none btn btn-lg btn-block btn-outline-success mb-2"
                                            id="type-error">
                                    </button>
                                </div>
                                <div class="row mr-2 ml-2" >
                                    <button type="text" class="error d-none btn btn-lg btn-block btn-outline-danger mb-2"
                                            id="type-error">
                                    </button>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered" style="width:100% !important;">
                                            <thead>
                                            <tr>
                                                <th> الاسم</th>
                                                <th>الوصف</th>
                                                <th>الصوره</th>
                                                <th>اللغه</th>
                                                <th>الحالة</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @isset($categories)
                                                    @foreach($categories as $category)
                                                        <tr class="tr_{{$category->id}}">
                                                            <td>{{$category->name}}</td>
                                                            <td>{{$category->description}}</td>
                                                            <td><img src="{{$category->photo}}" width="50" height="40"></td>
                                                            <td>{{$category->translation}}</td>
                                                            <td class="active_{{$category->id}}">{{$category->getActive()}}</td>
                                                            <td>
                                                                <div class="btn-group" role="group"
                                                                     aria-label="Basic example">
                                                                    <a href="{{route('main-categories.edit', $category->id)}}"
                                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                                    <button type="button"
                                                                            value=""
                                                                            class="cat_delete btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1"
                                                                            data-toggle="modal"
                                                                            data-id="{{$category->id}}"
                                                                            data-target="#rotateInUpRight">
                                                                        حذف
                                                                    </button>
                                                                    <button type="button"
                                                                            value=""
                                                                            class="cat_active btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1"
                                                                            data-toggle="modal"
                                                                            data-id="{{$category->id}}"
                                                                            data-active="{{$category->active}}"
                                                                            data-target="#rotateInUpRight">
                                                                        {{($category->active == 1) ? "الغاء تفعيل" : " تفعيل"}}
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endisset
                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop

@section('ajaxscript')
    <script>
        $(function () {
            //******** ajax request for deletion ************
            $("button.cat_delete").click(function () {
                $(".success, .ajax_success").addClass('hidden');
                $(".error, .ajax_error").addClass('hidden');
                $cat_id = $(this).data("id");
                url = "{{route('main-categories.destroy', ":id")}}";
                req_url = url.replace(":id", $cat_id);
                if (window.confirm("هل تريد حذف هذا القسم؟؟"))
                {
                    $.ajax({
                        method: "DELETE",
                        url: req_url,
                        data: {_token: "{{csrf_token()}}", id: $cat_id },
                        success: function (data) {
                            $(".tr_"+data.id).remove();
                            $success = $("button.ajax_success");
                            if ($success.hasClass("hidden"))
                            {
                                $success.removeClass("hidden");
                                $success.text(data.msg);
                            }
                        },
                        error: function (data) {
                            data = $.parseJSON(data.responseText);
                            $error = $("button.ajax_error");
                            if($error.hasClass("hidden"))
                            {
                                $error.removeClass("hidden");
                                $error.text(data.msg);
                            }
                        }
                    });
                }
            });

            //******** ajax request for activation ************
            $("button.cat_active").click(function () {
                $(".success, .ajax_success").addClass('hidden');
                $(".error, .ajax_error").addClass('hidden');
                $cat_id = $(this).data("id");
                $confirm = ($(this).attr("data-active") == 1) ? "هل تريد الغاء تفعيل هذا القسم؟؟" : "هل تريد تفعيل هذا القسم؟؟";
                url = "{{route('main-categories.activate', ":id")}}";
                req_url = url.replace(":id", $cat_id);
                $cur_btn = $(this);
                if (window.confirm($confirm))
                {
                    $.ajax({
                        method: "POST",
                        url: req_url,
                        data: {_token: "{{csrf_token()}}", id: $cat_id },
                        success: function (data) {
                            $cur_btn.attr("data-active", data.active);
                            if (data.active == 1)
                            {
                                $cur_btn.text("الغاء تفعيل");
                                $(".active_"+data.id).text("مفعل");
                            }
                            else
                            {
                                $cur_btn.text("تفعيل");
                                $(".active_"+data.id).text("غير مفعل");
                            }
                            $success = $("button.ajax_success");
                            if ($success.hasClass("hidden"))
                            {
                                $success.removeClass("hidden");
                                $success.text(data.msg);
                            }
                        },
                        error: function (data) {
                            data = $.parseJSON(data.responseText);
                            $error = $("button.ajax_error");
                            if($error.hasClass("hidden"))
                            {
                                $error.removeClass("hidden");
                                $error.text(data.msg);
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop
