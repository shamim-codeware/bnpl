<div class="col-md-5">
    @if ($installment_due_check > 0)
        @if ($hirepurchase->status == 3)
            <form action="{{ url('payment-collection') }}" method="post" class="parent-assign">
                @csrf
                <fieldset class="">
                    <legend>Payment Info:</legend>
                    <div class="row">
                        <div class="col-md-12 mb-25">
                            {{-- <h6 class="fw-normal">Details of money received on <strong>May 7,2024</strong>
                                regarding <strong>installments</strong> from <strong></strong></h6> --}}
                        </div>
                        <div class="col-md-12 mb-25">
                            <input type="hidden" value="{{ $hirepurchase->id }}" name="hire_purchase_id"
                                id="hire_purchase_id">
                            <input type="hidden" id="monthly_installment"
                                value="{{ @$hirepurchase->purchase_product->monthly_installment }}"
                                name="monthly_installment">
                            <select onchange="CalculateAmount()" name="number_of_instllment" id="number_of_instllment"
                                class="form-control">
                                <option value="">How many months are you accepting
                                    installments?</option>
                                @php
                                    $remainingInstallments = App\Models\Installment::where(
                                        'hire_purchase_id',
                                        $hirepurchase->id,
                                    )
                                        ->where('status', 0)
                                        ->count();
                                    $maxInstallments = Auth::user()->role_id == 3 ? 1 : min(9, $remainingInstallments);
                                @endphp
                                @for ($i = 1; $i <= $maxInstallments; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                {{--                                    <option value="0">Others</option> --}}
                            </select>
                        </div>
                        <div class="col-md-12 mb-25">
                            <div class="holder">
                                <div class="input-holder">
                                    <input readonly required="" name="amount" id="amount" class="input"
                                        type="text" placeholder=" " />
                                    <div class="placeholder">
                                        <p class="m-0">Receiving (BDT)<span class="text-danger">*</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-25" id="remarks_container" style="display:none;">
                            <div class="holder">
                                <div class="input-holder">
                                    <textarea name="fine_remarks" id="fine_remarks" class="form-control" placeholder="Enter remarks for late fine..."></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="fine_amount" id="fine_amount">
                        <div class="col-md-12 mb-25">
                            <h3 id="fine_amount_display" style="color: red; display: none;"></h3>
                        </div>
                        <div class="col-md-12 mb-25">
                            <div class="select-style2">
                                <div class="form-control d-flex gap-3 align-items-center">
                                    <div class="d-flex align-items-center flex-nowrap gap-2"><input checked
                                            name="payment_type" id="cus_showroom" value="1" type="radio" />
                                        <label class="mt-0" for="cus_showroom">The customer comes
                                            to
                                            the showroom and makes the payment</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-25">
                            <div class="select-style2">
                                <div class="form-control d-flex gap-3 align-items-center">
                                    <div class="d-flex align-items-center flex-nowrap gap-2"><input id="cus_house"
                                            name="payment_type" value="cus_house" type="radio" /> <label
                                            class="mt-0" for="2">Collection is being done by going to
                                            the customer's house</label></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 mb-25 pe-md-0">
                            <h4 id="msg_forwarn"></h4>
                            <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">Recive
                                Payment</button>
                        </div>
                        {{-- <div class="col-md-5 mb-25 ps-md-0">
                            <button type="button" class="btn btn-danger">
                                Cancel
                            </button>
                        </div> --}}
                    </div>
                </fieldset>
            </form>
        @else
            <h4>

                This {{ @$hirepurchase->order_no }} Sales are pending

            </h4>
        @endif
    @else
        <br>
        <h4>

            Full payment for installment of product {{ @$hirepurchase->purchase_product->brand->name }}
            {{ @$hirepurchase->purchase_product->product->product_model }} from {{ @$hirepurchase->name }}

        </h4>
    @endif
</div>

<div class="col-md-7">
    <fieldset>
        <legend>{{ @$hirepurchase->purchase_product->brand->name }}
            {{ @$hirepurchase->purchase_product->product->product_model }}</legend>
        <div class="row">
            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Product's Price:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span>{{ $hirepurchase->purchase_product->hire_price }} TK</span>
            </div>
            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Down payment paid:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span>{{ $hirepurchase->purchase_product->down_payment }} TK</span>
            </div>
            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Total payment ({{ $hirepurchase->purchase_product->installment_month - 1 }}
                    installments) to be made:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span>{{ $hirepurchase->purchase_product->hire_price - $hirepurchase->purchase_product->down_payment }}
                    TK</span>
            </div>
            {{-- <div class="col-md-7 mb-15 text-end">
                            <span class="fw-medium">Total payment (6 installments) to be made:</span>
                        </div>
                        <div class="col-md-5 mb-15">
                            <span>51,400.00 TK</span>
                        </div> --}}
            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Total paid in installments:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span> {{ $hirepurchase->purchase_product->total_paid }} TK</span>
            </div>
            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Remaining Installments:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span>
                    {{ App\Models\Installment::where('hire_purchase_id', $hirepurchase->id)->where('status', 0)->count() }}</span>
            </div>

            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Remaining Installments Amount:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span>
                    {{ App\Models\Installment::where('hire_purchase_id', $hirepurchase->id)->where('status', 0)->sum('amount') }}
                    TK </span>
            </div>

            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Monthly installment amount:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span>{{ $hirepurchase->purchase_product->monthly_installment }} TK</span>
            </div>
            <div class="col-md-7 mb-15 mt-15 text-end">
                <span class="fw-medium">Purchased the product:</span>
            </div>
            <div class="col-md-5 mb-15 mt-15">
                <span>{{ $hirepurchase->created_at->format('M j, Y') }}</span>
            </div>
            <div class="col-md-7 mb-15 text-end">
                <span class="fw-medium">Today's date:</span>
            </div>
            <div class="col-md-5 mb-15">
                <span> {{ $hirepurchase->created_at->format('M j, Y') }}
                </span>
            </div>
        </div>
    </fieldset>

</div>

<script>
    function CalculateAmount() {
        var monthly_installment = $("#monthly_installment").val();
        var number_of_instllment = $("#number_of_instllment").val();

        var hire_purchase_id = $("#hire_purchase_id").val();
        if (number_of_instllment == 0) {
            $("#amount").removeAttr("readonly");
            $("#amount").val(monthly_installment);
        } else {
            // Send data to the server via AJAX
            $.ajax({
                url: '/calculate-amount', // Server endpoint
                type: 'POST',
                data: {
                    monthly_installment: monthly_installment,
                    number_of_instllment: number_of_instllment,
                    hire_purchase_id: hire_purchase_id,
                    _token: $('meta[name="csrf-token"]').attr('content') // Laravel CSRF token
                },
                success: function(response) {
                    // Update the amount field with the calculated value
                    $("#amount").attr("readonly", "readonly");
                    $("#amount").val(response.total_amount);

                    // // Display fine amount if exists
                    // if (response.fine && response.fine > 0) {
                    //     $("#fine_amount_display").html("Fine Amount: " + response.fine + " BDT").show();
                    // } else {
                    //     $("#fine_amount_display").hide();
                    // }

                    if (response.fine && response.fine > 0) {
                        $("#fine_amount_display")
                            .html("Fine Amount: " + response.fine + " BDT")
                            .show();
                        $("#fine_amount").val(response.fine);
                        $("#remarks_container").show();
                        $("#fine_remarks").attr("required", true);
                    } else {
                        $("#fine_amount_display").hide();
                        $("#fine_amount").val('');
                        $("#remarks_container").hide();
                        $("#fine_remarks").removeAttr("required");
                    }
                },
                error: function(xhr) {
                    console.error("Error calculating amount:", xhr.responseText);
                }
            });
        }
    }

    function calculateMinimuninstallment() {
        var monthly_installment = $("#monthly_installment").val();
        var amount = $("#amount").val();
        var msg = "You Must be need to Payment " + monthly_installment + "BDT";
        if (monthly_installment > amount) {
            $("#msg_forwarn").html(msg);
        } else {
            $("#msg_forwarn").html('');
        }
    }
    $("#amount").on("input", calculateMinimuninstallment);
</script>
