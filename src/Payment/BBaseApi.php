<?php

namespace Karim007\LaravelBkash\Payment;

use Karim007\LaravelBkash\Traits\Helpers;

class BBaseApi
{
    use Helpers;

    /**
     * @var string $baseUrl
     */
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl();
    }

    /**
     * bkash Base Url
     * if sandbox is true it will be sandbox url otherwise it is host url
     */
    private function baseUrl()
    {
        if (config("bkash.sandbox") == true) {
            $this->baseUrl = 'https://checkout.sandbox.bka.sh/v1.2.0-beta';
        } else {
            $this->baseUrl = 'https://checkout.pay.bka.sh/v1.2.0-beta';
        }
    }

    /**
     * bkash Request Headers
     *
     * @return array
     */
    protected function headers()
    {
        return [
            "Content-Type"     => "application/json",
            "X-KM-IP-V4"       => $this->getIp(),
            "X-KM-Api-Version" => "v-0.2.0",
            "X-KM-Client-Type" => "PC_WEB"
        ];
    }
}
