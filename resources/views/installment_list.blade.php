<style type="text/css" media="print">
    @page {
        size: auto;
        margin: 0mm;
        padding: 1px;
    }
</style>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap');

    .formBody {
        padding: 20px;
    }

    body {
        font-family: 'Jost', sans-serif !important;
        font-size: 12px !important;
        padding: 1px;
        margin: 0px;
    }

    table th,
    table td {
        font-family: 'Jost', sans-serif !important;
        font-size: 14px !important;
        border-collapse: collapse;
        padding: 1px !important;
    }
    .list_table{
        border-collapse: collapse;
    }
    .list_table td,.list_table th{
        border: 1px solid #f1f2f6;
        padding: 0.5rem 0.5rem !important;
    }
.table>:not(:last-child)>:last-child>* {
    border: 1px solid #e6e6e6 !important;
}
    .userDatatable-header th {
        border-bottom: none;
        padding: 5px;
        vertical-align: middle;
        background: #f1f2f6;
        text-align: center !important;
    }

    p {
        line-height: 20px;
    }

    @media print {
        @import url('https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap');

        .formBody {
            padding: 20px 40px;
        }

        body {
            font-family: 'Jost', sans-serif !important;
            font-size: 10px !important;
            padding: 0.5px;
            margin: 0px;
        }
    table th,
    table td {
        font-family: 'Jost', sans-serif !important;
        font-size: 14px !important;
        border-collapse: collapse;
        padding: 1px !important;
    }
    .list_table{
        border-collapse: collapse;
    }
    .list_table td,.list_table th{
        border: 1px solid #f1f2f6;
        padding: 0.5rem 0.5rem !important;
    }
.table>:not(:last-child)>:last-child>* {
    border: 1px solid #e6e6e6 !important;
}
    .userDatatable-header th {
        border-bottom: none;
        padding: 5px;
        vertical-align: middle;
        background: #f1f2f6;
        text-align: center !important;
    }


        p {
            line-height: 18px;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        body {
            -webkit-print-color-adjust: exact;
            /*chrome & webkit browsers*/
            color-adjust: exact;
            /*firefox & IE */
            font-family: 'Jost', sans-serif;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        img {
            -webkit-print-color-adjust: exact;
        }

    }
</style>
<br>
<div class="formBody" style="width: 850px;margin:0 auto;">
    <table style="width:100%;" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <table style="width:100%;" cellspacing="0">
                        <tr>
                            <td style="width: 50%;padding-bottom:10px !important;">
                                <table style="width:100%;" cellspacing="0">
                                    <tr>
                                        <td style="padding-bottom: 5px !important;">
                                             <img style="width: 125px;" class="dark" src="{{ asset('assets/img/rangs-logo-1.png') }}" alt="svg">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600;">Customer Name :
                                            {{ $hirepurchase->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600;">Customer Phone :
                                            {{ $hirepurchase->pr_phone }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600;">Peresent Address :
                                            {{ $hirepurchase->pr_house_no }},
                                            {{ $hirepurchase->pr_road_no }},
                                            {{ $hirepurchase->districtpr->en_name }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 50%;text-align:right;padding-bottom:10px !important;">
                                <table style="width:100%;text-align:right;" cellspacing="0">
                                    <tr>
                                        <td style="font-weight: 600;">Order No: {{ $hirepurchase->order_no }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600;">Product Model: {{ $hirepurchase->purchase_product->product->product_model }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600;">Category: {{ $hirepurchase->purchase_product->product_category->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600;">Showroom Name: {{ $hirepurchase->show_room->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600;">Approval date: {{    date('d/m/Y', strtotime($hirepurchase->created_at)) }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="margin:0 auto;" class="table mb-0 table-bordered list_table">
                        <thead>
                            <tr class="userDatatable-header">
                                <th>
                                    <span class="userDatatable-title">SL</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Name of Installment</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Transaction Type</span>
                                </th>
                                 <th>
                                    <span class="userDatatable-title">Status</span>
                                </th>
                                 <th>
                                    <span class="userDatatable-title">Payment Date</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Amount</span>
                                </th>
                                <th>
                                    <span class="userDatatable-title">Due Date</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($installments as $key=>$item)
                            <tr>
                                <td>
                                    <div class="userDatatable-content">{{ $key+1 }}</div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">{{ \App\Helpers\Helper::formatOrdinal(++$key) }} Installment</div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        @if($key==1) Down Payment @else Installment @endif
                                    </div>
                                </td>
                                 <td>
                                    <div class="userDatatable-content">
                                        {{ $item->status == 1 ? "Paid" : "Unpaid" }}
                                    </div>
                                </td>
                                 <td>
                                    <div class="userDatatable-content">
                                       {{ $item->status == 1 ? $item->updated_at->format('d/m/Y') : "" }}
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        {{ $item->amount }}
                                    </div>
                                </td>
                                <td>
                                    <div class="userDatatable-content">
                                        {{    date('d/m/Y', strtotime($item->loan_end_date)), }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                                <tr>
                                  <td colspan="6">
                                    <div class="userDatatable-content">
                                     Hire Price :
                                    </div>
                                </td>
                                <td colspan="6">
                                    <div class="userDatatable-content">
                                  <b>  {{ $hirepurchase->purchase_product->hire_price }}</b>
                                    </div>
                                </td>
                            </tr>
                                <tr>
                                  <td colspan="6">
                                    <div class="userDatatable-content">
                                     Total Installment Amount :
                                    </div>
                                </td>
                                <td colspan="6">
                                    <div class="userDatatable-content">
                                   <b> {{ $total_installment_amount }}</b>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                  <td colspan="6">
                                    <div class="userDatatable-content">
                                        Advance Payment
                                    </div>
                                </td>
                                <td colspan="6">
                                    <div class="userDatatable-content">
                                    <b>{{ $advance_amount }}</b>
                                    </div>
                                </td>
                            </tr>
                              <tr>
                                  <td colspan="6">
                                    <div class="userDatatable-content">
                                       Due
                                    </div>
                                </td>
                                <td colspan="6">
                                    <div class="userDatatable-content">
                                  <b>  {{ $due }}</b>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p><b>Note :</b> This is system generated statement. No signature is required.</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    window.print();
</script>
