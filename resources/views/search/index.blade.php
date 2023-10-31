@php
   $allCompanies = DB::table('companies2') ->select('name', 'tax_id')
        ->get();
@endphp

<h5 style="margin-bottom: 50px;color:red;border-bottom: 1px solid red;width:55%">@lang('site.Note')</h5>
<div style="margin: 10px">
    <form action="{{ route('allinvoices') }}" method="get">
        <div class="form-row row text-center">
            <div class="form-group col-md-2">
                <label for="inputEmail4">@lang('site.invoices from')</label>
                <input required type="date" value="{{ request('datefrom') ? request('datefrom') : '' }}" name="datefrom"
                    class="form-control" id="inputEmail4">
            </div>
            <div class="form-group col-md-2">
                <label for="inputPassword4">@lang('site.invoices to')</label>
                <input required type="date" value="{{ request('dateto') ? request('dateto') : '' }}" name="dateto"
                    class="form-control" id="inputPassword4">
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">@lang('site.customer_name')</label>
                <select class="form-control single-select" name="receiverId">
                    {{-- @if (request('receiverId'))
                        <option value="">
                            {{ request('receiverId') == $allCompanies['BetakaDriba'] ? $allCompanies['name'] : '' }}
                        </option>
                    @endif --}}
                    <option value="">@lang('site.allcustomer')</option>
                    @foreach ($allCompanies as $company)
                        @if (request('receiverId'))
                            <option value=""
                                {{ request('receiverId') == $company->tax_id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @else
                            <option value="{{ $company->tax_id }}">{{ $company->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inputPassword4">@lang('site.Invoice Direction')</label>
                <select class="form-control single-select" name="direction">
                    {{-- <option value="">إختر إتجاه الفواتير...</option> --}}
                    <option value="Sent" {{ request('direction') == 'Sent' ? 'selected' : '' }}>@lang('site.sent')</option>
                    <option value="Received" {{ request('direction') == 'Received' ? 'selected' : '' }}>@lang('site.received')
                    </option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inputPassword4">@lang('site.Invoices Status')</label>
                <select class="form-control single-select" name="status">
                    <option value="Valid" {{ request('status') == 'Valid' ? 'selected' : '' }}>@lang('site.valid')</option>
                    <option value="Invalid" {{ request('status') == 'Invalid' ? 'selected' : '' }}>@lang('site.invalid') </option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}> @lang('site.Canceled')
                    </option>
                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>@lang('site.Rejected')</option>
                    </option>
                </select>
            </div>
        </div>

</div>

<div style="text-align: center">

    <button type="submit" class="btn btn-primary" style="margin-bottom: 50px;width: 100px">@lang('site.Search')</button>
</div>
</form>
