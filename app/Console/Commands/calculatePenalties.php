<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Installment;
use App\Models\Penalty;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

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
    // public function handle()
    // {
    //     try{
    //         $installments = Installment::whereHas('hire_purchase', function ($q) {
    //             $q->where('is_paid', 0);
    //         })
    //         ->where('status', 0)
    //         ->orderBy('hire_purchase_id')
    //         ->get();

    //         foreach ($installments as $installment) {
    //             $installment_no = Installment::where('hire_purchase_id', $installment->hire_purchase_id)->orderBy('id')->pluck('id')->search($installment->id);
    //             $installment_no = Helper::formatOrdinal($installment_no + 1);

    //             $loanCalculatedDate = Carbon::parse($installment->loan_start_date);
    //             $currentDate = Carbon::now();

    //             if ($currentDate->toDateString() > $loanCalculatedDate->toDateString()) {
    //                 $monthsOverdue = $loanCalculatedDate->diffInMonths($currentDate);

    //                 if($monthsOverdue >= 0 && $monthsOverdue <= 2) {
    //                     if($monthsOverdue == 0) {
    //                         if($this->penaltyExist($installment, 'customer', '1st')){
    //                             $this->createPenalty($installment, $installment_no, 'customer', '1st');
    //                         }
    //                     }

    //                     if($monthsOverdue == 1) {
    //                         if($this->penaltyExist($installment, 'customer', '1st')){
    //                             $this->createPenalty($installment, $installment_no, 'customer', '1st');
    //                         }
    //                         if($this->penaltyExist($installment, 'customer', '2nd')){
    //                             $this->createPenalty($installment, $installment_no, 'customer', '2nd');
    //                         }
    //                         if($this->penaltyExist($installment, 'granter', '2nd')){
    //                             $this->createPenalty($installment, $installment_no, 'granter', '2nd');
    //                         }
    //                     }

    //                     if($monthsOverdue == 2) {
    //                         if($this->penaltyExist($installment, 'customer', '1st')){
    //                             $this->createPenalty($installment, $installment_no, 'customer', '1st');
    //                         }
    //                         if($this->penaltyExist($installment, 'customer', '2nd')){
    //                             $this->createPenalty($installment, $installment_no, 'customer', '2nd');
    //                         }
    //                         if($this->penaltyExist($installment, 'granter', '2nd')){
    //                             $this->createPenalty($installment, $installment_no, 'granter', '2nd');
    //                         }
    //                         if($this->penaltyExist($installment, 'customer', '3rd')){
    //                             $this->createPenalty($installment, $installment_no, 'customer', '3rd');
    //                         }
    //                         if($this->penaltyExist($installment, 'granter', '3rd')){
    //                             $this->createPenalty($installment, $installment_no, 'granter', '3rd');
    //                         }
    //                     }

    //                 }
    //             }
    //         }
    //     }
    //     catch(\Exception $e) {
    //         logger($e->getMessage());
    //     }
    // }

    // public function penaltyExist($installment, $type, $notice_no)
    // {
    //     try {
    //         return !Penalty::where([
    //             ['installment_id', '=', $installment->id],
    //             ['notice_no', '=', $notice_no],
    //             ['type', '=', $type],
    //             ['due_date', '=', $installment->loan_start_date]
    //         ])->exists();
    //     } catch (\Exception $e) {
    //         logger($e->getMessage());
    //         return false;
    //     }
    // }

    // public function createPenalty($installment, $installment_no, $type, $notice_no)
    // {
    //     try{
    //         Penalty::create([
    //             'installment_id' => $installment->id,
    //             'installment_no' => $installment_no,
    //             'order_no' => $installment->hire_purchase->order_no,
    //             'type' => $type,
    //             'notice_no' => $notice_no,
    //             'due_date' => $installment->loan_start_date
    //         ]);
    //     }catch(\Exception $e) {
    //         logger($e->getMessage());
    //     }
    // }

    public function handle()
    {
        try {
            $installments = Installment::whereHas('hire_purchase', function ($q) {
                $q->where('is_paid', 0);
            })
                ->where('status', 0)
                ->orderBy('hire_purchase_id')
                ->get();

            foreach ($installments as $installment) {
                // STOP condition: যদি এই hire_purchase এ Customer 3rd + Granter 2nd notice আগে থেকেই থাকে
                $alreadyStopped = Penalty::where('order_no', $installment->hire_purchase->order_no)
                    ->where(function ($q) {
                        $q->where(function ($q1) {
                            $q1->where('type', 'customer')->where('notice_no', '3rd');
                        })->orWhere(function ($q2) {
                            $q2->where('type', 'granter')->where('notice_no', '2nd');
                        });
                    })->exists();

                if ($alreadyStopped) {
                    continue; // আর কোনো notice generate হবে না
                }

                $installment_no = Installment::where('hire_purchase_id', $installment->hire_purchase_id)
                    ->orderBy('id')
                    ->pluck('id')
                    ->search($installment->id);
                $installment_no = Helper::formatOrdinal($installment_no + 1);

                $dueDate = Carbon::parse($installment->loan_start_date);
                $currentDate = Carbon::now();

                if ($currentDate->gt($dueDate)) {
                    $daysOverdue = $dueDate->diffInDays($currentDate);

                    if ($daysOverdue >= 1) {
                        if ($this->penaltyExist($installment, 'customer', '1st')) {
                            $this->createPenalty($installment, $installment_no, 'customer', '1st');
                        }
                    }

                    if ($daysOverdue >= 31) {
                        if ($this->penaltyExist($installment, 'customer', '2nd')) {
                            $this->createPenalty($installment, $installment_no, 'customer', '2nd');
                        }
                        if ($this->penaltyExist($installment, 'granter', '1st')) {
                            $this->createPenalty($installment, $installment_no, 'granter', '1st');
                        }
                    }

                    if ($daysOverdue >= 61) {
                        if ($this->penaltyExist($installment, 'customer', '3rd')) {
                            $this->createPenalty($installment, $installment_no, 'customer', '3rd');
                        }
                        if ($this->penaltyExist($installment, 'granter', '2nd')) {
                            $this->createPenalty($installment, $installment_no, 'granter', '2nd');
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    public function penaltyExist($installment, $type, $notice_no)
    {
        try {
            return !Penalty::where([
                ['installment_id', '=', $installment->id],
                ['notice_no', '=', $notice_no],
                ['type', '=', $type],
                ['due_date', '=', $installment->loan_start_date]
            ])->exists();
        } catch (\Exception $e) {
            logger($e->getMessage());
            return false;
        }
    }

    public function createPenalty($installment, $installment_no, $type, $notice_no)
    {
        try {
            Penalty::create([
                'installment_id' => $installment->id,
                'installment_no' => $installment_no,
                'order_no' => $installment->hire_purchase->order_no,
                'type' => $type,
                'installment_amount' => $installment->amount,
                'notice_no' => $notice_no,
                'due_date' => $installment->loan_start_date
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }
}
