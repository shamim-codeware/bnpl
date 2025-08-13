@section('title', $title)
@section('description', $description)
@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="form-element">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-default card-md mb-4 grntr_card">
                        <div class="card-header">
                            <h6>Product Details</h6>
                        </div>
                        <div class="card-body py-md-30">
                            <form action="" method="post" class="parent-assign">
                                <input type="hidden" name="_token" value="" autocomplete="off" />
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <fieldset class="">
                                                <legend>Product Details:</legend>
                                                <div class="row">
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Category:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>Rangs AC</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Serial Number:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>132645</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Model:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>RAC-26SH</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Size:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>900 x 372 x 610</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Brand:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>Rangs</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Price:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>BDT 51,900</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 text-end">
                                                        <span class="fw-medium">Showroom Name:</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15">
                                                        <span>UTTARA-1 SHOWROOM SECTOR#6</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-7">
                                            <fieldset>
                                                <legend>Loan Details:</legend>
                                                <div class="row">
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Loan Agreement Date:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>12.04.2024</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Loan Start Date:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>12.04.2024</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Loan Stop Date:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>12.04.2024</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">First Installment Amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>51,400.00 TK</span>
                                                    </div>
                                                    {{-- <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Discount Amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>5,400.00 TK</span>
                                                    </div> --}}
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Installment Amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>51,400.00 TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Number of installments:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>6</span>
                                                    </div>
                                                    {{-- <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Overpay Amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>8,567.00 TK</span>
                                                    </div> --}}
                                                    <div class="col-md-7 mb-15 mt-15 text-end">
                                                        <span class="fw-medium">Receivable for next token amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15 mt-15">
                                                        <span>8,567.00 TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Total loan paid amount:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>28,567.00 TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Outstanding balance:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>28,567.00 TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Late fee per day:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>1,567.00 TK</span>
                                                    </div>
                                                    <div class="col-md-7 mb-15 text-end">
                                                        <span class="fw-medium">Interest Rate:</span>
                                                    </div>
                                                    <div class="col-md-5 mb-15">
                                                        <span>6%</span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h2>Transaction List (All)</h2>
                        </div>
                        <div class="card-body p-3" dir="ltr">
                            <div class="table-responsive d-lg-block d-md-block d-none custom-data-table-wrapper2">
                                <table class="table mb-0 table-bordered custom-data-table">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <span class="userDatatable-title">Transaction type</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">customer name</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">phone number</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">product model</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">showroom</span>
                                            </th>
                                            <th style="width: 13%;" data-type="html" data-name='Booking Id'>
                                                <span class="userDatatable-title">transaction date and time</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">transaction amount</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">collection type</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">received by</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">Down payment</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">Hammad Rahman</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    01890901015
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    RSTF-12OMINI
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Shoptorshi Electronics,Mohammadpur
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>02/01/2024 11:42 AM</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    62500
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Bkash
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    parvez
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">Installment</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">Hammad Rahman</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    01890901015
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    RSTF-12OMINI
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Shoptorshi Electronics,Mohammadpur
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>02/01/2024 11:42 AM</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    62500
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Bkash
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    parvez
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="pt-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h2>Payment Collection List</h2>
                        </div>
                        <div class="card-body p-3" dir="ltr">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 mb-25">
                                        <select name="store_type" id="store_type" class="form-control">
                                            <option value="">Store type</option>
                                            <option value="showroom">Showroom</option>
                                            <option value="ctp">CTP</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-25">
                                        <select name="zone" id="zone" class="form-control">
                                            <option value="">Zone</option>
                                            <option value="shyamoli">Shyamoli</option>
                                            <option value="adabor">Adabor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-25">
                                        <select name="showroom_ctp" id="showroom_ctp" class="form-control">
                                            <option value="">Showroom/CTP</option>
                                            <option value="shyamoli">Shyamoli</option>
                                            <option value="adabor">Adabor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="from_date" autocomplete="off" value="Form date" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8" >
                                    </div>
                                    <div style="width: 2%; height:40px;" class="col-1 d-flex justify-content-center align-items-center"><p class="m-0">To</p></div>
                                    <div class="col-md-3 mb-3">
                                            <input type="text" name="to_date" autocomplete="off" value="To date" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker17" >
                                    </div>
                                    <div class="col-md-3 pe-0 mb-3">
                                        <input type="search" name="keyword" value="search" class="form-control rounded-r-0" placeholder="Search" aria-label="Search">
                                    </div>
                                    <div class="col-md-2 ps-0 mb-3">
                                         <input class="btn btn-primary w-30 rounded-l-0 h-100" type="submit" value="Search">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive d-lg-block d-md-block d-none custom-data-table-wrapper2">
                                <table class="table mb-0 table-bordered custom-data-table">
                                    <thead>
                                        <tr class="userDatatable-header">
                                            <th>
                                                <span class="userDatatable-title">Transaction type</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">customer name</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">phone number</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">product model</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">showroom</span>
                                            </th>
                                            <th style="width: 13%;" data-type="html" data-name='Booking Id'>
                                                <span class="userDatatable-title">transaction date and time</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">transaction amount</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">collection type</span>
                                            </th>
                                            <th>
                                                <span class="userDatatable-title">received by</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">Down payment</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">Hammad Rahman</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    01890901015
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    RSTF-12OMINI
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Shoptorshi Electronics,Mohammadpur
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>02/01/2024 11:42 AM</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    62500
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Bkash
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    parvez
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="userDatatable-content">Installment</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">Hammad Rahman</div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    01890901015
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    RSTF-12OMINI
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Shoptorshi Electronics,Mohammadpur
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="userDatatable-inline-title">
                                                        <a href="#" class="text-dark fw-500">
                                                            <h6>02/01/2024 11:42 AM</h6>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    62500
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    Bkash
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    parvez
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="pt-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h2>Zone overview/CTP Overview</h2>
                        </div>
                        <div class="card-body p-3" dir="ltr">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 mb-25">
                                        <select name="report_type" id="report_type" class="form-control">
                                            <option value="">Report Type</option>
                                            <option value="zone">Zone</option>
                                            <option value="showroom">Showroom</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-25">
                                        <select name="all_zone" id="all_zone" class="form-control">
                                            <option value="">All Zone</option>
                                            <option value="shyamoli">Shyamoli</option>
                                            <option value="adabor">Adabor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-25">
                                        <select name="product_group" id="product_group" class="form-control">
                                            <option value="">Product Group</option>
                                            <option value="tv">Tv</option>
                                            <option value="ac">AC</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="from_date" autocomplete="off" value="Form date" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker8" >
                                    </div>
                                    <div style="width: 2%; height:40px;" class="col-1 d-flex justify-content-center align-items-center"><p class="m-0">To</p></div>
                                    <div class="col-md-3 mb-3">
                                            <input type="text" name="to_date" autocomplete="off" value="To date" class="form-control  ih-medium ip-gray radius-xs b-light" id="datepicker17" >
                                    </div>
                                    <div class="col-md-3 pe-0 mb-3">
                                        <input type="search" name="keyword" value="search" class="form-control rounded-r-0" placeholder="Search" aria-label="Search">
                                    </div>
                                    <div class="col-md-2 ps-0 mb-3">
                                         <input class="btn btn-primary w-30 rounded-l-0 h-100" type="submit" value="Search">
                                    </div>
                                </div>
                            </div>
                            <div class="GroupedBarChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
