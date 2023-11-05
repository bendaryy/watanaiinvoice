@extends('layouts.main')

@section('content')
    <div class="page-content">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@lang('site.dashboard')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('site.apisetting')</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                     @if (isset($setting[0]['id']))
                        <a href="{{ route('setting.edit', $setting[0]['id']) }}" class="btn btn-outline-success px-5 radius-30">
                            <i class="bx bx-message-square-edit mr-1"></i>@lang('site.edit') </a>
                    @else
                        <a href="{{ route('setting.create') }}" class="btn btn-outline-success px-5 radius-30">
                            <i class="bx bx-message-square-edit mr-1"></i>@lang('site.Add')</a>
                     @endif

                </div>
            </div>
        </div>

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('site.name') </th>
                                <th>@lang('site.client_id') </th>
                                <th>@lang('site.secret_id') </th>
                                <th>@lang('site.commerial_num') </th>
                                {{-- <th>@lang('site.control')</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    @if (isset($setting[0]['company_name']))
                                        {{ $setting[0]['company_name'] }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($setting[0]['client_id']))
                                        {{ $setting[0]['client_id'] }}
                                    @endif
                                </td>
                                <td>
                                   @if (isset($setting[0]['client_secret']))
                                        {{ $setting[0]['client_secret'] }}
                                    @endif
                                </td>
                                <td>
                                  @if (isset($setting[0]['company_id']))
                                        {{ $setting[0]['company_id'] }}
                                    @endif
                                </td>

                                {{-- <td>
                                    @if (isset($setting[0]['id']))
                                        <a class="btn btn-info"
                                            href="{{ route('setting.edit', $setting[0]['id']) }}">@lang('site.edit') </a>
                                    @endif
                                </td> --}}
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>@lang('site.name') </th>
                                <th>@lang('site.client_id') </th>
                                <th>@lang('site.secret_id') </th>
                                <th>@lang('site.commerial_num') </th>
                                {{-- <th>@lang('site.control')</th> --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('main/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('main/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
