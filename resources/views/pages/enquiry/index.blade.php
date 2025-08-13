@section('title', $data['title'])
@section('description', $data['description'])
@extends('layout.app')

@section('content')


<div class="conatiner-fluid mt-3 position-relative">
    <div class="form-element">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-defaultn card-md mb-4">
                            <div class="card-header">
                                <div class="block-wrapper align-items-center d-flex gx-3 mb-2">
                                    <h6>Manage Enquiry</h6>
                                    <div id="export"></div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Filter <span class="m-0 px-1"><i class="fas fa-filter"></i></span>
                                      </button>
                                    <a class="btn btn-primary" href="{{ url('enquiry/create')}}">Add Enquiry</a>
                                    {{-- <div id="export"></div> --}}
                                </div>
                          

                            </div>
                            {{-- Filter --}}
                            {{-- <div class="card-header">
                                <div class="col-lg-12 d-lg-block d-md-block d-none d-flex justify-content-end">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Filter <span class="m-0 px-1"><i class="fas fa-filter"></i></span>
                                      </button>
                                </div>
                            </div> --}}
                              <div class="collapse {{ request()->has('from_date')? 'show': '' }}" id="collapseExample">
                                <div class="card card-body">
                                    <div class="filter p-4">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="text" name="from_date" autocomplete="off" value="{{ request()->from_date ? request()->from_date: date('1-m-Y') }}" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8" >    
                                            </div>
                                            <div style="width: 2%; height:40px;" class="col-1 d-flex justify-content-center align-items-center"><p class="m-0">To</p></div>
                                            <div class="col-md-3 mb-3">
                                                 <input type="text" name="to_date" autocomplete="off" value="{{ request()->to_date? request()->to_date: date('t-m-Y') }}" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker17" >   
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <select name="date_type" id="date_type" class="form-control" required>
                                                    <option value="2" @selected(request()->date_type == 2)>Created At</option>
                                                    <option value="1" @selected(request()->date_type == 1)>Follow-Up</option> 
                                                </select>
                                            </div>
                                            @if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 6) || (Auth::user()->role_id == 9))
                                            <div class="col-md-3">
                                                <select onchange="FindShowroom()" name="zone_id" id="zone_id" class="form-control" required>
                                                    <option value="0">All Zone</option>
                                                    @foreach ($data['zones'] as $zone)
                                                        <option  @selected(request()->zone_id == $zone->id)  value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                {{-- <label for="datepicker2">Showroom </label> --}}
                                                <select required name="show_room_id" id="show_room_id" class="form-control">
                                                    <option value="0">All Showroom</option>
                                                    @foreach ($data['showrooms'] as $showroom)
                                                        <option  @selected(request()->showroom_id == $showroom->id) value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3 d-none" >
                                                {{-- <label for="zone_id">Zone</label> --}}
                                                <select name="executive_id" id="executive_id" class="form-control" required>
                                                    <option value="0">All Executive</option>
                                                    @foreach ($data['executives'] as $executive)
                                                        <option value="{{ $executive->id }}">{{ $executive->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @elseif (Auth::user()->role_id == 3)
                                            <div class="col-md-3 mb-3">
                                                {{-- <label for="zone_id">Zone</label> --}}
                                                <select name="executive_id" id="executive_id" class="form-control" required>
                                                    <option value="0">All Executive</option>
                                                    @foreach ($data['executives'] as $executive)
                                                        <option value="{{ $executive->id }}">{{ $executive->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @elseif(Auth::user()->role_id == 2)
                                               <input type="hidden" id="executive_id" value="{{ Auth::user()->id }}">
                                            @endif
                                            <div class="col-md-3 mb-3">
                                                {{-- <label for="source_id">Enquiry Source</label> --}}
                                                <select required name="source_id" id="source_id" class="form-control">
                                                    <option value="0">All Source</option>
                                                    @foreach ($data['sources'] as $source)
                                                        <option @selected(request()->source_id == $source->id) value="{{ $source->id }}">{{ $source->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                {{-- <label for="buying_aspect">Buying Aspect</label> --}}
                                                <select required name="buying_aspect" id="buying_aspect" class="form-control">
                                                    <option value="0">All Buying Aspect</option> 
                                                    <option value="1">High</option> 
                                                    <option value="2">Medium</option> 
                                                    <option value="3">Low</option> 
                                                </select>
                                            </div>
                                            {{-- <div class="col-md-2">
                                                <label for="status_type">Status Type</label>
                                                <select required name="status_type" id="status_type" onchange="status_type(this.value)" class="form-control">
                                                    <option value="0">All Status</option> 
                                                    @foreach ($data['status_types'] as $type)
                                                        <option value="{{ $type['id'] }}">{{ $type['name'] }}</option> 
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="col-md-3 mb-3" >
                                                {{-- <label for="status">Status</label> --}}
                                                <select required name="status" id="status" class="form-control status" onchange="SelecStatus()">
                                                    <option value="0">All Status</option> 
                                                    @foreach ($data['status_parent'] as $type)
                                                        <option @selected(request()->status == $type->id) value="{{ $type->id }}">{{ $type->name }}</option> 
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="status_from_dashboard" value="{{ request()->status_ck }}">
                                            </div>

                                            <div class="col-md-3" style="display: @if(request()->status_ck) @else none @endif "  id="visible_status">
                                                <div class="status_assign">
                                                     <select id="status_parent" required  class="form-control ">
                                                       <option  value="">All Purpose</option>
                                                     </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1 form-basic pb-4">
                                                {{-- <label for=""></label> --}}
                                                <button type="button"  class="btn btn-lg btn-primary customr-btn  enquiry-filter">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            <div class="card-body p-2" >
                                <div id="data-assign">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-lg-none d-md-none d-sm-block d-block">
        <div class="row"> 
            <div class="col-lg-4 mx-auto">
                <div class="search-box-header card mb-2 p-2 en-border d-none">
                    <h4 class="text-center">Manage Enquiry</h4>
                    <hr class="title-bottom">
                    <div class="search-area d-flex justify-content-center align-items-center">
                        <span class="p-2 rounded"><i class="fas fa-search"></i></span>
                        <input placeholder="Search..." class="d-block w-100" type="search" name="" id="">
                        <span onclick="filterbtn();" id="filterbtn" class="d-flex align-items-center p-2"><i
                                class="fas fa-filter"></i>Filter</span>
                    </div>
                </div>

                {{-- filter-show  --}}
                <div style="display: none" id="filtershow" class="search-box-header card mb-2 p-2 en-border">
                    <div class="d-flex flex-wrap flex-lg-nowrap gap-1">
                        {{-- <div>
                        <span onclick="filter1()" id="filter1" class="filter-tagtitle">All Zone <i class="fas fa-chevron-down"></i></span>

                        <ul style="display: none" id="filterdata" class="filter-box-cat">
                            <li><a href="#">Dhaka</a></li>
                            <li><a href="#">Khula</a></li>
                        </ul>
                    </div> --}}
                        <div>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>All Zone</option>
                                <option value="1">Mirpur CTP</option>
                                <option value="2">Mohammadpur CTP</option>

                            </select>
                        </div>
                        <div>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>All Showroom</option>
                                <option value="1">Mirpur CTP</option>
                                <option value="2">Mohammadpur CTP</option>

                            </select>
                        </div>
                        <div>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>All Enquiry Source</option>
                                <option value="1">Mirpur CTP</option>
                                <option value="2">Mohammadpur CTP</option>

                            </select>
                        </div>
                        <div>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Buying Aspect </option>
                                <option value="1">Mirpur CTP</option>
                                <option value="2">Mohammadpur CTP</option>

                            </select>
                        </div>
                        <div>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Status</option>
                                <option value="1">Mirpur CTP</option>
                                <option value="2">Mohammadpur CTP</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('custom_js')
<script type="text/javascript">

 function SelecStatus(){
       //  console.log(arr);
        var parent_status = $("#status").val();
        $.post("{{ url('/check-status-all')}}", {_token:'{{ csrf_token() }}','parent_status': parent_status}, function(data){
            if(data != ''){
                $("#visible_status").show();
                 $(".status_assign").html(data);
              
            }else{
                 $(".status_assign").html(data);
                 $("#visible_status").hide();
            }
        });

    }

    var show_room_id = <?php echo request('showroom_id') ? request('showroom_id')  : 0 ?> ;
    
    $(document).ready(function() {

     var parent_status = $("#status").val();
     if(parent_status != 0){
            $.post("{{ url('/check-status-all')}}", {_token:'{{ csrf_token() }}','parent_status': parent_status}, function(data){
                if(data != ''){

                    $("#visible_status").show();
                    $(".status_assign").html(data);
                
                }else{
                    $(".status_assign").html(data);
                    $("#visible_status").hide();
                }
            });
    }




        var parent_id = $("#zone_id").val();
        $('.collapse').addClass('show');
        getData(1, 0);

    });

  

    function dateFlatpickr(){
        flatpickr(".flatpickr", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    }
    $(document).on('click', '.pagination a',function(event){
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var myurl = $(this).attr('href');
        var page=$(this).attr('href').split('page=')[1];
        // Get data 
        getData(page, 0);
    });
    $('.enquiry-filter').on('click', function(){
        getData(1, 1);
    });
    function getData(page, event)
    {
       
        var params = {
            from_date: $('input[name=from_date]').val(),
            to_date: $('input[name=to_date]').val(),
            date_type: $('#date_type').val(),
            zone_id: $('#zone_id').val(),
            showroom_id: $('#show_room_id').val(),
            source_id: $('#source_id').val(),
            buying_aspect: $('#buying_aspect').val(),
            status_type: $('#status_type').val(),
            status: $('#status').val(),
            executive_id : $("#executive_id").val(),
            from : $("#from").val(),
            status_from_dashboard : $("#status_from_dashboard").val(),
            status_child : $("#status_parent").val(),
        };
        var paramStrings = [];
        for (var key in params) {
            paramStrings.push(key + '=' + encodeURIComponent(params[key])); 
        }
        // Field validation 
        if(event == 1 && params.from_date == ""){
            toastr.error('From date field is required');
            return false;
        }
        if(event == 1 && params.to_date == ""){
            toastr.error('To date field is required');
            return false;
        }
        $('.btn-submit').prop('disabled', true);

        var custome = "{{ url('enquiry-export?page=') }}"+page +"&"+paramStrings.join('&');
        const anchor = $('<a class="mx-2 fw-bold excel-btn" href="">Export Excel<i class="px-2 far fa-file-excel"></i></a>')
    .attr('href', custome)
    .text('Export'); 
    $("#export").html(anchor);
        // Call 
        $.ajax({
            url: "{{ url('enquiries?page=') }}"+page +"&"+paramStrings.join('&'),
            type: "get",
            datatype: "html",
        })
        .done(function(data){
            $("#data-assign").empty().html(data);
            $('.btn-submit').prop('disabled', false);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError){
            getData(page, 0);
            $('.btn-submit').prop('disabled', false);
        });
    }
    function status_type(type_id)
    {
        if(type_id == 2){
            $('.status').html("");
            var url = "{{ url('/status-type/') }}" + '/' + type_id;
            // Ajax request 
            $.get(url, function(data){ 
                if(data){
                    $('.status').append(` <option value="0">All</option> `);
                    $.each(data, function(index, item) {
                        $('.status').append(`<option value="${item.id}">${item.name}</option>`);
                    }); 
                    $('.status').prop('required', true);
                    $(".status_div").css('display', ''); 
                }else{
                    $(".status_div").css('display', 'none');  
                }
            });
        }
    }
    function attend(id)
    {
        var url = "{{ url('/attend-follow-up/') }}" + '/' + id;
        $.get(url, function(data){
            $(".modal-body").html(data.html);
            $('.modal-title').html(data.title);
            $('.modal-basic').modal('show');
        });
    }
   

    </script>
@endsection