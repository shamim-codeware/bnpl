<nav class="navbar navbar-light">
    <div class="navbar-left">
        <div class="logo-area">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img class="dark" src="{{ asset('assets/img/rangs-logo-1.png') }}" alt="svg">
                {{-- <img class="dark" src="{{ asset('assets/img/rangs-logo-1.png') }}" alt="svg"> --}}
                {{-- <img class="light" src="{{ asset('assets/img/tvs-logo.png') }}" alt="img"> --}}
            </a>
            <a href="#" class="sidebar-toggle">
                <img class="svg" src="{{ asset('assets/img/svg/align-center-alt.svg') }}" alt="img"></a>
            {{--
            <div style="gap: 10px" class="d-flex date-times">
                <a style="font-size: 16px" class="bg-red fw-bold d-block p-1 px-2 rounded-2" href="#">
                    <div id="digital-clock"></div>
                </a>
                <div class="date d-block fw-bold bg-red p-1 px-2 rounded-2">
                    <p style="font-size:16px" class="mb-0 fw-bold">@php date_default_timezone_set('Asia/Dhaka') @endphp {{ date('d/m/Y') }}</p>
                </div>
            </div> --}}
        </div>


        {{-- <li class="nav-notification">
            <div class="dropdown-custom">
                <a href="{{ url('/notifications') }}" class="positioin-relative">
                    <img class="svg" src="{{ asset('assets/img/svg/alarm.svg') }}" alt="img">
                    <span  class="position-absolute not-count">{{ count($enquiries) + count( $passedover) }}</span>
                </a>

            </div>
        </li> --}}
    </div>
    <div class="offer_text mx-auto">
        <h1> Buy Now Pay later</h1>
    </div>
    {{-- <div class="navbar-middle top-heading d-lg-block d-none">
        Healine 
        <div class="container-fluid">
            <div class="row">
                <div class="dashboard_marque">
                    <marquee class="" id="marque-text">
                    </marquee>
                </div>
            </div>
        </div>
          Healine 
    </div> --}}
    <div class="dashboard_marque">
        <marquee id="marque-text_st" behavior="scroll" direction="left">
        </marquee>
    </div>

    <div class="navbar-right ms-auto">
        <ul class="navbar-right__menu">
            {{-- <div class="date-time">
                <a href="#"><div id="digital-clock"></div></a>
                <div class="date"><p class="mb-0">@php date_default_timezone_set('Asia/Dhaka') @endphp {{ date('d/m/Y') }}</p></div>
            </div> --}}
            @php
                use App\Models\Notification;
                use App\Models\ZonePermission;
                $total_notification = 0;
                $userId = Auth::user()->id;

                if (Auth::user()->role_id == 3) {
                    // manager
                    $total_notification = Notification::with(['showroom', 'notificationSeen', 'hirepurchase'])
                        ->where('manager', 1)
                        ->whereDoesntHave('notificationSeen', function ($query) use ($userId) {
                            $query->where('user_id', $userId);
                        })
                        ->where('showroom_id', Auth::user()->showroom_id)
                        ->count();
                } elseif (Auth::user()->role_id == 6) {
                    //retailer
                    $permission = ZonePermission::where('user_id', Auth::user()->id)
                        ->pluck('zone_id')
                        ->toArray();

                    $total_notification = Notification::with(['showroom', 'notificationSeen', 'hirepurchase'])
                        ->where('retail', 1)
                        ->whereDoesntHave('notificationSeen', function ($query) use ($userId) {
                            $query->where('user_id', $userId);
                        })
                        ->whereHas('showroom', function ($q) use ($permission) {
                            $q->whereIn('zone_id', $permission);
                        })
                        ->count();
                }
            @endphp


            <li class="nav-notification">
                <div class="dropdown-custom">
                    <a href="{{ url('/notifications') }}" class="positioin-relative">
                        <i class="far fa-bell fa-2x"></i>
                        <span class="position-absolute not-count">{{ $total_notification }}</span>
                    </a>
                </div>
            </li>
            <li class="nav-author">
                <div class="dropdown-custom">
                    <a href="javascript:;" class="nav-item-toggle"><img
                            src="{{ Auth::user()->profile_photo_path ? url(Auth::user()->profile_photo_path) : asset('assets/img/author-nav.jpg') }}"
                            alt="" class="rounded-circle">
                        @if (Auth::check())
                            <span
                                class="nav-item__title">{{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}<i
                                    class="las la-angle-down nav-item__arrow"></i></span>
                        @endif
                    </a>
                    <div class="dropdown-wrapper">
                        <div class="nav-author__info">
                            <div class="author-img">
                                <img src="{{ Auth::user()->profile_photo_path ? url(Auth::user()->profile_photo_path) : asset('assets/img/author-nav.jpg') }}"
                                    alt="" class="rounded-circle">
                            </div>
                            <div>
                                @if (Auth::check())
                                    <h6 class="text-capitalize">
                                        {{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}
                                    </h6>
                                @endif
                                @php
                                    $role = App\Models\User::with('roles')
                                        ->where('id', Auth::user()->id)
                                        ->first();
                                @endphp
                                <span>{{ @$role->roles->name }}</span>
                            </div>
                        </div>
                        <div class="nav-author__options">
                            <ul>
                                <li>
                                    <a href="{{ url('user/profile/' . Auth::user()->id) }}">
                                        <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user"
                                            class="svg"> Profile</a>
                                </li>
                                <li>
                                    <a href="{{ url('change-password/' . Auth::user()->id) }}">
                                        <img src="{{ asset('assets/img/svg/user.svg') }}" alt="user"
                                            class="svg"> Change Password</a>
                                </li>
                                {{-- <li>
                                    <a href="">
                                        <img src="{{ asset('assets/img/svg/settings.svg') }}" alt="settings" class="svg"> Settings</a>
                                </li> --}}
                            </ul>
                            <a href="" class="nav-author__signout btn-secondary"
                                onclick="event.preventDefault();document.getElementById('logout').submit();">
                                <img src="{{ asset('assets/img/svg/log-out.svg') }}" alt="log-out" class="svg">
                                Sign Out</a>
                            <form style="display:none;" id="logout" action="{{ route('logout') }}" method="POST">
                                @csrf
                                @method('post')
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="navbar-right__mobileAction d-md-none">
            <a href="#" class="btn-search">
                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg feather-search">
                <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg feather-x">
            </a>
            <a href="#" class="btn-author-action">
                <img src="{{ asset('assets/img/svg/more-vertical.svg') }}" alt="more-vertical" class="svg"></a>
        </div>
    </div>
</nav>
<script>
    function showTime() {
        var date = new Date();
        var h = date.getHours();
        var m = date.getMinutes();
        var s = date.getSeconds();
        var session = "AM";
        if (h > 12) {
            h = h - 12; // 12 Hour Format
            session = "PM";
        }
        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;


        document.getElementById("digital-clock").innerHTML = h + ":" + m + ":" + s + " " + session;
        setTimeout(showTime, 1000);
    }
    showTime();
    $('.not-count').on('click', function() {
        $(this).text('');
    });
</script>

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
