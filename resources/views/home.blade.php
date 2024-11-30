<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление финансами</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="text-center">
            <h1>Добро пожаловать в систему управления финансами!</h1>
            <p class="lead">Следите за своими доходами, расходами и финансовыми целями.</p>
            <hr>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Управление доходами</h5>
                        <p class="card-text">Добавляйте и анализируйте свои источники дохода.</p>
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Управление расходами</h5>
                        <p class="card-text">Контролируйте свои расходы и избегайте лишних затрат.</p>
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Финансовые отчёты</h5>
                        <p class="card-text">Просматривайте детализированные отчёты по финансам.</p>
                        <a href="{{ route('statistics') }}" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Статистика</h5>
                        <p class="card-text">Просматривайте статистику по вашим финансам.</p>
                        <a href="{{ route('statistics') }}" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
