<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Финансовая статистика</h1>
        <hr>

        <div class="row">
            <!-- Общее состояние -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Текущий баланс</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($balance, 2) }} ₽</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Общий доход</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($totalIncome, 2) }} ₽</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Общий расход</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($totalExpense, 2) }} ₽</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Диаграммы -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Доходы и расходы по категориям</h4>
                <canvas id="categoryChart"></canvas>
            </div>
            <div class="col-md-6">
                <h4>График доходов и расходов по времени</h4>
                <canvas id="timeChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Подготовка данных для диаграммы категорий
        const categoryLabels = {!! json_encode($categories->pluck('description')) !!};
        const categoryData = {!! json_encode($categories->pluck('total')) !!};

        const categoryChart = new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Сумма по категориям',
                    data: categoryData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
                }]
            }
        });

        // Подготовка данных для графика по времени
        const timeLabels = {!! json_encode($transactionsByDate->pluck('date')) !!};
        const incomeData = {!! json_encode($transactionsByDate->pluck('total_income')) !!};
        const expenseData = {!! json_encode($transactionsByDate->pluck('total_expense')) !!};

        const timeChart = new Chart(document.getElementById('timeChart'), {
            type: 'line',
            data: {
                labels: timeLabels,
                datasets: [
                    {
                        label: 'Доход',
                        data: incomeData,
                        borderColor: '#4BC0C0',
                        fill: false
                    },
                    {
                        label: 'Расход',
                        data: expenseData,
                        borderColor: '#FF6384',
                        fill: false
                    }
                ]
            }
        });
    </script>
</body>
</html>
