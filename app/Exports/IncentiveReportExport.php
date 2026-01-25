<?php

namespace App\Exports;

use App\Models\Incentive;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncentiveReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $incentives;

    public function __construct($incentives)
    {
        $this->incentives = $incentives;
    }

    public function collection()
    {
        return $this->incentives;
    }

    public function headings(): array
    {
        return [
            'SL',
            'Order No',
            'Customer Name',
            'Product Group',
            'Product Model',
            'Incentive Type',
            'Incentive Category',
            'Incentive Amount',
            'Status',
            'Created Date',
            'Showroom',
            'Sales User',
        ];
    }

    public function map($incentive): array
    {
        $product_group = $incentive->hirePurchase->purchase_products->pluck('product_group.name')->implode(', ') ?? 'N/A';
        $product_model = $incentive->hirePurchase->purchase_products->pluck('product.product_model')->implode(', ') ?? 'N/A';

        $incentive_category = '';
        if ($incentive->sure_shot_type == 'category') {
            $incentive_category = $incentive->product_category_name ?? 'N/A';
        } elseif ($incentive->sure_shot_type == 'model') {
            $incentive_category = $incentive->product_model_name ?? 'N/A';
        } else {
            $incentive_category = ucfirst($incentive->type);
        }

        return [
            $this->rowNumber ?? ($this->rowNumber = 1) ? ++$this->rowNumber - 1 : 1, // SL auto increment
            $incentive->hirePurchase->order_no ?? 'N/A',
            Str::title($incentive->hirePurchase->name ?? 'N/A'),
            $product_group,
            $product_model,
            ucfirst(str_replace('_', ' ', $incentive->type)),
            $incentive_category,
            number_format($incentive->incentive_amount ?? 0, 2),
            ucfirst($incentive->status),
            $incentive->created_at?->format('d/m/Y H:i:s') ?? 'N/A',
            $incentive->hirePurchase->show_room->name ?? 'N/A',
            Str::title($incentive->hirePurchase->users->name ?? 'N/A'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row bold + background
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFD3D3D3']],
            ],
        ];
    }
}
