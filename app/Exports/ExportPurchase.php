<?php

namespace App\Exports;

use DB;
use Carbon\Carbon;
use App\Models\Installment;

use App\Models\HirePurchase;
use App\Service\LateFeeService;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPurchase implements FromCollection, WithMapping, WithHeadings, WithEvents
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
        $firstLoanStartDate = null;
        $lastLoanEndDate = null;
        $last_payment = null;
        $last_paid_amount = 0;

        // Safely get installment dates
        // if ($filter_data->installment && count($filter_data->installment) > 0) {
        //     $firstLoanStartDate = $filter_data->installment[0]->loan_start_date;
        //     $lastLoanEndDate = $filter_data->installment[count($filter_data->installment) - 1]->loan_end_date;
        // }
        if ($filter_data->installment && count($filter_data->installment) > 0) {
            // earliest due date = loan start date
            $firstLoanStartDate = $filter_data->installment->min('loan_start_date');
            // latest due date = loan end date
            $lastLoanEndDate = $filter_data->installment->max('loan_start_date');
        }

        // Safely get transaction details
        if ($filter_data->transaction && count($filter_data->transaction) > 0) {
            $lastTransaction = $filter_data->transaction[count($filter_data->transaction) - 1];
            $last_payment = $lastTransaction->updated_at;
            $last_paid_amount = $lastTransaction->amount;
        }

        // $outstanding_balance = $filter_data->purchase_product ? ($filter_data->purchase_product->hire_price - $filter_data->purchase_product->total_paid) : 0;
        // Installment paid
        $installment_paid = $filter_data->installment
            ? $filter_data->installment->where('status', 1)->sum('amount')
            : 0;

        // Hire price
        $hire_price = $filter_data->hire_price ?? 0;

        // Late fee via Trait (assume LateFeeService class exists)
        $lateFeeService = app(LateFeeService::class);
        $late_fee = $lateFeeService->calculateLateFine($filter_data->id);

        // Final outstanding balance
        $outstanding_balance = ($hire_price - $installment_paid) + $late_fee;

        $next_installment_date = Installment::where('hire_purchase_id', $filter_data->id)->where('status', 0)->orderby('id', "ASC")->first();

        $paid_fine_amount = $filter_data->installment
            ? $filter_data->installment->sum('fine_amount')
            : 0.00;

        $status = 'Regular';

        $lastUnpaidDue = $filter_data->installment
            ? $filter_data->installment->where('status', 0)->max('loan_start_date')
            : null;

        if ($lastUnpaidDue && Carbon::parse($lastUnpaidDue)->lt(now()->subDays(30))) {
            $status = 'Defaulter';
        }


        return [
            @$filter_data->show_room->name,
            $filter_data->order_no,
            // $firstLoanStartDate,
            // $lastLoanEndDate,
            $firstLoanStartDate ? \Carbon\Carbon::parse($firstLoanStartDate)->format('d F Y') : '',
            $lastLoanEndDate ? \Carbon\Carbon::parse($lastLoanEndDate)->format('d F Y') : '',
            @$filter_data->purchase_products->pluck('brand.name')->implode(', ') ?? 'N/A',
            @$filter_data->purchase_products->pluck('product.product_model')->implode(', ') ?? 'N/A',
            @$filter_data->purchase_products->pluck('product_size_id')->implode(', ') ?? 'N/A',
            @$filter_data->hire_price ? (float) ($filter_data->hire_price) : '0.00',
            @$filter_data->down_payment,
            @$filter_data->monthly_installment,
            @$filter_data->total_paid,
            // @$late_fee ?? 0.00,
            ($late_fee) ?? 0.00,
            ($paid_fine_amount),
            // $outstanding_balance,
            ($outstanding_balance),
            @$filter_data->installment->count(),
            @$filter_data->installment->where('status', 1)->count(),
            @$filter_data->installment->where('status', 0)->count(),
            $last_paid_amount,
            // $last_payment,
            // @$next_installment_date->loan_start_date,
            $last_payment ? \Carbon\Carbon::parse($last_payment)->format('d F Y') : '',

            @$next_installment_date?->loan_start_date
                ? \Carbon\Carbon::parse($next_installment_date->loan_start_date)->format('d F Y')
                : '',
            $filter_data->name,
            $filter_data->pr_phone,
            @$filter_data->show_room_user->name,
            @$filter_data->users->name,
            @$filter_data->show_room->zone->name,
            $status,
        ];
    }


    public function headings(): array

    {

        return [
            "CTP",
            "BNPL Order No ",
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
            "Customer Name ",
            "Phone Number",
            "Sales Representative",
            "Created By	",
            "Zone",
            "Status",
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
