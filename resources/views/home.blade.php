<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление финансами</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px;
        }
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #a71d2a;
        }
        .display-4 {
            font-weight: bold;
            color: #343a40;
        }
        .lead {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Заголовок -->
        <div class="text-center mb-4">
            <h1 class="display-4">Добро пожаловать в систему управления финансами!</h1>
            <p class="lead">Следите за своими доходами, расходами и финансовыми целями.</p>
            <hr class="my-4">
        </div>
        
        <!-- Карточки -->
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Управление доходами и расходами</h5>
                        <p class="card-text text-muted">Добавляйте и анализируйте свои источники дохода и расхода.</p>
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Финансовые отчёты</h5>
                        <p class="card-text text-muted">Просматривайте детализированные отчёты по финансам.</p>
                        <a href="{{ route('statistics') }}" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кнопка выхода -->
        <div class="text-center mt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg">Выйти</button>
            </form>
        </div>
    </div>
</body>
</html>
