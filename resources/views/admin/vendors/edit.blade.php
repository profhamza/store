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
                                <li class="breadcrumb-item active"> تعديل بيانات - {{$vendor->name}}
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
                                    <h4 class="card-title" id="basic-layout-form">  تعديل بيانات - {{$vendor->name}} </h4>
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
                                        <form class="form" action="{{route('vendors.update', $vendor->id)}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{$vendor->id}}">
                                            <input type="hidden" name="logo_if_notsend" value="{{$vendor->logo}}">
                                            <input type="hidden" name="pass_if_notsend" value="{{$vendor->password}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">  اسم التاجر  </label>
                                                        <input type="text"
                                                               id="name"
                                                               value="{{$vendor->name}}"
                                                               class="form-control"
                                                               placeholder="ادخل اسم التاجر  "
                                                               name="name">
                                                        @error("name")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> الايميل  </label>
                                                        <input type="text"
                                                               id="email"
                                                               value="{{$vendor->email}}"
                                                               class="form-control"
                                                               placeholder="ادخل الايميل  "
                                                               name="email">
                                                        @error("email")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> رقم الهاتف </label>
                                                        <input type="text"
                                                               class="form-control"
                                                               value="{{$vendor->phone}}"
                                                               placeholder="ادخل رقم الهاتف"
                                                               name="phone">
                                                        @error("phone")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> الرقم السرى </label>
                                                        <input type="text"
                                                               class="form-control"
                                                               placeholder="ادخل رقم سرى جديد"
                                                               name="password">
                                                        @error("password")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> اختر القسم </label>
                                                        <select name="cat_id" class="select2 form-control">
                                                            <optgroup label="اختر القسم">
                                                                @foreach($maincats as $cat)
                                                                    <option value="{{$cat->id}}" @if($vendor->cat_id == $cat->id) selected @endif>{{$cat->name}}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        </select>
                                                        @error("cat_id")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mt-1">
                                                        <input type="hidden" name="active" value="off"/>
                                                        <input type="checkbox" name="active"
                                                               id="switcheryColor4"
                                                               class="switchery" data-color="success"
                                                               @if($vendor->active == 1) checked @endif/>
                                                        <label for="switcheryColor4"
                                                               class="card-title ml-1">الحالة </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group upload-image">
                                                        <input type="file" class="form-control input-upload" name="logo">
                                                        <div class="custom-upload">
                                                            <div>اختر لوجو للمتجر </div>
                                                            <div>رفع</div>
                                                        </div>
                                                        @error("logo")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <img src="{{$vendor->getLogo()}}" width="50" height="40">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <input id="pac-input" type="text" class="form-control" name="address" value="{{$vendor->address}}">
                                                        @error("address")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="map" style="height:800px"></div>
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

@section('script')
    <script src="{{asset('assets/admin/js/scripts/mapapi.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOBB4Ve4nM2dYPpArL0TE4xiNeyUA0uLA&libraries=places&callback=initAutocomplete&language=ar&region=EG"></script>
@stop
