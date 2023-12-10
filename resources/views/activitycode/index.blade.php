@extends('layouts.main')

@section('content')
    <div class="page-content">
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('deleted'))
            <div class="alert alert-danger text-center">
                {{ session('deleted') }}
            </div>
        @endif

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@lang('site.Tax Activity Code')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('site.All Activity Codes')</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('activitycode.create') }}" class="btn btn-outline-success px-5 radius-30">
                        <i class="bx bx-message-square-edit mr-1"></i>@lang('site.Add New Activity Code') </a>

                </div>
            </div>
        </div>

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>@lang('site.Activity Code Name') </th>
                                <th>@lang('site.Activity Code Number') </th>
                                <th>@lang('site.control')</th>

                        </thead>
                        <tbody>

                            @foreach ($codes as $index => $code)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $code->Desc_ar }}</td>
                                    <td>{{ $code->code }}</td>

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <form style="display: contents;" method="post" action="{{ route('activitycode.destroy',$code->id) }}">

                                                @method('DELETE')
                                                @csrf
                                                <button  onclick="return confirm('@lang('site.Sure To Delete')');" type="sumbit" class="btn btn-outline-danger"><i
                                                        class="bx bxs-trash me-0"></i></button>
                                            </form>

                                            <a href="{{ route('activitycode.edit', $code->id) }}"
                                                class="btn btn-outline-primary"><i class="bx bxs-edit me-0"></i></a>

                                            {{--  <a href="{{ route('customer.show', $customer->id ) }}" class="btn btn-outline-info"><i class="bx bx-show-alt me-0"></i></a>  --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>

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
                lengthChange: true,
                // responsive: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
