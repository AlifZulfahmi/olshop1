<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $title }}</title>
    <style>
        @page {
            size: landscape;
            margin: 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 120px;
        }

        .header .details {
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 16px;
        }

        .line {
            border-top: 2px solid #000;
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('assets/img/shop_logo.png') }}" alt="Shop Logo">
            <div class="details">
                <h1>{{ $title }}</h1>
                <p>Olshop</p>
                <p>{{ $date }}</p>
            </div>
        </div>

        <div class="line"></div>

        {{-- Informasi Transaksi --}}
        @if ($transactions->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->product->name }}</td>
                            <td>{{ $transaction->quantity }}</td>
                            <td>{{ $transaction->status }}</td>
                            <td>{{ 'Rp. ' . number_format($transaction->product->price, 0, ',', '.') }}</td>
                            <td>{{ 'Rp. ' . number_format($transaction->quantity * $transaction->product->price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="total">Total Transaksi:
                {{ 'Rp. ' . number_format($transactions->sum(fn($t) => $t->quantity * $t->product->price), 0, ',', '.') }}
            </p>
        @else
            <p>Tidak ada transaksi ditemukan.</p>
        @endif
    </div>
</body>

</html>
