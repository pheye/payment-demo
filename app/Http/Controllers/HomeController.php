<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yansongda\Pay\Pay;
use Log;
use Auth;

class HomeController extends Controller
{
    protected $config = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->config = [
        'app_id' => env('ALIPAY_APPID'),
        'notify_url' => 'http://abc.tunnel.papamk.com/onNotify',
        'return_url' => 'http://abc.tunnel.papamk.com/onReturn',
        'ali_public_key' => env('ALIPAY_PUBLICK_KEY'),
        'private_key' => env('ALIPAY_PRIVATE_KEY'),
        'log' => [ // optional
            'file' => './alipay.log',
            'level' => 'debug'
        ],
    ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = \Pheye\Payments\Models\Plan::all();
        $payments = Auth()->user()->payments()->orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        return view('home')->with(['plans' => $plans, 'payments' => $payments, 'user' => $user]);
    }

    public function pay()
    {
        $order = [
            'out_trade_no' => time(),
            'total_amount' => '0.01',
            'subject'      => 'test subject',
        ];

        $alipay = Pay::alipay($this->config)->web($order);

        return $alipay->send();
    }

    public function onReturn ()
    {
        $data = Pay::alipay($this->config)->verify();
        Log::info('data', ['data' => $data]);
    }

    public function onNotify()
    {
        $alipay = Pay::alipay($this->config);
    
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况

            Log::info('Alipay notify', ['data' => $data->all()]);
        } catch (Exception $e) {
            Log::info('message:' . $e->getMessage());
        }

        return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
    }
}
