<?php

namespace Karim007\LaravelBkash\Controllers;
use Illuminate\Http\Request;
use Karim007\LaravelBkash\Facade\BkashPayment;
use Karim007\LaravelBkash\Facade\BkashRefund;

class BkashPaymentController
{
    public function index()
    {
        return view('bkash::bkash-payment');
    }

    public function getToken()
    {
        session()->put('invoice_amount',100);
        return BkashPayment::getToken();
    }
    public function createPayment(Request $request)
    {
        $request['intent'] = 'sale';
        $request['currency'] = 'BDT';
        $request['amount'] = session()->get('invoice_amount') ??100;
        $request['merchantInvoiceNumber'] = rand();
        $request['callbackURL'] = config("bkash.callbackURL");;

        $request_data_json = json_encode($request->all());

        return BkashPayment::cPayment($request_data_json);
    }

    public function executePayment(Request $request)
    {
        $paymentID = $request->paymentID;
        return BkashPayment::executePayment($paymentID);
    }
    public function queryPayment(Request $request)
    {
        $paymentID = $request->payment_info['payment_id'];
        return BkashPayment::queryPayment($paymentID);
    }
    public function bkashSuccess(Request $request)
    {
        $pay_success = $request->payment_info['transactionStatus'];
        return BkashPayment::bkashSuccess($pay_success);
    }
    public function refundPage()
    {
        return BkashRefund::index();
    }
    public function refund(Request $request)
    {
        $this->validate($request, [
            'payment_id' => 'required',
            'amount' => 'required',
            'trx_id' => 'required',
            'sku' => 'required|max:255',
            'reason' => 'required|max:255'
        ]);

        $post_fields = [
            'paymentID' => $request->payment_id,
            'amount' => $request->amount,
            'trxID' => $request->trx_id,
            'sku' => $request->sku,
            'reason' => $request->reason,
        ];
        return BkashRefund::refund($post_fields);
    }
}
