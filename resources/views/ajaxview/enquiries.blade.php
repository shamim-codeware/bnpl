<div class="table-responsive d-lg-block d-md-block d-none custom-data-table-wrapper2">
    <h4 style="color: #0c3688" class="py-3">Total : {{ $total  }}</h4>
    <table class="table custom-data-table mb-0 table-bordered adv-table" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="10">
        <thead>
            <tr class="userDatatable-header">
                <th>
                    <span class="userDatatable-title">SL</span>
                </th>
                <th>
                    <span class="userDatatable-title">Event Code</span>
                </th>
                 <th>
                    <span class="userDatatable-title">Showroom </span>
                </th>
                <th data-type="html" data-name='Booking Id'>
                    <span class="userDatatable-title">Created date</span>
                </th>
                <th>
                    <span class="userDatatable-title">Source Category</span>
                </th>
                 <th>
                    <span class="userDatatable-title">Source</span>
                </th>
                <th>
                    <span class="userDatatable-title">Product</span>
                </th>
                <th  >
                    <span class="userDatatable-title">Full Name</span>
                </th>
                {{-- <th>
                    <span class="userDatatable-title">Mobile</span>
                </th> --}}
                <th>
                    <span class="userDatatable-title">Customer Type</span>
                </th>
                <th>
                    <span class="userDatatable-title">Status</span>
                </th>
                <th>
                    <span class="userDatatable-title">Assign by</span>
                </th>
                <th>
                    <span class="userDatatable-title">Created by</span>
                </th>
                <th>
                    <span class="userDatatable-title">Next Follow-up</span>
                </th>
                <!-- <th data-type="html" data-name='Created'>
                    <span class="userDatatable-title">Follow-up</span>
                </th> -->
                <th>
                    <span class="userDatatable-title d-block">action</span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($enquiries as $key=>$enquiry)
            <tr>
                <td>{{ ($enquiries->currentpage()-1) * $enquiries->perpage() + $key + 1 }}</td>
                <td><button style="color:#0C3688" class="mb-0 border-0 bg-transparent text-center" onclick="history({{ $enquiry->id }})"><div style="color:#0C3688" class="userDatatable-content">{{ $enquiry->event_code }}</div></button>

                    <div class="icon-wrapper">
                        @if($enquiry->buying_aspect == 1)
                        <span href="#" data-toggle="tooltip" data-placement="top" title="High" style="color: #00cc2c "><img src="https://i.postimg.cc/3R4Ttmqw/heigh.png" alt="High"></span>
                        @elseif($enquiry->buying_aspect == 2)
                        <span href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Medium" style="color: #00ccff"><img src="https://i.postimg.cc/s22QDHM0/medium.png" alt="medium"></span>
                        @else
                        <span href="#" data-toggle="tooltip" data-placement="top" title="Low" style="color: #ff5100"><img src="https://i.postimg.cc/4xWyMvWv/low.png" alt="low"></span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$enquiry->showroom->name }}
                    </div>
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <div class="userDatatable-inline-title">
                            <a href="#" class="text-dark fw-500">
                                <h6>{{  date('d/m/Y h:i A', strtotime($enquiry->created_at))  }}</h6>
                            </a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content">
                        {{ @$enquiry->enquiry_source->name }}
                    </div>
                </td>

                <td>
                    <div class="userDatatable-content">
                        {{ @$enquiry->enquiry_source_child->name }}
                    </div>
                </td>
                @php
                    $products = DB::table('enquiry_products')->where('enquiry_id',$enquiry->id)->get('product_name');
                    $productNames = $products->pluck('product_name')->implode(', ');
                @endphp
                <td><div class="userDatatable-content">{{$productNames}}</div></td>
                <td><div class="userDatatable-content"> <span class="d-block">{{ $enquiry->name }}</span> <a class="d-block" href="tel:{{ $enquiry->name }}"> <span><i class="fas fa-phone-alt"></i></span> {{ $enquiry->number }}</a></div></td>
                {{-- <td><div class="userDatatable-content">{{ $enquiry->number }}</div></td> --}}
                <td>
                    <div class="userDatatable-content d-inline-block">
                        <span class="color-success  userDatatable-content active">{{ @$enquiry->customer->customer_types->name }}</span>
                    </div>
                </td>
                <td>
                    @php
                     $new_close_status = array_diff($enquiry_status['close'], [$enquiry_status['sale']]);
                    @endphp
                    <div class="userDatatable-content d-inline-block @if($enquiry_status['open'] == @$enquiry->enquirystatus->id) yellow @elseif(in_array(@$enquiry->enquirystatus->id,$new_close_status)) red @elseif($enquiry_status['sale'] == @$enquiry->enquirystatus->id)green @elseif(in_array(@$enquiry->enquirystatus->id , $enquiry_status['pending'])) blue @else   @endif">
                        <span class="color-success   userDatatable-content active">
                            {{  @$enquiry->enquirystatus->name }}
                        </span>
                    </div>
                </td>

                <td>
                    <div class="userDatatable-content d-inline-block">
                        <span class="color-success  userDatatable-content active">{{  @$enquiry->assign_by->name }}</span>
                    </div>
                </td>

                <td>
                    <div class="userDatatable-content d-inline-block">
                        <span class="color-success  userDatatable-content active">{{ @$enquiry->users->name }}</span>
                    </div>
                </td>
                <td>
                    <div class="userDatatable-content d-inline-block">
                        <span class="color-success  userDatatable-content active">{{ $enquiry->next_follow_up_date? date('d/m/Y h:i A', strtotime($enquiry->next_follow_up_date)) : null }}</span>
                    </div>
                </td>
                <td>
                    <ul class="mb-0 justify-content-center align-items-center d-flex flex-wrap">
                        <li>
                            @if(Auth::user()->role_id == 2)
                            @if( (@$enquiry->enquirystatus->id  == @App\Models\Setting::first()->enquiry_status['open']) OR (in_array(@$enquiry->enquirystatus->id, @App\Models\Setting::first()->enquiry_status['pending']) ))
                            {{-- <button class="btn bg-green mb-2 text-center" onclick="attend({{ $enquiry->id }})">Attend</button> --}}
                            <a  class="btn bg-green mb-2  text-center" href="{{ url('/attend-follow-up/'.$enquiry->id) }}" >Attend</a>
                            @endif
                            @endif
                            <button class="btn btn-dark mb-2 text-center" onclick="history({{ $enquiry->id }})">History</button>
                            {{-- <a href="#" title="edit" class="edit"><i class="uil uil-edit"></i></a> --}}
                        </li>
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pt-2">
    {{  $enquiries->links()  }}
