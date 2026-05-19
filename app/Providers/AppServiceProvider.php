<?php

namespace App\Providers;

use App\Models\FinancialAccount;
use App\Models\Movement;
use App\Models\Receipt;
use App\Modules\Accounts\Policies\AccountPolicy;
use App\Modules\Movements\Policies\MovementPolicy;
use App\Modules\Receipts\Policies\ReceiptPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(FinancialAccount::class, AccountPolicy::class);
        Gate::policy(Movement::class, MovementPolicy::class);
        Gate::policy(Receipt::class, ReceiptPolicy::class);
    }
}
