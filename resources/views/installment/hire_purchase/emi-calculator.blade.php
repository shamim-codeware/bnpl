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
                                    <div class="col-md-6">
                                        <label for="select-option2" class="form-label">Select Product</label>
                                        <select name="product_id" class="form-control" id="select-option2" onchange="handleProductChange()">
                                            <option value="">-- Select Product --</option>
                                            @foreach($products as $item)
                                                <option value="{{ $item->id }}">{{ $item->product_model }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
    var product_id = $("#select-option2").val();
    if (!product_id) {
        alert("Please select a product first");
        return;
    }

    // Get the selected down payment percentage
    var down_payment_percentage = $("#down_payment_percentage").val();

    // Show loading indicator
    $("#data_rcv").html('<div class="text-center mt-4"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2">Calculating EMI options...</p></div>');

    var url = "{{ url('/calculate-data/') }}" + '/' + product_id;

    // Ajax request with down payment percentage
    $.get(url, { down_payment: down_payment_percentage }, function(data){
        $("#data_rcv").html(data);
    });
}

function handlePercentageChange() {
    // Auto-recalculate if a product is already selected
    if ($("#select-option2").val()) {
        EmiCalculation();
    }
}

function handleProductChange() {
    // Auto-calculate when product is selected
    if ($("#select-option2").val()) {
        EmiCalculation();
    } else {
        // Clear the results if no product is selected
        $("#data_rcv").html('');
    }
}
</script>
@endsection






