</div>

@foreach($enquiries as $key=>$enquiry)
<div class="enquiry-box d-lg-none d-md-none d-block card en-border mb-3">
    <div class="en-box-header  en-border-bottom">
        <div class="row align-items-center p-2">
            <div class="col-4">
                <p class="text-dark font-14px m-0">{{  date('d/m/Y', strtotime($enquiry->created_at))  }}</p>
            </div>
            <div class="col-4">
                <p class="text-center font-14px text-dark m-0">{{  $enquiry->event_code  }}</p>
            </div>
            <div class="col-4">
                <a href="tel:{{ $enquiry->number }}"> <span class="text-end font-14px phone-icon d-block m-0"><i
                            class="fas fa-phone"></i></span></a>

            </div>
        </div>
    </div>
    <div class="en-box-body">
        <div class="row p-2">
            <div class="col-9">
                <h6>{{ $enquiry->name  }}</h6>
                @php
                $products = DB::table('enquiry_products')->where('enquiry_id',$enquiry->id)->get('product_name');
                $productNames = $products->pluck('product_name')->implode(', ');
            @endphp
                <p class="en-text">{{ $productNames  }}</p>
                <p class="en-text">Source: {{ @$enquiry->enquiry_source->name }}</p>
                <p class="en-text">Next Follow-up: {{  date('d/m/Y h:i:s A', strtotime($enquiry->next_follow_up_date))  }}</p>
            </div>
            <div class="col-3">
                <p class="text-uppercase font-14 mb-0 fw-500 @if(@App\Models\Setting::first()->enquiry_status['open'] == @$enquiry->enquirystatus->id) text-success @else text-danger @endif font-14 text-end">{{  @$enquiry->enquirystatus->name }}</p>
                <p class="text-uppercase mb-0 fw-500 text-primary text-end"> @if($enquiry->buying_aspect == 1) Cold @elseif ($enquiry->buying_aspect == 2) Hot @else Warm @endif </p>
            </div>
        </div>


        <div class="en-box-footer d-flex justify-content-end">
            <div class="btn-group-wrapper d-flex gap-2 p-2">
                @if(Auth::user()->role_id == 2)
                @if(@$enquiry->enquirystatus->id  == @App\Models\Setting::first()->enquiry_status['open'])
                <a class="btn bg-green"  href="{{ url('/attend-follow-up/'.$enquiry->id) }}">Attend</a>
                @endif
                @endif
                <button class="btn btn-dark" onclick="history({{ $enquiry->id }})">History</button>
            </div>
        </div>
        <div class="ex-footer-bottom">
            <div class="row p-2">
                <div class="col-6">
                    <p class="mb-0 font-14 text-dark">{{  @$enquiry->assign_by->name }}</p>
                </div>
                <div class="col-6">
                    <p class="text-end font-14 text-dark mb-0">{{ @$enquiry->showroom->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


<script>
    $(document).ready(function () {
    // Create the outer div for the table top scrollbar
    let $parentDivForTableTopScrollBar = $('<div></div>').addClass('custom-data-table-wrapper1 sticky-top');

    // Create the inner div for the table top scrollbar
    let $innerDivForTableTopScrollBar = $('<div></div>').addClass('custom-data-table-top-scrollbar');

    // Append the inner div to the outer div
    $parentDivForTableTopScrollBar.append($innerDivForTableTopScrollBar);

    // Insert the outer div before the .custom-data-table-wrapper2 element
    let $customDataTableWrapper2 = $('.custom-data-table-wrapper2');
    $parentDivForTableTopScrollBar.insertBefore($customDataTableWrapper2);

    let $customDataTableWrapper1 = $('.custom-data-table-wrapper1');

    // Add a scroll event listener to customDataTableWrapper1
    $customDataTableWrapper1.on('scroll', function () {
        $customDataTableWrapper2.scrollLeft($customDataTableWrapper1.scrollLeft());
    });

    // Add a scroll event listener to customDataTableWrapper2
    $customDataTableWrapper2.on('scroll', function () {
        $customDataTableWrapper1.scrollLeft($customDataTableWrapper2.scrollLeft());
    });

    let $customDataTable = $('.custom-data-table');
    let customDataTableWidth = $customDataTable.outerWidth();
    $('.custom-data-table-top-scrollbar').css('width', customDataTableWidth + 'px');
});
</script>


