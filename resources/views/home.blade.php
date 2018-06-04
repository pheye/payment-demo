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
      <input type="submit" value="Submit" />
    </form>  
</li>
@endforeach
</ul>

<ul>
@foreach ($payments as $payment)
<li>{{$payment->number}} : {{$payment->amount}} , {{$payment->status}}, <form action="/payments/{{$payment->number}}/refund_request" method="POST">{{ method_field('PUT') }}<input type="submit" value="退款"/></form></li>
@endforeach
</li>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
