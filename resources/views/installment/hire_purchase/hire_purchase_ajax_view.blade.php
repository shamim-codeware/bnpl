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
                    <span class="userDatatable-title">Action</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @php
               $total = 0;

            @endphp
            @foreach($hirepurchase as $key=>$hire)
            @php
                $total += @$hire->purchase_product->monthly_installment;
            @endphp
            <tr>
                <td>
                    <div class="userDatatable-content">{{ $key+1 }}</div>
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
                <td>
                    <div class="userDatatable-content">
                        {{ @$hire->purchase_product->product->product_model }}
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
                                <h6>{{ \App\Helpers\Helper::formatDateTimeStandard($hire->created_at) }}</h6>
                            </a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$hire->purchase_product->hire_price }}
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$hire->purchase_product->down_payment }}
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$hire->purchase_product->monthly_installment }}
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

                   <a style="white-space: nowrap"  class="btn btn-info" href="{{ url('product_details/'.$hire->id) }}" target="_blank">Product Details</a>
@if(Auth::user()->role_id == 1)
                    <a style="white-space: nowrap"  class="btn btn-success" href="{{ url('hire-purchase-product-edit/'.$hire->id) }}" >Product Edit</a>
@endif
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
