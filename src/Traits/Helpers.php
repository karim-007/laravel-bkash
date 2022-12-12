<?php

namespace Karim007\LaravelBkash\Traits;

use Carbon\Carbon;

trait Helpers
{
    /**
     * @return string|null
     */
    public function getIp()
    {
        return request()->ip();
    }

    public function getUrlToken()
    {
        session()->forget('bkash_token');
        $post_token = array(
            'app_key' => config("bkash.bkash_app_key"),
            'app_secret' => config("bkash.bkash_app_secret")
        );

        $url = curl_init("$this->baseUrl/checkout/token/grant");
        $post_token = json_encode($post_token);

        $username = config("bkash.bkash_username");
        $password = config("bkash.bkash_password");

        $header = array(
            'Content-Type:application/json',
            "password:$password",
            "username:$username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        return $url;
    }

    public function getUrl($url, $method, $data=null)
    {
        $token = session()->get('bkash_token');
        $app_key = config("bkash.bkash_app_key");

        $url = curl_init($this->baseUrl.$url);
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        if ($data) curl_setopt($url, CURLOPT_POSTFIELDS, $data);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        return $url;
    }


}
