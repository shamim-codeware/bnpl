<?php

namespace App\Exports;

use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DefaulterCustomersExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $data;
    private $rowNumber = 0;

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
            'SL No',
            'Order No',
            'Customer Name',
            'Phone',
            'Total Amount',
            'Outstanding Balance',
            'Last Payment Date',
            'Days Overdue',
            'Next Due Date',
            'Showroom',
            'Zone'
        ];
    }

    public function map($customer): array
    {
        $this->rowNumber++;
        $next_due_date = null;
        $outstanding_balance = 0;

        // Check for overdue installments (installment is the relationship name, not installments)
        if ($customer->installment && count($customer->installment) > 0) {
            // Find the earliest overdue installment
            $overdue_installments = $customer->installment->filter(function($installment) {
                return $installment->status == 0 && $installment->loan_start_date < now()->toDateString();
            })->sortBy('loan_start_date');

            if ($overdue_installments->count() > 0) {
                $next_due_date = $overdue_installments->first()->loan_start_date;
            }
        }

        if ($customer->purchase_product) {
            $outstanding_balance = $customer->purchase_product->hire_price - $customer->purchase_product->total_paid;
        }

        $last_payment = null;
        if ($customer->transaction && count($customer->transaction) > 0) {
            $last_transaction = $customer->transaction->sortByDesc('created_at')->first();
            $last_payment = $last_transaction->created_at;
        }

        return [
            $this->rowNumber,
            $customer->order_no,
            $customer->name,
            $customer->pr_phone,
            $customer->purchase_product ? (float)($customer->purchase_product->hire_price) : '0.00',
            (float)($outstanding_balance),
            $last_payment ? \Carbon\Carbon::parse($last_payment)->format('d F Y') : 'N/A',
            $customer->days_overdue ?? 0,
            $next_due_date ? \Carbon\Carbon::parse($next_due_date)->format('d F Y') : 'N/A',
            $customer->show_room ? $customer->show_room->name : 'N/A',
            $customer->show_room && $customer->show_room->zone ? $customer->show_room->zone->name : 'N/A'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:K1')->applyFromArray([
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

                // Auto-size columns
                foreach(range('A','K') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}
