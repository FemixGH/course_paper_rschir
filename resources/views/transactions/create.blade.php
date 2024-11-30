<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить транзакцию</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Добавить транзакцию</h1>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="type" class="form-label">Тип транзакции</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="income">Доход</option>
                    <option value="expense">Расход</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Сумма</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0.01" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <input type="text" name="description" id="description" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
        </form>
    </div>
</body>
</html>
