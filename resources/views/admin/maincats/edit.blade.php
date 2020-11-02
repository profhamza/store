@extends('layouts.admin')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('main-categories.index')}}"> الاقسام الرئيسيه </a>
                                </li>
                                <li class="breadcrumb-item active"> تعديل قسم - {{$category->name}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">  تعديل قسم - {{$category->name}} </h4>
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
                                @include('alerts.error')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{route('main-categories.update', $category->id)}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> اسم القسم {{__("messages." . $category->translation)}} </label>
                                                            <input type="text"
                                                                   value="@isset($category->name) {{$category->name}} @endisset"
                                                                   id="name"
                                                                   class="form-control"
                                                                   placeholder="ادخل اسم القسم  "
                                                                   name="category[0][name]">
                                                            @error('category.0.name')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> الوصف {{__("messages." . $category->translation)}} </label>
                                                            <input type="text"
                                                                   value="@isset($category->description) {{$category->description}} @endisset"
                                                                   id="abbr"
                                                                   class="form-control"
                                                                   placeholder="ادخل وصف للقسم "
                                                                   name="category[0][description]">
                                                            @error('category.0.description')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row hidden">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> اختصار اللغه </label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   placeholder="ادخل اختصار اللغه"
                                                                   value="{{$category->translation}}"
                                                                   name="category[0][translation]">
                                                            @error("category.0.translation")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="hidden" name="category[0][active]" value="off"/>
                                                            <input type="checkbox" name="category[0][active]"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"
                                                                   @if(isset($category->active) && $category->active == 1) checked @endif />
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group upload-image">
                                                            <input type="file" class="form-control input-upload" name="photo">
                                                            <input type="hidden" name="image_not_send" value="{{$category->photo}}">
                                                            <div class="custom-upload">
                                                                <div>اختر صوره للقسم</div>
                                                                <div>رفع</div>
                                                            </div>
                                                            @error("photo")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <img src="/assets/admin/images/uploads/maincats/{{$category->photo}}" width="50" height="40">
                                                    </div>
                                                </div>
                                                <div class="tab-content px-1 pt-1">
                                                    <ul class="nav nav-tabs">
                                                        @isset($category->categories)
                                                            @foreach($category->categories as $index => $cat)
                                                                <li class="nav-item">
                                                                    <a class="nav-link @if($index == 0) active @endif" id="homeLable-tab" data-toggle="tab"
                                                                       href="#homeLable{{$index}}" aria-controls="homeLable"
                                                                       aria-expanded="true">
                                                                        {{__("messages." . $cat->translation)}}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        @endisset
                                                    </ul>
                                                    @isset($category->categories)
                                                        @foreach($category->categories as $index => $cat)
                                                            <div style="padding-top:25px" role="tabpanel" class="tab-pane @if($index == 0) active @endif" id="homeLable{{$index}}"
                                                                 aria-labelledby="homeLable-tab"
                                                                 aria-expanded="true">
                                                                <input type="hidden" name="category[{{$index + 1}}][id]" value="{{$cat->id}}">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">  اسم القسم {{__("messages." . $cat->translation)}} </label>
                                                                            <input type="text"
                                                                                   value="@isset($cat->name) {{$cat->name}} @endisset"
                                                                                   id="name"
                                                                                   class="form-control"
                                                                                   placeholder="ادخل اسم القسم  "
                                                                                   name="category[{{$index + 1}}][name]">
                                                                            @error("category." . ($index + 1) . ".name")
                                                                            <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1"> الوصف {{__("messages." . $cat->translation)}} </label>
                                                                            <input type="text"
                                                                                   value="@isset($cat->description) {{$cat->description}} @endisset"
                                                                                   id="abbr"
                                                                                   class="form-control"
                                                                                   placeholder="ادخل وصف للقسم "
                                                                                   name="category[{{$index + 1}}][description]">
                                                                            @error("category." . ($index + 1) . ".description")
                                                                            <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row hidden">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1"> اختصار اللغه </label>
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   placeholder="ادخل اختصار اللغه"
                                                                                   value="{{$cat->translation}}"
                                                                                   name="category[{{$index + 1}}][translation]">
                                                                            @error("category." . ($index + 1) . "translation")
                                                                            <span class="text-danger">{{$message}}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mt-1">
                                                                            <input type="hidden" name="category[{{$index + 1}}][active]" value="off"/>
                                                                            <input type="checkbox" name="category[{{$index + 1}}][active]"
                                                                                   id="switcheryColor4"
                                                                                   class="switchery" data-color="success"
                                                                                   @if(isset($cat->active) && $cat->active == 1) checked @endif />
                                                                            <label for="switcheryColor4"
                                                                                   class="card-title ml-1">الحالة </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endisset
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <a href="{{route('main-categories.create-another-languages', $category->id)}}" class="btn btn-primary">اضافه لغات اخرى للقسم</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
@stop
