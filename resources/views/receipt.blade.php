<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $transaction->transaction_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
            background-color: #2b2b2b;
        }

        .receipt-container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            font-size: 12px;
            color: #666;
        }

        .info {
            margin: 10px 0;
            font-size: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .address-section {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px dotted #666;
            font-size: 11px;
        }

        .address-label {
            font-weight: bold;
            color: #444;
            margin-bottom: 2px;
        }

        .address-content {
            line-height: 1.4;
            color: #333;
        }

        .items {
            margin: 15px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
        }

        .item {
            margin-bottom: 10px;
            font-size: 12px;
        }

        .item-header {
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            color: #444;
        }

        .totals {
            margin: 10px 0;
            font-size: 12px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .grand-total {
            font-size: 15px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 10px;
            margin-top: 10px;
        }

        .payment {
            margin: 15px 0;
            font-size: 12px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #666;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        .no-print {
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-print {
            background: #000;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-family: sans-serif;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <a href="{{ route('build') }}"
            style="display:inline-block; margin-left:10px; color:#fffafa; text-decoration:none; font-family:sans-serif; font-size:14px;">Kembali
            ke Rakit PC</a>
    </div>

    <div class="receipt-container">
        <div class="header">
            <div class="logo">ALTAR</div>
            <div class="subtitle">Part & Computer</div>
        </div>

        <div class="info">
            <div class="info-row">
                <span>Receipt:</span>
                <strong>{{ $transaction->transaction_id }}</strong>
            </div>
            <div class="info-row">
                <span>Date:</span>
                <span>{{ $transaction->transaction_date->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span>Customer:</span>
                <span>{{ $transaction->customer_name }}</span>
            </div>

            <div class="address-section">
                <div class="address-label">SHIP TO:</div>
                <div class="address-content">
                    {{ $transaction->customer_address }}
                </div>
            </div>
        </div>

        <div class="items">
            @foreach ($transaction->items as $item)
                <div class="item">
                    <span class="item-header">{{ $item->product_name }}</span>
                    <div class="item-detail">
                        <span>{{ $item->quantity }} x IDR {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span>IDR {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>IDR {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Tax (11%):</span>
                <span>IDR {{ number_format($transaction->tax, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>IDR {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="payment">
            <div class="total-row">
                <span>Payment Method:</span>

                <strong>{{ strtoupper(str_replace('_', ' ', $transaction->payment_method)) }}</strong>
            </div>

            @if ($transaction->payment_method === 'cash')
                <div class="total-row">
                    <span>Cash Paid:</span>
                    <span>IDR {{ number_format($transaction->cash_amount, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span>Change:</span>
                    <span>IDR {{ number_format($transaction->change, 0, ',', '.') }}</span>
                </div>
            @elseif($transaction->payment_method === 'credit_card' || $transaction->payment_method === 'e-wallet')
                <div class="total-row">
                    <span>Status:</span>
                    <span style="color: green; font-weight: bold;">PAID / LUNAS</span>
                </div>
            @endif
        </div>

        <div class="footer">
            Thank you for your purchase!<br />
            Visit us again at ALTAR Part & Computer
        </div>
    </div>
</body>

</html>
