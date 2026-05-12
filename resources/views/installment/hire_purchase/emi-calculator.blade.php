@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 form-element">
            <div class="card card-default card-md mb-4">
                <div class="card-header">
                    <h6>EMI Calculator</h6>
                </div>
                <div class="card-body py-md-30">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info mb-4">
                                <p class="mb-0"><strong>EMI Calculator</strong> - Choose a product and down payment percentage, then click Calculate to see EMI options</p>
                            </div>
                            <form id="emiCalculatorForm" class="menu-permission-form">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="emi_type" class="form-label">Calculate for</label>
                                        <select name="type" class="form-control" id="emi_type" onchange="handleTypeChange()">
                                            <option value="product">Product</option>
                                            <option value="package">Package</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="product_select_container">
                                        <label for="select-option2" class="form-label">Select Product</label>
                                        <select name="product_id" class="form-control" id="select-option2" onchange="handleProductChange()">
                                            <option value="">-- Select Product --</option>
                                            @foreach($products as $item)
                                                <option value="{{ $item->id }}">{{ $item->product_model }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 d-none" id="package_select_container">
                                        <label for="select-package" class="form-label">Select Package</label>
                                        <select name="package_id" class="form-control" id="select-package" onchange="handlePackageChange()">
                                            <option value="">-- Select Package --</option>
                                            @foreach($packages as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="down_payment_percentage" class="form-label">Down Payment Percentage</label>
                                        <select name="down_payment_percentage" id="down_payment_percentage" class="form-control" onchange="handlePercentageChange()">
                                            @foreach($down_payment_percentage as $item)
                                                <option value="{{ $item->payment_percentage }}">{{ $item->payment_percentage }}%</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-primary btn-block" onclick="EmiCalculation()">Calculate</button>
                                    </div>
                                </div>
                                <div class="table-responsive d-lg-block d-md-block" id="data_rcv">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
<script>
function EmiCalculation(){
    var type = $("#emi_type").val();
    var selectedId = type === 'package' ? $("#select-package").val() : $("#select-option2").val();
    if (!selectedId) {
        alert(type === 'package' ? "Please select a package first" : "Please select a product first");
        return;
    }

    // Get the selected down payment percentage
    var down_payment_percentage = $("#down_payment_percentage").val();

    // Show loading indicator
    $("#data_rcv").html('<div class="text-center mt-4"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2">Calculating EMI options...</p></div>');

    var url = "{{ url('/calculate-data/') }}" + '/' + selectedId;

    // Ajax request with down payment percentage and selected type
    $.get(url, { down_payment: down_payment_percentage, type: type }, function(data){
        $("#data_rcv").html(data);
    });
}

function handlePercentageChange() {
    // Auto-recalculate if a selection is already made
    var type = $("#emi_type").val();
    var selectedId = type === 'package' ? $("#select-package").val() : $("#select-option2").val();
    if (selectedId) {
        EmiCalculation();
    }
}

function handleProductChange() {
    if ($("#select-option2").val()) {
        EmiCalculation();
    } else {
        $("#data_rcv").html('');
    }
}

function handlePackageChange() {
    if ($("#select-package").val()) {
        EmiCalculation();
    } else {
        $("#data_rcv").html('');
    }
}

function handleTypeChange() {
    var type = $("#emi_type").val();
    if (type === 'package') {
        $("#product_select_container").addClass('d-none');
        $("#package_select_container").removeClass('d-none');
        $("#select-option2").val('');
    } else {
        $("#package_select_container").addClass('d-none');
        $("#product_select_container").removeClass('d-none');
        $("#select-package").val('');
    }
    $("#data_rcv").html('');
}
</script>
@endsection






















