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
        <div class="row">
            @foreach ($products as $index => $item)
                @for ($i = 0; $i < $item['count']; $i++)
                    <div class="col-md-2 col-sm-2 col-2">
                        <svg id="barcode-{{ $index }}"></svg>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                JsBarcode("#barcode-{{ $index }}", "{{ $item['code'] }}", {
                                    format: "CODE128",
                                    displayValue: true,
                                    fontSize: 12,
                                    width: 1, // Adjust the line width for the barcode
                                    height: 20 // Adjust the height of the barcode
                                });
                            });
                        </script>
                    </div>
                @endfor
            @endforeach
        </div>
    </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
