<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Installment;
use App\Models\Penalty;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class calculatePenalties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $installments = Installment::query()
        ->whereHas('hire_purchase' , function ($q) {
            $q->where('is_paid' , 0);
        }) 
        ->where('status', 0)
        ->orderBy('id')
        ->get();

        foreach ($installments as $installment) {
            $installment_no = Installment::where('hire_purchase_id', $installment->hire_purchase_id)->orderBy('id')->pluck('id')->search($installment->id) + 1;
            $loanStartDate = Carbon::parse($installment->loan_start_date);
            $loanEndDate = Carbon::parse($installment->loan_end_date);
            $currentDate = Carbon::now();
            $penalty_exist = Penalty::query()
            ->where('installment_id', $installment->id)
            ->whereIn('notice_no', ['1st', '2nd', '3rd'])
            ->where(function($q) {
                $q->where('type', 'customer')
                ->orWhere('type', 'granter');
            })
            ->where('due_date', $installment->loan_end_date)
            ->first();

            if ($currentDate->greaterThan($loanEndDate) && empty($penalty_exist)) {
                $monthsOverdue = $loanEndDate->diffInMonths($currentDate);
                if($monthsOverdue >= 0 && $monthsOverdue <= 2) {
                    if($monthsOverdue == 0) {
                        Penalty::create([
                            'installment_id' => $installment->id,
                            'installment_no' => Helper::formatOrdinal($installment_no),
                            'order_no' => $installment->hire_purchase->order_no,
                            'type' => 'customer',
                            'notice_no' => '1st',
                            'due_date' => $installment->loan_end_date
                        ]);
                    }
                    if($monthsOverdue == 1) {
                        Penalty::create([
                            'installment_id' => $installment->id,
                            'installment_no' => Helper::formatOrdinal($installment_no),
                            'order_no' => $installment->hire_purchase->order_no,
                            'type' => 'customer',
                            'notice_no' => '2nd',
                            'due_date' => $installment->loan_end_date
                        ]);

                        Penalty::create([
                            'installment_id' => $installment->id,
                            'installment_no' => Helper::formatOrdinal($installment_no),
                            'order_no' => $installment->hire_purchase->order_no,
                            'type' => 'granter',
                            'notice_no' => '2nd',
                            'due_date' => $installment->loan_end_date
                        ]);
                    }
                    if($monthsOverdue == 2) {
                        Penalty::create([
                            'installment_id' => $installment->id,
                            'installment_no' => Helper::formatOrdinal($installment_no),
                            'order_no' => $installment->hire_purchase->order_no,
                            'type' => 'customer',
                            'notice_no' => '3rd',
                            'due_date' => $installment->loan_end_date
                        ]);

                        Penalty::create([
                            'installment_id' => $installment->id,
                            'installment_no' => Helper::formatOrdinal($installment_no),
                            'order_no' => $installment->hire_purchase->order_no,
                            'type' => 'granter',
                            'notice_no' => '3rd',
                            'due_date' => $installment->loan_end_date
                        ]);
                    }
                }

            }
        }

    }
}
