<div class="col-md-5">
    @php
        $installment_due_check = $hirepurchase->installment->where('status', 0)->count();
    @endphp

    @if ($installment_due_check > 0)
        @if ($hirepurchase->status == 3)
            <form action="{{ route('sales.return.submit') }}" method="POST" class="parent-assign">
                @csrf
                <input type="hidden" name="hire_purchase_id" value="{{ $hirepurchase->id }}">
                <fieldset class="">
                    <legend>Return or Cancel</legend>
                    <div class="row">
                        <div class="col-md-12 mb-25">
                            <select name="action_type" id="action_type" class="form-control" required>
                                {{-- <option value="" {{ old('action_type') ? '' : 'selected' }}>Select Action</option> --}}
                                <option value="cancel" {{ old('action_type') === 'cancel' ? 'selected' : '' }}>Sales Cancel</option>
                                <option value="return" {{ old('action_type') === 'return' ? 'selected' : '' }}>Sales Return</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-25" id="return_fields">
                            <select name="return_reason" id="return_reason" class="form-control" required>
                                <option value="">-- Select Return Reason --</option>
                                <option value="cash_purchase_change">Changed to Cash Purchase</option>
                                <option value="technical_issue">Technical Problem - Sales Return</option>
                                <option value="upgrade_model">Product Upgrade & Model Change</option>
                                <option value="defaulter_return">Defaulter Customer - Product Return</option>
                                <option value="others">Others</option>
                            </select>
                            @error('return_reason')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-25" id="return_ref_fields">
                            <label for="reference_number">Reference Number<span class="text-danger">*</span></label>
                            <input name="reference_number" id="reference_number" class="input" type="text" placeholder=" " />
                            @error('reference_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-25" id="cancel_fields" style="display: none;">
                            <textarea name="cancel_narration" id="cancel_narration" class="form-control" rows="3" placeholder="Cancel narration"></textarea>
                            @error('cancel_narration')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-25">
                            <button type="submit" class="btn btn-lg btn-danger customr-btn">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        @elseif ($hirepurchase->status == 5)
            <h4>
                This {{ @$hirepurchase->order_no }} Sales has already been returned
            </h4>
        @elseif ($hirepurchase->status == 4)
            <h4>
                This {{ @$hirepurchase->order_no }} Sales has already been cancelled
            </h4>
        @else
            <h4>
                This {{ @$hirepurchase->order_no }} Sales are pending
            </h4>
        @endif
    @else
        <br>
        <h4>
            Full payment for installment of product
            {{ @$hirepurchase->purchase_products->pluck('brand.name')->implode(', ') }}
            {{ @$hirepurchase->purchase_products->pluck('product.product_model')->implode(', ') }}
            from {{ optional($hirepurchase->customer)->name ?? 'N/A' }}
        </h4>
    @endif
</div>


<div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h6>Order & Financial Summary</h6>
            </div>
            <div class="card-body">

                <!-- Product Information -->
                <fieldset class="mb-4">
                    <legend>Product Information</legend>
                    <div class="row g-3">
                        <div class="col-md-5 text-end fw-bold">Category</div>
                        <div class="col-md-7">{{ $hirepurchase->purchase_products->pluck('product_category.name')->implode(', ') }}</div>

                        <div class="col-md-5 text-end fw-bold">Brand</div>
                        <div class="col-md-7">{{ $hirepurchase->purchase_products->pluck('brand.name')->implode(', ') }}</div>

                        <div class="col-md-5 text-end fw-bold">Model</div>
                        <div class="col-md-7">{{ $hirepurchase->purchase_products->pluck('product.product_model')->implode(', ') }}</div>

                        <div class="col-md-5 text-end fw-bold">Serial No</div>
                        <div class="col-md-7">{{ $hirepurchase->purchase_products->pluck('serial_no')->implode(', ') }}</div>

                        <div class="col-md-5 text-end fw-bold">Order No</div>
                        <div class="col-md-7"><strong>{{ $hirepurchase->order_no }}</strong></div>

                        <div class="col-md-5 text-end fw-bold">Purchase Date</div>
                        <div class="col-md-7">{{ \Carbon\Carbon::parse($hirepurchase->created_at)->format('d M Y') }}</div>
                    </div>
                </fieldset>

                <!-- Financial Summary - Most Important Part -->
                <fieldset>
                    <legend>Financial Summary</legend>
                    <div class="row g-3">

                        <div class="col-md-7 text-end fw-bold">Hire Price (Total Payable)</div>
                        <div class="col-md-5"><strong>{{ number_format($hirepurchase->hire_price, 2) }} TK</strong></div>

                        <div class="col-md-7 text-end">Down Payment</div>
                        <div class="col-md-5">{{ number_format($hirepurchase->down_payment, 2) }} TK</div>

                        <div class="col-md-7 text-end">Total Installment Paid</div>
                        <div class="col-md-5 text-success">{{ number_format($totalPaidInstallments, 2) }} TK</div>

                        <div class="col-md-7 text-end">Total Fine Paid</div>
                        <div class="col-md-5 {{ $totalFine > 0 ? 'text-danger' : '' }}">
                            {{ number_format($totalFine, 2) }} TK
                        </div>

                        <div class="col-md-7 text-end fw-bold border-top pt-2">Total Amount Paid</div>
                        <div class="col-md-5 fw-bold border-top pt-2">
                            {{ number_format($totalPaidOverall, 2) }} TK
                        </div>

                        <div class="col-md-7 text-end fw-bold text-danger border-top pt-3">Outstanding Amount</div>
                        <div class="col-md-5 fw-bold text-danger border-top pt-3 fs-5">
                            {{ number_format($outstandingAmount, 2) }} TK
                        </div>
                        <div class="col-md-7 text-end fw-bold text-danger border-top pt-3">Total Late Payment Fee</div>
                        <div class="col-md-5 fw-bold text-danger border-top pt-3 fs-5">
                            {{ number_format($totalLatePaymentFine, 2) }} TK
                        </div>

                        <div class="col-md-7 text-end">Monthly Installment</div>
                        <div class="col-md-5">{{ number_format($hirepurchase->monthly_installment, 2) }} TK</div>

                        <div class="col-md-7 text-end">Remaining Installments</div>
                        <div class="col-md-5">
                            {{ $remainingInstallmentCount }}
                        </div>

                        <div class="col-md-7 text-end">Customer</div>
                        <div class="col-md-5">{{ optional($hirepurchase->customer)->name ?? 'N/A' }}</div>

                    </div>
                </fieldset>

            </div>
        </div>
    </div>

    <script>
        (function () {
            function toggleReturnCancelFields() {
                var actionType = document.getElementById('action_type');
                if (!actionType) return;
                var isCancel = actionType.value === 'cancel';
                var returnFields = document.getElementById('return_fields');
                var returnRefFields = document.getElementById('return_ref_fields');
                var cancelFields = document.getElementById('cancel_fields');
                if (returnFields) returnFields.style.display = (isCancel || !actionType.value) ? 'none' : '';
                if (returnRefFields) returnRefFields.style.display = (isCancel || !actionType.value) ? 'none' : '';
                if (cancelFields) cancelFields.style.display = isCancel ? '' : 'none';

                var returnReason = document.getElementById('return_reason');
                var referenceNumber = document.getElementById('reference_number');
                var cancelNarration = document.getElementById('cancel_narration');
                if (returnReason) returnReason.required = (!isCancel && actionType.value === 'return');
                if (referenceNumber) referenceNumber.required = (!isCancel && actionType.value === 'return');
                if (cancelNarration) cancelNarration.required = isCancel;
            }

            document.addEventListener('change', function (e) {
                if (e.target && e.target.id === 'action_type') {
                    toggleReturnCancelFields();
                }
            });

            toggleReturnCancelFields();
        })();
    </script>
