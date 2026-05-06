<?php

namespace App\Exports;

use App\Helpers\Helper;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithMapping, WithHeadings
{
    protected $products;
    protected $rowNumber = 0;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function map($product): array
    {
        $this->rowNumber++;
        $status = ($product->status === 'publish') ? 'Active' : 'Inactive';

        return [
            $this->rowNumber,
            $product->product_model ?? 'N/A',
            $product->hire_price ?? '0.00',
            @$product->types->name ?? 'N/A',
            @$product->categories->name ?? 'N/A',
            // Helper::formatDateTimeStandard($product->created_at),
            Carbon::parse($product->created_at)->format('d F Y h:i A'),
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            'SL No',
            'Product Model',
            'Price',
            'Product Group',
            'Product Category',
            'Created Date',
            'Status',
        ];
    }
}
