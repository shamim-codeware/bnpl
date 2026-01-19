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
                    <span class="userDatatable-title">Late Payment Fee</span>
                </th>
                <th>
                    <span class="userDatatable-title">Outstanding Balance</span>
                </th>
                <th>
                    <span class="userDatatable-title">Sales Return Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Return Amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">Refund Amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">Other Income (Defaulter)</span>
                </th>
                <th>
                    <span class="userDatatable-title">Return Reason</span>
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

            @php
                $lateFeeService = app(App\Service\LateFeeService::class);
            @endphp

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

                    $installment_paid = $purchase->installment->where('status', 1)->sum(function ($installment) {
                        return $installment->amount + $installment->fine_amount;
                    });

                    $total_paid = $installment_paid;

                    $just_installment_paid = $purchase->installment->where('status', 1)->sum('amount');
                    $hire_price = $purchase->hire_price ?? 0;

                    $late_fee = $lateFeeService->calculateLateFine($purchase->id);

                    // logger([
                    //     'late_fee' => $late_fee,
                    //     'just_installment_paid' => $just_installment_paid,
                    //     'hire_price' => $hire_price,
                    // ])

                    // $outstanding_balance = $hire_price - $just_installment_paid + $late_fee;
                    $outstanding_balance = max(0, $hire_price - $just_installment_paid + $late_fee);

                    $next_due_date = null;
                    if ($purchase->installment && count($purchase->installment) > 0) {
                        foreach ($purchase->installment as $installment) {
                            if ($installment->status == 0) {
                                $next_due_date = $installment->loan_start_date;
                                break;
                            }
                        }
                    }

                    // Sales Return data
                    $return = $purchase->salesReturn;
                    $return_date = $return ? \Carbon\Carbon::parse($return->returned_at)->format('d M Y') : 'N/A';
                    $return_amount = $return ? number_format($return->return_amount ?? 0, 2) : '0.00';
                    $refund_amount = $return ? number_format($return->refund_amount ?? 0, 2) : '0.00';
                    $other_income = $return ? number_format($return->other_income ?? 0, 2) : '0.00';
                    $return_reason = $return ? $return->reason_text ?? ucfirst($return->reason) : 'N/A';

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
                        <div class="userDatatable-content">{{ $purchase->name }}</div>
                    </td>
                    {{-- <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->purchase_product->product->product_type->name }}
                        </div>
                    </td> --}}
                    <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->purchase_products->pluck('product.product_model')->implode(', ') }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->hire_price }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ @$purchase->approval_date ? \Carbon\Carbon::parse($purchase->approval_date)->format('d F Y') : '' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $next_due_date ? \Carbon\Carbon::parse($next_due_date)->format('d F Y') : 'N/A' }}
                        </div>
                    </td>
                    {{-- <td>
                        <div class="userDatatable-content">{{ @$purchase->purchase_product->total_paid }}</div>
                    </td> --}}
                    <td>
                        <div class="userDatatable-content">{{ @$total_paid }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ @$purchase->late_fee }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ number_format($outstanding_balance, 2) }}</div>
                    </td>

                    <!-- নতুন কলাম -->
                    <td>{{ $return_date }}</td>
                    <td>{{ $return_amount }}</td>
                    <td>{{ $refund_amount }}</td>
                    <td>{{ $other_income }}</td>
                    <td>{{ $return_reason }}</td>
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
                                switch ($purchase->status) {
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
                                    case 5:
                                        $statusText = 'Sale Return';
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
                            @if ($purchase->status == 0 && Auth::user()->role_id == 1)
                                <a style="white-space: nowrap" class="btn btn-success w-100 d-block btn-sm"
                                    href="{{ url('product_edit_after_approval/' . $purchase->id) }}"
                                    title="View details" target="_blank">
                                    Edit
                                </a>
                            @endif
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
