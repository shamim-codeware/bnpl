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
                {{-- <th>
                    <span class="userDatatable-title">Group</span>
                </th> --}}
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
                    <span class="userDatatable-title">Next Payment Due</span>
                </th>
                <th>
                    <span class="userDatatable-title">Total Paid</span>
                </th>
                <th>
                    <span class="userDatatable-title">Outstanding Balance</span>
                </th>
                <th>
                    <span class="userDatatable-title">Phone</span>
                </th>
                <th>
                    <span class="userDatatable-title">Showroom</span>
                </th>
                <th>
                    <span class="userDatatable-title">Status</span>
                </th>
                <th>
                    <span class="userDatatable-title">Action</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hirepurchase as $key => $purchase)
                @php
                    $last_payment = '';
                    $last_paid_amount = 0;
                    $outstanding_balance = 0;

                    if ($purchase->transaction && count($purchase->transaction) > 0) {
                        $lastTransaction = $purchase->transaction[count($purchase->transaction) - 1];
                        $last_payment = $lastTransaction->updated_at;
                        $last_paid_amount = $lastTransaction->amount;
                    }

                    if ($purchase->purchase_product) {
                        $outstanding_balance = $purchase->purchase_product->hire_price - $purchase->purchase_product->total_paid;
                    }

                    $next_due_date = null;
                    if ($purchase->installment && count($purchase->installment) > 0) {
                        foreach ($purchase->installment as $installment) {
                            if ($installment->status == 0) {
                                $next_due_date = $installment->loan_start_date;
                                break;
                            }
                        }
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
                    {{-- <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->purchase_product->product->product_type->name }}
                        </div>
                    </td> --}}
                    <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->purchase_product->product->product_model }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product->hire_price }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->approval_date ? \App\Helpers\Helper::formatDateStandard($purchase->approval_date) : '' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $next_due_date ? \App\Helpers\Helper::formatDateStandard($next_due_date) : 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product->total_paid }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $outstanding_balance }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->pr_phone }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->show_room->name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @php
                                $statusText = '';
                                switch($purchase->status) {
                                    case 0:
                                        $statusText = 'Pending';
                                        break;
                                    case 1:
                                        $statusText = 'Approved';
                                        break;
                                    case 2:
                                        $statusText = 'Rejected';
                                        break;
                                    case 3:
                                        $statusText = 'Sale Confirm';
                                        break;
                                    case 4:
                                        $statusText = 'Sale Cancel';
                                        break;
                                    default:
                                        $statusText = 'Unknown';
                                }
                            @endphp
                            {{ $statusText }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            <a class="btn btn-info" href="{{ url('product_details', $purchase->id) }}" target="_blank">
                                Product Details
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (empty($hirepurchase))
        <p class="text-center">Data Not Found</p>
    @endif

</div>
<div class="pt-2">
    {{ $hirepurchase->links() }}
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
