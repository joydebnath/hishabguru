<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 10px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
            color: #363636;
        }

        h4, .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4, .h4 {
            font-size: 1.15rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .mono {
            font-family: "Courier New", Courier, monospace;
            font-size: 1.15em;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .text-capitalize {
            text-transform: capitalize !important;
        }

        * {
            font-family: "DejaVu Sans";
        }

        body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
            line-height: 1.1;
        }

        .party-header {
            font-size: .75rem;
            text-transform: uppercase;
            color: #797b86;
            letter-spacing: .15em;
            font-family: Verdana, Geneva, sans-serif !important;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .mb-1 {
            margin-bottom: .25rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .font-medium {
            font-weight: 500;
        }

        .tracing-wider {
            letter-spacing: .05em;
        }

        .border-r-1 {
            border-right: 1px solid #e6e7e8 !important;
        }

        .border-r-0 {
            border-right: none !important;
        }

        .border-t-0 {
            border-top: none !important;
        }

        .min-h-400 {
            min-height: 500px;
        }

        .label {
            font-weight: 500;
            font-size: 1.15em;
            margin-bottom: 10px;
            display: block;
            letter-spacing: .02em;
        }

        .tag {
            font-size: 1.05em;
            text-transform: uppercase;
            color: #777787;
            letter-spacing: .02em;
        }
    </style>
</head>

<body>
{{-- Header --}}
@if($invoice->logo)
    <img src="{{ $invoice->getLogo() }}" alt="logo" style="max-height: 65px; min-height: 50px">
@endif
<table class="table mt-5">
    <tbody>
    <tr>
        <td class="border-0 pl-0" width="68%">
            <h4 class="text-gray-700" style="color: #363636;letter-spacing: .05em;">
                <strong>{{ $invoice->name }}</strong>
            </h4>
            @isset($invoice->status)
            <span>
                Status: <strong class="tag">{{$invoice->status}}</strong>
            </span>
            @endisset
        </td>
        <td class="border-0 pl-0">
            <p class="mb-1">{{ __('invoices::invoice.serial') }} <strong>{{ $invoice->getInvoiceNumber() }}</strong></p>
            <p class="mb-1">{{ __('invoices::invoice.date') }}: <strong>{{ $invoice->getDate() }}</strong></p>
            @if(isset($invoice->due_date))
                <p class="mb-1">{{ trans('invoices::invoice.due_date') }}:
                    <strong style="color: #403f3f">{{ $invoice->getDueDate() }}</strong>
                </p>
            @endif
            @if(isset($invoice->expiry_date))
                <p class="mb-1">{{ trans('invoices::invoice.expiry_date') }}:
                    <strong style="color: #403f3f">{{ $invoice->getExpiryDate() }}</strong>
                </p>
            @endif
            @if(isset($invoice->delivery_date))
                <p class="mb-1">{{ trans('invoices::invoice.delivery_date') }}:
                    <strong style="color: #403f3f">{{ $invoice->getDeliveryDate() }}</strong>
                </p>
            @endif
        </td>
    </tr>
    </tbody>
</table>

{{-- Seller - Buyer --}}
<table class="table">
    <tbody>
    <tr>
        <td class="px-0 border-0">
            <p class="party-header mb-1"><strong>{{ __('invoices::invoice.seller') }}</strong></p>
            @if($invoice->seller->name)
                <p class="seller-name mb-1">
                    <strong>{{ $invoice->seller->name }}</strong>
                </p>
            @endif

            @if($invoice->seller->address)
                <p class="seller-address mb-1">
                    {{ __('invoices::invoice.address') }}: {{ $invoice->seller->address }}
                </p>
            @endif

            @if($invoice->seller->code)
                <p class="seller-code mb-1">
                    {{ __('invoices::invoice.code') }}: {{ $invoice->seller->code }}
                </p>
            @endif

            @if($invoice->seller->vat)
                <p class="seller-vat mb-1">
                    {{ __('invoices::invoice.vat') }}: {{ $invoice->seller->vat }}
                </p>
            @endif

            @if($invoice->seller->phone)
                <p class="seller-phone mb-1">
                    {{ __('invoices::invoice.phone') }}: {{ $invoice->seller->phone }}
                </p>
            @endif

            @foreach($invoice->seller->custom_fields as $key => $value)
                <p class="seller-custom-field mb-1">
                    {{ ucfirst($key) }}: {{ $value }}
                </p>
            @endforeach
        </td>
        <td class="border-0"></td>
        <td class="px-0 border-0">
            <p class="party-header mb-1"><strong>{{ __('invoices::invoice.buyer') }}</strong></p>
            @if($invoice->buyer->name)
                <p class="buyer-name mb-1">
                    <strong>{{ $invoice->buyer->name }}</strong>
                </p>
            @endif

            @if($invoice->buyer->address)
                <p class="buyer-address mb-1">
                    {{ __('invoices::invoice.address') }}: {{ $invoice->buyer->address }}
                </p>
            @endif

            @if($invoice->buyer->code)
                <p class="buyer-code mb-1">
                    {{ __('invoices::invoice.code') }}: {{ $invoice->buyer->code }}
                </p>
            @endif

            @if($invoice->buyer->vat)
                <p class="buyer-vat mb-1">
                    {{ __('invoices::invoice.vat') }}: {{ $invoice->buyer->vat }}
                </p>
            @endif

            @if($invoice->buyer->phone)
                <p class="buyer-phone mb-1">
                    {{ __('invoices::invoice.phone') }}: {{ $invoice->buyer->phone }}
                </p>
            @endif

            @foreach($invoice->buyer->custom_fields as $key => $value)
                <p class="buyer-custom-field mb-1">
                    {{ ucfirst($key) }}: {{ $value }}
                </p>
            @endforeach
        </td>
    </tr>
    </tbody>
</table>

{{-- Table --}}
<table class="table">
    <thead>
    <tr>
        <th scope="col" class="border-0 pl-0">{{ __('invoices::invoice.description') }}</th>
        @if($invoice->hasItemUnits)
            <th scope="col" class="text-center border-0">{{ __('invoices::invoice.units') }}</th>
        @endif
        <th scope="col" class="text-center border-0">{{ __('invoices::invoice.quantity') }}</th>
        <th scope="col" class="text-right border-0">{{ __('invoices::invoice.price') }}</th>
        @if($invoice->hasItemDiscount)
            <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>
        @endif
        @if($invoice->hasItemTax)
            <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>
        @endif
        <th scope="col" class="text-right border-0 pr-0">{{ __('invoices::invoice.sub_total') }}</th>
    </tr>
    </thead>
    <tbody>
    {{-- Items --}}
    @foreach($invoice->items as $item)
        <tr>
            <td class="pl-0 mono">{{ $item->title }}</td>
            @if($invoice->hasItemUnits)
                <td class="text-center">{{ $item->units }}</td>
            @endif
            <td class="text-center mono">{{ $item->quantity }}</td>
            <td class="text-right mono">
                {{ $invoice->formatCurrency($item->price_per_unit) }}
            </td>
            @if($invoice->hasItemDiscount)
                <td class="text-right mono">
                    {{ $invoice->formatCurrency($item->discount) }}
                </td>
            @endif
            @if($invoice->hasItemTax)
                <td class="text-right mono">
                    {{ $invoice->formatCurrency($item->tax) }}
                </td>
            @endif

            <td class="text-right pr-0 mono">
                {{ $invoice->formatCurrency($item->sub_total_price) }}
            </td>
        </tr>
    @endforeach
    {{-- Summary --}}
    @if($invoice->hasItemOrInvoiceDiscount())
        <tr>
            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0 mono"></td>
            <td class="text-right pl-0 mono">{{ __('invoices::invoice.total_discount') }}</td>
            <td class="text-right pr-0 mono">
                {{ $invoice->formatCurrency($invoice->total_discount) }}
            </td>
        </tr>
    @endif
    @if($invoice->taxable_amount)
        <tr>
            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0 mono"></td>
            <td class="text-right pl-0 mono">{{ __('invoices::invoice.taxable_amount') }}</td>
            <td class="text-right pr-0 mono">
                {{ $invoice->formatCurrency($invoice->taxable_amount) }}
            </td>
        </tr>
    @endif
    @if($invoice->tax_rate)
        <tr>
            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0 mono"></td>
            <td class="text-right pl-0 mono">{{ __('invoices::invoice.tax_rate') }}</td>
            <td class="text-right pr-0 mono">
                {{ $invoice->tax_rate }}%
            </td>
        </tr>
    @endif
    @if($invoice->hasItemOrInvoiceTax())
        <tr>
            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0 mono"></td>
            <td class="text-right pl-0 mono">{{ __('invoices::invoice.total_taxes') }}</td>
            <td class="text-right pr-0 mono">
                {{ $invoice->formatCurrency($invoice->total_taxes) }}
            </td>
        </tr>
    @endif
    @if($invoice->shipping_amount)
        <tr>
            <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0 mono"></td>
            <td class="text-right pl-0 mono">{{ __('invoices::invoice.shipping') }}</td>
            <td class="text-right pr-0 mono">
                {{ $invoice->formatCurrency($invoice->shipping_amount) }}
            </td>
        </tr>
    @endif
    <tr>
        <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0 mono"></td>
        <td class="text-right pl-0 mono">{{ __('invoices::invoice.total_amount') }}</td>
        <td class="text-right pr-0 total-amount mono">
            {{ $invoice->formatCurrency($invoice->total_amount) }}
        </td>
    </tr>
    </tbody>
</table>
<p style="font-size: 1.05em;">
    {{ trans('invoices::invoice.amount_in_words') }}: <span
        class="text-uppercase">{{ $invoice->getTotalAmountInWords() }}</span>
</p>

@if($invoice->delivery_details)
    <br>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th colspan="3" style="border-bottom: none">
                <h2 class="text-uppercase font-medium mb-0 tracing-wider"
                    style="margin: 0"
                >
                    {{trans('invoices::invoice.delivery_details')}}
                </h2>
            </th>
        </tr>
        <tbody>
        <tr>
            @if($invoice->delivery_details->delivery_address)
                <td class="px-0 border-t-0 border-r-1 min-h-400">
                    <span class="label">Delivery Address</span>
                    @foreach($invoice->delivery_details->delivery_address as $value)
                        <p class="mb-1">
                            {{$value}}
                        </p>
                    @endforeach
                </td>
            @endif

            @if($invoice->delivery_details->other_details)
                <td class="px-0 border-t-0 border-r-1 min-h-400">
                    <span class="label">Contact Details</span>
                    @foreach($invoice->delivery_details->other_details as $key => $value)
                        <p style="font-size: 1.05em" class="mb-1 font-medium tracing-wider text-capitalize">{{$key}}</p>
                        <p>{{$value}}</p>
                    @endforeach
                </td>
            @endif

            @if($invoice->delivery_details->delivery_instructions)
                <td class="px-0 border-t-0 border-r-0 min-h-400">
                    <span class="label">Delivery Instructions</span>
                    <p>{{$invoice->delivery_details->delivery_instructions}}</p>
                </td>
            @endif
        </tr>
        </tbody>
    </table>
@endif

@if($invoice->notes)
    <p style="font-size: 1.05em;letter-spacing: .05rem">
        {{ trans('invoices::invoice.notes') }}:
        {!! $invoice->notes !!}
    </p>
@endif

@if($invoice->message)
    <p style="font-size: 1.05em;letter-spacing: .02rem">
        {{ trans('invoices::invoice.message') }}:
        {!! $invoice->message !!}
    </p>
@endif

<script type="text/php">
    if (isset($pdf) && $PAGE_COUNT > 1) {
        $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
        $size = 8;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width);
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }


</script>

</body>
</html>
