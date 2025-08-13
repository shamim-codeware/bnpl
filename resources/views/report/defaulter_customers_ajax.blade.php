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
                    <span class="userDatatable-title">Product Name</span>
                </th>
                <th>
                    <span class="userDatatable-title">Phone</span>
                </th>
                <th>
                    <span class="userDatatable-title">Total Amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">Outstanding Balance</span>
                </th>
                <th>
                    <span class="userDatatable-title">Last Payment Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Days Overdue</span>
                </th>
                <th>
                    <span class="userDatatable-title">Next Due Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Showroom</span>
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
            @foreach ($customers as $key => $customer)
                @php
                    $next_due_date = null;
                    $outstanding_balance = 0;

                    // Find the earliest overdue installment
                    if ($customer->installment && count($customer->installment) > 0) {
                        $overdue_installments = $customer->installment->filter(function($installment) {
                            return $installment->status == 0 && $installment->loan_start_date < now()->toDateString();
                        })->sortBy('loan_start_date');

                        if ($overdue_installments->count() > 0) {
                            $next_due_date = $overdue_installments->first()->loan_start_date;
                        }
                    }

                    if ($customer->purchase_product) {
                        $outstanding_balance = $customer->purchase_product->hire_price - $customer->purchase_product->total_paid;
                    }
                @endphp
                <tr>
                    <td>
                        <div class="userDatatable-content">{{ ($customers->currentpage()-1) * $customers->perpage() + $key + 1 }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $customer->order_no }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $customer->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $customer->purchase_product->product->product_model }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $customer->pr_phone }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$customer->purchase_product ? number_format($customer->purchase_product->hire_price, 2) : '0.00' }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ number_format($outstanding_balance, 2) }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @php
                                $last_payment = null;
                                if ($customer->transaction && count($customer->transaction) > 0) {
                                    $last_transaction = $customer->transaction->sortByDesc('created_at')->first();
                                    $last_payment = $last_transaction->created_at;
                                }
                            @endphp
                            {{ $last_payment ? \App\Helpers\Helper::formatDateStandard($last_payment) : 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $customer->days_overdue ?? 0 }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $next_due_date ? \App\Helpers\Helper::formatDateStandard($next_due_date) : 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$customer->show_room->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$customer->show_room->zone->name ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            <a class="btn btn-info" href="{{ url('product_details', $customer->id) }}" target="_blank">
                                Product Details
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (empty($customers))
        <p class="text-center">Data Not Found</p>
    @endif
</div>
<div class="pt-2">
    {{ $customers->links() }}
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
