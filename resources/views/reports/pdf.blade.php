<!DOCTYPE html>
<html>

<head>
    <title>Stock Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <h1>Stock Report</h1>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Transaction Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->product->name }}</td>
                    <td>{{ ucfirst($report->type) }}</td>
                    <td>{{ $report->type == 'in' ? $report->quantity_in : $report->quantity_out }}</td>
                    <td>{{ $report->transaction_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
