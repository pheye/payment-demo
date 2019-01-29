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
<div>
    <div>
        当前计划： {{$user->subscription->getPlan()->display_name}}
    </div>
    <form action="/pay" method="post">
    <input type="hidden" name="plan_name" value="vip" /> 
    <input type="hidden" value="paypal_ec" name="gateway_name"/>
    <input type="hidden"  value="0" name="onetime"/>
    <input type="hidden"  value="1" name="upgrade"/>
    <input class="btn btn-primary" type="submit" value="升级VIP"/>
    </form>
</div>
<ul>
@foreach ($plans as $plan) 
<li>{{$plan->display_name}}: {{$plan->amount}} {{$plan->currency}}
    <form action="/pay" method="post" id="form_{{$plan->name}}">               
      <input type="text" name="plan_name" value="{{$plan->name}}" /> 
      <input type="text" class="text" value="paypal_ec" name="gateway_name"/>
      <input type="text" class="text" value="0" placeholder="0为循环扣款 1为一次性扣款" name="onetime"/>
      <input type="text" class="text" value="" placeholder="优惠码" name="coupon"/>
      @if ($plan->name == 'vip')
        @component('components.credit', ['formid' => "form_" . $plan->name ])
        @endcomponent
      @endif
      <input type="submit" value="Submit" class="btn btn-primary"/>
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
@if ($payment->subscription)
    {{$payment->subscription->agreement_id}} 
    @if ($payment->subscription->agreement_id) 
    <span class="text-danger">{{$payment->subscription->status}}</span>
    @endif
    <span>({{$payment->subscription->plan}})</span>
@else
  <span class="text-info">Onetime Payment</span>
@endif
</td>
<td><span class="text-primary">{{$payment->number}}</span> </td>
<td> {{$payment->amount}}</td>
<td> {{$payment->status}} </td>
<td>
@if ($payment->status == 'completed') <form action="/payments/{{$payment->number}}/refund_request" method="POST">{{ method_field('PUT') }}<input type="submit" value="退款" class="btn btn-default" /></form>
@endif
@if ($payment->subscription && $payment->subscription->agreement_id && $payment->subscription->status != 'canceled') 
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
