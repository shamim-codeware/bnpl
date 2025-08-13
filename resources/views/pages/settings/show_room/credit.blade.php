@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-default card-md mb-4">
                                <div class="card-header">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <h6>Showroom Credit Report </h6>
                                        {{-- <a class="mx-2 fw-bold excel-btn" href="{{ url('/showroom-export') }}">Export</a> --}}
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center w-100">
                        <div class="col-md-6">
                            <h2 class="">Total - {{ $total }}</h2>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <form action="/show-room-credit" class="filter-support-order-search__form w-100" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select onchange="Filter()" name="store_type" id="store_type" class="form-control">
                                            <option value="">All</option>
                                            <option value="0">Showroom</option>
                                            <option value="1">Dealer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="zone_id" onchange="Filter()" id="zone_id" class="form-control">
                                            <option value="">Zone Type</option>
                                            @foreach ($zones as $key => $zone)
                                                <option
                                                    @if (request('zone_id') == $zone->id) @selected(true) @endif
                                                    value="{{ $zone->id }}">{{ $zone->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="col-md-4">
                                <form action="/show-rooms" class="support-order-search__form" method="get">
                                    <div class="row w-100">
                                        <div class="col-md-9 pe-0">
                                            <input type="search" name="keyword" class="form-control rounded-r-0"
                                                placeholder="Search" aria-label="Search">
                                        </div>
                                        <div class="col-md-3 ps-0">
                                            <input id="filter_date" class="btn btn-primary w-30 rounded-l-0 h-100"
                                                type="submit" value="Search">
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                    </div>
                    {{-- <div class="support-form__search">
                            <div class="support-order-search">
                                <form action="/show-rooms" class="support-order-search__form" method="get">
                                    <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                    <input name="keyword" class="form-control border-0 box-shadow-none" type="search"
                                        placeholder="Search" aria-label="Search">
                                    <input style="background: #006666 !important;" class="search-btn-btn" type="submit"
                                        value="Search">
                                </form>
                            </div>
                        </div> --}}
                </div>
                <div class="card-body p-3">
                    <div class="userDatatable userDatatable--ticket userDatatable--ticket--2 mt-1">
                        <div class="table-responsive custom-data-table-wrapper2">
                            <table class="table mb-0 table-borderless custom-data-table">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">SL</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Credit Score </span>
                                        </th>
                                        <th>  <span class="userDatatable-title"> Used Balance </span> </th>
                                        <th>   <span class="userDatatable-title"> Remaining Balance </span> </th>
                                        <th>
                                            <span class="userDatatable-title">Store Type</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">C. Name</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showrooms as $key => $showroom)
                                        <tr>
                                            <td>{{ ($showrooms->currentpage() - 1) * $showrooms->perpage() + $key + 1 }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>{{ $showroom->name }}</h6>
                                                            <span style="font-size: 12px" data-toggle="tooltip"
                                                                data-placement="top" title="Created By"
                                                                style="color: #00ccff"><i
                                                                    class="fas fa-user pe-1"></i>{{ $showroom->users ? $showroom->users->name : '' }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $showroom->credit_score }}</td>
                                            <td>
                                               @php 
                                                $dueData = App\Models\HirePurchase::where('installment_complete', 0)
                                                ->where('hire_purchases.showroom_id', $showroom->id)
                                                ->join('hire_purchase_products', 'hire_purchases.id', '=', 'hire_purchase_products.hire_purchase_id')
                                                ->select(
                                                    DB::raw('SUM(hire_purchase_products.hire_price - hire_purchase_products.total_paid) as total_due'),
                                                    DB::raw('COUNT(hire_purchases.id) as total_count')
                                                )
                                                ->first(); 
                                                $total_credit = $dueData->total_due;
                                                  
                                               @endphp  
                                               {{ $total_credit }}
                                            </td>
                                            <td>{{ $showroom->credit_score - $total_credit }}</td>
                                            <td>

                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <h6>{{ $showroom->dealar == 1 ? 'Dealer' : 'Show Room' }}</h6>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="tel:{{ $showroom->number }}" class="text-dark fw-500">
                                                            <h6>{{ $showroom->contact_person }}</h6>
                                                            <span style="font-size: 12px"><i class="fas fa-phone pe-1"></i>
                                                                {{ $showroom->number }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                           
                                          

                                          
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-2">
                            {{ $showrooms->links() }}
                        </div>
                    </div>
                </div>


                <script>
                    function Filter() {

                        $(".filter-support-order-search__form").submit();
                    }
                </script>
            @endsection
