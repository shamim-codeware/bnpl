<div>
    <div class="table-responsive d-lg-block d-md-block  custom-data-table-wrapper2">
        <table class="table mb-0 table-bordered custom-data-table">
            <thead>
                <tr class="userDatatable-header">
                    <th>
                        <span class="userDatatable-title">SL</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Order No </span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Customer name</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Phone number</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Product model</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">CTP</span>
                    </th>
                    <th style="width: 13%;" data-type="html" data-name='Booking Id'>
                        <span class="userDatatable-title">Purchase date and time</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Hire Price</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">First Installment</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Monthly Installment</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">SR</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Created By</span>
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
                    $total = 0;

                @endphp
                @foreach ($hirepurchase as $key => $hire)
                    @php
                        $status = 'Regular';

                        if ($hire->installment && $hire->installment->isNotEmpty()) {
                            $hasUnpaid = $hire->installment->contains('status', 0);

                            if (!$hasUnpaid) {
                                $status = 'Paid';
                            } else {
                                $lastUnpaidDate = $hire->installment->where('status', 0)->max('loan_start_date');
                                $hasOverdueUnpaid = $hire->installment
                                    ->where('status', 0)
                                    ->filter(function ($inst) {
                                        return \Carbon\Carbon::parse($inst->loan_start_date)->lt(now());
                                    })
                                    ->isNotEmpty();

                                if ($lastUnpaidDate) {
                                    $lastDue = \Carbon\Carbon::parse($lastUnpaidDate);
                                    if ($lastDue->lt(now()->subDays(30))) {
                                        $status = 'Defaulter';
                                    } elseif ($hasOverdueUnpaid) {
                                        $status = 'Overdue';
                                    }
                                } elseif ($hasOverdueUnpaid) {
                                    $status = 'Overdue';
                                }
                            }
                        }
                    @endphp
                    @php
                        $total += @$hire->monthly_installment;
                    @endphp
                    <tr>
                        <td>
                            <div class="userDatatable-content">{{ $key + 1 }}</div>
                        </td>
                        <td>{{ $hire->order_no }}</td>
                        <td>
                            <div class="userDatatable-content">{{ $hire->name }}</div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ $hire->pr_phone }}
                            </div>
                        </td>
                        {{-- <td>
                            <div class="userDatatable-content">
                                {{ @$hire->purchase_product->product->product_model }}
                            </div>
                        </td> --}}
                        <td>
                            <div class="userDatatable-content">
                                @foreach ($hire->purchase_products as $purchaseProduct)
                                    {{ $purchaseProduct->product->product_model }}<br>
                                @endforeach
                            </div>
                        </td>

                        <td>
                            <div class="userDatatable-content">
                                {{ @$hire->show_room->name }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="userDatatable-inline-title">
                                    <a href="#" class="text-dark fw-500">
                                        <h6>{{ \Carbon\Carbon::parse($hire->created_at)->format('d F Y') }}</h6>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ @$hire->hire_price }}
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ @$hire->down_payment }}
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ @$hire->monthly_installment }}
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ @$hire->show_room_user->name }}
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                {{ @$hire->users->name }}
                            </div>
                        </td>
                        <td>
                            <div
                                class="userDatatable-content
        {{ $status === 'Paid' ? 'text-success fw-bold' : '' }}
        {{ $status === 'Defaulter' ? 'text-danger fw-bold' : '' }}
        {{ $status === 'Overdue' ? 'text-warning fw-bold' : '' }}
        {{ $status === 'Regular' ? 'text-warning fw-medium' : '' }}">

                                {{ $status }}
                            </div>
                        </td>

                        <td>
                            <ul class="mb-0 d-flex justify-content-center gap-2">
                                <li class="d-flex align-items-center gap-2">
                                    <a class="action-icon action-icon--info"
                                        href="{{ url('product_details/' . $hire->id) }}" target="_blank"
                                        title="Product Details" aria-label="Product Details">
                                         <i class="uil uil-eye"></i>
                                    </a>
                                    @if (Auth::user()->role_id == 1 && ($hire->status = 3))
                                        <a class="action-icon action-icon--success" target="_blank"
                                            href="{{ url('product_edit_after_approval/' . $hire->id) }}"
                                            title="Product Edit" aria-label="Product Edit">
                                            <i class="uil uil-edit"></i>
                                        </a>
                                    @endif
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach

                {{-- <b>Total - </b>   {{  $total }} --}}

            </tbody>
        </table>
        <div class="pt-2">
            {{ $hirepurchase->links() }}
        </div>
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
<style>
    .action-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f1f3f5;
        color: #495057;
        text-decoration: none;
        transition: all 0.15s ease-in-out;
    }
    .action-icon:hover {
        background: #e9ecef;
        color: #212529;
        text-decoration: none;
    }
    .action-icon--info { color: #0d6efd; }
    .action-icon--success { color: #198754; }
    .action-icon i { font-size: 18px; }
</style>
