<?php

namespace Karim007\LaravelBkash\Facade;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * @method static getToken()
 * @method static cPayment($request_data_json)
 * @method static executePayment($paymentID)
 * @method static queryPayment($paymentID)
 * @method static bkashSuccess($pay_success)
 */
class BkashPayment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bpayment';
    }
}
