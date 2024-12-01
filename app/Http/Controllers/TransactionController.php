<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index()
    {
        // Получить транзакции текущего пользователя
        $transactions = Transaction::where('user_id', Auth::id())->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully!');
    }
    
    public function statistics(Request $request)
{
    $userId = Auth::id();
    
    // Получение дат из фильтра
    $startDate = $request->input('start_date', '1900-01-01');
    $endDate = $request->input('end_date', now()->toDateString());
    
    // Получение общей статистики
    $totalIncome = Transaction::where('user_id', $userId)
        ->where('type', 'income')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('amount');
    $totalExpense = Transaction::where('user_id', $userId)
        ->where('type', 'expense')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('amount');
    $balance = $totalIncome - $totalExpense;

    // Доходы и расходы по категориям
    $categories = Transaction::select('description', DB::raw('SUM(amount) as total'))
        ->where('user_id', $userId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('description')
        ->get();

    // Данные для графиков
    $transactionsByDate = Transaction::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(CASE WHEN type = \'income\' THEN amount ELSE 0 END) as total_income'),
        DB::raw('SUM(CASE WHEN type = \'expense\' THEN amount ELSE 0 END) as total_expense')
    )
        ->where('user_id', $userId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return view('statistics', compact('totalIncome', 'totalExpense', 'balance', 'categories', 'transactionsByDate', 'startDate', 'endDate'));
}

    
    private function generateCharts($categories, $transactionsByDate)
    {
        // Пример: создание графиков с использованием PHP или библиотек.
        // Здесь можно использовать GD, ImageMagick, или экспорт из Chart.js.
        $categoryChartPath = public_path('charts/category-chart.png');
        $timeChartPath = public_path('charts/time-chart.png');
    
        // Сохраните изображения графиков.
        file_put_contents($categoryChartPath, '...'); // Ваш код для графика по категориям
        file_put_contents($timeChartPath, '...');    // Ваш код для графика по времени
    }

    
    public function downloadPDF()
{
    $userId = Auth::id();

    // Получение данных для отчета
    $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;

    $categories = Transaction::select('description', DB::raw('SUM(amount) as total'))
        ->where('user_id', $userId)
        ->groupBy('description')
        ->get();

    $transactionsByDate = Transaction::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(CASE WHEN type = \'income\' THEN amount ELSE 0 END) as total_income'),
        DB::raw('SUM(CASE WHEN type = \'expense\' THEN amount ELSE 0 END) as total_expense')
    )
        ->where('user_id', $userId)
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $pdf = Pdf::loadView('pdf.statistics', [
        'totalIncome' => $totalIncome,
        'totalExpense' => $totalExpense,
        'balance' => $balance,
        'categories' => $categories,
        'transactionsByDate' => $transactionsByDate
    ]);

    return $pdf->download('financial_statistics.pdf');
}
public function downloadStatisticsPDF(Request $request)
{
    $userId = Auth::id();

    // Получение дат из фильтра
    $startDate = $request->input('start_date', '1900-01-01');
    $endDate = $request->input('end_date', now()->toDateString());

    // Статистика
    $totalIncome = Transaction::where('user_id', $userId)
        ->where('type', 'income')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('amount');
    $totalExpense = Transaction::where('user_id', $userId)
        ->where('type', 'expense')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('amount');
    $balance = $totalIncome - $totalExpense;

    $categories = Transaction::select('description', DB::raw('SUM(amount) as total'))
        ->where('user_id', $userId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('description')
        ->get();

    $transactionsByDate = Transaction::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(CASE WHEN type = \'income\' THEN amount ELSE 0 END) as total_income'),
        DB::raw('SUM(CASE WHEN type = \'expense\' THEN amount ELSE 0 END) as total_expense')
    )
        ->where('user_id', $userId)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Генерация PDF
    $pdf = Pdf::loadView('pdf.statistics', compact(
        'totalIncome',
        'totalExpense',
        'balance',
        'categories',
        'transactionsByDate',
        'startDate',
        'endDate'
    ));

    return $pdf->download("Financial_Statistics_{$startDate}_to_{$endDate}.pdf");
}

}
