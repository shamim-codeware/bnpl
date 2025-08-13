@section('title',$title)
@section('description',$description)
@extends('layout.app')
@section('content')

{{-- <h2>Follow-up</h2> --}}

<div class="conatiner-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <h6>{{ $title }} </h6>
                                {{-- <p>
                                    
                                 Customer Name : {{ $followup->name }} <br>  Due Date : {{ $followup->next_follow_up_date  }}</p> --}}
                            </div>
                           
                            <div class="card-body py-md-30">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ url('/update-follow',$followup->id)}}" method="post">
                                <div class="row">
                                    <div class="col-4">
                                        <p> <strong>Customer Name : {{ $followup->name }} <br>  Due Date : {{ $followup->next_follow_up_date  }}</strong></p> 
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-25 select-style2">
                                            <div class="dm-select ">   
                                                <select onchange="SelecStatus()" name="status_parent_" id="parent_status" class="form-control">
                                                    <option value="" disabled >Status</option>
                                                    @foreach($enquiry_parent_status as $sett)
                                                    <option value="{{ $sett->id }}" @if($settings['open']==$sett->id)selected @endif  >{{$sett->name }}</option>
                                                    @endforeach
                                                </select> 
                                                {{-- <select onchange="SelecStatus()" name="status_parent" id="parent_status" class="form-control">
                                                    <option value="" disabled >Status</option>
                                                    @foreach($enquiry_status as $enqs)
                                                    <option value="{{ $enqs->id }}" @if($settings['open']==$enqs->id)selected @endif>{{$enqs->name}}</option>
                                                    @endforeach
                                                </select>           --}}
                                            </div>           
                                        </div>
                                    </div>

                                      <div class="col-md-4" id="visible_status" style="display: none">
                                        <div class="status_assign">

                                        </div>
                                     </div>

                                </div>
                                <hr class="mt-0 mb-3">
                                @csrf 
                                <div class="form-group row mb-n25">
                                    {{-- <div id="open" >
                                       
                                        <input type="hidden" value="{{ $status_open->id }}" name="status_parent">
                                    </div>

                                     <div id="sale" style="display: none">
                                        <input type="hidden" value="{{ $status_sale->id }}" name="status_parent">
                                    </div> --}}
                                   
                                    
                                        {{-- <div class="col-md-4 " id="close" style="display: none">
                                            <div class="mb-25 select-style2">
                                                <div class="dm-select ">
                                                    <select required name="status_parent" class="form-control ">
                                                        <option  value="">Select Purpose</option>
                                                        @foreach ($status_close as $close)
                                                        <option value="{{ $close->id }}">{{ $close->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> --}}
                                   

                                    <input type="hidden" readonly name="name" value="{{ $followup->name }}" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Full name">
                                    
                                    <div class="col-md-4">
                                        <div class="with-icon">
                                            @php 
                                              date_default_timezone_set('Asia/Dhaka');
                                             @endphp 
                                            {{-- <span class="lar la-calendar-plus color-light"></span> --}}
                                            <div class="form-group form-group-calender mb-20">
                                                <input value="<?=date('d-m-Y H:i:s')?>"  name="last_attend_date" placeholder="Attend date & time" id="flatpickr" class="flatpickr form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 next-info">
                                        <div class="mb-25 select-style2">
                                            <div class="dm-select ">
                                                <select name="follow_up_info" class="form-control ">
                                                    <option  selected value="{{ $followup->follow_up_info ? $followup->follow_up_info : '' }}">{{ $followup->follow_up_info ? $followup->follow_up_info : 'Select Follow Up Info' }}</option>
                                                    <option >Purchase Tomorrow</option>
                                                    <option >Next Week</option>
                                                    <option >Next Month</option>
                                                    <option >Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 next-method">
                                        <div class="mb-25 select-style2">
                                            <div class="dm-select ">          
                                                <select  name="next_follow_up_method" id="select-alerts2" class="form-control ">
                                                    <option class="tag" value="{{ $followup->next_follow_up_method ? $followup->next_follow_up_method : ''}}">{{ $followup->next_follow_up_method ? $followup->followupmethod->name : 'Select Method ' }}</option>
                                                    @foreach($followup_methods as $key=>$method)
                                                    <option class="tag" value="{{ $method->id }}">{{ $method->name }}</option>
                                                    @endforeach
                                                </select>          
                                            </div>           
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-25">
                                            <textarea required name="note" placeholder="Note" class="w-100 p-3"></textarea>            
                                        </div>
                                    </div>
{{-- 
                                    <div id="status_assign">

                                    </div> --}}
                            
                                    <div class="col-md-4 next-date">
                            
                                        {{-- <div class="with-icon">
                                            <span class="lar la-calendar-plus color-light"></span>
                                            <div class="form-group form-group-calender mb-20">
                                                <input  type="text"  name="next_follow_up_date" placeholder="Follow-up date & time*" class="flatpickr form-control" required>
                                            </div>
                                        </div> --}}
                            
                                        <div class="with-icon">
                                            {{-- <span class="lar la-calendar-plus color-light"></span> --}}
                                            <div class="form-group form-group-calender mb-20">
                                                <input autocomplete="off"  name="next_follow_up_date" placeholder="Next Follow-up date & time" class="flatpickr form-control" >
                                                <label for="" id="required" style="display:none;color: red;">Please Fill Up the field </label>
                                            </div>
                                        </div>
                                    </div>
                            
                                    </div>
                                        <div class="col-md-12 d-flex justify-content-end form-basic mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>
                                        </div>
                                    </div>
                                </div>
                              </form> 
                            </div>
                        </div>
                    </div>
                 
                </div>

            </div>
           
        </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<?php 
$json_arr = json_encode($settings['close'],TRUE);
?>
{{-- <input type="hidden" id="close" value="$settings['close'] }}">
<input type="hidden" id="sales" value="{{ $settings['sales'] }}"> --}}
<?php
$json = json_encode($settings['close']);
?>
<script>
$(document).ready(function() {
  const flatpickr_time = $('#flatpickr').flatpickr({
    //static: position the calendar inside the wrapper and next to the input element*.
    static: true
  });
});

    var arr = <?php echo $json; ?>;
    function SelecStatus(){
       //  console.log(arr);
        var parent_status = $("#parent_status").val();

        $.post("{{ url('/check-status')}}", {_token:'{{ csrf_token() }}','parent_status': parent_status}, function(data){
        
            if(data != ''){

                $("#visible_status").show();
                 $(".status_assign").html(data);
              
            }else{
                 $(".status_assign").html(data);
                 $("#visible_status").hide();
            }
          
        });

       if(arr.indexOf(parent_status) !== -1){
        $(".next-method").hide();
        $(".next-date").hide();
        $(".next-info").hide();
     
       }else{
        $(".next-method").show();
        $(".next-date").show();
        $(".next-info").show();
       }
    }
    // flatpickr(".flatpickr", {
    //             enableTime: true,
    //             dateFormat: "Y-m-d H:i",
    //         });
</script>

{{-- <script>
function StatusChild(parent_id){ 
    if((parent_id == 4) && $("#next_follow_up_date").val() == undefined){
        $("#required").show();
    }else{
        $("#required").hide();
    }
    $.post("{{ url('/child-status')}}", {_token:'{{ csrf_token() }}','parent_id': parent_id}, function(data){ 
        $('.status_child').html("");  
        // Child status
        if(data.length > 0){
            $('.status_child').append(`<option value="" disabled selected>Select One</option>`);
            $.each(data, function(index, item) {
                $('.status_child').append(`<option value="${item.id}">${item.name}</option>`);
            }); 
            $('.status_child').prop('required', true) ;
            $(".childclass").css('display', ''); 
        }else{
            $(".childclass").css('display', 'none');  
        }
    });
}
</script> --}}

@endsection
