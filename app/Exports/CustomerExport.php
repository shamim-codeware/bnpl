<?php

namespace App\Exports;

use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class CustomerExport implements FromCollection, WithMapping, WithHeadings
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
            $filter_data->name,
            $filter_data->email,
            $filter_data->number,
            $filter_data->alt_number,
            @$filter_data->customer_types->name,
            @$filter_data->district->name,
            @$filter_data->upazila->name,
           $filter_data->gender,
           $filter_data->age,

           \App\Helpers\Helper::formatDateTimeStandard($filter_data->created_at),
        ];
    }



    public function headings(): array

    {

        return [
            "Name",
            "Email",
            "Number",
            "Alternative Number",
            "Type",
            "District",
            "Upazila / Thana",

            "Gender",
            "Age",
            "Created Date"

            ];

    }
}
