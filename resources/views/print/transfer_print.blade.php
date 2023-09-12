<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #{{ $materialRequest->id }}</title>
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
    <table width="100%">
        <tr>
            <td valign="top" width="30%">
                <br/>  <br/>  <br/>  <br/>
                <span>From : <b>Production</b></span><br/>
                @php
                    $type = explode('\\',$materialRequest->request_type);
                @endphp
                <span>Request Type : <b>{{  $type[count($type) -1] }}</b></span><br/>
                <span>Request Date : <b>{{ eng_str_date($materialRequest->request_date)  }}</b></span><br/>
                <span>Request Time : <b>{{  twelveHourClock($materialRequest->request_time) }}</b></span><br/>

            </td>
            <td valign="top" align="center" width="40%">
                @if($store->logo != "1659902910.png")
                    <img style="max-height:60px;float: right;margin-top: -10px" src="{{ public_path("logo/". $store->logo) }}" alt='Logo'>
                @endif
                <h2  class="center">{{ $store->name}}</h2>
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
            <td valign="top" width="30%">
                <br/>  <br/>  <br/>
                <span>To : <b>Store</b></span><br/>
                <span>Requested By : <b>{{  $materialRequest->request_by->name }}</b></span><br/>
                <span>Status : <b>{{  $materialRequest->status->name }}</b></span><br/>
                <span>Description : <b>{{  $materialRequest->description }}</b></span><br/>
            </td>
        </tr>
    </table>
    @if(in_array(auth()->user()->department_id, [1,2]))
        <h2 align="center">{{ \Illuminate\Support\Str::upper(auth()->user()->department->name) }}</h2>
    @endif
    <h4 align="center">TRANSFER ITEMS</h4>
    <table id="products" align="center">
        <tr class="product_row">
            <td>#</td>
            <td align="left"><b>Material Name</b></td>
            <td align="center"><b>Department</b></td>
            <td align="center"><b>Request</b></td>
            <td align="center"><b>Status</b></td>
            <td align="center"><b>Resolved By</b></td>
        </tr>
        <tbody id="appender">
            @foreach($materialRequest->print_material_request_item_by_department() as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->department->name }}</td>
                    <td>{{ $item->measurement }} {{ $item->unit }}</td>
                    <td>{{ $item->status->name }}</td>
                    <td>{{ $item->resolve_by->name ?? ""  }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>