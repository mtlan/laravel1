<?php

return [

    /*
    |--------------------------------------------------------------------------
    | QR Code Default Format
    |--------------------------------------------------------------------------
    |
    | This option controls the default format for QR codes.
    |
    */

    'format' => env('QR_CODE_FORMAT', 'png'),

    /*
    |--------------------------------------------------------------------------
    | QR Code Default Size
    |--------------------------------------------------------------------------
    |
    | This option controls the default size for QR codes.
    |
    */

    'size' => env('QR_CODE_SIZE', 200),

    /*
    |--------------------------------------------------------------------------
    | QR Code Default Margin
    |--------------------------------------------------------------------------
    |
    | This option controls the default margin for QR codes.
    |
    */

    'margin' => env('QR_CODE_MARGIN', 0),

    /*
    |--------------------------------------------------------------------------
    | QR Code Default Error Correction
    |--------------------------------------------------------------------------
    |
    | This option controls the default error correction level for QR codes.
    | Options: L, M, Q, H
    |
    */

    'errorCorrection' => env('QR_CODE_ERROR_CORRECTION', 'M'),

    /*
    |--------------------------------------------------------------------------
    | QR Code Default Encoding
    |--------------------------------------------------------------------------
    |
    | This option controls the default encoding for QR codes.
    |
    */

    'encoding' => env('QR_CODE_ENCODING', 'UTF-8'),

    /*
    |--------------------------------------------------------------------------
    | QR Code Default Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default driver for QR codes.
    | Options: gd, imagick
    |
    */

    'driver' => env('QR_CODE_DRIVER', 'gd'),

];
