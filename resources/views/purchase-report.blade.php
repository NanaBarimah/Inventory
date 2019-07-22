<!DOCTYPE html>
<html>
    <head>
        <title>Approved Purchase Order</title>
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"/>
        <style>
            .title{
                font-weight:bold;
                color:#0c2646;
                margin-bottom: 12px;
            }

            address span{
                font-weight: 400;
                color: #aaa;
                font-style: normal;
                line-height: 1.5em;
                display:block;
            }

            .letter-heading{
                text-transform: uppercase;
                font-weight: bold;
                text-decoration: underline;
                text-align: center;
            }
            
            label{
                font-size: 12px;
                color: #aaa;
            }
        </style>
    </head>
    <body>
        <div>
            <div>
                <div class="mb-2">
                    <div class="col-md-7 text-center">
                        <h1 class="title">MaintainMe&trade;</h1>
                        <h6>Ledzekuku General Hospital</h6>
                        <address>
                            <span class="d-block">P.O. Box LG, 14</span>
                            <span class="d-block">+233 261 527 546</span>
                        </address>
                    </div>
                    <div class="col-md-5">
                        <h6><b>Purchasing Officer</b></h6>
                        <p>21st December, 2019</p>
                    </div>
                </div>
                <div>
                    <div class="col-md-12">
                        <p>Hello, </p>
                        <h6 class="letter-heading">Purchase of filters</h6>
                        <p>This note is to confirm the approval of a request to purchase the following parts 
                            for the clinicial engineering department of the hospital. Please ensure that this purchase is
                            fulfilled by the <b>21st December, 2019</b>. </p>
                    </div>
                </div>
                <div>
                    <div class="col-md-12">
                        <h6>Items</h6>
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price ($)</th>
                                            <th class="text-right">Amount ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->order_items as $key=>$item)
                                        <tr>
                                            <td>{{$item->part_name}}</td>
                                            <td>{{$item->unit_cost}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td class="text-right">{{$item->quantity * $item->unit_cost}}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="bg-transparent">
                                            <td colspan="3" class="text-right text-muted">Sales Tax</td>
                                            <td class="text-right">{{$order->sales_tax != null ? $order->sales_tax : 0}}</td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td colspan="3" class="text-right text-muted">Shipping Cost</td>
                                            <td class="text-right">{{$order->shipping_cost != null ? $order->shipping_cost : 0}}</td>
                                        </tr>
                                        <tr class="bg-transparent">
                                            <td colspan="3" class="text-right text-muted">Other Cost</td>
                                            <td class="text-right">{{$order->other_cost != null ? $order->other_cost : 0}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="border-bottom border-1">
                                        <tr>
                                            <th colspan="3" class="text-right font-weight-600">Total</th>
                                            <th class="text-right font-weight-600">{{$order->item_cost + $order->shipping_cost + $order->other_cost + $order->sales_tax != null ? $order->item_cost + $order->shipping_cost + $order->other_cost + $order->sales_tax : 0}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="col-md-3">
                        <div>
                            <label><b>Shipping Method</b></label>
                            <p>{{$order->shipping_method != null ? $order->shipping_method : 'N/A'}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <label><b>Extra Notes</b></label>
                            <p>{{$order->notes != null ? $order->notes : 'N/A'}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            <label><b>Description</b></label>
                            <p>{{$order->description != null ? $order->description : 'N/A'}}</p>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label><b>Terms</b></label>
                            <p>{{$order->terms != null ? $order->terms : 'N/A'}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="title">MaintainMe&trade;</h1>
                    </div>
                    <div class="col-md-6">
                        <p class="text-right mb-5">Sincerely,</p>
                        <p class="text-right">{{$user->firstname.' '.$user->lastname}}</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>