<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />


    <style>
        @print {
            #printBtn {
                display: none !important;
            }
        }
    </style>

    <title>Purchase Pay Slip</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="purchasePaySlipApp" class="max-w-[44rem] justify-center mx-auto">
        <purchase-pay-slip-component  :data="{{ $purchasePayment }}"></purchase-pay-slip-component>
    </div>
</body>

</html>
