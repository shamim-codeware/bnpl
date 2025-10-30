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
                            <h6>Product Details</h6>
                        </div>
                        <div class="card-body py-md-30">
                            <form action="" method="post" class="parent-assign">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <fieldset class="">
                                                <legend>Product Details:</legend>
                                                <div class="row">
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Category:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>{{ @$product_details->purchase_product->product_category->name }}</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Serial Number:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>{{ @$product_details->purchase_product->serial_no }}</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Model:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>{{ @$product_details->purchase_product->product->product_model }}</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Brand:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>{{ @$product_details->purchase_product->brand->name  }}</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Price:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>BDT {{ @$product_details->purchase_product->hire_price }}</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Showroom Name:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>{{ @$product_details->show_room->name }}</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br>
                                            <div class="row gy-2">
                                                <div class="col-xxl-5 col-md-5">
                                                    <a style="white-space: nowrap;" target="_blank" href="{{ url('view-customer-info/'.$product_details->id) }}" class="btn btn-info">Customer Information</a>
                                                </div>
                                                <div class="col-xxl-5 col-md-4 ps-0">
                                                    <a style="white-space: nowrap;" target="_blank" href="{{ url('view-guarantor-info/'.$product_details->id) }}" class="btn btn-info">Guarantor Information</a>
                                                </div>
                                                <div class="col-xxl-5 col-md-4">
                                                    <a style="white-space: nowrap;" target="_blank" href="{{ url('installment-list/'.$product_details->id) }}" class="btn btn-info">Installment List</a>
                                                </div>

                                                {{-- Approve/Reject buttons for pending sales --}}
                                                @if(($product_details->status == 0) && ((Auth::user()->id == 248) || (Auth::user()->id == 217) || (Auth::user()->id == 267)))
                                                <div class="col-xxl-6 col-md-6">
                                                    <button type="button" class="btn btn-success" onclick="showApproveModal({{ $product_details->id }})">
                                                        <i class="fas fa-check"></i> Approve Sale
                                                    </button>
                                                </div>
                                                <div class="col-xxl-6 col-md-6">
                                                    <button type="button" class="btn btn-danger" onclick="showRejectModal({{ $product_details->id }})">
                                                        <i class="fas fa-times"></i> Reject Sale
                                                    </button>
                                                </div>
                                                @endif
                                             @if(App\Models\User::ADMIN == Auth::user()->role_id)
                                                @if(isset($product_details->erplog))
                                                {{-- @if($product_details->erplog->sent == 0) --}}
                                                    {{-- <div class="col-xxl-4 col-md-4">
                                                        <a style="white-space: nowrap;" target="_blank" href="{{ url('erp-view/'.$product_details->erplog->id) }}" class="btn btn-info">Send Erp</a>
                                                    </div> --}}
                                                             <div class="col-xxl-4 col-md-4">
                                                                <a style="white-space: nowrap;"
                                                                target="_blank"
                                                                href="{{ url('erp-view/'.$product_details->erplog->id) }}"
                                                                class="btn btn-info erp-send-btn"
                                                                onclick="disableButton(this)">
                                                                Send Erp
                                                                </a>
                                                            </div>
                                                    {{-- @else
                                                    <a href="#" class="btn btn-info">Send Erp Successfully</a>

                                               {{--  @endif --}}

                                                    <div class="col-xxl-4 col-md-4">
                                                        <a style="white-space: nowrap;"  href="{{ url('sale-cancel/'.$product_details->id) }}" class="btn btn-info">Sale Cancel </a>
                                                    </div>
                                                @endif
                                                 @endif                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <fieldset>
                                                <legend>Loan Details:</legend>
                                                <div class="row">
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Loan Agreement Date:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>{{    date('d/m/Y H:i A', strtotime($product_details->created_at)), }}</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Loan Start Date:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>{{    date('d/m/Y H:i A', strtotime($product_details->created_at)), }}</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Loan End Date:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span> {{    date('d/m/Y H:i A', strtotime($installment_date->loan_start_date)), }} </span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Down Payment:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>{{ @$product_details->purchase_product->down_payment }} TK</span>
                                                    </div>
                                                    {{-- <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Discount Amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>5,400.00 TK</span>
                                                    </div> --}}
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Installment Amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>{{ @$product_details->purchase_product->monthly_installment }} TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Number of installments:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>{{ @$product_details->purchase_product->installment_month }}</span>
                                                    </div>
                                                    {{-- <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Overpay Amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>8,567.00 TK</span>
                                                    </div> --}}
                                                    <div class="col-md-7 mb-15 mt-15 text-end">
                                                        <span class="fw-medium">Receivable for next token amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 mt-15">
                                                        <span></span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Total loan paid amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>{{ @$total_loan_paid_amount }} TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Outstanding balance:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>{{ number_format($out_standing_amount, 2) }} TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Late Payment Fee:</span>
                                                    </div>
                                                    {{-- <div class="col-md-5 mb-15">
                                                        <span>{{  $total_installment_paid - @$product_details->purchase_product->total_paid }}</span>
                                                    </div> --}}
                                                    <div class="col-md-5 mb-15">
                                                                <span class="{{ $totalFine > 0 ? 'text-danger fw-bold' : '' }}">
                                                                    {{ number_format($totalFine, 2) }} TK
                                                                    @if($totalFine > 0)
                                                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Interest Rate:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @if($product_details->status == 3)

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2>Payment Collection List</h2>
                    </div>
                    <div class="card-body p-3" dir="ltr">
                        {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-4 mb-25">
                                    <select name="store_type" id="store_type" class="form-control">
                                        <option value="">Store type</option>
                                        <option value="showroom">Showroom</option>
                                        <option value="ctp">CTP</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-25">
                                    <select name="zone" id="zone" class="form-control">
                                        <option value="">Zone</option>
                                        <option value="shyamoli">Shyamoli</option>
                                        <option value="adabor">Adabor</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-25">
                                    <select name="showroom_ctp" id="showroom_ctp" class="form-control">
                                        <option value="">Showroom/CTP</option>
                                        <option value="shyamoli">Shyamoli</option>
                                        <option value="adabor">Adabor</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="from_date" autocomplete="off" value="Form date" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8" >
                                </div>
                                <div style="width: 2%; height:40px;" class="col-1 d-flex justify-content-center align-items-center"><p class="m-0">To</p></div>
                                <div class="col-md-3 mb-3">
                                        <input type="text" name="to_date" autocomplete="off" value="To date" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker17" >
                                </div>
                                <div class="col-md-3 pe-0 mb-3">
                                    <input type="search" name="keyword" value="search" class="form-control rounded-r-0" placeholder="Search" aria-label="Search">
                                </div>
                                <div class="col-md-2 ps-0 mb-3">
                                     <input class="btn btn-primary w-30 rounded-l-0 h-100" type="submit" value="Search">
                                </div>
                            </div>
                        </div> --}}
                        <div class="table-responsive d-lg-block d-md-block d-none custom-data-table-wrapper2">
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
                                        {{-- <th>
                                            <span class="userDatatable-title">collection type</span>
                                        </th> --}}
                                        <th>
                                            <span class="userDatatable-title">received by</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($installments as $key=>$item)
                                    <tr>
                                        <td>
                                        <div class="userDatatable-content">{{ $item->transaction_type }}</div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">{{ $item->hire_purchase->name }}</div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $item->hire_purchase->pr_phone }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $item->hire_purchase->purchase_product->product->product_model }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ @$product_details->show_room->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{  date('d/m/Y h:i A', strtotime($item->created_at))  }}</h6>
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
                                        {{-- <td>
                                            <div class="userDatatable-content">
                                                parvez
                                            </div>
                                        </td> --}}
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
        </div>

        @endif

    </div>

    {{-- Approve Modal --}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to approve this sale?</p>
                    <p><strong>Order No:</strong> {{ $product_details->order_no }}</p>
                    <p><strong>Customer:</strong> {{ $product_details->name }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="confirmApprove()">Approve</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this sale?</p>
                    <p><strong>Order No:</strong> {{ $product_details->order_no }}</p>
                    <p><strong>Customer:</strong> {{ $product_details->name }}</p>

                    <div class="mb-3">
                        <label for="rejectNote" class="form-label">Rejection Note <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectNote" rows="3" placeholder="Please provide a reason for rejection..."></textarea>
                        <div class="text-danger" id="rejectNoteError" style="display: none;">Please provide a rejection note.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="confirmReject()">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <script>
            function disableButton(button) {
                // Disable button immediately
                button.style.pointerEvents = 'none';
                button.style.opacity = '0.6';
                button.innerHTML = 'Processing...';

                // Re-enable after 10 seconds (adjust as needed)
                setTimeout(function() {
                    button.style.pointerEvents = 'auto';
                    button.style.opacity = '1';
                    button.innerHTML = 'Send Erp';
                }, 10000);
            }
</script>

    <script>
        let currentHireId = null;

        function showApproveModal(hireId) {
            currentHireId = hireId;
            $('#approveModal').modal('show');
        }

        function showRejectModal(hireId) {
            currentHireId = hireId;
            $('#rejectModal').modal('show');
        }

        function confirmApprove() {
            if (currentHireId) {
                window.location.href = "{{ url('approve-sale/') }}/" + currentHireId;
            }
        }

        function confirmReject() {
            const rejectNote = document.getElementById('rejectNote').value.trim();
            const errorDiv = document.getElementById('rejectNoteError');

            if (!rejectNote) {
                errorDiv.style.display = 'block';
                return;
            }

            errorDiv.style.display = 'none';

            if (currentHireId) {
                // Create a form to submit the rejection with note
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ url('reject-sale/') }}/" + currentHireId;

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add rejection note
                const noteInput = document.createElement('input');
                noteInput.type = 'hidden';
                noteInput.name = 'rejection_note';
                noteInput.value = rejectNote;
                form.appendChild(noteInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    @endsection


