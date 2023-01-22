<?php

namespace Karim007\LaravelBkash\Payment;

use Karim007\LaravelBkash\Traits\Helpers;
use Illuminate\Support\Facades\Session;

class BPayment extends BBaseApi
{
    use Helpers;

    public function getToken()
    {
        $url = $this->getUrlToken();
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdata, true);

        if (array_key_exists('msg', $response)) {
            return $response;
        }

        session()->put('bkash_token', $response['id_token']);

        return response()->json(['success', true]);
    }

    public function cPayment($request_data_json)
    {
        /*if (((string) $request->amount != (string) session()->get('invoice_amount'))) {
            return response()->json([
                'errorMessage' => 'Amount Mismatch',
                'errorCode' => 2006
            ],422);
        }*/
        $url = $this->getUrl('/checkout/payment/create','POST',$request_data_json);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function executePayment($paymentID)
    {
        $url = $this->getUrl("/checkout/payment/execute/".$paymentID,'POST');
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function queryPayment($paymentID)
    {
        $url = $this->getUrl("/checkout/payment/query/".$paymentID,'GET');
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }
    public function bkashSuccess($pay_success)
    {
        if ($pay_success == 'Completed') {
            Session::flash('successMsg', 'Payment has been Completed Successfully');
            return response()->json(['status' => true,'message'=>'Payment has been Completed Successfully']);
        }

        Session::flash('error', 'Payment is not completed');

        return response()->json(['status' => false,'message'=>'Payment is not completed']);
    }

}
