@include('partials._header')
{{-- shariya --}}

<body class="layout-light side-menu">
    <div class="mobile-search">
        <form action="/" class="search-form">
            <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
            <input class="form-control me-sm-2 box-shadow-none" type="search" placeholder="Search..." aria-label="Search">
        </form>
    </div>
    <div class="mobile-author-actions"></div>
    <header class="header-top">
        @include('partials._top_nav')
    </header>
    <main class="main-content">

        @include('partials._sidenav')
        {{-- sidebar --}}

        <div class="contents">
            @yield('content')
        </div>
        <footer class="footer-wrapper">
            @include('partials._footer')
        </footer>
    </main>
    <div id="overlayer">
        <span class="loader-overlay">
            <div class="dm-spin-dots spin-lg">
                {{-- <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span> --}}
            </div>
        </span>
    </div>
    <div class="overlay-dark-sidebar"></div>
    <div class="customizer-overlay"></div>
    <div class="customizer-wrapper">
        @include('partials._customizer')
    </div>


    <!-- ends: .dm-page-content -->
    <div class="modal-basic modal fade show" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-bg-white ">
                <div class="modal-header">
                    <h6 class="modal-title"></h6>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            class="text-danger"><i class="fas fa-times"></i></span></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>

        <script>
            var env = {
                iconLoaderUrl: "{{ asset('assets/js/json/icons.json') }}",
                googleMarkerUrl: "{{ asset('assets/img/markar-icon.png') }}",
                editorIconUrl: "{{ asset('assets/img/ui/icons.svg') }}",
                mapClockIcon: "{{ asset('assets/img/svg/clock-ticket1.sv') }}g"
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDduF2tLXicDEPDMAtC6-NLOekX0A5vlnY"></script>
        <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.min.js?v=0.5') }}"></script>
        <script src="{{ asset('js/app.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
        <script src="{{ asset('assets/js/apexmain.js') }}"></script>
        <script src="{{ asset('assets/js/charts.js?v=1.234') }}"></script>
        <script>
            function GetCategoryP() {
                var parentElement = document.getElementById("Select-Model");
                // var productSize = document.getElementById("product_size_id");
                var url = '{{ url('/query-category') }}';
                var grp_id = $("#group").val();
                // const myArray = grp_id.split("-");
                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    type: grp_id
                }, function(data) {

                    parentElement.innerHTML = '';

                    const fixedOption = document.createElement('option');
                    fixedOption.value = '';
                    fixedOption.textContent = 'select all';

                    parentElement.appendChild(fixedOption);
                    data[0].forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Replace 'item.value' with the actual data field
                        option.textContent = item.name; // Replace 'item.text' with the actual data field
                        parentElement.appendChild(option);
                    });


                });

            }

            function FindShowroom() {
                var parent_id = $("#zone_id").val();
                const selectElement = document.getElementById("show_room_id");
                $.post('{{ url('/select-showroom') }}', {
                    _token: '{{ csrf_token() }}',
                    parent_id: parent_id
                }, function(data) {
                    data = JSON.parse(data);
                    selectElement.innerHTML = '';
                    const fixedOption = document.createElement('option');
                    fixedOption.value = '';
                    fixedOption.textContent = 'All Showroom';
                    selectElement.appendChild(fixedOption);
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Replace 'item.value' with the actual data field
                        option.textContent = item.name; // Replace 'item.text' with the actual data field
                        selectElement.appendChild(option);
                    });

                });

            }

            function GetCategory() {
                var parentElement = document.getElementById("Select-Model");

                // var productSize = document.getElementById("product_size_id");
                var url = '{{ url('/query-category') }}';
                var grp_id = $("#group").val();
                // const myArray = grp_id.split("-");
                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    type: grp_id
                }, function(data) {

                    parentElement.innerHTML = '';

                    // productSize.innerHTML = '';

                    const fixedOption = document.createElement('option');
                    fixedOption.value = '';
                    fixedOption.textContent = 'select all';
                    // productSize.appendChild(fixedOption);

                    parentElement.appendChild(fixedOption);
                    data[0].forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Replace 'item.value' with the actual data field
                        option.textContent = item.name; // Replace 'item.text' with the actual data field
                        parentElement.appendChild(option);
                    });


                    data[1].forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Replace 'item.value' with the actual data field
                        option.textContent = item.name; // Replace 'item.text' with the actual data field
                        productSize.appendChild(option);
                    });

                });

            }

            function GetProduct() {
                var parentProductElement = document.getElementById("Select-color");
                var url = '{{ url('/query-product') }}';
                var grp_id = $("#group").val();
                var category = $("#Select-Model").val();
                var prod_brand = $("#prod_brand").val();

                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    type: grp_id,
                    category: category,
                    brand_id: prod_brand
                }, function(data) {
                    parentProductElement.innerHTML = '';

                    const fixedOption = document.createElement('option');
                    fixedOption.value = '';
                    fixedOption.textContent = 'Select Product';

                    parentProductElement.appendChild(fixedOption);

                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.product_model;
                        parentProductElement.appendChild(option);
                    });
                });
            }


            function SourceStatistics() {

                var month_source = $("#month_source_source").val();
                var zone = "{{ request('zone') }}";
                var Showroom = "{{ request('Showroom') }}";
                var url = "{{ url('/source-statistics/') }}";
                $("#sourcedata").html('');
                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    month_source: month_source,
                    Showroom: Showroom,
                    zone: zone
                }, function(data) {
                    $("#sourcedata").html(data);
                });
            }

            // function EnquiryStatistics() {
            //     var month_source = $("#month_source").val();
            //     var zone = {!! json_encode(old('zone')) !!};
            //     var Showroom = {!! json_encode(old('Showroom')) !!};
            //     var url = "{{ url('/enquiry-statistics/') }}";

            //     $("#card-box-value-status").html('');

            //     $.get(url, {
            //         month_source: month_source,
            //         Showroom: Showroom,
            //         zone: zone
            //     }, function(data) {
            //         console.log(data);
            //         $(".appned_statistics").html(data);
            //     });
            // }

            function EnquiryStatistics() {
                var from_date = $('input[name=from_date]').val();
                var to_date = $('input[name=to_date]').val();
                var zone = "{{ request('zone') }}";
                var Showroom = "{{ request('Showroom') }}";
                var url = "{{ url('/enquiry-statistics') }}";

                $("#card-box-value-status").html('');

                $.post(url, {
                    _token: '{{ csrf_token() }}',
                    Showroom: Showroom,
                    zone: zone,
                    from_date: from_date,
                    to_date: to_date
                }, function(data) {
                      $(".appned_statistics").html(data);
                });
            }

            $(document).ready(function() {

                // SourceStatistics();
                toastr.options.timeOut = 10000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif (Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif
                // Menu active
                $('li.has-child').each(function() {
                    if ($(this).find('li.sub-menu-li.active').length > 0) {
                        $(this).closest('.has-child').addClass('open');
                        $(this).find('.sub-menu').css('display', '');
                    }
                });
                //
                flatpickr(".flatpickr", {
                    enableTime: true,
                    dateFormat: "d-m-Y H:i",
                    onClose: function(selectedDates, dateStr, instance) {
                        // Check if a date is selected
                        if (selectedDates.length > 0) {
                            // Close the Flatpickr instance
                            instance.close();
                        }
                    }
                });
            });


            function history(id) {
                var url = "{{ url('/enquiry/') }}" + '/' + id;
                $.get(url, function(data) {
                    $(".modal-body").html(data.html);
                    $('.modal-title').html(data.title);
                    $('.modal-basic').modal('show');
                });
            }
        </script>

        <script>
            function FindDistrict() {
                var district_id = $("#select-district").val();
                const selectElement = document.getElementById("Select-upazila");
                $.post('{{ url('/find-upazila') }}', {
                    _token: '{{ csrf_token() }}',
                    district_id: district_id
                }, function(data) {
                    data = JSON.parse(data);
                    selectElement.innerHTML = '';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Replace 'item.value' with the actual data field
                        option.textContent = item.name; // Replace 'item.text' with the actual data field
                        selectElement.appendChild(option);
                    });

                });

            }
        </script>



        @yield('custom_js')
</body>

</html>
