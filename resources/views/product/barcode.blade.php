@extends('layouts.app', ['title' => 'Product Barcode'])


@section('head')

@endsection


@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Barcode</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Product Barcode</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Product's Barcode List</h3>

                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="productSelect">Select Product</label>
                                    <select id="productSelect" class="product-select custom-select" style="width: 100%;">
                                        @foreach ($productAttribute as $item)
                                            <option data-name="{{ $item->product->name }}" data-code="{{ $item->code }}"
                                                value="{{ $item->id }}">{{ $item->product->name }} - {{ $item->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="card p-3">
                                    <form class="selectedProductContainer" action="{{ route('product.barcode') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody class="insertSelectedProduct"></tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>

                            </div>
                            <div class="col-12 col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#productSelect').select2({
                placeholder: "Choose a product", // Placeholder text
                allowClear: true // Adds a clear button
            });

            $('#productSelect').on('change', function() {
                const selectedOption = $(this).find(':selected'); // Get the selected option
                const productId = selectedOption.val(); // Get value attribute
                const productName = selectedOption.data('name'); // Get data-name attribute
                const productCode = selectedOption.data('code'); // Get data-code attribute
                const html = `
                    <tr>
                        <td>${productName}</td>
                        <td>${productCode}</td>
                        <td>
                            <input type="text" class="form-control mx-2 d-none" name="selectedProducts[${productId}][id]" value="${productId}">
                            <input type="text" class="form-control mx-2 d-none" name="selectedProducts[${productId}][code]"
                            value="${productCode}">
                            <input type="number" class="form-control mx-2 px-2" name="selectedProducts[${productId}][count]" value="1">
                        </td>
                    </tr>
                `;

                // Append the row to an existing table body
                $(".insertSelectedProduct").append(html);
            });
        });
    </script>
@endpush
