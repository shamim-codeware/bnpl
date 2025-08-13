@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4 grntr_card">
                        <div class="card-header">
                            <h6>Payment Collection</h6>
                        </div>
                        <div class="card-body py-md-30">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-8 mb-25">
                                                    <div class="holder">
                                                        <div class="input-holder">
                                                            <input required="" name="name" id="order_no"
                                                                class="input" type="text" placeholder=" " />
                                                            <div class="placeholder">
                                                                <p class="m-0">Order Number<span
                                                                        class="text-danger">*</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-25">
                                                    <button type="button" onclick="LoanDetails()" class="btn btn-primary w-30">
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="data-assign">
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

       function LoanDetails(){
        var order_no = $("#order_no").val();

        if(!order_no) {
            alert('Please enter an order number');
            return;
        }

        $.ajax({
            url: "{{ url('loan-details/') }}/"+order_no,
            type: "get",
            datatype: "json",
        })
        .done(function(data){
            // Check if response is JSON (error response)
            if(typeof data === 'object' && data.error) {
                toastr.error(data.message);
                $("#data-assign").empty();
            } else if(data == 1) {
                toastr.error('Order not found. Please check the order number and try again.');
                $("#data-assign").empty();
            } else {
                $("#data-assign").empty().html(data);
                $('.btn-submit').prop('disabled', false);
            }
        })
        .fail(function(jqXHR, ajaxOptions, thrownError){
            toastr.error('An error occurred while searching. Please try again.');
            $('.btn-submit').prop('disabled', false);
        });
    }

    </script>

@endsection
