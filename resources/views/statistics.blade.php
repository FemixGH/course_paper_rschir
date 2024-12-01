<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Финансовая статистика</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        h1 {
            font-size: 2.5rem;
        }
        .chart-container {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-success {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Финансовая статистика</h1>
            <a href="{{ route('home') }}" class="btn btn-secondary">На главную</a>
        </div>
        
        <hr class="mb-5">
        <form method="GET" action="{{ route('statistics') }}" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Начальная дата</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Конечная дата</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Применить</button>
                </div>
            </div>
        </form>
        

        <!-- Карточки общей информации -->
        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm mb-3">
                    <div class="card-header">Текущий баланс</div>
                    <div class="card-body">
                        <h5 class="card-title fs-3">{{ number_format($balance, 2) }} ₽</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary shadow-sm mb-3">
                    <div class="card-header">Общий доход</div>
                    <div class="card-body">
                        <h5 class="card-title fs-3">{{ number_format($totalIncome, 2) }} ₽</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger shadow-sm mb-3">
                    <div class="card-header">Общий расход</div>
                    <div class="card-body">
                        <h5 class="card-title fs-3">{{ number_format($totalExpense, 2) }} ₽</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Диаграммы -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container shadow-sm mb-4">
                    <h4 class="text-center text-muted">Доходы и расходы по категориям</h4>
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container shadow-sm mb-4">
                    <h4 class="text-center text-muted">График доходов и расходов по времени</h4>
                    <canvas id="timeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a 
                href="{{ route('statistics.download', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                class="btn btn-success btn-lg shadow-sm">
                Скачать PDF
            </a>
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
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw.toLocaleString();
                                return `${context.label}: ${value} ₽`;
                            }
                        }
                    }
                }
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
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Расход',
                        data: expenseData,
                        borderColor: '#FF6384',
                        backgroundColor: 'rgba(255, 99, 132, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw.toLocaleString();
                                return `${context.dataset.label}: ${value} ₽`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Дата',
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Сумма (₽)',
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
