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
                    <span class="userDatatable-title">Late Payment Fee</span>
                </th>
                <th>
                    <span class="userDatatable-title">Outstanding Blance</span>
                </th>
                <th>
                    <span class="userDatatable-title">Pr Number</span>
                </th>
                <th>
                    <span class="userDatatable-title">Zone</span>
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
                    if ($purchase->installment && count($purchase->installment) > 0) {
                        $firstLoanStartDate = $purchase->installment[0]->loan_start_date;
                        $lastLoanEndDate = $purchase->installment[count($purchase->installment) - 1]->loan_end_date;
                    }

                    // Safely get last transaction details
                    if ($purchase->transaction && count($purchase->transaction) > 0) {
                        $lastTransaction = $purchase->transaction[count($purchase->transaction) - 1];
                        $last_payment = $lastTransaction->updated_at;
                        $last_paid_amount = $lastTransaction->amount;
                    }

                    // $outstanding_balance = $purchase->purchase_product ? ($purchase->purchase_product->hire_price - $purchase->purchase_product->total_paid) : 0;
                    // Installment paid
                    $installment_paid = $purchase->installment->where('status', 1)->sum('amount');
                    $hire_price = $purchase->purchase_product->hire_price ?? 0;

                    // Late fee via Trait
                    $lateFeeService = app(App\Service\LateFeeService::class);
                    $late_fee = $lateFeeService->calculateLateFine($purchase->id);

                    // Final outstanding balance
                    $outstanding_balance = $hire_price - $installment_paid + $late_fee;

                @endphp
                <tr>
                    <td>
                        <div class="userDatatable-content">
                            {{ ($hirepurchase->currentPage() - 1) * $hirepurchase->perPage() + $key + 1 }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $purchase->order_no }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product->product_group->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product->product->product_model }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->purchase_product ? (float) $purchase->purchase_product->hire_price : '0.00' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ \Carbon\Carbon::parse(@$firstLoanStartDate)->format('d F Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ \Carbon\Carbon::parse(@$lastLoanEndDate)->format('d F Y') }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ \Carbon\Carbon::parse(@$last_payment)->format('d F Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $last_paid_amount }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $purchase->late_fee }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{number_format($outstanding_balance, 2) }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->pr_phone }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->show_room->zone->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content"><a class="btn btn-info"
                                href="{{ url('product_details', $purchase->id) }}" target="_blank">Product Details</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (empty($hirepurchase))
        <p class="text-center">Data Not Found</p>
    @endif
    <div class="pt-2">
        {{ $hirepurchase->links() }}
    </div>
</div>

<style>
    .custom-data-table th:nth-child(6),
    .custom-data-table th:nth-child(7),
    .custom-data-table th:nth-child(8),
    .custom-data-table td:nth-child(6),
    .custom-data-table td:nth-child(7),
    .custom-data-table td:nth-child(8) {
        min-width: 120px;
        white-space: nowrap;
    }
</style>

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
