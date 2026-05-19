<?php

namespace App\Modules\Dashboard\Services;

use App\Models\FinancialAccount;
use App\Models\Movement;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardService
{
    public function summary(User $user): array
    {
        $now   = Carbon::now();
        $month = $now->month;
        $year  = $now->year;

        $totalBalance = FinancialAccount::where('user_id', $user->id)
            ->where('is_active', true)
            ->sum('current_balance');

        $monthlyIncome = Movement::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $monthlyExpense = Movement::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $accounts = FinancialAccount::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'type', 'current_balance', 'currency']);

        $recentMovements = Movement::where('user_id', $user->id)
            ->with(['category', 'account'])
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return [
            'balance'          => (float) $totalBalance,
            'monthly_income'   => (float) $monthlyIncome,
            'monthly_expense'  => (float) $monthlyExpense,
            'monthly_net'      => (float) ($monthlyIncome - $monthlyExpense),
            'accounts'         => $accounts,
            'recent_movements' => $recentMovements,
        ];
    }
}
