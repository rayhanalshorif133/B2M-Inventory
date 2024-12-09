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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>



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
    </style>

    <title>Inovice</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>

<body>
    <div id="sales_invoice_app" style="width: fit-content" class="justify-center mx-auto">
        <div class="main_content_width" class="justify-center mx-auto">
            <div class="sm:px-3 md:px-4 xl:px-5">
                <div class="flex justify-between w-full">
                    <div class="flex mt-2 space-x-3">
                        <img src="{{ $sales->company->logo }}" alt="company logo" class="w-44 h-14 mt-2" />
                        <div class="space-y-2">
                            <h1 class="text-xl font-bold">
                                {{ $sales->company->name }}
                                <div class="w-auto h-px bg-blue-400"></div>
                            </h1>
                            <h2 class="text-xs font-semibold">
                                {{ $sales->company->address }}
                            </h2>
                            <h2 class="text-xs font-semibold">
                                {{ $sales->company->email }}
                            </h2>
                            <h2 class="text-xs font-semibold">
                                {{ $sales->company->phone }}
                            </h2>
                        </div>
                    </div>
                    <div class="invoicePrint_contianer" style="margin-top: 4.5rem" class="space-x-3 print:hidden">
                        <a
                            class="invoicePrint px-3 py-2 mx-1 font-semibold text-white bg-gray-600 w-fit h-fit rounded-md cursor-pointer">
                            <i class="fa-solid fa-print"></i> Invoice Print
                        </a>
                        <a
                            class="posPrinter px-3 py-2 mx-1 font-semibold text-white bg-green-600 w-fit h-fit rounded-md cursor-pointer">
                            <i class="fa-solid fa-print"></i> Pos Print
                        </a>
                        <a href="/sales/list"
                            class="px-3 py-2 mx-1 font-semibold text-white bg-red-600 w-fit h-fit rounded-md cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="posPrint_contianer hidden" class="space-x-3 mt-2 print:hidden">
                    <a
                        class="invoicePrint mx-1 px-3 py-1 text-sm font-semibold text-white bg-gray-600 w-fit h-fit rounded-md cursor-pointer">
                        <i class="fa-solid fa-print"></i> Invoice
                    </a>
                    <a
                        class="posPrinter mx-1 px-3 py-1 text-sm font-semibold text-white bg-green-600 w-fit h-fit rounded-md cursor-pointer">
                        <i class="fa-solid fa-print"></i> Pos
                    </a>
                    <a class="mx-1 px-3 py-1 text-sm font-semibold text-white bg-red-600 w-fit h-fit rounded-md cursor-pointer"
                        href="/sales/list">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div>
                <h2 class="hiddenClassPos"
                    class="text-base font-bold mt-3 pl-[5.5rem] py-2 border-2 mx-auto text-center border-gray-700 border-dotted">
                    Invoice
                </h2>
                <div class="flex justify-between" class="marginTopClass">
                    <div>
                        <p class="text-sm font-normal">From</p>
                        <p class="text-sm font-semibold">{{ $sales->customer->name }}</p>
                        <p class="text-sm font-normal">{{ $sales->customer->address }}</p>
                        <p class="text-sm font-normal">
                            Phone: {{ $sales->customer->contact }}
                        </p>
                    </div>
                    <div class="hiddenClass">
                        <h2 class="text-2xl font-bold mt-3 px-5 py-2 border-2 border-gray-700 border-dotted">
                            Invoice
                        </h2>
                    </div>
                    <div class="mt-2 text-right">
                        <p class="text-sm font-semibold">
                            Invoice: {{ $sales->code }}
                        </p>
                        <p class="text-sm font-normal">
                            Generated By: {{ $sales->createdBy->name }}
                        </p>
                        <p class="text-sm font-normal">
                            Generated at: {{ $sales->invoice_date }}
                        </p>
                    </div>
                </div>
                <div class="mt-5">
                    <table class="w-full mt-10">
                        <thead class="w-full">
                            <tr class="shadow-sm border-b-2 border-t-2 w-full">
                                <th class="p-2 text-right w-10">#</th>
                                <th class="p-2 text-right w-20">Particulars</th>
                                <th class="p-2 text-right w-10">Qty</th>
                                <th class="p-2 text-right w-20">Rate</th>
                                <th class="p-2 text-right w-20">Discount</th>
                                <th class="p-2 text-right w-20">Total</th>
                            </tr>
                        </thead>
                        <tbody class="px-2 w-full">
                            @foreach ($salesDetails as $index => $item)
                                <tr class="px-3 border-b-2 border-t-2 w-full">
                                    <td class="p-2 text-right">{{ $index + 1 }}</td>
                                    <td class="p-2 text-right">
                                        {{ $item->product->name }} <br />
                                        {{ $item->productAttribute->model }} ::
                                        {{ $item->productAttribute->size }} ::
                                        {{ $item->productAttribute->color }}
                                    </td>
                                    <td class="p-2 text-right">{{ $item->qty }}</td>
                                    <td class="p-2 text-right">
                                        Tk. {{ $item->sales_rate }}
                                    </td>
                                    <td class="p-2 text-right">
                                        Tk. {{ $item->discount }}
                                    </td>
                                    <td class="p-2 text-right">Tk. {{ $item->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="px-3">
                                <td class="p-2 text-justify" colspan="3" rowspan="3">
                                    <span class="pr-10 text-base font-bold">Note:</span>
                                    <span class="text-right">{{ $sales->note }}</span>
                                </td>
                                <td class="text-right" colspan="3">
                                    <span class="pr-10 text-base font-bold">Sub total:</span>
                                    Tk. {{ $sales->total_amount }}
                                </td>
                            </tr>
                            <tr class="px-3">
                                <td class="p-2 text-right" colspan="3">
                                    <div class="flex justify-end">
                                        <div class="pr-10">
                                            <p class="font-bold">Paid Amount:</p>
                                            <p class="text-end font-normal">
                                                {{ $salesPayment->transactionType->name }}
                                            </p>
                                            <p class="font-normal text-end">
                                                {{ $salesPayment->created_date }}
                                            </p>
                                        </div>
                                        <p>Tk. {{ $sales->paid_amount }}</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="px-3">
                                <td class="p-2 text-right" colspan="3">
                                    <span class="pr-10 text-base font-bold">Due amount:</span>
                                    Tk.
                                    {{ number_format($sales->total_amount - $sales->paid_amount, 2) }}
                                </td>
                            </tr>
                            <tr class="px-3">
                                <td class="pt-1 text-left px-2" colspan="3">
                                    <span class="text-left font-semibold">
                                        Print Date: {{ $print_date }}
                                    </span>
                                </td>
                                <td class="pt-1 text-right px-2" colspan="3">
                                    <span class="text-left font-semibold">
                                        Paid By : {{ $sales->createdBy->name }}
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(() => {
            $(".invoicePrint").click(() => {
                $('.main_content_width').addClass('max-width-content');
                $('.invoicePrint_contianer').addClass('hidden');
                $('.posPrint_contianer').addClass('hidden');
                setTimeout(() => {
                    $('.invoicePrint_contianer').removeClass('hidden');
                }, 500);
                printNow();
            });

            $(".posPrinter").click(() => {
                $('.main_content_width').addClass('pos-width-content');
                $('.invoicePrint_contianer').addClass('hidden');
                $('.posPrint_contianer').removeClass('flex').addClass('hidden');
                setTimeout(() => {
                    $('.posPrint_contianer').removeClass('hidden').addClass('flex');
                }, 500);
                $('.marginTopClass').addClass('mt-3');
                printNow();
            });
        });

        const printNow = () => {
            setTimeout(() => {
                window.print();
            }, 300);



        };
    </script>
</body>

</html>
