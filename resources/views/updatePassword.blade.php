@extends('layouts.main')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}"><i class="bx bx-home-alt"></i> @lang('site.dashboard') </a>
                        </li> &nbsp;
                        <li class="breadcrumb-item active" aria-current="page"> @lang('site.update password') </li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">

                    <div class="col-lg-8" style="margin: auto">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('updatepassword') }}">
                                    @csrf
                                    @method('post')

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">@lang('site.current password')</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="password" name="old_password" class="form-control" required />
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">@lang('site.new password')</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="password" name="new_password" class="form-control" required />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">@lang('site.password confirmation')</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="password" name="confirm_password" class="form-control" required />
                                        </div>
                                    </div>




                                    <div class="row" style="text-align: center">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-primary px-4" value="@lang('site.edit')" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
