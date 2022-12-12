<?php

return [
    "sandbox"         => env("BKASH_SANDBOX", true),
    "bkash_app_key"     => env("BKASH_APP_KEY", "5nej5keguopj928ekcj3dne8p"),
    "bkash_app_secret" => env("BKASH_APP_SECRET", "1honf6u1c56mqcivtc9ffl960slp4v2756jle5925nbooa46ch62"),
    "bkash_username"      => env("BKASH_USERNAME", "testdemo"),
    "bkash_password"     => env("BKASH_PASSWORD", "test%#de23@msdao"),
    "callbackURL"     => env("BKASH_CALLBACK_URL", "http://127.0.0.1:8000"),
    'timezone'        => 'Asia/Dhaka',
];
