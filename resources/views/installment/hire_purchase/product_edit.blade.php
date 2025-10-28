@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <form action="{{ url('hire-purchase-product-update/' . $query->id) }}" method="post" enctype="multipart/form-data"
                class="parent-assign">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-header">
                                <h6>Buy Now Pay Later Form</h6>
                            </div>
                            <div class="card-body py-md-30">
                            </div>
                        </div>
                        <div class="card card-default card-md mb-4 purchase_app">
                            <div class="card-body py-md-30">
                                <div class="form-group">
                                    <fieldset>
                                        <legend>Office Use Only:</legend>
                                        <div class="row">
                                            <!-- Product Group -->
                                            <div class="col-md-3">
                                                <select required name="product_group_id" onchange="GetCategory()"
                                                    id="group" class="form-control">
                                                    <option value="">Product Group</option>
                                                    @foreach ($product_type as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ isset($hirepurchase_product) && $hirepurchase_product->product_group_id == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Product Category -->
                                            <div class="col-md-3 mb-25">
                                                <div class="">
                                                    <div class="">
                                                        <select required name="product_category_id" id="Select-Model"
                                                            class="form-control category">
                                                            @if (isset($hirepurchase_product) && $hirepurchase_product->product_category_id)
                                                                <option
                                                                    value="{{ $hirepurchase_product->product_category_id }}"
                                                                    selected>
                                                                    {{ @$hirepurchase_product->product_category->name }}
                                                                </option>
                                                            @endif
                                                        </select>
                                                        <span style="color: red" id="category-require"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Product Brand -->
                                            <div class="col-md-3">
                                                <select required onchange="GetProduct()" name="product_brand_id"
                                                    id="prod_brand" class="form-control">
                                                    <option value="">Product Brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            {{ isset($hirepurchase_product) && $hirepurchase_product->product_brand_id == $brand->id ? 'selected' : '' }}>
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Product Model -->
                                            <div class="col-md-3">
                                                <select required onchange="GetPrice()" name="product_model_id"
                                                    id="Select-color" class="form-control">
                                                    <option value="">Product Model:</option>
                                                    @if (isset($hirepurchase_product) && $hirepurchase_product->product_model_id)
                                                        <option value="{{ $hirepurchase_product->product_model_id }}"
                                                            selected>
                                                            {{ $hirepurchase_product->product->product_model }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                            <!-- Product Size -->
                                            <div class="col-md-3">
                                                <input type="text" name="product_size_id" id="product_size"
                                                    class="form-control"
                                                    value="{{ $hirepurchase_product->product_size_id }}"
                                                    placeholder="Product Size">
                                            </div>
                                            <!-- Serial Number -->
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="serial_no" id="serial_no" class="input"
                                                            type="text" placeholder=" "
                                                            value="{{ isset($hirepurchase_product) ? $hirepurchase_product->serial_no : '' }}" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Serial No:<span class="text-danger">*</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Cash Price -->
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="cash_price" id="cash_price" class="input"
                                                            readonly type="number" placeholder=" "
                                                            value="{{ isset($hirepurchase_product) ? $hirepurchase_product->cash_price : '' }}" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Cash Price:<span class="text-danger">*</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Down Payment Percentage -->
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <select required onchange="calculate()"
                                                            name="down_payment_parcentage" id="down_payment_parcentage"
                                                            class="form-control">
                                                            @foreach ($down_payment_parcentage as $item)
                                                                <option value="{{ $item->payment_percentage }}"
                                                                    {{ (isset($hirepurchase_product) &&
                                                                        $hirepurchase_product->down_payment_parcentage == $item->payment_percentage) ||
                                                                    (!isset($hirepurchase_product) && $item->payment_percentage == 40)
                                                                        ? 'selected'
                                                                        : '' }}>
                                                                    {{ $item->payment_percentage }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Installment Month -->
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        @foreach ($interestrate as $interest_hid)
                                                            <input type="hidden"
                                                                id="interest_rate_{{ $interest_hid->month }}"
                                                                value="{{ $interest_hid->interest_rate }}">
                                                        @endforeach
                                                        <select required onchange="calculate()" name="installment_month"
                                                            id="installment_month" class="form-control">
                                                            <option value="">Installment Month</option>
                                                            @foreach ($interestrate as $interest)
                                                                <option value="{{ $interest->month }}"
                                                                    {{ isset($hirepurchase_product) && $hirepurchase_product->installment_month == $interest->month ? 'selected' : '' }}>
                                                                    {{ $interest->month }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Hire Price -->
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input onkeyup="calculate()" required name="hire_price"
                                                            id="hire_price" class="input" readonly type="text"
                                                            placeholder=" "
                                                            value="{{ isset($hirepurchase_product) ? $hirepurchase_product->hire_price : '' }}" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Hire Price:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Down Payment -->
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="down_payment" id="down_payment"
                                                            class="input" type="text" placeholder=" "
                                                            value="{{ isset($hirepurchase_product) ? $hirepurchase_product->down_payment : '' }}" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Down Payment:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                        <span id="alert_downpayment" class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Monthly Installment -->
                                            <div class="col-md-3 mb-25">
                                                <div class="holder">
                                                    <div class="input-holder">
                                                        <input required name="monthly_installment" id="monthly_inst"
                                                            class="input" type="text" placeholder=" "
                                                            value="{{ isset($hirepurchase_product) ? $hirepurchase_product->monthly_installment : '' }}" />
                                                        <div class="placeholder">
                                                            <p class="m-0">Monthly Inst. Tk:<span
                                                                    class="text-danger">*</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="capable_action" class="mb-3 alert alert-danger" style="display: none">
                                    Sorry, Monthly Installment Must Be 3000 Taka Then You Are Applicable
                                </div>
                                <span id="credit_validation" class="text-danger"></span>
                            </div>
                            <div class="col-md-6">
                                <button id="save_button" class="btn btn-lg btn-primary customr-btn btn-submit ms-auto"
                                    type="submit">
                                    Save And Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <script>
        // Get down payment settings
        @php
            $down_payment = App\Models\DownPaymentSetting::latest()->first();
        @endphp

        // Calculate Monthly Installment based on down payment
        function calculateMonthlyInstallment() {
            var installment_month = $("#installment_month").val();
            var hire_price = parseFloat($("#hire_price").val()) || 0;
            var down_payment = Math.round(parseFloat($("#down_payment").val()) || 0);

            if (installment_month == 0) {
                $("#down_payment").val(0);
                return;
            }

            var payment_percentage = parseFloat($("#down_payment_parcentage").val()) || 0;
            var required_payment = (hire_price * payment_percentage / 100);

            // Calculate monthly installment
            var monthly_install = 0;
            if (installment_month > 1) {
                monthly_install = ((hire_price - down_payment) / (installment_month - 1)).toFixed(2);
            }

            // Validation for minimum down payment
            if (required_payment > down_payment) {
                var alert_message = "You must pay at least " + payment_percentage + "% down payment: " + required_payment.toFixed(2) + " BDT";
                $("#alert_downpayment").html(alert_message);
                $("#save_button").hide();
            } else {
                $("#alert_downpayment").html('');
                $("#save_button").show();
            }

            // Validation for minimum monthly installment
            if (monthly_install < 3000 && monthly_install > 0) {
                $("#capable_action").show();
                $("#save_button").hide();
            } else {
                $("#capable_action").hide();
                if ($("#alert_downpayment").html() === '') {
                    $("#save_button").show();
                }
            }

            $("#monthly_inst").val(monthly_install);
            calculateCreditScoreWithHirePrice();
        }

        // Calculate Down Payment based on monthly installment
        function calculateDownPayment() {
            var installment_month = parseInt($("#installment_month").val()) || 0;
            var hire_price = parseFloat($("#hire_price").val()) || 0;
            var monthly_install = parseFloat($("#monthly_inst").val()) || 0;
            var payment_percentage = parseFloat($("#down_payment_parcentage").val()) || 0;

            var required_payment = (hire_price * payment_percentage / 100);
            var down_payment = 0;

            if (installment_month > 1) {
                down_payment = (hire_price - (monthly_install * (installment_month - 1))).toFixed(2);
            }

            $("#down_payment").val(down_payment);

            // Validation for minimum down payment
            if (required_payment > down_payment) {
                var alert_message = "You must pay at least " + payment_percentage + "% down payment: " + required_payment.toFixed(2) + " BDT";
                $("#alert_downpayment").html(alert_message);
                $("#save_button").hide();
            } else {
                $("#alert_downpayment").html('');
                $("#save_button").show();
            }

            calculateCreditScoreWithHirePrice();
        }

        // Event listeners for recalculation
        $("#down_payment").on("input", calculateMonthlyInstallment);
        $("#monthly_inst").on("input", calculateDownPayment);

        // Check credit limit
        function calculateCreditScoreWithHirePrice() {
            var downPayment = parseFloat($('#down_payment').val()) || 0;
            var hirePrice = parseFloat($('#hire_price').val()) || 0;
            var showroom_credit = <?php echo $showroom_credit->remaining_credit; ?>;
            var credit = parseFloat(showroom_credit);
            var due = hirePrice - downPayment;

            if (due > credit) {
                var alert_message = "You have exceeded your credit limitation. Your current credit is " + credit.toFixed(2) + " BDT";
                $('#credit_validation').html(alert_message);
                $("#save_button").hide();
            } else {
                $("#credit_validation").html("");
                if ($("#alert_downpayment").html() === '' &&
                    (parseFloat($("#monthly_inst").val()) >= 3000 || parseFloat($("#monthly_inst").val()) == 0)) {
                    $("#save_button").show();
                }
            }
        }

        // Calculate hire price and payments
        function calculate() {
            var installment_month = parseInt($("#installment_month").val()) || 0;
            var cash_price = parseInt($("#cash_price").val()) || 0;
            var interest_rate = 0;

            if (installment_month > 0) {
                interest_rate = parseInt($("#interest_rate_" + installment_month).val()) || 0;
            }

            var interest_amount = (interest_rate * cash_price) / 100;
            var effective_installment_month = installment_month > 0 ? installment_month - 1 : 0;
            var hire_price = interest_amount + cash_price;

            // Calculate down payment based on percentage
            var payment_percentage = parseFloat($("#down_payment_parcentage").val()) || 0;
            var down_payment = (hire_price * payment_percentage / 100).toFixed(2);

            // Set values to form fields
            $("#hire_price").val(hire_price);
            $("#down_payment").val(down_payment);

            // Calculate monthly installment
            var monthly_install = 0;
            if (effective_installment_month > 0) {
                monthly_install = ((hire_price - down_payment) / effective_installment_month).toFixed(2);
            }

            $("#monthly_inst").val(monthly_install);

            // Validation checks
            if (monthly_install < 3000 && monthly_install > 0) {
                $("#capable_action").show();
                $("#save_button").hide();
            } else {
                $("#capable_action").hide();
                $("#save_button").show();
            }

            calculateCreditScoreWithHirePrice();
        }

        // Get product price
        function GetPrice() {
            var product = $("#Select-color").val();
            $.post('{{ url('/get-price') }}', {
                _token: '{{ csrf_token() }}',
                id: product
            }, function(data) {
                $("#cash_price").val(data);
                calculate();
            });
        }

        // Get product category
        function GetCategory() {
            var product_group = $("#group").val();
            $.post('{{ url('/get-category') }}', {
                _token: '{{ csrf_token() }}',
                id: product_group
            }, function(data) {
                data = JSON.parse(data);
                var selectElement = $("#Select-Model")[0];
                selectElement.innerHTML = '<option value="">Select Category</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            });
        }

        // Get product models
        function GetProduct() {
            var product_brand = $("#prod_brand").val();
            var product_category = $("#Select-Model").val();

            $.post('{{ url('/get-product') }}', {
                _token: '{{ csrf_token() }}',
                brand_id: product_brand,
                category_id: product_category
            }, function(data) {
                data = JSON.parse(data);
                var selectElement = $("#Select-color")[0];
                selectElement.innerHTML = '<option value="">Select Model</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            });

            // Clear size selection when brand changes
            $("#product_size_id").html('<option value="">Select Size</option>');
        }

        // Initialize the form on page load
        $(document).ready(function() {
            // If editing, trigger calculation
            if ($("#cash_price").val()) {
                calculate();
            }

            // If product model is selected, get sizes
            $("#Select-color").change(function() {
                var model_id = $(this).val();
                $.post('{{ url('/get-sizes') }}', {
                    _token: '{{ csrf_token() }}',
                    model_id: model_id
                }, function(data) {
                    data = JSON.parse(data);
                    var sizeSelect = $("#product_size_id")[0];
                    sizeSelect.innerHTML = '<option value="">Select Size</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        sizeSelect.appendChild(option);
                    });
                });
            });
        });
    </script> --}}

    <script>
        // Add this flag to track if user has made changes
        var userHasInteracted = false;
        var isEditMode = $("#is_editing").val() === '1';

        // Get down payment settings
        @php
            $down_payment = App\Models\DownPaymentSetting::latest()->first();
        @endphp

        // Calculate Monthly Installment based on down payment
        function calculateMonthlyInstallment() {
            // In edit mode, only calculate if user has interacted
            if (isEditMode && !userHasInteracted) {
                return;
            }

            var installment_month = $("#installment_month").val();
            var hire_price = parseFloat($("#hire_price").val()) || 0;
            var down_payment = Math.round(parseFloat($("#down_payment").val()) || 0);

            if (installment_month == 0) {
                $("#down_payment").val(0);
                return;
            }

            var payment_percentage = parseFloat($("#down_payment_parcentage").val()) || 0;
            var required_payment = (hire_price * payment_percentage / 100);

            // Calculate monthly installment
            var monthly_install = 0;
            if (installment_month > 1) {
                monthly_install = ((hire_price - down_payment) / (installment_month - 1)).toFixed(2);
            }

            // Validation for minimum down payment
            if (required_payment > down_payment) {
                var alert_message = "You must pay at least " + payment_percentage + "% down payment: " + required_payment
                    .toFixed(2) + " BDT";
                $("#alert_downpayment").html(alert_message);
                $("#save_button").hide();
            } else {
                $("#alert_downpayment").html('');
                $("#save_button").show();
            }

            // Validation for minimum monthly installment
            if (monthly_install < 3000 && monthly_install > 0) {
                $("#capable_action").show();
                $("#save_button").hide();
            } else {
                $("#capable_action").hide();
                if ($("#alert_downpayment").html() === '') {
                    $("#save_button").show();
                }
            }

            $("#monthly_inst").val(monthly_install);
            calculateCreditScoreWithHirePrice();
        }

        // Calculate Down Payment based on monthly installment
        function calculateDownPayment() {
            // In edit mode, only calculate if user has interacted
            if (isEditMode && !userHasInteracted) {
                return;
            }

            var installment_month = parseInt($("#installment_month").val()) || 0;
            var hire_price = parseFloat($("#hire_price").val()) || 0;
            var monthly_install = parseFloat($("#monthly_inst").val()) || 0;
            var payment_percentage = parseFloat($("#down_payment_parcentage").val()) || 0;

            var required_payment = (hire_price * payment_percentage / 100);
            var down_payment = 0;

            if (installment_month > 1) {
                down_payment = (hire_price - (monthly_install * (installment_month - 1))).toFixed(2);
            }

            $("#down_payment").val(down_payment);

            // Validation for minimum down payment
            if (required_payment > down_payment) {
                var alert_message = "You must pay at least " + payment_percentage + "% down payment: " + required_payment
                    .toFixed(2) + " BDT";
                $("#alert_downpayment").html(alert_message);
                $("#save_button").hide();
            } else {
                $("#alert_downpayment").html('');
                $("#save_button").show();
            }

            calculateCreditScoreWithHirePrice();
        }

        // Event listeners for recalculation
        $("#down_payment").on("input", function() {
            userHasInteracted = true;
            calculateMonthlyInstallment();
        });

        $("#monthly_inst").on("input", function() {
            userHasInteracted = true;
            calculateDownPayment();
        });

        // Check credit limit
        function calculateCreditScoreWithHirePrice() {
            var downPayment = parseFloat($('#down_payment').val()) || 0;
            var hirePrice = parseFloat($('#hire_price').val()) || 0;
            var showroom_credit = <?php echo $showroom_credit->remaining_credit; ?>;
            var credit = parseFloat(showroom_credit);
            var due = hirePrice - downPayment;

            if (due > credit) {
                var alert_message = "You have exceeded your credit limitation. Your current credit is " + credit.toFixed(
                    2) + " BDT";
                $('#credit_validation').html(alert_message);
                $("#save_button").hide();
            } else {
                $("#credit_validation").html("");
                if ($("#alert_downpayment").html() === '' &&
                    (parseFloat($("#monthly_inst").val()) >= 3000 || parseFloat($("#monthly_inst").val()) == 0)) {
                    $("#save_button").show();
                }
            }
        }

        // Calculate hire price and payments
        function calculate() {
            // In edit mode, only calculate if user has interacted
            if (isEditMode && !userHasInteracted) {
                return;
            }

            var installment_month = parseInt($("#installment_month").val()) || 0;
            var cash_price = parseInt($("#cash_price").val()) || 0;
            var interest_rate = 0;

            if (installment_month > 0) {
                interest_rate = parseInt($("#interest_rate_" + installment_month).val()) || 0;
            }

            var interest_amount = (interest_rate * cash_price) / 100;
            var effective_installment_month = installment_month > 0 ? installment_month - 1 : 0;
            var hire_price = interest_amount + cash_price;

            var payment_percentage = parseFloat($("#down_payment_parcentage").val()) || 0;
            var down_payment = (hire_price * payment_percentage / 100).toFixed(2);

            $("#hire_price").val(hire_price);
            $("#down_payment").val(down_payment);

            var monthly_install = 0;
            if (effective_installment_month > 0) {
                monthly_install = ((hire_price - down_payment) / effective_installment_month).toFixed(2);
            }

            $("#monthly_inst").val(monthly_install);

            if (monthly_install < 3000 && monthly_install > 0) {
                $("#capable_action").show();
                $("#save_button").hide();
            } else {
                $("#capable_action").hide();
                $("#save_button").show();
            }

            calculateCreditScoreWithHirePrice();
        }

        // Get product price
        // function GetPrice() {
        //     userHasInteracted = true;
        //     var product = $("#Select-color").val();
        //     $.post('{{ url('/get-price') }}', {
        //         _token: '{{ csrf_token() }}',
        //         id: product
        //     }, function(data) {
        //         $("#cash_price").val(data);
        //         calculate();
        //     });
        // }

        function GetPrice() {
            userHasInteracted = true;
            var product = $("#Select-color").val();
            $.post('{{ url('/get-price') }}', {
                _token: '{{ csrf_token() }}',
                id: product
            }, function(data) {
                console.log(data);
                // Parse the JSON if it's a string, or use it directly if it's already an object
                var response = typeof data === 'string' ? JSON.parse(data) : data;

                // Set cash price from the response
                $("#cash_price").val(response.price);

                // Set product size if available
                if (response.size) {
                    $("#product_size").val(response.size);
                }

                // Now calculate
                calculate();
            });
        }

        // Get product category
        function GetCategory() {
            userHasInteracted = true;
            var product_group = $("#group").val();
            $.post('{{ url('/get-category') }}', {
                _token: '{{ csrf_token() }}',
                id: product_group
            }, function(data) {
                data = JSON.parse(data);
                var selectElement = $("#Select-Model")[0];
                selectElement.innerHTML = '<option value="">Select Category</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            });
        }

        // Get product models
        function GetProduct() {
            userHasInteracted = true;
            var product_brand = $("#prod_brand").val();
            var product_category = $("#Select-Model").val();

            $.post('{{ url('/get-product') }}', {
                _token: '{{ csrf_token() }}',
                brand_id: product_brand,
                category_id: product_category
            }, function(data) {
                data = JSON.parse(data);
                var selectElement = $("#Select-color")[0];
                selectElement.innerHTML = '<option value="">Select Model</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectElement.appendChild(option);
                });
            });

            // Clear size selection when brand changes
            $("#product_size_id").html('<option value="">Select Size</option>');
        }

        // Mark interaction when dropdowns change
        $("#down_payment_parcentage").change(function() {
            userHasInteracted = true;
            calculate();
        });

        $("#installment_month").change(function() {
            userHasInteracted = true;
            calculate();
        });

        // Initialize the form on page load
        $(document).ready(function() {
            // If editing, just validate the existing values without recalculating
            if (isEditMode && $("#cash_price").val()) {
                calculateCreditScoreWithHirePrice();

                // Check if monthly installment meets minimum requirement
                var monthly_install = parseFloat($("#monthly_inst").val()) || 0;
                if (monthly_install < 3000 && monthly_install > 0) {
                    $("#capable_action").show();
                    $("#save_button").hide();
                }
            }

            // If product model is selected, get sizes
            $("#Select-color").change(function() {
                userHasInteracted = true;
                var model_id = $(this).val();
                $.post('{{ url('/get-sizes') }}', {
                    _token: '{{ csrf_token() }}',
                    model_id: model_id
                }, function(data) {
                    data = JSON.parse(data);
                    var sizeSelect = $("#product_size_id")[0];
                    sizeSelect.innerHTML = '<option value="">Select Size</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        sizeSelect.appendChild(option);
                    });
                });
            });
        });
    </script>
@endsection
