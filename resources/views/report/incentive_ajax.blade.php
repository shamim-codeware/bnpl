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
                    <span class="userDatatable-title">Product Group</span>
                </th>
                <th>
                    <span class="userDatatable-title">Product Model</span>
                </th>
                <th>
                    <span class="userDatatable-title">Incentive Type</span>
                </th>
                <th>
                    <span class="userDatatable-title">Incentive Category</span>
                </th>
                <th>
                    <span class="userDatatable-title">Incentive Amount (Tk)</span>
                </th>
                <th>
                    <span class="userDatatable-title">Created Date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Showroom</span>
                </th>
                <th>
                    <span class="userDatatable-title">Created By</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incentives as $key => $incentive)
                @php
                    $order_no = $incentive->hirePurchase->order_no ?? '';
                    $customer_name = $incentive->hirePurchase->name ?? '';
                    $product_group = $incentive->hirePurchase->purchase_products
                        ? $incentive->hirePurchase->purchase_products->pluck('product_group.name')->implode(', ')
                        : '';

                    $product_model = $incentive->hirePurchase->purchase_products
                        ? $incentive->hirePurchase->purchase_products->pluck('product.product_model')->implode(', ')
                        : '';

                    $showroom_name = $incentive->hirePurchase->show_room->name ?? '';
                    $created_by = $incentive->hirePurchase->users->name ?? '';

                    // Determine incentive category based on type
                    $incentive_category = '';
                    if ($incentive->type == 'sure_shot') {
                        if ($incentive->sure_shot_type == 'category') {
                            $incentive_category = $incentive->product_category_name ?? '';
                        } elseif ($incentive->sure_shot_type == 'model') {
                            $incentive_category = $incentive->product_model_name ?? '';
                        }
                    } else {
                        $incentive_category = ucfirst($incentive->type);
                    }

                    // Format incentive amount
                    $incentive_amount = number_format($incentive->incentive_amount, 2);

                    // Format created date
                    $created_at = $incentive->created_at->format('d/m/Y H:i:s');
                @endphp
                <tr>
                    <td>
                        <div class="userDatatable-content">{{ $key + 1 }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $order_no }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $customer_name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $product_group }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $product_model }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @if ($incentive->type == 'down_payment')
                                <span class="badge bg-primary">Down Payment</span>
                            @elseif($incentive->type == 'collection')
                                <span class="badge bg-info">Collection</span>
                            @elseif($incentive->type == 'sure_shot')
                                @if ($incentive->sure_shot_type == 'category')
                                    <span class="badge bg-success">Category Wise</span>
                                @elseif($incentive->sure_shot_type == 'model')
                                    <span class="badge bg-danger">Model Wise</span>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $incentive_category }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content"><strong>Tk {{ $incentive_amount }}</strong></div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $created_at }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $showroom_name }}</div>
                    </td>
                    <td>
                        <div class="userDatatable-content">{{ $created_by }}</div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (empty($incentives))
        <p class="text-center">No incentive data found</p>
    @endif
</div>

<div class="pt-2">
    {{ $incentives->links() }}
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
