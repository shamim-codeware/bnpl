<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenaltyExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $filter_data;
    public function __construct( $data)
    {
        $this->filter_data = $data;
    }

    public function collection()
    {
       return $this->filter_data;

    }
        public function map($filter_data): array
    {
        return [
            $filter_data->order_no,
            $filter_data->installment_no,
            $filter_data->notice_no,
            $filter_data->type,
            $filter_data->status_date,
            $filter_data->status
        ];
    }
    /**

     * Write code on Method

     *

     * @return response()

     */

    public function headings(): array
    {
        return ["Order No", "Installment No", "Notice No", "Type", "Order View", "Courier Status"];
    }
}
