@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h2>Pending Ctp Confirmation List </h2>
                        </div>
                        <div class="card-body p-3" dir="ltr">
                            <div class="form-group">
                                <div class="row">
                                    @if(Auth::user()->role_id == 3)
                                        <div class="d-none">
                                            <input type="hidden" value="" id="store_type" >
                                            <input type="hidden" value="" id="zone_id">
                                            <input type="hidden" id="show_room_id" value="{{ Auth::user()->showroom_id }}">
                                        </div>
                                    @elseif(Auth::user()->role_id == 2)

                                        <div class="col-md-4 mb-25">
                                            <select name="store_type" id="store_type" class="form-control">
                                                <option value="">All</option>
                                                <option value="0">Showroom</option>
                                                <option value="1">Dealer</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-25">
                                            <select name="showroom_ctp" id="show_room_id" class="form-control">
                                                <option value="">Showroom/CTP</option>
                                                @foreach ($showrooms as $showroom)
                                                    <option  @selected(request()->showroom_id == $showroom->id) value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="d-none">
                                            <input type="hidden" value="{{ Auth::user()->zone_id }}" id="zone_id">


                                        </div>
                                    @elseif((Auth::user()->role_id == 1) || (Auth::user()->role_id == 6))
                                        <div class="col-md-4 mb-25">
                                            <select name="store_type" id="store_type" class="form-control">
                                                <option value="">All Store Type</option>
                                                <option value="0">Showroom</option>
                                                <option value="1">Dealer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <select onchange="FindShowroom()" name="zone" id="zone_id" class="form-control">
                                                <option value="">Zone</option>
                                                @foreach($zones as $key=>$zone)
                                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-25">
                                            <select name="showroom_ctp" id="show_room_id" class="form-control">
                                                <option value="">Showroom/CTP</option>
                                                @foreach ($showrooms as $showroom)
                                                    <option  @selected(request()->showroom_id == $showroom->id) value="{{ $showroom->id }}">{{ $showroom->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-md-3">
                                        <input type="text" name="from_date"  autocomplete="off" value="{{ request()->from_date ? request()->from_date: date('1-m-Y') }}" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8" >
                                    </div>
                                    <div style="width: 2%; height:40px;" class="col-1 d-flex justify-content-center align-items-center"><p class="m-0">To</p></div>
                                    <div class="col-md-3 mb-3">
                                        <input type="text" value="{{ request()->to_date? request()->to_date: date('t-m-Y') }}" name="to_date" autocomplete="off"  class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker17" >
                                    </div>
                                    {{-- <div class="col-md-3 pe-0 mb-3">
                                        <input type="search" name="keyword"  class="form-control rounded-r-0" placeholder="Search" aria-label="Search">
                                    </div> --}}
                                    <div class="col-md-2 ps-0 mb-3">
                                        <input id="filter_date" class="btn btn-primary w-30 rounded-l-0 h-100" type="button" value="Search">
                                    </div>
                                </div>
                            </div>
                            <div id="data-assign"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function() {
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
        $('#filter_date').on('click', function(){
            getData(1, 1);
        });
        function getData(page, event)
        {
            var params = {
                from_date: $('input[name=from_date]').val(),
                to_date: $('input[name=to_date]').val(),
                zone_id: $('#zone_id').val(),
                showroom_id: $('#show_room_id').val(),
                store_type : $("#store_type").val()


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
                url: "{{ url('all-purchase-sale-pending-action?page=') }}"+page +"&"+paramStrings.join('&'),
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
    </script>


@endsection
