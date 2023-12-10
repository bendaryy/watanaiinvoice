@extends('layouts.main')


@section('content')
    <style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />.select2-container {
            padding: 30px
        }
    </style>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@lang('site.Activity Codes')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('site.Add New Activity Code')</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row row-cols-1 row-cols-2">


            <div class="col-md-9">

                <hr />
                <div class="card border-top border-0 border-4 border-info">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div>
                            </div>
                            <h5 class="mb-0 text-info">@lang('site.Add New Activity Code')</h5>
                        </div>
                        <hr>

                        <form class="row g-3" method="POST" action="{{ route('activitycode.store') }}">
                            @csrf


                            <div class="col-12">
                                <label for="inputLastName1" class="form-label">@lang('site.Activity Code Name')</label>
                                <div class="input-group"> <span class="input-group-text bg-transparent"><i
                                            class='bx bxs-user'></i></span>
                                    <input name="Desc_ar" required type="text" class="form-control border-start-0"
                                        id="inputLastName1" value="{{ old('Desc_ar') }}" placeholder="@lang('site.Activity Code Name')" />
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="inputPhoneNo" class="form-label">@lang('site.Activity Code Number')</label>
                                {{-- <label for="inputPhoneNo" class="form-label">@lang('site.phone')</label> --}}
                                <div class="input-group"> <span class="input-group-text bg-transparent"><i
                                            class='bx bxs-microphone'></i></span>
                                    <input name="code" required required value="{{ old('code') }}" type="number"
                                        class="form-control border-start-0" id="code"
                                        placeholder="@lang('site.Activity Code Number')" />
                                </div>
                            </div>
                            {{-- <div class="col-12">
                            <label for="inputEmailAddress" class="form-label">@lang('site.reg-numer')/@lang('site.id')</label>
                            <div class="input-group"> <span class="input-group-text bg-transparent"><i class='bx bxs-message' ></i></span>
                                <input type="text" name="tax_id"   class="form-control border-start-0" id="inputEmailAddress" placeholder="@lang('site.reg-numer')" />
                            </div>
                        </div> --}}







                            <div class="col-12">
                                <button type="submit" class="btn btn-info px-5">@lang('site.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>

    </div>
@endsection
