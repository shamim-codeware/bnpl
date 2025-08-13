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
                        <div class="card card-default card-md mb-4">
                            <div class="card-header">
                                <div class="d-flex flex-wrap align-items-center">
                                    <h6>Pending Enquiry </h6>
                                    <div id="export"></div>
                                </div>                            
                            </div>
                            {{-- Passed Filter  --}}
                            <div class="filter p-4 d-none">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="datepicker3">From date</label>
                                        <input type="text" name="from_date" class="form-control" value="{{ request()->from_date? request()->from_date: date('1-m-y') }}"  id="datepicker3" placeholder="From Date" required autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="datepicker2">To date</label>
                                        <input type="text" name="to_date" class="form-control"   value="{{ request()->to_date? request()->to_date: date('t-m-Y') }}"  id="datepicker2" placeholder="To Date" required autocomplete="off">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="date_type">Date Type</label>
                                        <select name="date_type" id="date_type" class="form-control" required>
                                            <option value="1" @selected(request()->date_type == 1)>Follow-Up</option> 
                                            <option value="2" @selected(request()->date_type == 2)>Created At</option>
                                        </select>
                                    </div>
                                
                                    <div class="col-md-2">
                                        <label for="zone_id">Zone</label>
                                        <select name="zone_id" id="zone_id" class="form-control" required>
                                            <option value="0">All</option>
                                            @foreach ($data['zones'] as $zone)
                                                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="datepicker2">CTP</label>
                                        <select required name="show_room_id" id="show_room_id" class="form-control">
                                            <option value="0">All</option>
                                            @foreach ($data['showrooms'] as $showroom)
                                                <option value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  
                                    <div class="col-md-2">
                                        <label for="source_id">Enquiry Source</label>
                                        <select required name="source_id" id="source_id" class="form-control">
                                            <option value="0">All</option>
                                            @foreach ($data['sources'] as $source)
                                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="buying_aspect">Buying Aspect</label>
                                        <select required name="buying_aspect" id="buying_aspect" class="form-control">
                                            <option value="0">All</option> 
                                            <option value="1">Hot</option> 
                                            <option value="2">Warm</option> 
                                            <option value="3">Cool</option> 
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="status_type">Status Type</label>
                                        <select required name="status_type" id="status_type" onchange="status_type(this.value)" class="form-control">
                                            <option value="0">All</option> 
                                            @foreach ($data['status_types'] as $type)
                                                <option value="{{ $type['id'] }}">{{ $type['name'] }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 status_div" style="display: none">
                                        <label for="status">Status</label>
                                        <select required name="status" id="status" class="form-control status">
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-basic pb-4">
                                        <label for=""></label>
                                        <button type="button"  class="btn btn-lg btn-primary customr-btn btn-submit enquiry-filter">submit</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="data-assign"></div>
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
                {{-- <div class="search-box-header card mb-2 p-2 en-border">
                    <h4 class="text-center"></h4>
                    <hr class="title-bottom">
                    <div class="search-area d-flex justify-content-center align-items-center">
                        <span class="p-2 rounded"><i class="fas fa-search"></i></span>
                        <input placeholder="Search..." class="d-block w-100" type="search" name="" id="">
                        <span onclick="filterbtn();" id="filterbtn" class="d-flex align-items-center p-2"><i class="fas fa-filter"></i>Filter</span>
                    </div>
                </div> --}}

                {{-- filter-show  --}}
                {{-- <div style="display: none" id="filtershow" class="search-box-header card mb-2 p-2 en-border">
                    <div class="d-flex flex-wrap flex-lg-nowrap gap-1">
                      
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
                </div> --}}
            </div>
        </div>
    </div>
</div>

<!-- ends: .dm-page-content -->
{{-- <div class="modal-basic modal fade show" tabindex="-1" role="dialog" aria-hidden="false">
<div class="modal-dialog modal-xl" role="document">
   <div class="modal-content modal-bg-white ">
      <div class="modal-header">
        <h6 class="modal-title"></h6>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span class="text-danger"><i class="fas fa-times"></i></span></button>
      </div>
      <div class="modal-body">
          
      </div>
     
   </div>
</div> --}}
@endsection

@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){      
        getData(1, 0);

    });
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
        // Call 
        $.ajax({
            url: "{{ url('pending-enquiries?page=') }}"+page +"&"+paramStrings.join('&'),
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

        

        var custome = "{{ url('pending-enquiries-export?page=') }}"+page +"&"+paramStrings.join('&');
        const anchor = $('<a class="mx-2 fw-bold excel-btn" href="">Export Excel<i class="px-2 far fa-file-excel"></i></a>')
    .attr('href', custome)
    .text('Export'); 
    
    $("#export").html(anchor);

    }
    function status_type(type_id)
    {
        if(type_id == 3){
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
    // function attend(id)
    // {
    //     var url = "{{ url('/attend-follow-up/') }}" + '/' + id;
    //     $.get(url, function(data){
    //         $(".modal-body").html(data.html);
    //         $('.modal-title').html(data.title);
    //         $('.modal-basic').modal('show');
    //     });
    // }
    // function history(id)
    // {
    //     var url = "{{ url('/enquiry/') }}" + '/' + id;
    //     $.get(url, function(data){
    //         $(".modal-body").html(data.html);
    //         $('.modal-title').html(data.title);
    //         $('.modal-basic').modal('show');
    //     });
    // }
</script>
@endsection
