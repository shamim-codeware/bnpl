 @section('title', $title)
 @section('description', $description)
 @extends('layout.app')

 @section('content')
     <div class="row">
         <div class="col-lg-12 mb-4">
             <div class="card">
                 <div class="card-header">
                     <h2>Zone overview/CTP Overview</h2>
                 </div>
                 <div class="card-body p-3" dir="ltr">
                     <div class="form-group">
                         <div class="row">
                             {{-- <div class="col-md-3 mb-25">
                                 <select name="report_type" id="report_type" class="form-control">
                                     <option value="">Report Type</option>
                                     <option value="zone">Zone</option>
                                     <option value="showroom">Showroom</option>
                                 </select>
                             </div> --}}
                             {{-- <div class="col-md-4 mb-25">
                                 <select name="all_zone[]" id="all_zone" class="form-control">
                                     <option value="">All Zone</option>
                                     @foreach ($zones as $zone)
                                         <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                     @endforeach
                                 </select>
                             </div> --}}
                             @if (auth()->user()->role_id == 1) {{-- 1 = Admin --}}
                                 <div class="col-md-4 mb-25">
                                     <select name="all_zone[]" id="all_zone" class="form-control">
                                         <option value="">All Zone</option>
                                         @foreach ($zones as $zone)
                                             <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             @endif
                             <div class="col-md-4 mb-25">
                                 <select name="product_group[]" id="product_group" class="form-control">
                                     <option value="">Product Group</option>
                                     @foreach ($product_type as $group)
                                         <option value="{{ $group->id }}">{{ $group->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                             <div class="col-md-3">
                                 <input type="text" name="from_date" autocomplete="off" placeholder="From Date "
                                     class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8">
                             </div>
                             <div style="width: 2%; height:40px;"
                                 class="col-1 d-flex justify-content-center align-items-center">
                                 <p class="m-0">To</p>
                             </div>
                             <div class="col-md-3 mb-3">
                                 <input type="text" name="to_date" placeholder="To Date" autocomplete="off"
                                     value="" class="form-control  ih-medium ip-gray radius-xs b-light"
                                     id="datepicker17">
                             </div>
                             {{-- <div class="col-md-3 pe-0 mb-3">
                                    <input type="search" name="keyword" value="search" class="form-control rounded-r-0"
                                        placeholder="Search" aria-label="Search">
                                </div> --}}
                             <div class="col-md-2 ps-0 mb-3">
                                 <input id="filter_date" class="btn btn-primary w-30 rounded-l-0 h-100" type="submit"
                                     value="Search">
                             </div>
                         </div>
                     </div>
                     <div class="data-append">

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
             $('.GroupedBarChart').css('display', 'none');

             var params = {
                 zone_id: $('select[id=all_zone]').val(),
                 product_group: $('select[id=product_group]').val(),
                 from_date: $('input[name=from_date]').val(),
                 to_date: $('input[name=to_date]').val(),
             };


             var paramStrings = [];
             for (var key in params) {
                 paramStrings.push(key + '=' + encodeURIComponent(params[key]));
             }



             // Field validation
             // if (event == 1 && params.from_date == "") {
             //     toastr.error('From date field is required');
             //     return false;
             // }
             // if (event == 1 && params.to_date == "") {
             //     toastr.error('To date field is required');
             //     return false;
             // }
             $('.btn-submit').prop('disabled', true);

             var custome = "{{ url('hire-purchase-export?page=') }}" + page + "&" + paramStrings.join('&');
             const anchor = $(
                     '<a class="mx-2 fw-bold excel-btn" href="">Export Excel<i class="px-2 far fa-file-excel"></i></a>')
                 .attr('href', custome)
                 .text('Export');
             $("#export").html(anchor);
             // Call
             $.ajax({
                     url: "{{ url('zone-overview-get-data?page=') }}" + page + "&" + paramStrings.join('&'),
                     type: "get",
                     datatype: "html",
                 })
                 .done(function(data) {
                     $(".data-append").empty().html(data);
                     //   $('.GroupedBarChart').css('display', 'block');
                     //   groupBarChart(".GroupedBarChart", "100%", 280,data.total_hirepurchase_price, data.total_paid, data.total_remaining);

                     //  $("#data-assign").empty().html(data);
                     $('.btn-submit').prop('disabled', false);
                 })
                 .fail(function(jqXHR, ajaxOptions, thrownError) {
                     getData(page, 0);
                     $('.btn-submit').prop('disabled', false);
                 });
         }
     </script>
 @endsection
