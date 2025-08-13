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
                            <h2>Due On Next Month</h2>
                            <div id="export"></div>
                        </div>
                        <div class="card-body p-3" dir="ltr">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" name="order_no" autocomplete="off" value="{{ request()->order_no ?? '' }}" class="form-control ih-medium ip-gray radius-xs b-light"  placeholder="Enter order number">
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text" name="from_date" autocomplete="off" value="{{ request()->from_date ? request()->from_date : date('1-m-Y', strtotime('first day of next month')) }}" class="form-control ih-medium ip-gray radius-xs b-light" id="datepicker8">
                                    </div>
                                    <div style="width: 2%; height:40px;" class="col-1 d-flex justify-content-center align-items-center"><p class="m-0">To</p></div>
                                    <div class="col-md-2 mb-3">
                                        <input type="text" value="{{ request()->to_date ? request()->to_date : date('t-m-Y', strtotime('last day of next month')) }}" name="to_date" autocomplete="off" class="form-control ih-medium ip-gray radius-xs b-light" id="datepicker17">
                                    </div>

                                    {{-- <div class="col-md-2 pe-0 mb-3">
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
            $(".product_group").select2({
                placeholder: "Select Product Group",
                allowClear: true,

            });

        });
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
                order_no: $('input[name=order_no]').val(),
                product_group: $('#product_group').val()
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

            var custome = "{{ url('hire-purchase-export?page=') }}"+page +"&"+paramStrings.join('&');
            const anchor = $('<a class="mx-2 fw-bold excel-btn" href="">Export Excel<i class="px-2 far fa-file-excel"></i></a>')
                .attr('href', custome)
                .text('Export');
            $("#export").html(anchor);
            // Call
            $.ajax({
                url: "{{ url('due-on-next-month-get-data?page=') }}"+page +"&"+paramStrings.join('&'),
                type: "get",
                datatype: "html",
            })
                .done(function(data){
                    console.log(data);
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
