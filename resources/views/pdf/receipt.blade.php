<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $transaction->transaction_id }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 5px 0;
            font-size: 24px;
        }
        .info {
            margin-bottom: 25px;
            width: 100%;
        }
        .info table {
            border: none;
        }
        .info td {
            border: none;
            padding: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #f4f4f4;
            padding: 10px;
            text-align: left;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .total-section {
            float: right;
            width: 300px;
            margin-top: 10px;
        }
        .total-row {
            width: 100%;
            margin-bottom: 5px;
        }
        .label {
            display: inline-block;
            width: 120px;
            text-align: left;
            color: #666;
        }
        .value {
            display: inline-block;
            width: 170px;
            text-align: right;
            font-weight: bold;
        }
        .grand-total {
            border-top: 1px solid #000;
            margin-top: 10px;
            padding-top: 10px;
            font-size: 16px;
        }
        .footer {
            clear: both;
            text-align: center;
            margin-top: 80px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        @if(file_exists(public_path('images/logos/logo.png')))
            <img src="{{ public_path('images/logos/logo.png') }}" style="width: 70px; height: auto;">
        @endif
        <h1>ALTAR COMPUTER</h1>
        <p style="margin:2px 0; font-family: monospace;">#{{ $transaction->transaction_id }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120"><strong>Date</strong></td>
                <td>: {{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><strong>Customer</strong></td>
                <td>: {{ $transaction->customer_name }}</td>
            </tr>
            <tr>
                <td><strong>Phone</strong></td>
                <td>: {{ $transaction->customer_phone }}</td>
            </tr>
            <tr>
                <td><strong>Address</strong></td>
                <td>: {{ $transaction->customer_address }}</td>
            </tr>
            <tr>
                <td><strong>Payment</strong></td>
                <td>: {{ strtoupper($transaction->payment_method) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product Description</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong><br>
                        <small style="color: #666;">{{ $item->category }}</small>
                    </td>
                    <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span class="label">Subtotal</span>
            <span class="value">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span class="label">Tax (11%)</span>
            <span class="value">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
        </div>
        <div class="total-row grand-total">
            <span class="label" style="color:#000;">TOTAL</span>
            <span class="value" style="font-size: 18px;">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
        </div>

        @if($transaction->payment_method === 'cash')
            <div class="total-row" style="margin-top: 15px;">
                <span class="label">Cash Paid</span>
                <span class="value">Rp {{ number_format($transaction->cash_amount, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span class="label">Change</span>
                <span class="value">Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>

    <div class="footer">
        <p>This receipt is a valid proof of purchase.</p>
        <p><strong>Thank you for choosing ALTAR! Build your dream with us.</strong></p>
        <p style="margin-top: 10px;">{{ date('Y') }} Altar Part & Computer POS System</p>
    </div>

</body>
</html>
