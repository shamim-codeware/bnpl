<?php
$total_amount = 0;
$total_last_paid_amount = 0;
?>

<div class="table-responsive d-block custom-data-table-wrapper2">
    <table class="table mb-0 table-bordered custom-data-table">
        <thead>
            <tr class="userDatatable-header">
                <th>
                    <span class="userDatatable-title">SL No</span>
                </th>
                <th>
                    <span class="userDatatable-title">Oder No</span>
                </th>
                <th>
                    <span class="userDatatable-title">Group</span>
                </th>
                <th>
                    <span class="userDatatable-title">Category</span>
                </th>
                <th>
                    <span class="userDatatable-title">Brand</span>
                </th>
                <th>
                    <span class="userDatatable-title">Model</span>
                </th>
                <th>
                    <span class="userDatatable-title">Total Amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">Loan Start Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Loan End Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Last Payment</span>
                </th>
                <th>
                    <span class="userDatatable-title">Last Paid Amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">Details</span>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach ($hirepurchase as $key => $purchase)
                @php
                    $firstLoanStartDate = null;
                    $lastLoanEndDate = null;
                    $last_payment = null;
                    $last_paid_amount = 0;

                    // Safely get first and last installment dates
                    // if ($purchase->installment && count($purchase->installment) > 0) {
                    //     $firstLoanStartDate = $purchase->installment[0]->loan_start_date;
                    //     $lastLoanEndDate = $purchase->installment[count($purchase->installment) - 1]->loan_end_date;
                    // }
                    if ($purchase->installment && count($purchase->installment) > 0) {
                        $firstLoanStartDate = $purchase->installment->min('loan_start_date');
                        $lastLoanEndDate = $purchase->installment->max('loan_start_date');
                    }

                    // Safely get last transaction details
                    if ($purchase->transaction && count($purchase->transaction) > 0) {
                        $lastTransaction = $purchase->transaction[count($purchase->transaction) - 1];
                        $last_payment = $lastTransaction->updated_at;
                        $last_paid_amount = $lastTransaction->amount;
                    }
                @endphp
                <tr>
                    <td>
                        <div class="userDatatable-content">{{ $key + 1 }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $purchase->order_no }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @foreach ($purchase->purchase_products as $purchaseProduct)
                                {{ $purchaseProduct->product_group->name }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @foreach ($purchase->purchase_products as $purchaseProduct)
                                {{ $purchaseProduct->product_category->name }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @foreach ($purchase->purchase_products as $purchaseProduct)
                                {{ $purchaseProduct->brand->name }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->purchase_products->pluck('product.product_model')->implode(', ') }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            <?php
                                $purchase_total =  $purchase->total_paid ?? '0.00';
                                $total_amount += $purchase_total;
                            ?>
                            {{ number_format($purchase_total, 2) }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $firstLoanStartDate ? \Carbon\Carbon::parse($firstLoanStartDate)->format('d F Y') : 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $lastLoanEndDate ? \Carbon\Carbon::parse($lastLoanEndDate)->format('d F Y') : 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $last_payment ? \Carbon\Carbon::parse($last_payment)->format('d F Y') : 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            <?php
                                //$last_paid_amount = $last_paid_amount ?? '0.00';
                                $total_last_paid_amount += $last_paid_amount;
                            ?>
                            {{ number_format($last_paid_amount, 2) }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content"><a class="btn btn-info"
                                href="{{ url('product_details', $purchase->id) }}" target="_blank">Product Details</a>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <th colspan="6"></th>
                <th>{{ number_format($total_amount, 2) }}</th>
                <th colspan="3"></th>
                <th>{{ number_format($total_last_paid_amount, 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    @if (empty($hirepurchase))
        <p class="text-center">Data Not Found</p>
    @endif
    <div class="pt-2">
        {{ $hirepurchase->links() }}
    </div>
</div>

<script>
    $(document).ready(function() {
        // Create the outer div for the table top scrollbar
        let $parentDivForTableTopScrollBar = $('<div></div>').addClass('custom-data-table-wrapper1 sticky-top');

        // Create the inner div for the table top scrollbar
        let $innerDivForTableTopScrollBar = $('<div></div>').addClass('custom-data-table-top-scrollbar');

        // Append the inner div to the outer div
        $parentDivForTableTopScrollBar.append($innerDivForTableTopScrollBar);

        // Insert the outer div before the .custom-data-table-wrapper2 element
        let $customDataTableWrapper2 = $('.custom-data-table-wrapper2');
        $parentDivForTableTopScrollBar.insertBefore($customDataTableWrapper2);

        let $customDataTableWrapper1 = $('.custom-data-table-wrapper1');

        // Add a scroll event listener to customDataTableWrapper1
        $customDataTableWrapper1.on('scroll', function() {
            $customDataTableWrapper2.scrollLeft($customDataTableWrapper1.scrollLeft());
        });

        // Add a scroll event listener to customDataTableWrapper2
        $customDataTableWrapper2.on('scroll', function() {
            $customDataTableWrapper1.scrollLeft($customDataTableWrapper2.scrollLeft());
        });

        let $customDataTable = $('.custom-data-table');
        let customDataTableWidth = $customDataTable.outerWidth();
        $('.custom-data-table-top-scrollbar').css('width', customDataTableWidth + 'px');
    });
</script>
