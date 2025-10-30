<div class="table-responsive d-block custom-data-table-wrapper2">
    <table class="table mb-0 table-bordered custom-data-table">
        <thead>
            <tr class="userDatatable-header">
                <th>SL</th>
                <th>
                    <span class="userDatatable-title">Order No</span>
                </th>
                <th>
                    <span class="userDatatable-title">Transaction type</span>
                </th>
                <th>
                    <span class="userDatatable-title">customer name</span>
                </th>
                <th>
                    <span class="userDatatable-title">phone number</span>
                </th>
                <th>
                    <span class="userDatatable-title">product model</span>
                </th>
                <th>
                    <span class="userDatatable-title">showroom</span>
                </th>
                <th style="width: 13%;" data-type="html" data-name='Booking Id'>
                    <span class="userDatatable-title">transaction date and time</span>
                </th>
                <th>
                    <span class="userDatatable-title">transaction amount</span>
                </th>
                <th>
                    <span class="userDatatable-title">received by</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($installments as $key=>$item)
            <tr>
                <td>{{ ($installments->currentPage() - 1) * $installments->perPage() + $key + 1 }}</td>
                <td>
                    <div class="userDatatable-content">
                        @if(@$item->hire_purchase->order_no)
                            {{-- <a href="" class="text-dark fw-500"> --}}
                                {{ @$item->hire_purchase->order_no }}
                            {{-- </a> --}}
                        @else
                            <span class="text-danger">N/A</span>
                        @endif
                    </div>
                </td>
                <td>
                   <div class="userDatatable-content">{{ $item->transaction_type }}</div>
                </td>
                <td>
                    <div class="userDatatable-content">{{ @$item->hire_purchase->name }}</div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$item->hire_purchase->pr_phone }}
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$item->hire_purchase->purchase_product->product->product_model }}
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$item->hire_purchase->show_room->name }}
                    </div>
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <div class="userDatatable-inline-title">
                            <a href="#" class="text-dark fw-500">
                                <h6>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</h6>
                            </a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ $item->amount }}
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$item->users->name  }}

                    </div>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div class="pt-2">
        {{ $installments->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
    $(document).ready(function () {
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
    $customDataTableWrapper1.on('scroll', function () {
        $customDataTableWrapper2.scrollLeft($customDataTableWrapper1.scrollLeft());
    });

    // Add a scroll event listener to customDataTableWrapper2
    $customDataTableWrapper2.on('scroll', function () {
        $customDataTableWrapper1.scrollLeft($customDataTableWrapper2.scrollLeft());
    });

    let $customDataTable = $('.custom-data-table');
    let customDataTableWidth = $customDataTable.outerWidth();
    $('.custom-data-table-top-scrollbar').css('width', customDataTableWidth + 'px');
});
</script>
