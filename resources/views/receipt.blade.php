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
        .items {
            margin: 15px 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
        }
        .item {
            margin: 8px 0;
            font-size: 12px;
        }
        .item-name {
            font-weight: bold;
        }
        .item-detail {
            display: flex;
            justify-content: space-between;
            color: #666;
            margin-top: 3px;
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
            font-size: 16px;
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
    </style>
</head>
<body>
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
        <div class="info-row">
            <span>Phone:</span>
            <span>{{ $transaction->customer_phone }}</span>
        </div>
    </div>

    <div class="items">
        @foreach($transaction->items as $item)
            <div class="item">
                <div class="item-name">{{ $item->product_name }}</div>
                <div class="item-detail">
                    <span>{{ $item->quantity }} x Rp {{ number_format($item->price / 1000, 0) }}K</span>
                    <span>Rp {{ number_format($item->subtotal / 1000, 0) }}K</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($transaction->subtotal / 1000, 0) }}K</span>
        </div>
        <div class="total-row">
            <span>Tax (11%):</span>
            <span>Rp {{ number_format($transaction->tax / 1000, 0) }}K</span>
        </div>
        <div class="total-row grand-total">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($transaction->total / 1000, 0) }}K</span>
        </div>
    </div>

    <div class="payment">
        <div class="total-row">
            <span>Payment Method:</span>
            <strong>{{ strtoupper($transaction->payment_method) }}</strong>
        </div>
        @if($transaction->payment_method === 'cash')
            <div class="total-row">
                <span>Cash:</span>
                <span>Rp {{ number_format($transaction->cash_amount / 1000, 0) }}K</span>
            </div>
            <div class="total-row">
                <span>Change:</span>
                <span>Rp {{ number_format($transaction->change / 1000, 0) }}K</span>
            </div>
        @endif
    </div>

    <div class="footer">
        Thank you for your purchase!<br/>
        Visit us again at ALTAR Part & Computer
    </div>
</body>
</html>
