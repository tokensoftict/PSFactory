<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Waybill #{{ $invoice->id }}</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
        }

        #products {
            width: 100%;
        }
        #products th, #products td {
            padding-top:5px;
            padding-bottom:5px;
            border: 1px solid black;
        }
        #products tr td {
            font-size: 8pt;
        }

        #printbox {
            width: 98%;
            margin: 5pt;
            padding: 5px;
            margin: 0px auto;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 10pt;
        }

        .product_row {
            margin: 15pt;
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

<table width="100%">
    <tr>
        <td valign="top">
            <h2 align="left">{{ $store->name}}</h2>
            <p align="left">
                {{ $store->first_address }}
                @if(!empty($store->second_address))
                    <br/>
                    {{ $store->second_address }}
                @endif
                @if(!empty($store->contact_number))
                    <br/>
                    {{ $store->contact_number }}
                @endif
            </p>
        </td>

        <td valign="top" width="35%">
            @if($store->logo != "1659902910.png")
                <img style="max-height:100px;float: right;" src="{{ public_path("logo/". $store->logo) }}" alt='Logo'>
            @endif
        </td>
    </tr>
</table>
<table style="margin-top: -35px;">

    <tr>
        <th  align="left">Reference Number</th>
        <td>{{ $invoice->invoice_number }}</td>
    </tr>
    <tr>
        <th align="left">Invoice Date</th>
        <td>{{ convert_date($invoice->invoice_date)  }}</td>
    </tr>
    <tr>
        <th align="left">Time</th>
        <td>{{ twelveHourClock($invoice->sales_time) }}</td>
    </tr>
    <tr>
        <th align="left">Customer</th>
        @if($invoice->customer->type === "COMPANY")
            <td>{{ $invoice->customer->company_name }}</td>
        @else
            <td>{{ $invoice->customer->firstname }} {{ $invoice->customer->lastname }}</td>
        @endif
    </tr>
    <tr>
        <th align="left">Customer Phone No.</th>
        <td>{{ $invoice->customer->phone_number }}</td>
    </tr>
    <tr>
        <th align="left">User.</th>
        <td>{{ $invoice->last_updated->name }}</td>
    </tr>
    <tr>
        <th align="left">Status</th>
        <td>{{ $invoice->status->name }}</td>
    </tr>
    <tr>
        <th align="left">Vehicle Number</th>
        <td>{{ $invoice->vehicle_number }}</td>
    </tr>
    <tr>
        <th align="left">Driver Name</th>
        <td>{{ $invoice->driver_name }}</td>
    </tr>

    <tr>
        <th align="left">Driver Phone Number</th>
        <td>{{ $invoice->driver_phone_number }}</td>
    </tr>
    <tr>
</table>

<h2 style="margin-top:0" class="text-center">Invoice WayBill.</h2>
<table id="products" width="100%">
    <tr class="product_row">
        <td>#</td>
        <td align="left"><b>Name</b></td>
        <td align="center"><b>Quantity</b></td>
    </tr>
    <tbody id="appender">
    @foreach($invoice->invoiceitems as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td align="left" class="text-left">{{ $item->stock->name }}</td>
            <td align="center" class="text-center">{{ $item->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br/>

<table  width="100%">
    <tr>
        <td width="40%">
            <table width="100%" id="products">
                <tr>
                    <td><b>Prepared By : </b></td>
                    <td> {{ \Illuminate\Support\Str::upper($invoice->create_by->name) }} <br/></td>
                </tr>
                <tr>
                    <td><b>Signature : </b></td>
                    <td> <br/> <br/> <br/> <br/></td>
                </tr>
                <tr>
                    <td><b>Date : </b></td>
                    <td>{{ now()->format('d/m/Y') }}</td>
                </tr>
            </table>
        </td>
        <td width="20%"></td>
        <td width="40%">
            <table width="100%" id="products">
                <tr>
                    <td><b>Received By : </b></td>
                    <td> {{ \Illuminate\Support\Str::upper($invoice->received_by) }}</td>
                </tr>
                <tr>
                    <td><b>Signature : </b></td>
                    <td> <br/> <br/> <br/> <br/></td>
                </tr>
                <tr>
                    <td><b>Date : </b></td>
                    <td>{{ now()->format('d/m/Y') }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="text-center">  {{ $store->footer_notes }}</div>
<br/>
<div align="center">
</div>
<br/>
<div class="text-center"> {!! softwareStampWithDate() !!}</div>
</body>
</html>

