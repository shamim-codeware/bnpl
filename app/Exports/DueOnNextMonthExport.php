<?php

namespace App\Exports;

use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

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
            "Order No",
            "Customer Name",
            "Phone Number",
            "Group",
            "Model",
            "Total Amount",
            "Next Payment Due Date",
            "Monthly Installment",
            "Last Payment Date",
            "Late Payment Fee",
            "Last Paid Amount",
            "Outstanding Amount",
            "CTP",
            "Zone"
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
        $outstanding_balance = 0;
        if ($purchase->purchase_product) {
            $outstanding_balance = $purchase->purchase_product->hire_price - $purchase->purchase_product->total_paid;
        }

        static $slNo = 0;
        $slNo++;

        return [
            $slNo,
            $purchase->order_no ?? 'N/A',
            $purchase->name ?? 'N/A',
            $purchase->pr_phone ?? 'N/A',
            @$purchase->purchase_product->product_group->name ?? 'N/A',
            @$purchase->purchase_product->product->product_model ?? 'N/A',
            @$purchase->purchase_product ? (float)($purchase->purchase_product->hire_price) : '0.00',
            // $nextDueInstallment ? Helper::formatDateStandard($nextDueInstallment->loan_start_date) : 'N/A',
            $nextDueInstallment ? \Carbon\Carbon::parse($nextDueInstallment->loan_start_date)->format('d F Y') : 'N/A',
            @$purchase->purchase_product ? (float) $purchase->purchase_product->monthly_installment : '0.00',
            $last_payment ? \Carbon\Carbon::parse($last_payment)->format('d F Y') : 'N/A',
            (float) $purchase->late_fee ?? 0.00,
            (float) $last_paid_amount,
            (float) $outstanding_balance,
            @$purchase->show_room->name ?? 'N/A',
            @$purchase->show_room->zone->name ?? 'N/A'
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
