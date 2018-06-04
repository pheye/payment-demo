<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yansongda\Pay\Pay;
use Log;

class HomeController extends Controller
{
    protected $config = [
        'app_id' => '2018051760159810',
        'notify_url' => 'http://abc.tunnel.papamk.com/onNotify',
        'return_url' => 'http://abc.tunnel.papamk.com/onReturn',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjFcrd6p+oy7wfCZBjaUBL8YOkwxCYSnV+M6x/mi37EOpxwkWWQjm50RvSpTNYgoUkPX2HMtwDurvVvcT/YN+RM8mR6uLcNz/s+rMnDMKhgF6tfflkyxBFeIXolcwP0BKHA8LPHAaQzQN6ILPpABOdPflz1KlU/LBOtikZGKf3MH03LOBwQNoAeYNcfjMHM7AFTnTdeIqe9LPZEc9cLBzZgb8xB+oeuZE97kEA6lYgpI73l0Pqjag3Y/LeFjLO1RL1Z0puM/aRV4CHnEG6BHQGVoQtvrVwxdry1R8XYGYWjE2zse+U7DdTHCQKYA4JUcJVLYRd6WY8UM+Z+P1srGakwIDAQAB',
        'private_key' => 'MIIEpAIBAAKCAQEAwXVJ4AQ7L8OVPU+dG4hSI720Twx4IRKja9w3hpcMfB0ptUVckg2qo9qgI3Irq2eW69ApDwXe101oY2hf9dR/vw3VqoLvTBbFg2ouMCTOmO12eqPGQCf4P2sE2DRAte/Gj9xPgaNfz4kwQaUKF5kz3pLEtSrqegtJ+waVqg/wW3gS9n0TIAyVfkF1JJESTUvxHjyJnkLYc4SE/3yGgPYo1FgIH0c4vH0gt+5/vGNt2NeXqvNTwVZnI+yUq0mFEPrulSl/jxf939lIpG7wM4rXllEScbCm67UaEesUwVKlgLEau1dSGaw5O26CPFW3Q//J2lmxDi/pgZ/GuPLpAkQMdQIDAQABAoIBAQCBGpzqeuhkv8lg2Tinnxnx8C/ccR3aNG4LFTOZBkS2r1+eMWPNtIEkSEqGXTL3eHInfQtpkylb1bTMYmNn0yBNiBYHbMn1pVy6jqm0R1v4gsCGp7UuK35oFCtvfa+Ruypv5z7H7ReLkKo7pMBPb1ZGOvw7SyCfwdjlRUer7mchIp+d6GPhqCa1JueZ+ROOdNVv435K1mHdwUp6G931/wewh8DxYs3s+VrRBapzmAbPHZM1syzxkjMnFF2zr4PIcaO6ilMfJm8CaHtSEQEjCKtKdexN/xxOa61XeYN4e1JM0sng7yRSAJIZ//i65G3O+mVcT6cs0pfnAsEfYB1SlywhAoGBAOT+6pn2CO6q8fiuckcZ1QU4dZX5QFfEK4lc3Rd276yOuzWbXGxnSlJvUVbRoq2vIKutmQhvxezbI2L1epBNIGojo7wvygQp5n//oXfO8wi0Nswy9KPXg2P4RCwnsRwGDL2bQMzb4RG2u0PerwFCgo47ynE2Bn3fsVfL/xm3SJijAoGBANhFicDL6pjvC7NWOj+dPj0dHtsGDbamzoQRSIYFIEzi2+ONrpVcIgsM6Eu/nH4wholao+/KwZIohnxB7elW80+ZSh6409zoVimnNle7NhdaKJBNLw0RPoUN87vGi2suePaZvK05dPhBZgLJLmjo23gUcGrOCXUJBxAu7G40tqAHAoGBAItv9aZePD4n9UM55fgJcL7HDEKQDW/j0abI1w+MqpBmMPSJb5PKqWTcx6iX6fjcZIZlJIQQm3KIVVnSpBjt/cjjfrX+W4KBiQtzuvxbFX29Toi0lmaVujnLWKeSW7P2sxdZS/HyCXBh1lGTbPjVaO321mRtQzKuXSxa2TDte9UFAoGAO+on242ilHPFHg3JXU5Gq8+heLQYoH1dwSC4oshQxnwixsu9jgtUMxOEV1fiFuOCohLGT+wv7Dnl6A6rxnUcOvUQn6o8p3qGREvatjtbJOUJT9DSNCCO3XWcDG1YunzJbifxKVw9l3kmtabegJniE0Y2TqB95jp2Bnm5bl6UKYkCgYBXyP9NcL5iLOaqcEGffnS5vcdn+hgQ7cXX6U5vNjfV21jaucmHcMtt4d9ebQK1dki+d5lumUl9n9VHFlxi345OcvnosnL1BB+d+k7s2STUHSVqWRGPRwEhJXFSN+/nnzvH9baNIaf5ScAo2l+BPJvhEV+FDJDpT+88UhkMrFG08g==',
        'log' => [ // optional
            'file' => './alipay.log',
            'level' => 'debug'
        ],
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = \Pheye\Payments\Models\Plan::all();
        $payments = Auth()->user()->payments;
        return view('home')->with(['plans' => $plans, 'payments' => $payments]);
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
