<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $voucher }}</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 30px;
            color: #333;
            background-color: #fff;
        }

        /* Invoice Container */
        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #eee;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .company-info h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
            text-transform: uppercase;
        }

        .company-info p {
            margin: 2px 0;
            font-size: 13px;
            color: #777;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 28px;
            color: #333;
            letter-spacing: 2px;
        }

        /* Details Section */
        .details-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .bill-to p,
        .invoice-meta p {
            margin: 4px 0;
            font-size: 14px;
        }

        .label {
            color: #777;
            font-weight: bold;
            width: 100px;
            display: inline-block;
        }

        /* Table Design */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead tr {
            background-color: #2c3e50;
            color: #ffffff;
        }

        th {
            padding: 12px;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .text-end {
            text-align: right;
        }

        /* Totals Section */
        .totals-section {
            margin-top: 20px;
            float: right;
            width: 300px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .grand-total {
            border-top: 2px solid #333;
            margin-top: 5px;
            padding-top: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #2c3e50;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        /* Print Settings */
        @media print {
            body {
                padding: 0;
            }

            .invoice-box {
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>

<body onload="handlePrint()">

    <div class="invoice-box">
        <div class="header">
            <div class="company-info">
                <h1>{{ $comapnyInfo->title }}</h1>
                <p>Address: </p>
                <p>Phone: {{ $comapnyInfo->system_name }}</p>
                <p>Email: {{ $comapnyInfo->email }}</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
            </div>
        </div>

        <div class="details-container">
            <div class="bill-to">
                <p><strong>Bill To:</strong></p>
                <p>Customer</p>

            </div>
            <div class="invoice-meta">
                <p><span class="label">Voucher:</span> #{{ $voucher }}</p>
                <p><span class="label">Date:</span> {{ \Carbon\Carbon::parse($transactions->first()->in_date)->format('d M, Y') }}</p>
                <p><span class="label">Status:</span> PAID/DUE</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product Description</th>
                    <th class="text-end">Unit Price</th>
                    <th class="text-end">Qty</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>{{ $t->product->name }}</td>
                    <td class="text-end">{{ number_format($t->total_price / $t->quantity, 2) }}</td>
                    <td class="text-end">{{ $t->quantity }}</td>
                    <td class="text-end">{{ number_format($t->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>{{ number_format($grandTotal, 2) }}</span>
            </div>
            <div class="total-row grand-total">
                <span>Grand Total:</span>
                <span>{{ number_format($grandTotal, 2) }}</span>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice and requires no signature.</p>
        </div>
    </div>

<script>
    function handlePrint() {
        window.print();

        // প্রিন্ট পপআপ বন্ধ করলে বা প্রিন্ট শেষ হলে এই ইভেন্ট কাজ করবে
        window.onafterprint = function() {
            // আপনার স্টক আউট ইনডেক্স রাউটের URL এখানে দিন
            window.location.href = "{{ route('stockOut.index') }}"; 
        };

        // কিছু ব্রাউজারে onafterprint কাজ না করলে ব্যাকআপ হিসেবে এটি কাজ করবে
        setTimeout(function() {
            // যদি ২ সেকেন্ডের মধ্যে পেজ রিডাইরেক্ট না হয়
            if(document.hasFocus()){
                 window.location.href = "{{ route('stockOut.index') }}";
            }
        }, 3000);
    }
</script>

</body>

</html>