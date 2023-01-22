# Bkash Payment Gateway for PHP/Laravel Framework

[![Downloads](https://img.shields.io/packagist/dt/karim007/laravel-bkash)](https://packagist.org/packages/karim007/laravel-bkash)
[![Starts](https://img.shields.io/packagist/stars/karim007/laravel-bkash)](https://packagist.org/packages/karim007/laravel-bkash)

## Features

This is a php/laravel wrapper package for [Bkash](https://developer.bka.sh/)

## Requirements

- PHP >=7.4
- Laravel >= 6


## Installation

```bash
composer require karim007/laravel-bkash
```

### vendor publish (config)

```bash
php artisan vendor:publish --provider="Karim007\LaravelBkash\BkashServiceProvider"
```

After publish config file setup your credential. you can see this in your config directory bkash.php file

```
"sandbox"         => env("BKASH_SANDBOX", true),
"bkash_app_key"     => env("BKASH_APP_KEY", "5nej5keguopj928ekcj3dne8p"),
"bkash_app_secret" => env("BKASH_APP_SECRET", "1honf6u1c56mqcivtc9ffl960slp4v2756jle5925nbooa46ch62"),
"bkash_username"      => env("BKASH_USERNAME", "testdemo"),
"bkash_password"     => env("BKASH_PASSWORD", "test%#de23@msdao"),
"callbackURL"     => env("BKASH_CALLBACK_URL", "http://127.0.0.1:8000"),
'timezone'        => 'Asia/Dhaka', 
```

### Set .env configuration

```
BKASH_SANDBOX=true  #for production use false
BKASH_APP_KEY=""
BKASH_APP_SECRET=""
BKASH_USERNAME=""
BKASH_PASSWORD=""
BKASH_CALLBACK_URL=""
```

## Usage
### 1. create a controller
```
php artisan make:controller BkashPaymentController
```

### 2. you can override the routes (routes must be in authenticate bkash prefer it)
```
Route::group(['middleware' => ['auth']], function () {

    // Payment Routes for bKash
    Route::get('/bkash/payment', [BkashPaymentController::class,'index']);
    Route::post('/bkash/get-token', [BkashPaymentController::class,'getToken'])->name('bkash-get-token');
    Route::post('/bkash/create-payment', [BkashPaymentController::class,'createPayment'])->name('bkash-create-payment');
    Route::post('/bkash/execute-payment', [BkashPaymentController::class,'executePayment'])->name('bkash-execute-payment');
    Route::get('/bkash/query-payment', [BkashPaymentController::class,'queryPayment'])->name('bkash-query-payment');
    Route::post('/bkash/success', [BkashPaymentController::class,'bkashSuccess'])->name('bkash-success');

    // Refund Routes for bKash
    Route::get('/bkash/refund', [BkashPaymentController::class,'refundPage'])->name('bkash-refund');
    Route::post('/bkash/refund', [BkashPaymentController::class,'refund'])->name('bkash-refund');

});
```

### 3. you can also override the methods

#must be included in your controller
```
use Karim007\LaravelBkash\Facade\BkashPayment;
use Karim007\LaravelBkash\Facade\BkashRefund;
```

### 4. payment page
```
public function index()
{
    return view('bkash::bkash-payment');
}
```

### 4. grand token get
```
public function getToken()
{
    session()->put('invoice_amount',100);
    return BkashPayment::getToken();
}
```


### 4. create payment

```
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
```

### 5. execute payment

```
public function executePayment(Request $request)
{
    $paymentID = $request->paymentID;
    return BkashPayment::executePayment($paymentID);
}

```

### 6. query payment

```
public function queryPayment(Request $request)
{
    $paymentID = $request->payment_info['payment_id'];
    return BkashPayment::queryPayment($paymentID);
}

```

### 7. success

```
public function bkashSuccess(Request $request)
{
    $pay_success = $request->payment_info['transactionStatus'];
    return BkashPayment::bkashSuccess($pay_success);
}

```

### 8. refundPage

```
public function refundPage()
{
    return BkashRefund::index();
}

```

### 9. refund

```
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

```

#### Required APIs
0. **Developer Portal** (detail Product, workflow, API information): https://developer.bka.sh/docs/checkout-process-overview
1. **Grant Token :** https://developer.bka.sh/v1.2.0-beta/reference#gettokenusingpost
2. **Create Payment :** https://developer.bka.sh/v1.2.0-beta/reference#createpaymentusingpost
3. **Execute Payment :** https://developer.bka.sh/v1.2.0-beta/reference#executepaymentusingpost
4. **Query Payment :** https://developer.bka.sh/v1.2.0-beta/reference#querypaymentusingget
5. **Search Transaction Details :** https://developer.bka.sh/v1.2.0-beta/reference#searchtransactionusingget

### Checkout Demo
1. Go to https://merchantdemo.sandbox.bka.sh/frontend/checkout/version/1.2.0-beta
2. **Wallet Number:** 01770618575
3. **OTP:** 123456
4. **Pin:** 12121

Contributions to the Bkash Payment Gateway package are welcome. Please note the following guidelines before submitting your pull
request.

- Follow [PSR-4](http://www.php-fig.org/psr/psr-4/) coding standards.
- Read Nagad API documentations first. Please contact with Nagad for their api documentation and sandbox access.

## License

This repository is licensed under the [MIT License](http://opensource.org/licenses/MIT).

Copyright 2022 [md abdul karim](https://github.com/karim-007). We are not affiliated with Nagad and don't give any guarantee. 
