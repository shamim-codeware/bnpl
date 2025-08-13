<?php

namespace App\Exports;

use App\Models\Enquery;
use Maatwebsite\Excel\Concerns\FromCollection;


use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use App\Models\FollowUp;
use App\Helpers\Helper;

class ExportPending implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $filter_data;
    public function __construct($data)
    {
        $this->filter_data = $data;
    }

    public function collection()
    {
        return $this->filter_data;
    }
    public function map($filter_data): array
    {
        //  dd($filter_data);
        $products = DB::table('enquiry_products')->where('enquiry_id', $filter_data->id)->get('product_name');

        $productNames = $products->pluck('product_name')->implode(', ');
        if ($filter_data->buying_aspect == 1) {

            $aspect = "High";
        } elseif ($filter_data->buying_aspect == 2) {
            $aspect = "Medium";
        } else {
            $aspect = "Low";
        }
        $formattedString = '';
        if (!empty($filter_data->type_of_offer)) {
            $decode = json_decode($filter_data->type_of_offer);
            $formattedString = implode(', ', $decode);
        }

        return [
            $filter_data->event_code,
            $filter_data->name,
            $filter_data->number,
            @$filter_data->customer->gender,
            Helper::formatOrdinal(FollowUp::where('enquiry_id', $filter_data->id)->count()),
            @$filter_data->enquirystatus->name,
            @$filter_data->showroom->name,
            $productNames,
            @$filter_data->enquiry_source_child->name,
            @$filter_data->purchase_modes->name,
            date('d/m/Y H:i A', strtotime($filter_data->sales_date)),
            $aspect,
            $formattedString,
            
            date('d/m/Y H:i A', strtotime($filter_data->created_at)),
            date('d/m/Y H:i A', strtotime($filter_data->next_follow_up_date)),
            @$filter_data->assign_by->name,
           
            @$filter_data->users->name
            // ... and so on for other related columns
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
            "Event Code",
            "Customer Name",
            "Customer Number",
            "Gender",
            "Follow Up ",
            "Status",
            "Showroom Name",
            "Product",
            "Enquiry Source",
            "Payment Type",
            "Aspected Sales Date",
            "Buying Aspect ",
            "Offers",
            "Created Date",
            "Next Follow Up Date",
            "Assign To",
          
            "Created By"
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(60);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('N')->setWidth(20);
            },
        ];
    }
}
