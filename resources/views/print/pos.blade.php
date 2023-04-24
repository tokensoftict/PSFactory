<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #{{ $invoice->id }}</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 8pt;
            background-color: #fff;
        }

        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 7pt;
        }

        #printbox {
            width: 80mm;
            margin: 5pt;
            padding: 5px;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 14pt;
        }

        .product_row {
            margin: 13pt;
        }

        .stamp {
            margin: 5pt;
            padding: 3pt;
            border: 3pt solid #111;
            text-align: center;
            font-size: 20pt;
            color:#000;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
@if($store->logo != "1659902910.png")
<h3 id="logo" class="text-center"><br><img style="max-height:30px;" src="{{ public_path("logo/". $store->logo) }}" alt='Logo'></h3>
@endif
<div id="printbox">
    <h2 style="margin:-2px;padding: 0px" class="text-center">{{ $store->name}}</h2>
    <div align="center" >
        {{ $store->first_address }}
        @if(!empty($store->second_address))
            <br/>
            {{ $store->second_address }}
        @endif
        @if(!empty($store->contact_number))
            <br/>
            {{ $store->contact_number }}
        @endif
    </div>
    <table class="inv_info">
        <tr>
            <th  align="left">Reference Number</th>
            <td>{{ $invoice->invoice_number }}</td>
        </tr>
        <tr>
            <th  align="left">Invoice Date</th>
            <td>{{ convert_date($invoice->invoice_date)  }} {{ twelveHourClock($invoice->sales_time) }}</td>
        </tr>
        <tr>
            <th align="left">Customer</th>
            <td>{{ $invoice->customer->firstname }} {{ $invoice->customer->lastname }}</td>
        </tr>
        <tr>
            <th align="left">Sales Rep.</th>
            <td>{{ $invoice->last_updated->name }}</td>
        </tr>
        <tr>
            <th  align="left">Invoice Status</th>
            <td>{{ $invoice->status->name }}</td>
        </tr>
        <!--
        @if($invoice->status_id === status('Paid') || $invoice->status_id === status('Dispatched'))
        <tr>
            <th  align="left">Mode of Payment</th>
            <td>
                @if($invoice->paymentmethoditems->count() > 1)
                    @php
                        $methods = [];
                    @endphp

                    @foreach($invoice->paymentmethoditems as $meth)
                        @php
                            echo  $meth->paymentmethod->name." : ". number_format( $meth->amount,2)."<br/>";
                        @endphp
                    @endforeach


                @else
                   {{ $invoice->paymentmethoditems->first()->paymentmethod->name  }} : {{ number_format($invoice->paymentmethoditems->first()->amount,2) }}
                @endif
            </td>
        </tr>
        @endif
        -->
    </table>
    <hr>
    <table id="products">
        <tr class="product_row">
            <td>#</td>
            <td align="left"><b>Name</b></td>
            <td align="center"><b>Quantity</b></td>
            <td align="center"><b>Price</b></td>
            <td align="right"><b>Total</b></td>
        </tr>
        <tr>
            <td colspan="5">
                <hr>
            </td>
        </tr>
        <tbody id="appender">
        @foreach($invoice->invoiceitems as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td align="left" class="text-left">{{ $item->stock->name }}</td>
                <td align="center" class="text-center">{{ $item->quantity }}</td>
                <td align="center" class="text-center">{{ number_format($item->selling_price,2) }}</td>
                <td align="right" class="text-right">{{ number_format(($item->total_selling_price),2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">Sub Total</td>
            <td class="text-right">{{ number_format($invoice->sub_total,2) }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td  align="right" class="text-right">Total</td>
            <td  align="right" class="text-right"><b>{{ number_format(($invoice->sub_total),2) }}</b></td>
        </tr>
        @if(isset($invoice->paymentmethoditems->first()->paymentmethod_id) && $invoice->paymentmethoditems->first()->paymentmethod_id == "1")
            @php
                $method = json_decode($invoice->paymentmethoditems->first()->payment_info);
            @endphp

            @if(isset( $method-> change) && $method-> change > 0 )
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td  align="right" class="text-right">Change</td>
            <td  align="right" class="text-right"><b>{{ $method->change }}</b></td>
        </tr>
        @endif
        @endif
        </tfoot>
    </table>
    <hr>
    <div class="text-center">  {{ $store->footer_notes }}</div>
    <div class="text-center"> {!! softwareStampWithDate() !!}</div>
    <div class="text-center"> Develop By Tokensoft ICT - 08130610626</div>
</div>
</body>
</html>

