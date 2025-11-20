<?php

namespace App\Console\Commands;

use App\Models\HirePurchase;
use Illuminate\Console\Command;

class CheckBNPLInstallments extends Command
{
    protected $signature = 'bnpl:check';
    protected $description = 'Check if all BNPL installments match hire prices';

    public function handle()
    {
        $this->info('Checking all BNPL installments...');

        $hirePurchases = HirePurchase::with(['purchase_product', 'installment'])->get();

        $mismatches = [];

        foreach ($hirePurchases as $hp) {
            $hirePrice = $hp->purchase_product->hire_price;
            $totalInstallments = $hp->installment->sum('amount');

            if ($hirePrice != $totalInstallments) {
                $mismatches[] = [
                    'Order No' => $hp->order_no,
                    'Customer' => $hp->name,
                    'Hire Price' => $hirePrice,
                    'Total Installments' => $totalInstallments,
                    'Difference' => $hirePrice - $totalInstallments,
                ];
            }
        }

        if (empty($mismatches)) {
            $this->info('✅ All BNPL installments match with hire prices!');
        } else {
            $this->error('❌ Found ' . count($mismatches) . ' mismatches:');
            $this->table(
                ['Order No', 'Customer', 'Hire Price', 'Total Installments', 'Difference'],
                $mismatches
            );
        }
    }
}
