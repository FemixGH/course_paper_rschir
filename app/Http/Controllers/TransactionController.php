<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
    
    public function statistics()
    {
        $userId = Auth::id();
    
        // Получение общей статистики
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
    
        // Доходы и расходы по категориям
        $categories = Transaction::select('description', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->groupBy('description')
            ->get();
    
        // Данные для графиков
        $transactionsByDate = Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(CASE WHEN type = \'income\' THEN amount ELSE 0 END) as total_income'),
            DB::raw('SUM(CASE WHEN type = \'expense\' THEN amount ELSE 0 END) as total_expense')
        )
            ->where('user_id', $userId)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        return view('statistics', compact('totalIncome', 'totalExpense', 'balance', 'categories', 'transactionsByDate'));
    }

    
    

}
