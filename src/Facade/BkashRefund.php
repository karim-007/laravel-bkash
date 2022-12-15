<?php

namespace Karim007\LaravelBkash\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static index()
 * @method static refund($post_fields)
 */
class BkashRefund extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'brefundPayment';
    }
}
