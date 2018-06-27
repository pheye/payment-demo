<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Pheye\Payments\Models\Payment;
use Pheye\Payments\Events\PayedEvent;
use Pheye\Payments\Events\RefundedEvent;
use Pheye\Payments\Events\CancelledEvent;
use Log;

class PaymentEventSubscriber extends \Pheye\Payments\Listeners\PaymentEventSubscriber
{

    /**
     * 处理支付完成事件
     */
    public function onPayed(PayedEvent $event)
    {
        $payment = $event->payment;
        Log::info('on payed test ' . $payment->number);
    }

    /**
     * 处理退款完成事件
     */
    public function onRefunded(RefundedEvent $event)
    {
        $refund = $event->refund;
        Log::info('on refuned test '.  $refund->payment->number);
    }

    /**
     * 处理取消订阅事件
     */
    public function onCancelled(CancelledEvent $event)
    {
        $sub = $event->subscription;
        Log::info('on cancellead test '.  $sub->agreement_id);
    }
}
