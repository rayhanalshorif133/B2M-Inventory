<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product's Barcode</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Barcode Generator Library -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode/dist/JsBarcode.all.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Product Barcodes</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Barcode</th>
                        <th scope="col">Scan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productAttribute as $index => $item)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $item->code }}</td>
                            <td>
                                <svg id="barcode-{{ $index }}"></svg>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        JsBarcode("#barcode-{{ $index }}", "{{ $item->code }}", {
                                            format: "CODE128",
                                            displayValue: true,
                                            fontSize: 14
                                        });
                                    });
                                </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
