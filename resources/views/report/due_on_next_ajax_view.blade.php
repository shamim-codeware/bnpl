<div class="table-responsive d-block custom-data-table-wrapper2">
    <table class="table mb-0 table-bordered custom-data-table">
        <thead>
            <tr class="userDatatable-header">
                <th>
                    <span class="userDatatable-title">SL No</span>
                </th>
                <th>
                    <span class="userDatatable-title">Order No</span>
                </th>
                <th>
                    <span class="userDatatable-title">Customer Name</span>
                </th>
                <th>
                    <span class="userDatatable-title">Phone Number</span>
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
                    <span class="userDatatable-title">Next Payment Due Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Monthly Installment</span>
                </th>
                <th>
                    <span class="userDatatable-title">Last Payment Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Last Paid Amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">Outstanding Amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">CTP</span>
                </th>
                <th>
                    <span class="userDatatable-title">Zone</span>
                </th>
                <th>
                    <span class="userDatatable-title">Action</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hirepurchase as $key => $purchase)
                @php
                    // Get next due installment in the specified date range
                    $nextDueInstallment = $purchase->installment->where('status', 0)->first();

                    // Get last payment details
                    $last_payment = null;
                    $last_paid_amount = 0;
                    if ($purchase->transaction && count($purchase->transaction) > 0) {
                        $lastTransaction = $purchase->transaction->first();
                        if ($lastTransaction) {
                            $last_payment = $lastTransaction->updated_at;
                            $last_paid_amount = $lastTransaction->amount;
                        }
                    }

                    // Calculate outstanding balance
                    $outstanding_balance = 0;
                    if ($purchase->purchase_product) {
                        $outstanding_balance = $purchase->purchase_product->hire_price - $purchase->purchase_product->total_paid;
                    }
                @endphp
                <tr>
                    <td>
                        <div class="userDatatable-content">{{ ($hirepurchase->currentPage() - 1) * $hirepurchase->perPage() + $key + 1 }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $purchase->order_no }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $purchase->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $purchase->pr_phone }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product->product_group->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product->product->product_model }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product ? number_format($purchase->purchase_product->hire_price, 2) : '0.00' }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @if($nextDueInstallment)
                                {{ \App\Helpers\Helper::formatDateStandard($nextDueInstallment->loan_start_date) }}
                            @else
                                N/A
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product ? number_format($purchase->purchase_product->monthly_installment, 2) : '0.00' }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $last_payment ? \App\Helpers\Helper::formatDateTimeStandard($last_payment) : 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ number_format($last_paid_amount, 2) }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ number_format($outstanding_balance, 2) }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->show_room->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->show_room->zone->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            <a class="btn btn-info" href="{{ url('product_details', $purchase->id) }}" target="_blank">Product Details</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($hirepurchase->isEmpty())
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
