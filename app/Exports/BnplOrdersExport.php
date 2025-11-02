<?php

namespace App\Exports;

use App\Helpers\Helper;
use App\Models\Installment;
use App\Service\LateFeeService;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BnplOrdersExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
            "BNPL Order No",
            "Loan Start Date",
            "Loan End Date",
            "Brand",
            "Model",
            "Size",
            "Total Hire Price",
            "First Installment",
            "Monthly Installment",
            "Total Payment Received",
            "Late Payment Fee",
            "Total Paid Late Payment Fee",
            "Outstanding Balance",
            "Total Installment",
            "Paid Installment",
            "Due Installment",
            "Last Transaction Amount",
            "Last Transaction Date",
            "Next Due Date",
            "Customer Name",
            "Phone Number",
            "Sales Representative",
            "Created By",
            "Status",
            "Guarantor 1 Name",
            "Guarantor 1 Relation",
            "Guarantor 1 Phone",
            "Guarantor 1 NID",
            "Guarantor 2 Name",
            "Guarantor 2 Relation",
            "Guarantor 2 Phone",
            "Guarantor 2 NID"
        ];
    }

    public function map($purchase): array
    {
        // Get loan dates
        $firstLoanStartDate = null;
        $lastLoanEndDate = null;
        $next_due_date = null;

        if ($purchase->installment && count($purchase->installment) > 0) {
            $firstLoanStartDate = $purchase->installment[0]->loan_start_date;
            $lastLoanEndDate = $purchase->installment[count($purchase->installment) - 1]->loan_end_date;

            // Find next due date
            $next_installment = Installment::where('hire_purchase_id', $purchase->id)
                ->where('status', 0)
                ->orderby('id', "ASC")
                ->first();
            if ($next_installment) {
                $next_due_date = $next_installment->loan_start_date;
            }
        }

        // Get last transaction details
        $last_paid_amount = 0;
        $last_payment_date = null;
        if ($purchase->transaction && count($purchase->transaction) > 0) {
            $last_paid_amount = $purchase->transaction[count($purchase->transaction) - 1]->amount;
            $last_payment_date = $purchase->transaction[count($purchase->transaction) - 1]->updated_at;
        }

        // Check if status is 2 (Rejected) or 4 (Sale Cancel)
        $isRejectedOrCancelled = in_array($purchase->status, [2, 4]);

        $installment_paid = $purchase->installment->where('status', 1)->sum('amount');
        $hire_price = $purchase->purchase_product->hire_price ?? 0;

        // Trait use করা class instance আনতে হবে
        $lateFeeService = app(LateFeeService::class);
        $late_fee = $lateFeeService->calculateLateFine($purchase->id);
        $paid_fine_amount = $purchase->installment->sum('fine_amount');



        // মোট বাকি = (hire_price - paid) + late_fee
        $outstanding_balance = ($hire_price - $installment_paid) + $late_fee;


        // Get status text
        $status_text = '';
        switch ($purchase->status) {
            case 0:
                $status_text = 'Pending';
                break;
            case 1:
                $status_text = 'Approved';
                break;
            case 2:
                $status_text = 'Rejected';
                break;
            case 3:
                $status_text = 'Sale Confirm';
                break;
            case 4:
                $status_text = 'Sale Cancel';
                break;
            default:
                $status_text = 'Unknown';
        }

        static $slNo = 0;
        $slNo++;

        // Get guarantor information
        $guarantor1_name = 'N/A';
        $guarantor1_relation = 'N/A';
        $guarantor1_phone = 'N/A';
        $guarantor1_nid = 'N/A';
        $guarantor2_name = 'N/A';
        $guarantor2_relation = 'N/A';
        $guarantor2_phone = 'N/A';
        $guarantor2_nid = 'N/A';

        if ($purchase->guaranter_info && count($purchase->guaranter_info) > 0) {
            // First guarantor (index 0)
            if (isset($purchase->guaranter_info[0])) {
                $guarantor1_name = $purchase->guaranter_info[0]->guarater_name ?? 'N/A';
                $guarantor1_relation = $purchase->guaranter_info[0]->guarater_relation ?? 'N/A';
                $guarantor1_phone = $purchase->guaranter_info[0]->guarater_phone ?? 'N/A';
                $guarantor1_nid = $purchase->guaranter_info[0]->guarater_nid ?? 'N/A';
            }

            // Second guarantor (index 1)
            if (isset($purchase->guaranter_info[1])) {
                $guarantor2_name = $purchase->guaranter_info[1]->guarater_name ?? 'N/A';
                $guarantor2_relation = $purchase->guaranter_info[1]->guarater_relation ?? 'N/A';
                $guarantor2_phone = $purchase->guaranter_info[1]->guarater_phone ?? 'N/A';
                $guarantor2_nid = $purchase->guaranter_info[1]->guarater_nid ?? 'N/A';
            }
        }



        // Set conditional values based on status
        $firstInstallment = $isRejectedOrCancelled ? '0.00' : (@$purchase->purchase_product ? number_format($purchase->purchase_product->down_payment, 2) : '0.00');

        $totalPaymentReceived = $isRejectedOrCancelled ? '0.00' : (@$purchase->purchase_product ? number_format($purchase->purchase_product->total_paid, 2) : '0.00');

        $outstandingBalanceFormatted = $isRejectedOrCancelled ? '0.00' :
            number_format($outstanding_balance, 2);

        $paidInstallment = $isRejectedOrCancelled ? '0' : (@$purchase->installment ? $purchase->installment->where('status', 1)->count() : '0');

        $dueInstallment = $isRejectedOrCancelled ? '0' : (@$purchase->installment ? $purchase->installment->where('status', 0)->count() : '0');

        return [
            $slNo,
            @$purchase->show_room->name ?? 'N/A',
            @$purchase->show_room->zone->name ?? 'N/A',
            $purchase->order_no,
            $firstLoanStartDate ? \Carbon\Carbon::parse($firstLoanStartDate)->format('d F Y') : 'N/A',
            $lastLoanEndDate ? \Carbon\Carbon::parse($lastLoanEndDate)->format('d F Y')  : 'N/A',
            @$purchase->purchase_product->brand->name ?? 'N/A',
            @$purchase->purchase_product->product->product_model ?? 'N/A',
            @$purchase->purchase_product->product_size_id ?? 'N/A',
            @$purchase->purchase_product ? (float)($purchase->purchase_product->hire_price) : '0.00',
            $firstInstallment, // Conditional: 0.00 if rejected/cancelled
            @$purchase->purchase_product ? (float)($purchase->purchase_product->monthly_installment) : '0.00',
            $totalPaymentReceived, // Conditional: 0.00 if rejected/cancelled
            // @$purchase->late_fee ?? 0.00,
            $isRejectedOrCancelled ? '0.00' : number_format($purchase->late_fee, 2),
            $isRejectedOrCancelled ? '0.00' : number_format($paid_fine_amount, 2),
            $outstandingBalanceFormatted, // Conditional: 0.00 if rejected/cancelled
            @$purchase->installment ? $purchase->installment->count() : '0',
            $paidInstallment, // Conditional: 0 if rejected/cancelled
            $dueInstallment, // Conditional: 0 if rejected/cancelled
            (float)($last_paid_amount),
            $last_payment_date ? \Carbon\Carbon::parse($last_payment_date)->format('d F Y') : 'N/A',
            $next_due_date ? \Carbon\Carbon::parse($next_due_date)->format('d F Y') : 'N/A',
            $purchase->name ?? 'N/A',
            $purchase->pr_phone ?? 'N/A',
            @$purchase->show_room_user->name ?? 'N/A',
            @$purchase->users->name ?? 'N/A',
            $status_text,
            $guarantor1_name,
            $guarantor1_relation,
            $guarantor1_phone,
            $guarantor1_nid,
            $guarantor2_name,
            $guarantor2_relation,
            $guarantor2_phone,
            $guarantor2_nid
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set column widths
                $columns = [
                    'A' => 8,  // SL No
                    'B' => 25, // CTP
                    'C' => 20, // Zone
                    'D' => 25, // Order No
                    'E' => 15, // Loan Start Date
                    'F' => 15, // Loan End Date
                    'G' => 15, // Brand
                    'H' => 20, // Model
                    'I' => 15, // Size
                    'J' => 20, // Total Hire Price
                    'K' => 20, // First Installment
                    'L' => 20, // Monthly Installment
                    'M' => 20, // Total Payment
                    'N' => 20, // Outstanding Balance
                    'O' => 15, // Total Installment
                    'P' => 15, // Paid Installment
                    'Q' => 15, // Due Installment
                    'R' => 20, // Last Transaction Amount
                    'S' => 20, // Last Transaction Date
                    'T' => 15, // Next Due Date
                    'U' => 25, // Customer Name
                    'V' => 15, // Phone Number
                    'W' => 25, // Sales Representative
                    'X' => 25, // Created By
                    'Y' => 15, // Status
                    'Z' => 25, // Guarantor 1 Name
                    'AA' => 20, // Guarantor 1 Relation
                    'AB' => 15, // Guarantor 1 Phone
                    'AC' => 20, // Guarantor 1 NID
                    'AD' => 25, // Guarantor 2 Name
                    'AE' => 20, // Guarantor 2 Relation
                    'AF' => 15, // Guarantor 2 Phone
                    'AG' => 20, // Guarantor 2 NID
                ];

                foreach ($columns as $column => $width) {
                    $event->sheet->getColumnDimension($column)->setWidth($width);
                }

                // Style header row
                $event->sheet->getStyle('A1:AG1')->applyFromArray([
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
