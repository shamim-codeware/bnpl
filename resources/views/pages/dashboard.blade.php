@section('title', $title)
@section('description', $description)
@extends('layout.app')
@section('content')
    <div class="">
        <div class=" align-items-center mt-3">
            @if (Auth::user()->role_id == 1)
                <form action="{{ url('home') }}">
                    <div class="container-fluid px-0">
                        <div class="row gap-padding gx-2">
                            <div class="col-lg-6 mb-2">
                                <div class="dm-select req">
                                    <select onchange="FindShowroomD()" name="zone" id="zone" class="form-control">
                                        <option value="">All Zone </option>
                                        @foreach ($zones as $key => $zone)
                                            <option @if ($zone->id == request('zone')) selected @endif
                                                value="{{ $zone->id }}">{{ $zone->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-2">
                                <div class="row gx-1">
                                    <div class="col-lg-10 col-md-9 mb-2">
                                        <div class="dm-select w-100">
                                            <select name="Showroom" id="showroom" class="form-control">
                                                <option value="">All Showroom</option>
                                                @if (request('Showroom'))
                                                    @php
                                                        $showroom = App\Models\ShowRoom::where(
                                                            'id',
                                                            request('Showroom'),
                                                        )->first();
                                                    @endphp
                                                    <option value="{{ $showroom->id }}" selected> {{ $showroom->name }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <button class="btn w-100 btn-primary px-30 mx-1 lh-45px"
                                            type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
            @include('components.dashboard.overview_cards')
            @include('components.dashboard.sales_growth')
        </div>
    </div>

    <script>
        var show_room_id = <?php echo request('Showroom') ? request('Showroom') : 0; ?>;


        $(document).ready(function() {
            var parent_id = $("#zone").val();
            if (parent_id != '') {
                const selectElement = document.getElementById("showroom");
                $.post('{{ url('/select-showroom') }}', {
                    _token: '{{ csrf_token() }}',
                    parent_id: parent_id
                }, function(data) {
                    data = JSON.parse(data);
                    console.log(data);
                    selectElement.innerHTML = '';
                    const fixedOption = document.createElement('option');
                    fixedOption.value = '';
                    fixedOption.textContent = 'All Showroom';
                    selectElement.appendChild(fixedOption);
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id; // Replace 'item.value' with the actual data field
                        option.textContent = item
                            .name; // Replace 'item.text' with the actual data field
                        selectElement.appendChild(option);
                    });
                    if (show_room_id != 0) {
                        for (let i = 0; i < selectElement.options.length; i++) {
                            if (selectElement.options[i].value == show_room_id) {
                                selectElement.selectedIndex = i;
                                break;
                            }
                        }

                    }

                });

            }

            var marquetext = "this is test ";
            $.post('{{ url('/marquee-notifications') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {

                $("#marque-text_st").html(data);
            });

            EnquiryStatistics()

        });


        //Enquiry Statistics ajax operation
        // function EnquiryStatistics(){
        //     var marquetext = "this is test ";
        //     var month_source = $("#month_source").val();
        //     $.post('{{ url('/enquiry-statistics') }}', {
        //         _token: '{{ csrf_token() }}',
        //         month_source : month_source
        //     }, function(data) {
        //        $("#card-box-value-status").append(data);
        //     });
        // }

        function EnquiryStatistics() {
            // Get the current values of the date inputs
            var from_date = $('input[name=statisics_from_date]').val();
            var to_date = $('input[name=statisics_to_date]').val();

            // Convert date format from d-m-Y to Y-m-d for PHP compatibility
            if (from_date) {
                var parts = from_date.split('-');
                from_date = parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            if (to_date) {
                var parts = to_date.split('-');
                to_date = parts[2] + '-' + parts[1] + '-' + parts[0];
            }

            // Get the current values of the zone and showroom dropdowns
            var zone = $("#zone").val();
            var Showroom = $("#showroom").val();

            var url = "{{ url('/enquiry-statistics') }}";

            console.log('Sending request with:', {
                statisics_from_date: from_date,
                statisics_to_date: to_date,
                Showroom: Showroom,
                zone: zone
            });

            // Show loading indicator
            $(".appned_statistics").html(
                '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>'
                );

            // Use POST request
            $.post(url, {
                _token: '{{ csrf_token() }}',
                statisics_from_date: from_date,
                statisics_to_date: to_date,
                Showroom: Showroom,
                zone: zone
            }, function(data) {
                console.log('Received data:', data);
                $(".appned_statistics").html(data);

                // Initialize the date pickers again if needed
                $("#datepicker8, #datepicker17").datepicker({
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true
                });
            }).fail(function(xhr, status, error) {
                console.error('Request failed:', status, error);
                console.log('Response status:', xhr.status);
                console.log('Response text:', xhr.responseText);
                $(".appned_statistics").html(
                    '<div class="alert alert-danger">Error loading data. Please try again.</div>');
            });
        }


        function FindShowroomD() {
            var parent_id = $("#zone").val();
            if (parent_id != '') {
                const selectElement = document.getElementById("showroom");
                if (!selectElement) {
                    console.error("Element with ID 'showroom' not found.");
                    return; // Exit the function if the element is not found
                }

                $.post('{{ url('/select-showroom') }}', {
                    _token: '{{ csrf_token() }}',
                    parent_id: parent_id
                }, function(data) {
                    data = JSON.parse(data);
                    console.log(data);
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
                    if (show_room_id != 0) {
                        for (let i = 0; i < selectElement.options.length; i++) {
                            if (selectElement.options[i].value == show_room_id) {
                                selectElement.selectedIndex = i;
                                break;
                            }
                        }
                    }
                });
            }
        }
    </script>

@endsection
