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

        .max-width-content {
            max-width: 1140px !important;
        }

        .pos-width-content {
            max-width: 100% !important;
        }

        @page {
            width: 302px !important;
        }
    </style>

    <title>Inovice</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="sales_invoice_app" style="width: fit-content" class="justify-center mx-auto">
        <sales-return-invoice-component></sales-return-invoice-component>
    </div>

</body>

</html>
