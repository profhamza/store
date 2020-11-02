@extends('layouts.admin')

@section('content')
   <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> اللغات </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> اللغات
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
                                    <h4 class="card-title">جميع لغات الموقع </h4>
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
                                                <th>الاختصار</th>
                                                <th>اتجاه</th>
                                                <th>الحالة</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @isset($languages)
                                                    @foreach($languages as $language)
                                                        <tr class="tr_{{$language->id}}">
                                                            <td>{{$language->name}}</td>
                                                            <td>{{$language->abbr}}</td>
                                                            <td>{{$language->direction}}</td>
                                                            <td>{{$language->getActive()}}</td>
                                                            <td>
                                                                <div class="btn-group" role="group"
                                                                     aria-label="Basic example">
                                                                    <a href="{{route('languages.edit', $language->id)}}"
                                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                                    <button type="button"
                                                                            value=""
                                                                            class="lang_btn btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1"
                                                                            data-toggle="modal"
                                                                            data-id="{{$language->id}}"
                                                                            data-target="#rotateInUpRight">
                                                                        حذف
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
            $("button.lang_btn").click(function () {
                if (window.confirm('هل تريد حذف هذه اللغه؟؟'))
                {
                    lang_id = $(this).data("id");
                    url = "{{route('languages.destroy', ":id")}}"
                    url = url.replace(":id", lang_id);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", langId: lang_id},
                        success: function (data) {
                            if (data.success)
                            {
                                $(".tr_"+data.id).remove();
                                if ($("button.success").hasClass('d-none'))
                                {
                                    $("button.success").addClass("d-block");
                                    $("button.success").text(data.msg);
                                }
                            }
                            else
                            {
                                if ($("button.error").hasClass('d-none'))
                                {
                                    $("button.error").addClass("d-block");
                                    $("button.error").text(data.msg);
                                }
                            }
                        },
                        error: function (data) {}
                    });
                }
            });
        });
    </script>
@stop
