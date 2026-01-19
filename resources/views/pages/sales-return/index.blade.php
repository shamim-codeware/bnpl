{{-- @extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3>Sales Return – Hire Purchase</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Select Hire Purchase</div>
        <div class="card-body">
            <form method="POST" action="{{ route('sales-return.load') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label>Customer</label>
                        <select name="customer_id" class="form-control">
                            <option value="">-- Select Customer --</option>
                            @foreach($customers as $cust)
                                <option value="{{ $cust->id }}" {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                    {{ $cust->name }} ({{ $cust->mobile }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>OR Hire Purchase ID (Order ID)</label>
                        <input type="text" name="order_id" class="form-control" placeholder="Enter HP ID" value="{{ old('order_id') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Load Hire Purchase</button>
            </form>
        </div>
    </div>

    @if(isset($hire))
        <div class="card mb-4">
            <div class="card-header">Hire Purchase Details</div>
            <div class="card-body">
                <p><strong>Customer:</strong> {{ $hire->customer->name }}</p>
                <p><strong>HP ID:</strong> {{ $hire->id }}</p>
                <p><strong>Down Payment:</strong> ৳{{ number_format($hire->down_payment, 2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($hire->status) }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Submit Sales Return</div>
            <div class="card-body">
                <form method="POST" action="{{ route('sales-return.store') }}">
                    @csrf
                    <input type="hidden" name="hire_id" value="{{ $hire->id }}">

                    <div class="mb-3">
                        <label class="form-label">Return Reason <span class="text-danger">*</span></label>
                        <select name="return_reason" class="form-control" required>
                            <option value="">-- Select Reason --</option>
                            <option value="cash_purchase_change">Changed to Cash Purchase</option>
                            <option value="technical_issue">Technical Problem - Sales Return</option>
                            <option value="upgrade_model">Product Upgrade & Model Change</option>
                            <option value="defaulter_return">Defaulter Customer - Product Return</option>
                            <option value="others">Others</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-danger">Submit Sales Return</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection --}}

@extends('layout.app')
@section('title', $title)
@section('description', $description)

@section('content')
<div class="container-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default card-md mb-4 grntr_card">
                    <div class="card-header">
                        <h6>Sales Return</h6>
                    </div>
                    <div class="card-body py-md-30">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-8 mb-25">
                                            <div class="holder">
                                                <div class="input-holder">
                                                    <input required name="order_no" id="order_no"
                                                        class="input" type="text" placeholder=" " />
                                                    <div class="placeholder">
                                                        <p class="m-0">Order Number<span class="text-danger">*</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <button type="button" onclick="loadReturnDetails()" class="btn btn-primary w-100">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="data-assign">
                                {{-- Return form + details will load here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadReturnDetails() {
    var order_no = $("#order_no").val();
    if (!order_no) {
        alert('Please enter an order number');
        return;
    }

    $.ajax({
        url: "{{ url('return-details/') }}/" + order_no,
        type: "GET",
        dataType: "html"
    })
    .done(function(data) {
        if (typeof data === 'string' && data.trim().startsWith('{')) {
            try {
                var json = JSON.parse(data);
                if (json.error) {
                    toastr.error(json.message);
                    $("#data-assign").empty();
                    return;
                }
            } catch (e) {
                // Not JSON → treat as HTML
            }
        }
        $("#data-assign").empty().html(data);
    })
    .fail(function() {
        toastr.error('An error occurred while searching. Please try again.');
    });
}
</script>
@endsection
