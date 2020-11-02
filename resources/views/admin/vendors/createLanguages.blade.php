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
                                <li class="breadcrumb-item"><a href="{{route('main-categories.index')}}"> الاقسام الرئيسه </a>
                                </li>
                                <li class="breadcrumb-item active">إضافة لغه لقسم {{$category->name}}
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
                                    <h4 class="card-title" id="basic-layout-form"> إضافة لغه لقسم {{$category->name}} </h4>
                                    @include("alerts.error")
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
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{route('main-categories.store-another-languages')}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="tab-content px-1 pt-1">
                                                <input type="hidden" name="id" value="{{$category->id}}">
                                                <ul class="nav nav-tabs">
                                                    @if(count($languages) > 0)
                                                        @foreach($languages as $index => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link @if($index == 0) active @endif" id="homeLable-tab" data-toggle="tab"
                                                                   href="#homeLable{{$index}}" aria-controls="homeLable"
                                                                   aria-expanded="true">
                                                                    {{__("messages." . $language->abbr)}}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                                @if(count($languages) > 0)
                                                    @foreach($languages as $index => $language)
                                                        <div style="padding-top:25px" role="tabpanel" class="tab-pane @if($index == 0) active @endif" id="homeLable{{$index}}"
                                                             aria-labelledby="homeLable-tab"
                                                             aria-expanded="true">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput1">  اسم القسم {{__("messages." . $language->abbr)}} </label>
                                                                        <input type="text"
                                                                               id="name"
                                                                               class="form-control"
                                                                               placeholder="ادخل اسم القسم  "
                                                                               name="category[{{$index}}][name]">
                                                                        @error("category.$index.name")
                                                                        <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="projectinput1"> الوصف {{__("messages." . $language->abbr)}} </label>
                                                                        <input type="text"
                                                                               id="description"
                                                                               class="form-control"
                                                                               placeholder="ادخل وصف للقسم "
                                                                               name="category[{{$index}}][description]">
                                                                        @error("category.$index.description")
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
                                                                               value="{{$language->abbr}}"
                                                                               name="category[{{$index}}][translation]">
                                                                        @error("category.$index.translation")
                                                                        <span class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mt-1">
                                                                        <input type="hidden" name="category[{{$index}}][active]" value="off"/>
                                                                        <input type="checkbox" name="category[{{$index}}][active]"
                                                                               id="switcheryColor4"
                                                                               class="switchery" data-color="success"
                                                                               checked />
                                                                        <label for="switcheryColor4"
                                                                               class="card-title ml-1">الحالة </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
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
