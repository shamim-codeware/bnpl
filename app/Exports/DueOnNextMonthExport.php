<?php

namespace App\Exports;

use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Service\LateFeeService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DueOnNextMonthExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            "SL No",
            "CTP",
            "Zone",
            "Order No",
            "Customer Name",
            "Phone Number",
            "Model",
            "Brand",
            "Total Hire Price",
            "Monthly Installment",
            "Total Payment Received",
            // "Next Payment Due Date",
            // "Last Payment Date",
            "Late Payment Fee",
            "Total Monthly Installment",
            // "Last Paid Amount",
            "Total Outstanding Balance",
        ];
    }

    public function map($purchase): array
    {
        // Get next due installment in the specified date range
        $nextDueInstallment = $purchase->installment->where('status', 0)->first();

        // Get last payment details
        $last_payment = null;
        $last_paid_amount = 0;
        if ($purchase->transaction && count($purchase->transaction) > 0) {
            $lastTransaction = $purchase->transaction->first();
            if ($lastTransaction) {
                $last_payment = $lastTransaction->updated_at;
                $last_paid_amount = $lastTransaction->amount;
            }
        }

        // Calculate outstanding balance
        $installment_paid = \App\Models\Installment::where('hire_purchase_id', $purchase->id)
            ->where('status', 1)
            ->sum('amount');

        $hire_price = $purchase->hire_price ?? 0;

        $lateFeeService = app(LateFeeService::class);

        $late_fee = $lateFeeService->calculateLateFine($purchase->id);

        $outstanding_balance = ($hire_price - $installment_paid) + $late_fee;

        $totalPaymentReceived = \App\Models\Installment::query()
            ->where('hire_purchase_id', $purchase->id)
            ->where('status', 1)
            ->sum(DB::raw('amount + COALESCE(fine_amount, 0)'));

        static $slNo = 0;
        $slNo++;

        return [
            $slNo,
            @$purchase->show_room->name ?? 'N/A',
            @$purchase->show_room->zone->name ?? 'N/A',
            $purchase->order_no ?? 'N/A',
            Str::title($purchase->name ?? 'N/A'),
            $purchase->pr_phone ?? 'N/A',
            @$purchase->purchase_products->pluck('product.product_model')->implode(', ') ?? 'N/A',
            @$purchase->purchase_products->pluck('brand.name')->implode(', ') ?? 'N/A',
            @$purchase->hire_price ? (float)($purchase->hire_price) : '0.00',
            // $nextDueInstallment ? Helper::formatDateStandard($nextDueInstallment->loan_start_date) : 'N/A',
            @$purchase->monthly_installment ? (float) $purchase->monthly_installment : '0.00',
            $totalPaymentReceived,
            // $nextDueInstallment ? \Carbon\Carbon::parse($nextDueInstallment->loan_start_date)->format('d F Y') : 'N/A',
            // $last_payment ? \Carbon\Carbon::parse($last_payment)->format('d F Y') : 'N/A',
            (float)($purchase->late_fee ?? 0),
            (float) $purchase->monthly_installment + (float)($purchase->late_fee ?? 0),
            // (float) $last_paid_amount,
            (float) $outstanding_balance,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Set column widths
                $columns = [
                    'A' => 8,  // SL No
                    'B' => 25, // Order No
                    'C' => 25, // Customer Name
                    'D' => 15, // Phone Number
                    'E' => 20, // Group
                    'F' => 25, // Model
                    'G' => 20, // Total Amount
                    'H' => 20, // Next Payment Due Date
                    'I' => 20, // Monthly Installment
                    'J' => 20, // Last Payment Date
                    'K' => 20, // Last Paid Amount
                    'L' => 20, // Outstanding Amount
                    'M' => 25, // CTP
                    'N' => 20, // Zone
                ];

                foreach ($columns as $column => $width) {
                    $event->sheet->getColumnDimension($column)->setWidth($width);
                }

                // Style header row
                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E2EFD9',
                        ]
                    ]
                ]);
            }
        ];
    }
}
