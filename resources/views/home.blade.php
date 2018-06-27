@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
<ul>
@foreach ($plans as $plan) 
<li>{{$plan->display_name}}: {{$plan->amount}} {{$plan->currency}}
    <form action="/pay" method="post">               
      <input type="text" name="plan_name" value="{{$plan->name}}" /> 
      <input type="text" class="text" value="paypal_ec" name="gateway_name"/>
      <input type="text" class="text" value="1" name="onetime"/>
      <input type="submit" value="Submit" />
    </form>  
</li>
@endforeach
</ul>

<table class="table table-striped">
<tr>
<th>订阅</th>
<th>订单</th>
<th>价格</th>
<th>状态</th>
<th>操作</th>
</tr>
@foreach ($payments as $payment)
<tr>
<td>
{{$payment->subscription->agreement_id}} 
@if ($payment->subscription->agreement_id) 
<span class="text-danger">{{$payment->subscription->status}}</span>
@endif
</td>
<td><span class="text-primary">{{$payment->number}}</span> </td>
<td> {{$payment->amount}}</td>
<td> {{$payment->status}} </td>
<td>
@if ($payment->status == 'completed') <form action="/payments/{{$payment->number}}/refund_request" method="POST">{{ method_field('PUT') }}<input type="submit" value="退款" class="btn btn-default" /></form>
@endif
@if ($payment->subscription->agreement_id && $payment->subscription->status != 'canceled') 
<form action="/subscription/{{$payment->subscription->id}}/cancel" method="POST"><input type="submit" value="取消订阅" class="btn btn-default" /></form>
@endif
</td>
</tr>
@endforeach
</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
