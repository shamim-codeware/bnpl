<?php

namespace App\Exports;

use App\Models\User;
use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class UsersExport implements FromCollection, WithMapping, WithHeadings
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
            $filter_data->phone,
            @$filter_data->roles->name,
            @$filter_data->showrooms->zone->name,
            @$filter_data->showrooms->name,
            $filter_data->last_seen ? \App\Helpers\Helper::formatDateTimeStandard($filter_data->last_seen) : ''
        ];
    }




    /**

     * Write code on Method

     *

     * @return response()

     */

    public function headings(): array

    {

        return [
            "Name",
            "Email",
            "Number",
            "Role",
            "Zone",
            "Showroom",
            "Last Login"

            ];

    }
}
