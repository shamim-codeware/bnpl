<?php

namespace App\Exports;

use DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShowroomExport implements FromCollection, WithMapping, WithHeadings , WithEvents
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
            Str::title($filter_data->name),
            $filter_data->suffix,
            $filter_data->contact_person,
            $filter_data->number,
            $filter_data->email,
            @$filter_data->district->en_name,
            @$filter_data->upazila->name,
            @$filter_data->zone->name,

        ];
    }



    public function headings(): array

    {

        return [
            "Name",
            "Suffix",
             "Contact Person Name",
            "Contact Person Number",
            "Contact Person Email",
            "District",
            "Upazila / Thana",
            "Zone"
            ];

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(15);

            },
        ];
    }
}
