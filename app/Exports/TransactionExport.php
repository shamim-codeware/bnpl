<?php

namespace App\Exports;

use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
            'Transaction Type',
            'Order No',
            'Customer Name',
            'Phone Number',
            'Product Model',
            'Showroom',
            'Transaction Date & Time',
            'Transaction Amount',
            'Received By'
        ];
    }

    public function map($transaction): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $transaction->transaction_type ?? 'N/A',
            $transaction->hire_purchase->order_no ?? 'N/A',
            $transaction->hire_purchase->name ?? 'N/A',
            $transaction->hire_purchase->pr_phone ?? 'N/A',
            $transaction->hire_purchase->purchase_product->product->product_model ?? 'N/A',
            $transaction->hire_purchase->show_room->name ?? 'N/A',
            Helper::formatDateTimeStandard($transaction->created_at),
            number_format($transaction->amount, 2),
            $transaction->users->name ?? 'N/A'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Style header row
                $event->sheet->getStyle('A1:J1')->applyFromArray([
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

                // Set column widths
                $columns = [
                    'A' => 8,  // SL No
                    'B' => 20, // Transaction Type
                    'C' => 25, // Order No
                    'D' => 25, // Customer Name
                    'E' => 15, // Phone Number
                    'F' => 25, // Product Model
                    'G' => 25, // Showroom
                    'H' => 20, // Transaction Date & Time
                    'I' => 18, // Transaction Amount
                    'J' => 25, // Received By
                ];

                foreach ($columns as $column => $width) {
                    $event->sheet->getColumnDimension($column)->setWidth($width);
                }
            }
        ];
    }
}
