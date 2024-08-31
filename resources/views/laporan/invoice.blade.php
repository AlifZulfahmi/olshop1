<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Invoice #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .container {
            max-width: 700px;
            /* Kurangi lebar maksimum untuk menyesuaikan halaman */
            margin: auto;
            border: 1px solid #ddd;
            padding: 10px;
            /* Kurangi padding untuk menghemat ruang */
            background-color: #fff;
        }

        .logo {
            max-width: 80px;
            /* Kurangi ukuran logo */
            margin-bottom: 10px;
        }

        .invoice-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            /* Kurangi padding untuk menghemat ruang */
            margin-bottom: 10px;
        }

        .invoice-header .details {
            text-align: right;
        }

        .invoice-header h1 {
            font-size: 20px;
            /* Kurangi ukuran font untuk menghemat ruang */
            margin: 0;
        }

        .invoice-header p {
            margin: 3px 0;
            font-size: 14px;
            /* Kurangi ukuran font untuk menghemat ruang */
        }

        .line {
            border-top: 1px solid #000;
            margin: 10px 0;
            /* Kurangi margin untuk menghemat ruang */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            /* Kurangi margin untuk menghemat ruang */
            page-break-inside: avoid;
            /* Hindari tabel terpecah antara halaman */
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 5px;
            /* Kurangi padding untuk menghemat ruang */
            text-align: center;
            font-size: 14px;
            /* Kurangi ukuran font untuk menghemat ruang */
        }

        .table th {
            background-color: #f4f4f4;
        }

        .total-box {
            text-align: center;
            border: 2px solid #000;
            padding: 5px;
            /* Kurangi padding untuk menghemat ruang */
            margin: 10px 0;
            /* Kurangi margin untuk menghemat ruang */
            font-size: 16px;
            /* Kurangi ukuran font untuk menghemat ruang */
        }

        .status {
            font-weight: bold;
            margin-top: 10px;
            /* Kurangi margin untuk menghemat ruang */
            font-size: 14px;
            /* Kurangi ukuran font untuk menghemat ruang */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-header">
            <img src="{{ public_path('assets/img/shop_logo.png') }}" alt="Shop Logo" class="logo">
            <div class="details">
                <h1>Invoice #{{ $transaction->id }}</h1>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaction->created_at)->format('d F Y') }}</p>
                <p><strong>Custemer:</strong> {{ Auth::user()->name }}</p>
            </div>
        </div>

        <div class="line"></div>

        <h3>Detail Produk</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Total</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $transaction->product->name }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ 'Rp. ' . number_format($transaction->product->price, 0, ',', '.') }}</td>
                    <td>{{ 'Rp. ' . number_format($transaction->quantity * $transaction->product->price, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="total-box">
            <p><strong>Total Pembayaran:</strong>
                {{ 'Rp. ' . number_format($transaction->quantity * $transaction->product->price, 0, ',', '.') }}</p>
        </div>

        <div class="status">
            <p><strong>Status Transaksi:</strong> {{ ucfirst($transaction->status) }}</p>
        </div>
    </div>
</body>

</html>
