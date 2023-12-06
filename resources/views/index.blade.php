@extends('layouts.main')


@section('content')
    {{-- {{ LaravelLocalization::getCurrentLocale() }} --}}

    <div class="dash-wrapper" style="background-color: #111">
        <div class="row">
             {{-- <div class="col border-end border-light-2">
                <div class="card bg-transparent shadow-none mb-0">
                    <div class="card-body text-center">
                        <p class="mb-1 text-white">Avg. Session Duration</p>
                        <h3 class="mb-3 text-white">00:04:60</h3>
                        <p class="font-13 text-white"><span class="text-danger"><i class="lni lni-arrow-down"></i>
                                5.2%</span> vs last 7 days</p>
                        <div id="chart5"></div>
                    </div>
                </div>
            </div> --}}
            <div class="col border-end border-light-2">
                <div class="card bg-transparent shadow-none mb-0">
                    <div class="card-body text-center">
                        <p class="mb-1 text-white">@lang('site.Total Sales')</p>
                        <h3 class="mb-3 text-white">E£ {{ $totalSales }}</h3>
                        {{-- <p class="font-13 text-white"><span class="text-success"><i class="lni lni-arrow-up"></i>2.1%</span> vs
                            last 7 days</p> --}}
                        {{-- <div id="chart1"></div> --}}
                    </div>
                </div>
            </div>
            <div class="col border-end border-light-2">
                <div class="card bg-transparent shadow-none mb-0">
                    <div class="card-body text-center">
                        <p class="mb-1 text-white">@lang('site.Net Profit')</p>
                        <h3 class="mb-3 text-white">E£ {{ $netProfit }}</h3>
                        {{-- <p class="font-13 text-white"><span class="text-success"><i class="lni lni-arrow-up"></i> 4.2%
                            </span> last 7 days</p> --}}
                        {{-- <div id="chart2"></div> --}}
                    </div>
                </div>
            </div>
            <div class="col border-end border-light-2">
                <div class="card bg-transparent shadow-none mb-0">
                    <div class="card-body text-center">
                        <p class="mb-1 text-white">@lang('site.Total Vat')</p>
                        <h3 class="mb-3 text-white">E£ {{ $TotalVat }}</h3>
                        {{-- <p class="font-13 text-white"><span class="text-danger"><i class="lni lni-arrow-down"></i>
                                3.6%</span> vs last 7 days</p> --}}
                        {{-- <div id="chart3"></div> --}}
                    </div>
                </div>
            </div>
            <div class="col border-end border-light-2">
                <div class="card bg-transparent shadow-none mb-0">
                    <div class="card-body text-center">
                        <p class="mb-1 text-white">@lang('site.Total WithHolding')</p>
                        <h3 class="mb-3 text-white">E£ {{ $TotalWithHolding }}</h3>
                        {{-- <p class="font-13 text-white"><span class="text-success"><i class="lni lni-arrow-up"></i>
                                2.5%</span> vs last 7 days</p> --}}
                        {{-- <div id="chart4"></div> --}}
                    </div>
                </div>
            </div>

        </div><!--end row-->
    </div>

    <div class="row row-cols-1 row-cols-xl-2">
        <div class="col-11 d-flex m-auto">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if (count($allDraft) > 0)
                            <div class="card radius-10"
                                style="width: 100%;padding:10px;margin:auto;">
                                <div class="card-header border-bottom-0 bg-transparent">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h5 class="font-weight-bold mb-0">@lang('site.Recent invoices')</h5>
                                        </div>
                                        <div class="ms-auto">
                                            <a href="{{ route('showDraft') }}"
                                                class="btn btn-white radius-10">@lang('site.View more')</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive text-center">
                                        <table class="table mb-0 align-middle">
                                            <thead>
                                                <tr>
                                                    <th>@lang('site.Sequence')</th>
                                                    <th>@lang('site.internalid')</th>
                                                    <th>@lang('site.customer_name')</th>
                                                    <th>@lang('site.dateTimeIssued')</th>
                                                    <th>@lang('site.Total')</th>
                                                    <th>@lang('site.control')</th>
                                                    <th>@lang('site.invoice status')</th>
                                                    {{-- <th>@lang('site.Delete')</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allDraft as $index => $draft)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $draft['jsondata']['internalID'] }}</td>
                                                        @isset($draft['jsondata']['receiver']['name'])
                                                            <td>{{ $draft['jsondata']['receiver']['name'] }}</td>
                                                        @else
                                                            <td></td>
                                                        @endisset
                                                        <td>{{ Carbon\Carbon::parse($draft['jsondata']['dateTimeIssued'])->format('d-m-Y') }}
                                                        </td>
                                                        <td>{{ $draft['jsondata']['totalAmount'] }}</td>
                                                        <td>
                                                            <a href="{{ route('showDraftDetails', $draft->id) }}"
                                                                class="btn btn-sm btn-secondary radius-2">@lang('site.View details')</a>
                                                        </td>

                                                        {{-- <form action="{{ route('sendDraftData',$draft->id) }}" method="post">
                                            @csrf
                                            @method('post')
                                            <button class="btn btn-success">ارسال</button>
                                        </form> --}}
                                                        @if ($draft->inv_uuid != null)
                                                            <td>
                                                                <a class="btn btn-sm btn-success radius-2"
                                                                    style="width: 80px;cursor: text;">
                                                                    @lang('site.sent')</a>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <a class="btn btn-sm btn-warning radius-2"
                                                                    style="width: 80px;cursor: text;">
                                                                    @lang('site.Not sent')</a>
                                                            </td>
                                                        @endif
                                                        {{-- <td>
                                        <form action="{{ route('deleteDraft', $draft->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger"
                                                onclick="return confirm('هل أنت متأكد من مسح الفاتورة؟');">@lang('site.Delete invoice')</button>
                                        </form>
                                    </td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- <div id="chart6"></div> --}}
                </div>
            </div>
        </div>
        {{-- <div class="col d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Visitor Status</h6>
                        </div>
                        <div class="d-flex align-items-center ms-auto font-13 gap-2">
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class='bx bxs-circle text-primary me-1'></i>New Visitor</span>
                            <span class="border px-1 rounded cursor-pointer"><i
                                    class='bx bxs-circle text-sky-light me-1'></i>Old Visitor</span>
                        </div>
                    </div>
                    <div id="chart7"></div>
                </div>
            </div>
        </div> --}}
    </div>


    <div class="page-content">
        <div class="row row-cols-1 row-cols-lg-3">
            <div class="col">
                <a href="{{ route('showDraft') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.Saved documents sent')</p>
                                    <h5 class="mb-0 mt-2" style="font-weight: bold;margin-right: 10px">
                                        {{ $sentinvoices }}
                                    </h5>
                                </div>
                                <div class="widgets-icons bg-gradient-cosmic text-white"><i class='bx bx-badge-check'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('showDraft') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.draft no sent')</p>
                                    <h5 class="mb-0 mt-2" style="font-weight: bold;margin-right: 10px">
                                        {{ $NotsentOfDraft }}
                                    </h5>
                                </div>
                                <div class="widgets-icons bg-gradient-cosmic text-white"><i class='bx bx-check'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('showDraft') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.all draft invoices')</p>
                                    <h5 class="mb-0 mt-2" style="font-weight: bold;margin-right: 10px">
                                        {{ $allDraftCount }}
                                    </h5>
                                </div>
                                <div class="widgets-icons bg-gradient-cosmic text-white"><i
                                        class='bx bx-add-to-queue'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('customer.index') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.customers')</p>
                                    <h5 class="mb-0 mt-2" style="font-weight: bold;margin-right: 10px">
                                        {{ $customers }}
                                    </h5>
                                </div>
                                <div class="widgets-icons bg-gradient-burning text-white"><i class='bx bx-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('active') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.Active Products')</p>
                                    <h4 class="font-weight-bold">
                                    </h4>
                                </div>
                                <div class="widgets-icons bg-gradient-lush text-white"><i class='bx bx-time'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('showAllPackages') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.Document Packages')</p>
                                    </h4>
                                </div>
                                <div class="widgets-icons bg-gradient-kyoto text-white"><i class='bx bxs-cube'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- <div class="col">
                <a href="{{ route('sentInvoices', '1') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.sent_documents')</p>

                                </div>
                                <div class="widgets-icons bg-gradient-blues text-white"><i class='bx bx-badge-check'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> --}}
            <div class="col">
                <a href="{{ route('receivedInvoices', '1') }}">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="mb-0">@lang('site.received_documents')</p>
                                    <h4 class="font-weight-bold">
                                    </h4>
                                </div>
                                <div class="widgets-icons bg-gradient-moonlit text-white"><i class='bx bx-bar-chart'></i>
                                </div>
                            </div>
                        </div>
                    </div>
            </div></a>
        </div>
        <!--end row-->
        {{-- <div class="row"> --}}
    @endsection

    @push('js')
        <script src="{{ asset('main/plugins/simplebar/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('main/plugins/metismenu/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('main/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/highcharts.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/highcharts-more.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/variable-pie.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/solid-gauge.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/highcharts-3d.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/cylinder.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/funnel3d.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/exporting.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/export-data.js') }}"></script>
        <script src="{{ asset('main/plugins/highcharts/js/accessibility.js') }}"></script>
        <script src="{{ asset('main/js/index4.js') }}"></script>
        <script src="{{ asset('main/js/app.js') }}"></script>
    @endpush
