<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Финансовая статистика</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .section {
            margin-bottom: 20px;
        }
        .chart {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Финансовая статистика</h1>

    <div class="section">
        <h2>Общая информация</h2>
        <p><strong>Общий доход:</strong> {{ number_format($totalIncome, 2) }} ₽</p>
        <p><strong>Общий расход:</strong> {{ number_format($totalExpense, 2) }} ₽</p>
        <p><strong>Баланс:</strong> {{ number_format($balance, 2) }} ₽</p>
    </div>

    <div class="section">
        <h2>Доходы и расходы по категориям</h2>
        <ul>
            @foreach($categories as $category)
                <li>{{ $category->description }}: {{ number_format($category->total, 2) }} ₽</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <h2>Доходы и расходы по времени</h2>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Доход</th>
                    <th>Расход</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactionsByDate as $transaction)
                <tr>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ number_format($transaction->total_income, 2) }} ₽</td>
                    <td>{{ number_format($transaction->total_expense, 2) }} ₽</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

   
</body>
</html>
