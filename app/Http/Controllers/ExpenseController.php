<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $from = Carbon::parse($request->from_date)->format('Y-m-d');
        $to = Carbon::parse($request->to_date)->format('Y-m-d');

        $user = $request->user();

        $expense = Expense::where('user_id', $user->id)
            ->whereBetween('spent_at', [
                $from,
                $to,
            ]);

        $expenseList = $expense->select('id', 'expense_category_id', 'amount', 'spent_at', 'created_at')->get();
        $total = $expense->sum('amount');

        return response()->json([
            "success" => true,
            "total" => $total,
            "expenses" => $expenseList,
            "from" => $request->from_date,
            "to" => $request->to_date
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'spent_at' => 'required|date|after_or_equal:1990-01-01',
            'description' => 'nullable|string|max:255',
        ]);


        $user = $request->user();

        $dt = Carbon::parse($request->spent_at);

        $expense = Expense::create([
            'user_id' => $user->id,
            'expense_category_id' => $validated['expense_category_id'],
            'amount' => $validated['amount'],
            'spent_at' => $dt->format('Y-m-d'),
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Your expense saved successfully",
            "expense" => [
                "expense_category_id" => $expense->expense_category_id,
                "amount" => $expense->amount,
                "spent_at" => $expense->spent_at,
                "created_at" => $expense->created_at
            ]
        ]);
    }
}
