<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>DeliveryChallan-</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
        }
        body:before{
            content: "";
            position: fixed;
            z-index: 0;
            top:25.33%;
            bottom: 0;
            left:25%;
            right: 0;
            background-image:url({{url('admin/dist/img/settings', $settings->invoice_logo)}});
            background-repeat: no-repeat;
            background-position: center center;
            background-size:600px 600px;
            width:600px;
            min-height:600px;
        }

        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }
        .address{
            background-color: #281848;
            border-radius: 7px;
            color: white;
        }
        .custom_table td{
            padding: .60rem !important;
            vertical-align: top;
            border-top: 1px solid #a2a2a3;
            font-size: 14px;
            border: 1px solid #a2a2a3;
        }
        .custom_table th{
            padding: .60rem !important;
            vertical-align: top;
            border-top: 1px solid #a2a2a3;
            font-size: 16px;
            border: 1px solid #a2a2a3;
        }
        .icon{
            padding:10px;
            text-align: center;
            line-height: 12px;
            font-size: 18px;
        }
        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        .company h2{
            float: right;
            font-size: 30px;
            font-family: initial;
            font-weight: bold;
            /* font-family: itallic; */
            padding: 10px 0px;
            color: #150f35;
        }
        .logo h2, .title-company h2{
            text-align: center;
            font-weight: bold;
            font-family: 'tahoma';
            color: #280363;
            padding:0px;
            margin: 0px;
        }
        .item-table p{
            margin:0px;
            padding:0px;
            line-height: 15px;
            font-size: 14px;
        }
        .signature{
            margin-bottom: 20px;
            padding: 0px 17px;
            text-decoration: overline;
            margin-top: 40px;
        }
        .signature p{
            margin-bottom: 100px;
        }
        .signature h4{
            margin: 0px;
            padding: 0px;
            font-size: 16px;
            font-weight: bold;
            font-family: initial;
        }
        .head-subtitle{
            font-size: 14px;
            font-style: italic;
            margin: 0px;
            font-weight: bold;
        }
        .app-head p{
            margin: 0px;
            padding: 0px;
            font-family: initial;
            line-height: 20px;
        }
        .date p{
            text-align: right;
            font-weight: bold;
            font-family: initial;
            margin-bottom: 0px;
            line-height: 15px;
        }
        .centered {
            text-align: center;
            align-content: center;
        }
        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        small{font-size:11px;}
        .invoice_title{
            border: 1px solid #2d0080;
            margin: 0px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            padding: 5px 10px;
        }

    .page-header {
        height: 300px;
    }
    .page-header-space {
        height: 370px;
    }

    .page-footer, .page-footer-space {
        height: 120px;
    }
    .page-footer {
        position: fixed;
        bottom: 0;
        width: 90%;
        margin-top:30px; /* for demo */
    }
    .page-header {
        position: fixed;
        width: 88%;
        height: 300px;
    }
    .title-company{
        width: 600px;
        margin: 0px auto;
        text-align: center;
    }

    .page {
        page-break-after: always;
    }

    @media print {
        *{
            font-size:20px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
        }
        .custom_table th, .custom_table td{
            padding: .30rem !important;
        }
        body:before{
            content: "";
            position: fixed;
            z-index: 0;
            top:25.33%;
            bottom: 0;
            left:25%;
            right: 0;
            background-image:url({{url('admin/dist/img/settings', $settings->invoice_logo)}});
            background-repeat: no-repeat;
            background-position: center center;
            background-size:600px 600px;
            width:600px;
            min-height:600px;
        }
        .card{
            background-color: none;
        }
        .hidden-print {
            display: none !important;
        }
        .head-subtitle{
            font-size: 16px;
            font-style: italic;
            margin: 0px;
            font-weight: bold;
        }
        .page-header {
            position: fixed;
            width: 88%;
            height: 300px;
        }
        .page-footer {
            position: fixed;
            bottom: 0;
            width: 90%;
            height: 120px;
    }
        thead {display: table-header-group;}
        tfoot {display: table-footer-group;}
        button {display: none;}
        body {margin: 0;}
        body { -webkit-print-color-adjust: exact !important; }
    }
    </style>
  </head>
<body>

