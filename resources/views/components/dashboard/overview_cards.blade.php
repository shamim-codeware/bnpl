<div class="col-xxl-12">
    <div class="row g-4 mb-3">
        <!-- Total Bookings -->
        {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div
                class="d-flex align-items-center gap-3 p-3 border border-primary-subtle rounded-3 bg-blue-50 border border-blue-200">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-blue-100 text-blue-600"
                    style="width:40px; height:40px;">
                    <i class="far fa-calendar-check fs-5"></i>
                </div>
                <div>
                    <p class="mb-0 fs-6 text-gray-600 fw-600">Total Sale</p>
                    <p class="mb-0 fs-5 fw-bold text-blue-600">{{ $data['dashboard_stats']['total_sale'] }}</p>
                </div>
            </div>
        </div> --}}

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="p-3 border border-primary-subtle rounded-3 bg-blue-50 shadow-sm h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-blue-100 text-blue-600 me-3"
                        style="width:40px; height:40px;">
                        <i class="fas fa-shopping-cart fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-gray-800">Total Sales</h6>
                </div>

                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Since Beginning:</span>
                        <span
                            class="fw-bold text-blue-700">{{ $data['dashboard_stats']['total_sales_since_beginning'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Fiscal Year:</span>
                        <span
                            class="fw-bold text-blue-700">{{ $data['dashboard_stats']['total_sales_fiscal_year'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Current Month:</span>
                        <span
                            class="fw-bold text-blue-700">{{ $data['dashboard_stats']['total_sales_current_month'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmed -->
        {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div
                class="d-flex align-items-center gap-3 p-3 border border-success-subtle rounded-3 bg-green-50 border border-green-200">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-green-100 text-green-600"
                    style="width:40px; height:40px;">
                    <i class="fa fa-check fs-5"></i>
                </div>
                <div>
                    <p class="mb-0 fs-6 text-gray-600 fw-600">Full Paid Customers</p>
                    <p class="mb-0 fs-5 fw-bold text-green-600">{{ $data['dashboard_stats']['full_paid'] }}</p>
                </div>
            </div>
        </div> --}}

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="p-3 border border-success-subtle rounded-3 bg-green-50 shadow-sm h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-green-100 text-green-600 me-3"
                        style="width:40px; height:40px;">
                        <i class="fa fa-check fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-gray-800">Total Outstanding</h6>
                </div>

                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Since Beginning:</span>
                        <span
                            class="fw-bold text-green-700">৳{{ number_format($data['dashboard_stats']['total_outstanding_since_beginning'], 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Fiscal Year:</span>
                        <span
                            class="fw-bold text-green-700">৳{{ number_format($data['dashboard_stats']['total_outstanding_fiscal_year'], 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Current Month:</span>
                        <span
                            class="fw-bold text-green-700">৳{{ number_format($data['dashboard_stats']['total_outstanding_current_month'], 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Awaiting -->
        {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div
                class="d-flex align-items-center gap-3 p-3 border border-warning-subtle rounded-3 bg-yellow-50 border border-yellow-200">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-yellow-100 text-yellow-600"
                    style="width:40px; height:40px;">
                    <i class="far fa-clock fs-5"></i>
                </div>
                <div>
                    <p class="mb-0 fs-6 text-gray-600 fw-600">Customer With Due</p>
                    <p class="mb-0 fs-5 fw-bold text-warning">{{ $data['dashboard_stats']['customer_with_due'] }}</p>
                </div>
            </div>
        </div> --}}

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="p-3 border border-danger-subtle rounded-3 bg-red-50 shadow-sm h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-red-100 text-red-600 me-3"
                        style="width:40px; height:40px;">
                        <i class="fas fa-file-invoice-dollar fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-gray-800">Total Overdue</h6>
                </div>

                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Since Beginning:</span>
                        <span
                            class="fw-bold text-red-700">৳{{ number_format($data['dashboard_stats']['total_overdue_since_beginning'], 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Fiscal Year:</span>
                        <span
                            class="fw-bold text-red-700">৳{{ number_format($data['dashboard_stats']['total_overdue_fiscal_year'], 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Current Month:</span>
                        <span
                            class="fw-bold text-red-700">৳{{ number_format($data['dashboard_stats']['total_overdue_current_month'], 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Canceled -->
        {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="d-flex align-items-center gap-3 p-3 border border-danger-subtle rounded-3 bg-red-50 border border-red-200">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-red-100 text-red-600" style="width:40px; height:40px;">
                    <i class="fa fa-times fs-5"></i>
                </div>
                <div>
                    <p class="mb-0 fs-6 text-gray-600 fw-600">Pending</p>
                    <p class="mb-0 fs-5 fw-bold text-danger">{{ $data['dashboard_stats']['pending'] }}</p>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div
                class="d-flex align-items-center gap-3 p-3 border border-primary-subtle rounded-3 bg-blue-50 border border-blue-200">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-blue-100 text-blue-600"
                    style="width:40px; height:40px;">
                    <i class="far fa-clock fs-5"></i>
                </div>
                <div>
                    <p class="mb-0 fs-6 text-gray-600 fw-600">Pending Customers</p>
                    <p class="mb-0 fs-5 fw-bold text-blue-600">{{ $data['dashboard_stats']['pending'] }}</p>
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                style="background-color: #f3e8ff; border: 1px solid #d8b4fe;">
                <div class="d-flex align-items-center justify-content-center rounded-circle"
                    style="width:40px; height:40px; background-color:#e9d5ff; color:#7c3aed;">
                    <i class="far fa-clock fs-5"></i>
                </div>
                <div>
                    <p class="mb-0 fs-6 text-gray-600 fw-600">Pending Approval</p>
                    <p class="mb-0 fs-5 fw-bold" style="color:#7c3aed;">
                        {{ $data['dashboard_stats']['pending'] }}
                    </p>
                </div>
            </div>
        </div> --}}

        {{-- Total Collection Card --}}
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="p-3 border border-teal-subtle rounded-3 bg-teal-50 border border-teal-200 shadow-sm h-10 h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-teal-100 text-teal-600 me-3"
                        style="width:40px; height:40px;">
                        <i class="fas fa-wallet fs-5"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-gray-800">Total Collection</h6>
                </div>

                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Since Beginning:</span>
                        <span
                            class="fw-bold text-teal-700">৳{{ number_format($data['dashboard_stats']['total_collection_since_beginning'], 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Fiscal Year:</span>
                        <span
                            class="fw-bold text-teal-700">৳{{ number_format($data['dashboard_stats']['total_collection_fiscal_year'], 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Current Month:</span>
                        <span
                            class="fw-bold text-teal-700">৳{{ number_format($data['dashboard_stats']['total_collection_current_month'], 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row gx-2">
        <div class="col-lg-4 mb-3">
            <a href="#">
                <div class="card">
                    <div class="d-flex p-2 box-header">
                        <p class="m-0 fw-600">Credit Limit</p>
                    </div>
                    <div class="card-box-value d-flex align-items-end px-2 py-2 gap-1">
                        <h2 class="fs-5 lh-36px">{{ number_format($data['showroom_credit'], 2) }}TK</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 mb-3">
            <a href="#">
                <div class="card">
                    <div class="d-flex p-2 box-header">
                        <p class="m-0 fw-600">Used Balance</p>
                    </div>
                    <div class="card-box-value d-flex align-items-end px-2 py-2 gap-1">
                        <h2 class="fs-5 lh-36px"> {{ number_format($data['remaining_credit'] ?? 0, 2) }} TK</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 mb-3">
            <a href="#">
                <div class="card">
                    <div class="d-flex p-2 box-header">
                        <p class="m-0 fw-600">Remaining Balance</p>
                    </div>
                    <div class="card-box-value d-flex align-items-end px-2 py-2 gap-1">
                        <h2 class="fs-5 lh-36px">
                            {{ number_format($data['showroom_credit'] - $data['remaining_credit'], 2) }}TK</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row gx-2 ">
        <div class="col-lg-3  col-md-6">
            <div class="card mb-3">
                <a href="{{ url('/credit-score') }}"
                    class="d-flex p-1 gap-3 align-items-center order-bg-opacity-primary rounded_10">
                    <div class="ap-po-details__icon-area color-primary"><i class="uil uil-sign-in-alt"></i></div>
                    <p class="m-0 fw-600">Customer Reg.</p>
                </a>
            </div>
        </div>
        @if (Auth::user()->role_id == 1)
            <div class="col-lg-3  col-md-6">
                <div class="card mb-3">
                    <a href="{{ url('pending-sales') }}"
                        class="d-flex p-1 gap-3 align-items-center order-bg-opacity-info rounded_10">
                        <div class="ap-po-details__icon-area color-info"><i class="uil uil-star"></i>
                        </div>
                        <p class="m-0 fw-600">Pending Sales</p>
                    </a>
                </div>
            </div>
        @endif

        @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 6)
            <div class="col-lg-3  col-md-6">
                <div class="card mb-3">
                    <a href="{{ url('all-purchase') }}"
                        class="d-flex p-1 gap-3 align-items-center order-bg-opacity-info rounded_10">
                        <div class="ap-po-details__icon-area color-info"><i class="uil uil-star"></i>
                        </div>
                        <p class="m-0 fw-600">Sales List</p>
                    </a>
                </div>
            </div>
        @endif

        <div class="col-lg-3  col-md-6">
            <div class="card mb-3">
                <a href="{{ url('payment/colllection') }}"
                    class="d-flex p-1 gap-3 align-items-center order-bg-opacity-secondary rounded_10">
                    <div style="color: #5840FF;" class="ap-po-details__icon-area"><i class="uil uil-money-bill"></i>
                    </div>
                    <p class="m-0 fw-600">Payment Collection</p>
                </a>
            </div>
        </div>
        <div class="col-lg-3  col-md-6">
            <div class="card mb-3">
                <a href="{{ url('transaction-list') }}"
                    class="d-flex p-1 gap-3 align-items-center order-bg-opacity-warning rounded_10">
                    <div class="ap-po-details__icon-area color-warning"><i class="uil uil-transaction"></i></div>
                    <p class="m-0 fw-600">Transaction list</p>
                </a>
            </div>
        </div>
    </div>


    <div class="row gx-2">
        <div class="col-md-6">
            {{-- Total’s Enquiry  --}}
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body p-3" dir="ltr">
                        <div class="row gx-3">
                            <div class="col-lg-6 mb-3">
                                <a href="#">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-2"><i
                                                    class="uil uil-usd-circle fs-5"></i></span>
                                            <p class="m-0 fw-600">Today's Sale</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">{{ $data['counttodaysales'] }}</h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <a href="#">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-3"><i
                                                    class="uil uil-arrow-growth fs-5"></i></span>
                                            <p class="m-0 fw-600">Todays Collection</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">{{ $data['todays_collection'] }}</h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <a href="{{ url('all-purchase?over_dues=1') }}">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-4"><i class="far fa-calendar-alt"></i></span>
                                            <p class="m-0 fw-600">Over Dues</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">{{ number_format($data['overdue'], 2) }}</h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <a href="{{ url('due-on-next-month') }}">
                                    <div class="card">
                                        <div class="d-flex p-2 box-header gap-3 align-items-center">
                                            <span class="enquiry-icon-4"><i class="far fa-calendar-check"></i></span>
                                            <p class="m-0 fw-600">Current month forecast</p>
                                        </div>
                                        <div class="card-box-value d-flex align-items-end px-2 py-3 gap-1">
                                            <h2 class="fs-36px lh-36px">
                                                {{ number_format($data['current_month_forcast'], 2) }}</h2>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bar Chart  --}}

        </div>
        <div class="col-md-6">
            {{-- Total’s Enquiry  --}}
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body p-3" dir="ltr">
                        <div class="row gx-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="d-flex box-header p-2 justify-content-between align-center">
                                        <div class="d-flex  gap-3 align-items-center">
                                            <span class="enquiry-icon-1"><i class="fas fa-calendar-check"></i></span>
                                            <p class="m-0 fw-600">Product Sale Statistics</p>
                                        </div>
                                        <div class="col-sm-6 month_select-x">
                                            <form action="" method="GET"
                                                class="filter-support-order-search__form">
                                                <div class="select-style2">
                                                    <div class="d-flex gap-2 dm-select enquiry_status_dm-select">
                                                        <input onchange="EnquiryStatistics()" type="text"
                                                            name="from_date" autocomplete="off"
                                                            value="{{ date('1-m-Y') }}"
                                                            class="form-control w-100 ih-medium ip-gray radius-xs b-light"
                                                            id="datepicker8">
                                                        <input type="text" onchange="EnquiryStatistics()"
                                                            name="to_date" autocomplete="off"
                                                            value="{{ date('t-m-Y') }}"
                                                            class="form-control w-100  ih-medium ip-gray radius-xs b-light"
                                                            id="datepicker17">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="appned_statistics"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12 col-sm-12 mb-25">
            <div class="card border-0 px-25 h-100">
                <div class="card-header px-0 border-0">
                    <h6>Monthly Collection status</h6>
                    <div id="month-name" style="font-size: 18px;"></div>
                </div>
                {{--
                <div class="col-sm-6 month_select-x">
                    <div class="select-style2">
                        <div class="d-flex gap-2 dm-select enquiry_status_dm-select">
                            <input onchange="updateCollectionChart()" type="text" name="from_date"
                                autocomplete="off" value="{{ date('1-m-Y') }}"
                                class="form-control w-100 ih-medium ip-gray radius-xs b-light datepicker"
                                id="collection_from_date">
                            <input type="text" onchange="updateCollectionChart()" name="to_date"
                                autocomplete="off" value="{{ date('t-m-Y') }}"
                                class="form-control w-100 ih-medium ip-gray radius-xs b-light datepicker"
                                id="collection_to_date">
                        </div>
                    </div>
                </div> --}}

                <div class="card-body p-0 pb-sm-25">
                    <div class="barChart" id="barChart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {{-- Latest Enquery  --}}
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2>Latest Collection</h2>
                        <a class="btn btn-outline-primary" href="#">View
                            All<i class="fas m-0 px-2 fa-angle-right"></i></a>
                    </div>
                    <div class="card-body p-3" dir="ltr">
                        <div class="table-responsive d-block custom-data-table-wrapper2">
                            <table class="table mb-0 table-bordered custom-data-table">

                                <thead>
                                    <tr class="userDatatable-header">
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
                                    @foreach ($installments as $key => $item)
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">{{ $item->transaction_type }}</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">{{ @$item->hire_purchase->name }}
                                                </div>
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
                                                            {{-- <h6>{{ date('d/m/Y h:i A', strtotime($item->created_at)) }} --}}
                                                            <h6>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                                            </h6>
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
                                                    {{ @$item->users->name }}

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="pt-2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Bar Chart Close  --}}
        </div>
    </div>
</div>


<script src="{{ asset('assets/js/plugins.min.js') }}"></script>
<script>
    var couttodaycollection = <?php echo $couttodaycollection; ?>;
    //basics bar
    function barChart(idName, width, height = "270") {
        // Get the current date
        var currentDate = new Date();
        // Get the current month and year
        var currentMonth = currentDate.getMonth();
        var currentYear = currentDate.getFullYear();

        // Get month name
        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var monthName = monthNames[currentMonth];

        // Set the month name in the HTML
        document.getElementById('month-name').innerText = monthName + " " + currentYear;

        // Calculate the number of days in the current month
        var daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        // Generate categories for each day of the current month
        var categories = [];
        for (var i = 1; i <= daysInMonth; i++) {
            categories.push(i.toString());
        }

        // // Generate random data for each day (you can replace this with actual data)
        var data = [];
        for (var i = 1; i <= daysInMonth; i++) {
            data.push(Math.floor(Math.random() * 1000) + 100); // Random data between 100 and 1100
        }

        // console.log(data);


        var optionRadial = {
            series: [{
                data: couttodaycollection,
            }],
            colors: ['#006666'],
            chart: {
                width: width,
                height: height,
                type: 'bar',
            },
            legend: {
                show: false
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: categories,
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return val.toFixed(2); // show 2 decimal places
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2); // tooltip formatting
                    }
                }
            },

        };

        if ($(idName).length > 0) {
            new ApexCharts(document.querySelector(idName), optionRadial).render();
        }
    }

    // Call the function for the chart
    barChart('#barChart', '100%', 280);


    function areaChart(e, t, o = "270") {
        var r = {
            series: [{
                data: totalenq.map(totale => totale)
            }],
            colors: ["#8231D3", "#00AAFF"],
            chart: {

                width: t,
                height: o,
                type: "area"
            },
            legend: {
                show: !1
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                curve: "straight"
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: !0
                }
            },
            dataLabels: {
                enabled: !1
            },
            xaxis: {
                categories: num.map(n => n)
            },
        };
        $(e).length > 0 && new ApexCharts(document.querySelector(e), r).render();
    }

    function exampleAreaChart(e, a, t, r, o, n) {
        let l, i, d, color;
        (d = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-primary"
        )),
        (i = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-primary-rgba"
        ));
        var s = document.getElementById(e);
        if (s) {
            s.getContext("2d"), (s.height = window.innerWidth <= 575 ? 180 : a);
            new Chart(s, {
                type: "line",
                data: {
                    labels: r,
                    datasets: [{
                        data: t,
                        borderColor: d,
                        borderWidth: 3,
                        backgroundColor: () =>
                            chartLinearGradient(
                                document.getElementById(e),
                                300, {
                                    start: `rgba(${i},0.5)`,
                                    end: "rgba(255,255,255,0.05)",
                                }
                            ),
                        fill: n,
                        label: o,
                        tension: 0.4,
                        hoverRadius: "6",
                        pointBackgroundColor: d,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHitRadius: 30,
                        pointStyle: "circle",
                        pointHoverBorderWidth: 2,
                    }, ],
                },
                options: {
                    maintainAspectRatio: !0,
                    responsive: !0,
                    interaction: {
                        mode: "index"
                    },
                    plugins: {
                        legend: {
                            display: !1,
                            position: "bottom",
                            align: "start",
                            labels: {
                                boxWidth: 6,
                                display: !0,
                                usePointStyle: !0
                            },
                        },
                        tooltip: {
                            usePointStyle: !0,
                            enabled: !0
                        },
                    },
                    animation: {
                        onComplete: () => {
                            l = !0;
                        },
                        delay: (e) => {
                            let a = 0;
                            return (
                                "data" !== e.type ||
                                "default" !== e.mode ||
                                l ||
                                (a = 200 * e.dataIndex + 50 * e.datasetIndex),
                                a
                            );
                        },
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                },
            });
        }
    }


    // Nipun Add
    function exampleAreaChart1(e, a, t, r, o, n) {
        let l, i, d, color;
        (d = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-success"
        )),
        (i = getComputedStyle(document.documentElement).getPropertyValue(
            "--color-success-rgba"
        ));
        var s = document.getElementById(e);
        if (s) {
            s.getContext("2d"), (s.height = window.innerWidth <= 575 ? 180 : a);
            new Chart(s, {
                type: "line",
                data: {
                    labels: r,
                    datasets: [{
                        data: t,
                        borderColor: d,
                        borderWidth: 3,
                        backgroundColor: () =>
                            chartLinearGradient(
                                document.getElementById(e),
                                300, {
                                    start: `rgba(${i},0.5)`,
                                    end: "rgba(255,255,255,0.05)",
                                }
                            ),
                        fill: n,
                        label: o,
                        tension: 0.4,
                        hoverRadius: "6",
                        pointBackgroundColor: d,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHitRadius: 30,
                        pointStyle: "circle",
                        pointHoverBorderWidth: 2,
                    }, ],
                },
                options: {
                    maintainAspectRatio: !0,
                    responsive: !0,
                    interaction: {
                        mode: "index"
                    },
                    plugins: {
                        legend: {
                            display: !1,
                            position: "bottom",
                            align: "start",
                            labels: {
                                boxWidth: 6,
                                display: !0,
                                usePointStyle: !0
                            },
                        },
                        tooltip: {
                            usePointStyle: !0,
                            enabled: !0
                        },
                    },
                    animation: {
                        onComplete: () => {
                            l = !0;
                        },
                        delay: (e) => {
                            let a = 0;
                            return (
                                "data" !== e.type ||
                                "default" !== e.mode ||
                                l ||
                                (a = 200 * e.dataIndex + 50 * e.datasetIndex),
                                a
                            );
                        },
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    },
                },
            });
        }
    }
    // Nipun Close

    $(document).ready(function() {
        // console.log(countfollowup);
        // Your code to be executed when the DOM is ready
        // pieChart(".apexPieToday", [countopen, countsales, countclose, countpending], "100%", 270),
        var selList = {!! json_encode($selList ?? []) !!};
        console.log(selList);
        var group_name = {!! json_encode($group_name ?? []) !!};
        console.log(group_name);
        pieChart('.apexPieToday', selList, '100%', 270);

        areaChart(".areaChartBasic", "100%", 267);
    });

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

//
<script>
    //     // Define these variables globally so they can be accessed anywhere
    //     let barChart = null;
    //     let updateCollectionChart;

    //     $(document).ready(function() {
    //         // Initialize datepickers
    //         $('.datepicker').datepicker({
    //             format: 'dd-mm-yyyy',
    //             autoclose: true,
    //             todayHighlight: true
    //         });

    //         // Define the updateCollectionChart function
    //         updateCollectionChart = function() {
    //             const fromDate = $('#collection_from_date').val();
    //             const toDate = $('#collection_to_date').val();

    //             // Get current filter values from the URL parameters
    //             const urlParams = new URLSearchParams(window.location.search);
    //             const zone = urlParams.get('zone') || '';
    //             const showroom = urlParams.get('Showroom') || '';

    //             // Make AJAX request
    //             $.ajax({
    //                 url: '{{ url('collection-chart-data') }}',
    //                 type: 'GET',
    //                 data: {
    //                     from_date: fromDate,
    //                     to_date: toDate,
    //                     zone: zone,
    //                     Showroom: showroom
    //                 },
    //                 success: function(response) {
    //                     // Update the month name
    //                     $('#month-name').text(response.month_name);

    //                     // Destroy existing chart if it exists
    //                     if (barChart) {
    //                         barChart.destroy();
    //                         barChart = null;
    //                     }

    //                     // Create new chart with updated data
    //                     const options = {
    //                         series: [{
    //                             data: response.data,
    //                         }],
    //                         colors: ['#006666'],
    //                         chart: {
    //                             width: '100%',
    //                             height: 280,
    //                             type: 'bar',
    //                         },
    //                         legend: {
    //                             show: false
    //                         },
    //                         plotOptions: {
    //                             bar: {
    //                                 borderRadius: 4,
    //                                 horizontal: false,
    //                             }
    //                         },
    //                         dataLabels: {
    //                             enabled: false
    //                         },
    //                         xaxis: {
    //                             categories: response.categories,
    //                         },
    //                         yaxis: {
    //                             labels: {
    //                                 formatter: function(val) {
    //                                     return val.toFixed(2); // show 2 decimal places
    //                                 }
    //                             }
    //                         },
    //                         tooltip: {
    //                             y: {
    //                                 formatter: function(val) {
    //                                     return val.toFixed(2); // tooltip formatting
    //                                 }
    //                             }
    //                         },
    //                     };

    //                     // Create and render the chart
    //                     barChart = new ApexCharts(document.querySelector("#barChart"), options);
    //                     barChart.render();
    //                 },
    //                 error: function(xhr, status, error) {
    //                     console.error('Error fetching collection chart data:', error);
    //                     $('#barChart').html('<div class="text-center py-5 text-danger">Error loading chart data. Please try again.</div>');
    //                 }
    //             });
    //         };

    //         // Initialize the chart with default data on page load
    //         updateCollectionChart();

    //         // Set up event listeners for date inputs using jQuery instead of onchange attributes
    //         $('#collection_from_date').on('changeDate', function() {
    //             updateCollectionChart();
    //         });

    //         $('#collection_to_date').on('changeDate', function() {
    //             updateCollectionChart();
    //         });
    //     });
    //
</script>
