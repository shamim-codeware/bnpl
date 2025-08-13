
<div class="row bg-white rounded">
    <div class="col-lg-6">
        <p><strong>Full Name:</strong>
           
             {{ $enquiries->customer_id ? $enquiries->customer->name : '' }}</p>
        <p><strong>Mobile:</strong>  {{ $enquiries->customer_id ? $enquiries->customer->number : '' }}</p>
        <p><strong>Alternative Mobile:</strong>  {{ $enquiries->customer_id ? $enquiries->customer->alt_number : '' }}</p>
        <p><strong>Email:</strong> {{ $enquiries->customer_id ? $enquiries->customer->email : '' }}</p>
       
        <p><strong>Age :</strong>{{ $enquiries->customer->age}}</p>
        <p><strong>Event Code:</strong>  {{ $enquiries->event_code }}</p>
        <p><strong>Source:</strong>  {{ $enquiries->source_parent ? $enquiries->enquiry_source->name : '' }}   </p>    
        <p><strong>Buying Aspect :</strong>  @if($enquiries->buying_aspect == 1) High @elseif ($enquiries->buying_aspect == 2) Medium @else Low @endif   </p>  
    </div>
        @php 
        $products = DB::table('enquiry_products')->where('enquiry_id',$enquiries->id)->get('product_name');
        $productNames = $products->pluck('product_name')->implode(', ');
        @endphp 
    <div class="col-lg-6">
        <p><strong>Product :  </strong> {{ $productNames }}</p>
        <p><strong>Customer Type:</strong> Individual</p>
        <p><strong>Gender:</strong> {{ $enquiries->customer_id ? $enquiries->customer->gender : '' }} </p>
        <p><strong>Expected deliver/Sales Date (Calendar): </strong>{{  date('j F Y', strtotime($enquiries->sales_date))  }} </p>
        @php 
        if(!empty($enquiries->type_of_offer)){
            $decode = json_decode($enquiries->type_of_offer);
            $formattedString = implode(', ', $decode);
        }
        @endphp 
        <p><strong>Available Exchange offer:</strong> @php   if(isset($formattedString)){ echo $formattedString; }else{echo "No";} @endphp  </p>
        <p><strong>Payment Type:</strong> {{ $enquiries->purchase_mode ? $enquiries->purchase_modes->name : '' }}</p>        
    </div>
</div>       
<div class="mt-4">
    <div class="table-responsive custom-data-table-wrapper2">
        <table class="table mb-0 table-bordered custom-data-table " data-sorting="" data-filter-container="#filter-form-container" data-paging-current="1" >
            <thead>
                <tr class="userDatatable-header">
                    <th>
                        <span class="userDatatable-title">Date & Time</span>
                    </th>
                    <th data-type="html" data-name='Booking Id'>
                        <span class="userDatatable-title">Follow-up</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Follow-Up Information
                            </span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Method</span>
                    </th>
                    <th  >
                        <span class="userDatatable-title">Note</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php 
    
                    $followups = App\Models\FollowUp::with(['followupmethod'])->where('enquiry_id',$enquiries->id)->orderBy('id','ASC')->get();
                    $positioin =  count($followups);
                @endphp 
                @foreach($followups as $key=>$followup)
                <tr>
                    <td>
                        <div class="userDatatable-content">{{  date('d/m/Y h:i A', strtotime($followup->next_follow_up_date))  }}</div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <div class="userDatatable-inline-title">
                                <a href="#" class="text-dark fw-500">
                                    <h6>{{ \App\Helpers\Helper::formatOrdinal(++$key) }} Follow Up </h6>
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $followup->follow_up_info ? $followup->follow_up_info : '--' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            {{ $followup->next_follow_up_method ? $followup->followupmethod->name : '--' }}
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content text-center">
                            {{ $followup->note ? $followup->note : '--' }}               
                        </div>
                    </td>
                </tr>  
                @endforeach           
            </tbody>
        </table>
    </div>

  
</div>

 