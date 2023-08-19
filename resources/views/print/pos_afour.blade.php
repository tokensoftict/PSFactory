<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #{{ $invoice->id }}</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
        }

        #products {
            width: 90%;
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
<div id="printbox">
    <table width="80%">
        <tr>
            <td valign="top" width="60%">
                <h2  class="text-center">{{ $store->name}}</h2>
                <p align="center">
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
            <td valign="top" width="40%" align="right">
                @if($store->logo != "1659902910.png")
                    <img style="max-height:100px;float: right;margin-top: -10px" src="{{ public_path("logo/". $store->logo) }}" alt='Logo'>
                @endif
                @if($invoice->status_id === status('Dispatched'))
                    <table class="inv_info" style="margin-top: 10px;">
                        @if($invoice->dispatched_by)
                            <tr>
                                <th align="left">Dispatched By  </th><td>{{ ucwords($invoice->dispatched->name) }}</td>
                            </tr>
                        @endif
                        @if($invoice->picked_by)
                            <tr>
                                <th  align="left">Picked By  </th><td> {{ ucwords($invoice->picked->name) }}</td>
                            </tr>
                        @endif
                        @if($invoice->packed_by)
                            <tr>
                                <th  align="left">Packed By  </th><td>{{  ucwords($invoice->packed->name) }}</td>
                            </tr>
                        @endif
                        @if($invoice->checked_by)
                            <tr>
                                <th  align="left">Checked By  </th><td>{{ ucwords($invoice->checked->name) }}</td>
                            </tr>
                        @endif


                    </table>
                @endif

            </td>
        </tr>

    </table>

    <table  @if($invoice->status_id === status('Dispatched')) style="margin-top: -90px;" @else style="margin-top: 4px;" @endif  class="inv_info">

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
            <th align="left">Sales Rep.</th>
            <td>{{ $invoice->last_updated->name }}</td>
        </tr>
        <tr>
            <th  align="left">Invoice Status</th>
            <td>{{ $invoice->status->name }}</td>
        </tr>
        <tr>
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


    <h2 style="margin-top:0" class="text-center">Sales Invoice / Receipt</h2>

    <table id="products">
        <tr class="product_row">
            <td>#</td>
            <td align="left"><b>Name</b></td>
           <!-- <td align="center"><b>Batch Number</b></td> -->
            <td align="center"><b>Quantity</b></td>
            <td align="center"><b>Price</b></td>
            <td align="center"><b>Discount Price</b></td>
            <td align="right"><b>Total</b></td>
        </tr>
        <tbody id="appender">
        @foreach($invoice->invoiceitems as $item)
            @php
                $batchNumber = [];
               foreach($item->invoiceitembatches as $batch){
                    $batchNumber[] =  $batch->stockbatch->batch_number. " - ".$batch->quantity." qty";
                }
            @endphp
            <tr>
                <td align="left">{{ $loop->iteration }}</td>
                <td align="left" class="text-left">{{ $item->stock->name }}</td>
               <!-- <td align="center">{{ implode("<br/>", $batchNumber) }}</td>-->
                <td align="center" class="text-center">{{ $item->quantity }}</td>
                <td align="center" class="text-center">{{ number_format($item->selling_price,2) }}</td>
                <td align="right" class="text-right">{{ number_format(($item->selling_price-$item->discount_amount),2) }}</td>
                <td align="right" class="text-right">{{ number_format(($item->quantity * ($item->selling_price - $item->discount_amount)),2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td></td>
           <!-- <td></td> -->
            <td></td>
            <td></td>
            <td></td>
            <th  align="right" class="text-right">Sub Total</th>
            <th  align="right" class="text-right">{{ number_format($invoice->sub_total,2) }}</th>
        </tr>
        <tr>
            <td></td>
            <!--  <td></td> -->
            <td></td>
            <td></td>
            <td></td>
            <th  align="right" class="text-right">Discount</th>
            <th  align="right" class="text-right">-{{ number_format($invoice->discount_amount,2) }}</th>
        </tr>
        <tr>
            <td></td>
            <!--   <td></td> -->
            <td></td>
            <td></td>
            <td></td>
            <th   align="right" class="text-right">Total</th>
            <th  align="right" class="text-right"><b>{{ number_format(($invoice->sub_total -$invoice->discount_amount),2) }}</b></th>
        </tr>
        </tfoot>
    </table>

    <div class="text-center">  {{ $store->footer_notes }}</div>
    <br/>
    <div align="center">

    </div>
    <br/>
    <div class="text-center"> {!! softwareStampWithDate() !!}</div>
    <div class="text-center"> Develop By Tokensoft ICT - 08130610626</div>
</div>
</body>
</html>

