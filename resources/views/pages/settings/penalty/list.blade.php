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
                            <h2>{{ __('Notice List') }}</h2>
                            <div id="export"></div>
                        </div>
                        <div class="card-body p-3" dir="ltr">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="order_no" autocomplete="off"
                                            value="{{ request()->order_no ?? '' }}"
                                            class="form-control ih-medium ip-gray radius-xs b-light" id="order_no"
                                            placeholder="Enter order number">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="from_date" autocomplete="off"
                                            value="{{ request()->from_date ? request()->from_date : date('1-m-Y') }}"
                                            class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8"
                                            placeholder="From Date">
                                    </div>
                                    <div style="width: 2%; height:40px;"
                                        class="col-1 d-flex justify-content-center align-items-center">
                                        <p class="m-0">To</p>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="text"
                                            value="{{ request()->to_date ? request()->to_date : date('t-m-Y') }}"
                                            name="to_date" autocomplete="off"
                                            class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker17"
                                            placeholder="To Date">
                                    </div>

                                    <div class="col-md-3">
                                        <select name="notice_no" class="form-control ih-medium ip-gray radius-xs b-light">
                                            <option value="">Select Notice</option>
                                            <option value="1st" {{ request()->notice_no == '1st' ? 'selected' : '' }}>1st
                                                Notice</option>
                                            <option value="2nd" {{ request()->notice_no == '2nd' ? 'selected' : '' }}>2nd
                                                Notice</option>
                                            <option value="3rd" {{ request()->notice_no == '3rd' ? 'selected' : '' }}>3rd
                                                Notice</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <select name="type" class="form-control ih-medium ip-gray radius-xs b-light">
                                            <option value="">Select Type</option>
                                            <option value="customer" {{ request()->type == 'customer' ? 'selected' : '' }}>
                                                Customer</option>
                                            <option value="granter" {{ request()->type == 'granter' ? 'selected' : '' }}>
                                                Granter</option>
                                        </select>
                                    </div>


                                    <div class="col-md-2 ps-0 mb-3">
                                        <input id="filter_date" class="btn btn-primary w-30 rounded-l-0 h-100"
                                            type="button" value="Search">
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

        $(document).on('click', '.pagination a', function(event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];
            // Get data
            getData(page, 0);
        });

        $('#filter_date').on('click', function() {
            getData(1, 1);
        });

        function getData(page, event) {
            var params = {
                order_no: $('input[name=order_no]').val(),
                from_date: $('input[name=from_date]').val(),
                to_date: $('input[name=to_date]').val(),
                notice_no: $('select[name=notice_no]').val(),
                type: $('select[name=type]').val()

            };
            var paramStrings = [];
            for (var key in params) {
                paramStrings.push(key + '=' + encodeURIComponent(params[key]));
            }
            $('.btn-submit').prop('disabled', true);

            var custome = "{{ url('penalty-export?page=') }}" + page + "&" + paramStrings.join('&');
            const anchor = $(
                    '<a class="mx-2 fw-bold excel-btn" href="">Export Excel<i class="px-2 far fa-file-excel"></i></a>')
                .attr('href', custome).text('Export');
            $("#export").html(anchor);
            // Call
            $.ajax({
                    url: "{{ url('all-penalty-action?page=') }}" + page + "&" + paramStrings.join('&'),
                    type: "get",
                    datatype: "html",
                })
                .done(function(data) {
                    $("#data-assign").empty().html(data);
                    $('.btn-submit').prop('disabled', false);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    getData(page, 0);
                    $('.btn-submit').prop('disabled', false);
                });
        }

        $(document).on('change', '.status', function() {

            let id = $(this).data('id');
            let status = $(this).val();

            $.ajax({
                url: "/penalty-status/" + id + "/" + status,
                type: "GET",
                success: function(res) {
                    if (res.status == 'success') {
                        toastr.success(res.message);
                    } else {
                        toastr.error(res.message);
                    }
                    getData(1, 0);
                },
                error: function() {
                    toastr.error("Something went wrong!");
                }
            });

        });
    </script>
@endsection
