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
</head>

<body>
    <div id="item_invoice_app" style="width: fit-content" class="justify-center mx-auto">
        <div class="main_content_width" class="justify-center mx-auto">
            <div class="sm:px-3 md:px-4 xl:px-5">
                <div class="flex justify-between w-full">
                    <div class="flex mt-2 space-x-3">
                        @php
                            $imageUrl = $item->company->logo;
                            $imageUrl = str_replace('\/', '/', $imageUrl);
                        @endphp
                        <img src="{{ asset($imageUrl)}}" alt="company logo" class="w-auto h-14 mt-2" />
                        <div class="space-y-2">
                            <h1 class="text-xl font-bold">
                                {{ $item->company->name }}
                                <div class="w-auto h-px bg-blue-400"></div>
                            </h1>
                            <h2 class="text-xs font-semibold">
                                {{ $item->company->address }}
                            </h2>
                            <h2 class="text-xs font-semibold">
                                {{ $item->company->email }}
                            </h2>
                            <h2 class="text-xs font-semibold">
                                {{ $item->company->phone }}
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
                        <a href="/{{ $type }}/list"
                            class="px-3 py-2 mx-1 font-semibold text-white bg-red-600 w-fit h-fit rounded-md cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="posPrint_contianer hidden" class="space-x-3 mt-2 print:hidden">
                    <a
                        class="invoicePrint mx-1 px-3 py-1 text-sm font-semibold text-white bg-gray-600 w-fit h-fit rounded-md cursor-pointer">
                        <i class="fa-solid fa-print"></i> {{ $invoice_name }}
                    </a>
                    <a
                        class="posPrinter mx-1 px-3 py-1 text-sm font-semibold text-white bg-green-600 w-fit h-fit rounded-md cursor-pointer">
                        <i class="fa-solid fa-print"></i> Pos
                    </a>
                    <a class="mx-1 px-3 py-1 text-sm font-semibold text-white bg-red-600 w-fit h-fit rounded-md cursor-pointer"
                        href="/{{ $type }}/list">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div>
                <h2 class="hiddenClassPos"
                    class="text-base font-bold mt-3 pl-[5.5rem] py-2 border-2 mx-auto text-center border-gray-700 border-dotted">
                    {{ $invoice_name }}
                </h2>
                <div class="flex justify-between" class="marginTopClass">
                    <div>
                        <p class="text-sm font-normal">From</p>
                        @if($item->customer)
                        <p class="text-sm font-semibold">{{ $item->customer->name }}</p>
                        <p class="text-sm font-normal">{{ $item->customer->address }}</p>
                        <p class="text-sm font-normal">Phone: {{ $item->customer->contact }}</p>
                        @else
                        <p class="text-sm font-semibold">{{ $item->supplier->name }}</p>
                        <p class="text-sm font-normal">{{ $item->supplier->address }}</p>
                        <p class="text-sm font-normal">Phone: {{ $item->supplier->contact }}</p>
                        @endif
                    </div>
                    <div class="hiddenClass">
                        <h2 class="text-2xl font-bold mt-3 px-5 py-2 border-2 border-gray-700 border-dotted">
                            {{ $invoice_name }}
                        </h2>
                    </div>
                    <div class="mt-2 text-right">
                        <p class="text-sm font-semibold">
                            Invoice: {{ $item->code }}
                        </p>
                        <p class="text-sm font-normal">
                            Generated By: {{ $item->createdBy->name }}
                        </p>
                        <p class="text-sm font-normal">
                            Generated at: {{ $item->invoice_date }}
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
                            @foreach ($itemDetails as $index => $itemDetail)
                                <tr class="px-3 border-b-2 border-t-2 w-full">
                                    <td class="p-2 text-right">{{ $index + 1 }}</td>
                                    <td class="p-2 text-right">
                                        {{ $itemDetail->name }} <br />
                                        {{ $itemDetail->model }} ::
                                        {{ $itemDetail->size }} ::
                                        {{ $itemDetail->color }}
                                    </td>
                                    <td class="p-2 text-right">
                                        {{ $itemDetail->qty }}
                                    </td>
                                    <td class="p-2 text-right">
                                        Tk. {{ $itemDetail->sales_rate }}
                                    </td>
                                    <td class="p-2 text-right">
                                        Tk. {{ $itemDetail->discount }}
                                    </td>
                                    <td class="p-2 text-right">Tk. {{ $itemDetail->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="px-3">
                                <td class="p-2 text-justify" colspan="3" rowspan="3">
                                    <span class="pr-10 text-base font-bold">Note:</span>
                                    <span class="text-right">{{ $item->note }}</span>
                                </td>
                                <td class="text-right" colspan="3">
                                    <span class="pr-10 text-base font-bold">Sub total:</span>
                                    Tk. {{ $item->total_amount }}
                                    <br />
                                    <span class="pr-10 text-base font-bold">Final Discount:</span>
                                    Tk. {{ $item->discount }}
                                    <br/>
                                    <span class="pr-10 text-base font-bold">Total Amount:</span>
                                    Tk. {{ $item->grand_total }}
                                </td>
                            </tr>
                            <tr class="px-3">
                                <td class="p-2 text-right" colspan="3">
                                    <div class="flex justify-end">
                                        <div class="pr-10">
                                            <p class="font-bold">Paid Amount:</p>
                                            <p class="text-end font-normal">
                                                {{ $payment->transactionType->name }}
                                            </p>
                                            <p class="font-normal text-end">
                                                {{ $payment->created_date }}
                                            </p>
                                        </div>
                                        <p>Tk. {{ $item->paid_amount }}</p>
                                    </div>
                                </td>
                            </tr>
                            <tr class="px-3">
                                <td class="p-2 text-right" colspan="3">
                                    <span class="pr-10 text-base font-bold">Due amount:</span>
                                    Tk. {{ $item->due_amount }}
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
                                        Paid By : {{ $item->createdBy->name }}
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
