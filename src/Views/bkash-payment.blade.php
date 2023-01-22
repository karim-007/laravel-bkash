<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@if(config("bkash.sandbox") == true)
<script id="myScript"
        src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
@else
{{--    This Commented Script for Live Production --}}
    <script id="myScript"
            src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
@endif

<button class="btn btn-success" id="bKash_button" onclick="BkashPayment()">
    Pay with bKash
</button>

@include('bkash::bkash-script')
