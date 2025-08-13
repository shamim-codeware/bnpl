
<div class="card mb-4">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h5>Model: <strong>{{ $product->product_model }}</strong></h5>
                <p>Cash Price: <strong>{{ number_format($product->hire_price, 2) }} BDT</strong></p>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success mb-0">
                    <p class="mb-0"><strong>Current Down Payment:</strong> {{ $down_payment }}%</p>
                    <small>You can change this on the main page and the calculations will update automatically</small>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table mb-4 table-bordered emi_calc_table">
    <tbody>
        <tr>
            @foreach($interestRate as $key=>$item)
            <td class="p-0">
                <table width="100%" cellpadding="0" >
                    <tr class="userDatatable-header">
                        <th style="border-bottom: 1px solid #f1f2f6 !important;" colspan="3">
                            <span class="userDatatable-title">Up to {{ $item->month }} Months</span>
                        </th>
                    </tr>
                    <tr class="userDatatable-header">
                        <th>
                            <span class="userDatatable-title">Sell Price</span>
                        </th>
                        <th style="border-left: 1px solid #f1f2f6 !important;
                            border-right: 1px solid #f1f2f6 !important;" >
                            <span class="userDatatable-title">Min. Down Payment</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">EMI</span>
                        </th>
                    </tr>
                    @php 
                    
                        $sell_price = $product->hire_price + (($product->hire_price * $item->interest_rate)/100);
                        $down_payment_total = ($sell_price *  floatval($down_payment)) / 100;
                        $after_downpayment = $sell_price - $down_payment_total;
                        $emi = $after_downpayment / ($item->month - 1);
                    @endphp 
                    <tr>
                        <td style="padding:5px;">  
                            <input type="hidden" id="hire_price_{{ $item->id }}" value="{{  $sell_price  }}">
                            <span id="sell_price_display_{{ $item->id }}">{{ number_format($sell_price, 2) }}</span>
                        </td>

                        <td style="background:cyan;padding:5px;min-width:50px;">
                            <input style="height: auto !important;padding:0 !important" type="hidden" id="installment_month_{{ $item->id }}" value="{{ $item->month }}">
                            <input style="height: auto !important;padding:0 !important" oninput="calculation({{ $item->id }})" id="down_payment_{{ $item->id }}"  type="text" value="{{ $down_payment_total  }}" class="form-control border-0 bg-transparent p-0 mt-1 text-center" >
                            <span style="color:red" id="down_alert_{{ $item->id }}"></span>
                        </td>

                        <td style="background:lightcoral;padding:5px;min-width:50px;">
                            <input style="height: auto !important;padding:0 !important" oninput="calculateDownPayment({{ $item->id }})" id="emi_{{ $item->id }}" type="text" value="{{ number_format($emi, 2, '.', '')   }}" class="form-control border-0 bg-transparent p-0 mt-1 text-center">

                            <span style="color:red" id="emi_alert_{{ $item->id }}"></span>
                        </td>
                    </tr>
                </table>
            </td>
            @endforeach
        
        </tr>
    </tbody>
</table>

<div class="alert alert-info mb-4">
    <p class="mb-0"><strong>Instructions:</strong></p>
    <ul class="mb-0">
        <li>To change the down payment percentage, select a different percentage from the dropdown on the main page - results will update automatically</li>
        <li>You can directly edit any down payment amount (blue cells) to see how it affects the monthly installment</li>
        <li>You can directly edit any monthly installment amount (red cells) to see how it affects the down payment</li>
        <li>Minimum monthly installment is 3,000 BDT</li>
    </ul>
</div>

<script>

function calculation(id) {
    var installment_month = $("#installment_month_"+id).val();
    var hire_price = $("#hire_price_"+id).val();
    var down_payment = parseFloat($("#down_payment_"+id).val()) || 0;
    if (installment_month == 0) {
        $("#down_payment_"+id).val(0);
        return;
    }

    var minimum_percentage = {{ floatval($down_payment) }};
    var minimum_payment = (hire_price * minimum_percentage / 100);
    
    var monthly_install = (hire_price - down_payment) / (installment_month-1);
    monthly_install = monthly_install.toFixed(2);
    
    if(minimum_payment > down_payment){
        var alert_message = `You must pay at least ${minimum_percentage}% (${formatNumber(minimum_payment)} BDT)`;
        $("#down_alert_"+id).html(alert_message);
    } else {
        $("#down_alert_"+id).html('');
    }
    
    if(monthly_install < 3000){
        $("#emi_alert_"+id).html("Minimum monthly installment is 3,000 BDT");
    } else {
        $("#emi_alert_"+id).html("");
    }
    
    $("#emi_"+id).val(formatNumber(monthly_install));
}

function calculateDownPayment(id) {
    var installment_month = $("#installment_month_"+id).val();
    var hire_price = $("#hire_price_"+id).val();

    var minimum_percentage = {{ floatval($down_payment) }};
    var minimum_payment = (hire_price * minimum_percentage / 100);

    var monthly_install = parseFloat($("#emi_"+id).val().replace(/,/g, '')) || 0;
    var down_payment = (hire_price - (monthly_install * (installment_month - 1)));
    $("#down_payment_"+id).val(down_payment.toFixed(2));

    if(minimum_payment > down_payment){
        var alert_message = `You must pay at least ${minimum_percentage}% (${formatNumber(minimum_payment)} BDT)`;
        $("#down_alert_"+id).html(alert_message);
    } else {
        $("#down_alert_"+id).html('');
    }

    if(monthly_install < 3000){
        $("#emi_alert_"+id).html("Minimum monthly installment is 3,000 BDT");
    } else {
        $("#emi_alert_"+id).html("");
    }
}

function formatNumber(number) {
    return parseFloat(number).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}


</script>