<div class="container">
<div>
    @if(preg_match('~[0-9]~', url()->previous()))
        @php $url = '../'; @endphp
    @else
        @php $url = url()->previous(); @endphp
    @endif
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="{{$url}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> {{trans('Back')}}</a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> {{trans('Print')}}</button></td>
            </tr>
        </table>
        <br>
    </div>

    <div id="receipt-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="border:none; background:none;">
                    <div class="card-body">
                        <div class="page-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card" style="border:none;">
                                        <div class="card-body" style="padding:0px">
                                            <div class="row">
                                                <div class="col-md-12" style="margin-bottom:20px;">
                                                    <div class="main">
                                                        <div class="title-company">
                                                            <img src="{{url('admin/dist/img/settings', $settings->company_logo)}}" alt="logo" width="10%" style="float: left;">
                                                            <h2>Shafizuddin Textile Ltd.</h2>
                                                            <h4 class="head-subtitle">A Reliable Home For Quality Knit Fabrics</h4>
                                                            <p style="margin:0px;">Corporate Office & Factory</p>
                                                        </div>
                                                    </div>
                                                    <div class="logo">
                                                        <div class="icon">
                                                            <i class="fa fa-home"> {{ $settings->address }} </i><br>
                                                            <i class="fa fa-envelope" style="text-transform: lowercase;"> {{ $settings->company_email }} </i><br>
                                                            <i class="fa fa-phone"> {{ $settings->company_phone }} </i><br>
                                                            <i class="fa fa-globe" aria-hidden="true" style="text-transform: lowercase;"> {{ $settings->company_website }} </i><br>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 app-head">
                                                    <p>Party's Name : {{ $ret_yarn_first->party->name }}</p>
                                                    <p>Address : {{ $ret_yarn_first->party->address }}</p>
                                                    <p>Driver :  {{ $ret_yarn_first->driver }}</p>
                                                    <p>Truck Number: {{ $ret_yarn_first->truck_number }}</p>
                                                </div>
                                                <div class="col-md-4 app-head">
                                                    <h2 class="invoice_title">Delivery Challan</h2>
                                                </div>
                                                <div class="col-md-4 date">
                                                    <p>Date: {{ $ret_yarn_first->date }}</p>
                                                    <p>No: <b>{{ $ret_yarn_first->ret_chalan }}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table width="100%">
                            <thead>
                                <tr>
                                  <td>
                                    <!--place holder for the fixed-position header-->
                                    <div class="page-header-space"></div>
                                  </td>
                                </tr>
                            </thead>

                            <tbody>
                              <tr>
                                <td>
                                   <div class="page">
                                     <div class="row" style="margin-top:20px;">
                                        <div class="col-md-12">
                                            <div class="vendor">
                                                <div class="description">
                                                    <table class="custom_table" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">SL NO</th>
                                                                <th width="45%">Particulars</th>
                                                                <th width="10%" style="text-align:center;">Roll</th>
                                                                <th width="5%" style="text-align:center;">Return Quantity</th>
                                                                <th width="10%" style="text-align:center;">Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $total_qty = 0; $total_toll = 0;
                                                            @endphp
                                                            @foreach($return_yarns as $key=>$yearn)
                                                                 <tr>
                                                                     <td>{{ $key+1 }}</td>
                                                                     <td>
                                                                         Yarn Brand : {{ $yearn->receiveYarn->brand }},
                                                                         Yarn Count : {{ $yearn->receiveYarn->count }},
                                                                         Yarn Lot : {{ $yearn->receiveYarn->lot }}
                                                                     </td>
                                                                     <td style="text-align:center;">{{ $yearn->roll }}</td>
                                                                     <td style="text-align:center;">{{ $yearn->quantity }}</td>
                                                                     <td></td>
                                                                     @php
                                                                         $total_qty += $yearn->quantity;
                                                                         $total_toll += $yearn->roll;
                                                                     @endphp
                                                                 </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th width="5%"></th>
                                                                <th width="45%">Total</th>
                                                                <th width="10%" style="text-align:center;">{{ $total_toll }}</th>
                                                                <th width="10%" style="text-align:center;">{{ $total_qty }}</th>
                                                                <th width="5%" style="text-align:center;"></th>
                                                            </tr>
                                                       </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   </div>
                                </td>
                              </tr>
                            </tbody>

                            <tfoot>
                              <tr>
                                <td>
                                  <div class="page-footer-space"></div>
                                </td>
                              </tr>
                            </tfoot>
                        </table>
                        <table>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="page-footer">
            <div class="row" style="margin-top:10px;">
                <div class="container">
                <table width="100%" style="font-weight: bold;">
                    <tbody>
                         <tr>
                            <td>
                                <div class="signature">
                                    <h4>Receiver</h4>
                                </div>
                            </td>
                            <td>
                                <div class="signature" style="text-align: center;">
                                    <h4>Store Officer</h4>
                                </div>

                            </td>
                            <td>
                                <div class="signature" style="text-align: right;">
                                    <h4>Store In-Chanrge</h4>
                                </div>
                            </td>
                            <td>
                                <div class="signature"  style="text-align: right;">
                                    <h4>Authorized</h4>
                                </div>
                            </td>
                         </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function auto_print() {
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
