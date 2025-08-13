@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')


<div id="filter-form-container"></div>

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-lg-12 p-3 bg-white rounded">
            <table class="table mb-0 table-borderless adv-table" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="10">
                <thead>
                    <tr class="userDatatable-header">
                        <th>
                            <span class="userDatatable-title">Event Code</span>
                        </th>
                        <th data-type="html" data-name='Booking Id'>
                            <span class="userDatatable-title">Created date</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">Source</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">Product</span>
                        </th>
                        <th  >
                            <span class="userDatatable-title">Full Name</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">Mobile</span>
                        </th>
                        <th data-type="html" data-name='Created'>
                            <span class="userDatatable-title">Customer Type</span>
                        </th>
                        <th data-type="html" data-name='Created'>
                            <span class="userDatatable-title">Status</span>
                        </th>
                        <th data-type="html" data-name='Created'>
                            <span class="userDatatable-title">Created by</span>
                        </th>
                        <th data-type="html" data-name='Created'>
                            <span class="userDatatable-title">Next Follow-up</span>
                        </th>
                        <th data-type="html" data-name='Created'>
                            <span class="userDatatable-title">Follow-up</span>
                        </th>
                       
                        <th>
                            <span class="userDatatable-title d-block float-right">action</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="userDatatable-content">EN00001</div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="userDatatable-inline-title">
                                    <a href="#" class="text-dark fw-500">
                                        <h6>Digital</h6>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                Facebook
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                Rangs 32
                                inch
                                Frameless
                                HD Regular
                                LED TV
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                Mr.
Kamal
       

                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                01711xxxxx
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content d-inline-block">
                                <span class="color-success  userDatatable-content active">Individua</span>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content d-inline-block">
                                <span class="color-success  userDatatable-content active">Open</span>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content d-inline-block">
                                <span class="color-success  userDatatable-content active">Mr. Rahim</span>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content d-inline-block">
                                <span class="color-success  userDatatable-content active">20-06-202
                                    3</span>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content d-inline-block">
                                <span class="color-success  userDatatable-content active">20-06-202
                                    3
                                    </span>
                            </div>
                        </td>
                        
                        <td>
                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                <li>
                                    <a href="#" title="edit" class="edit">
                                        <i class="uil uil-edit"></i></a>
                                </li>
                                <li>
                                    <a href="#" title="remove" class="remove">
                                        <img src="{{ asset('assets/img/svg/trash-2.svg') }}" alt="trash-2" class="svg"></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                  
                </tbody>
            </table>
        </div>
    </div>
</div>

<h2>Enquiry History</h2>

<div class="container">
    <div class="row bg-white rounded">
        <div class="col-lg-6">
            <p><strong>Full Name:</strong> Mr. Kamal</p>
            <p><strong>Mobile:</strong>  017xxxxxxx</p>
            <p><strong>Alternative Mobile:</strong>  017xxxxxxx</p>
            <p><strong>Email:</strong>  Kamal@gmail.com</p>
            <p><strong>Enquiry Type:</strong>  Digital</p>
            <p><strong>Event Code:</strong>  EN00001</p>
            <p><strong>Source:</strong>  Facebook   </p>
                   
        </div>
        <div class="col-lg-6">
            <p><strong>Product:</strong>  Washing Machine</p>
            <p><strong>Customer Type:</strong> Individual</p>
            <p><strong>Gender:</strong>  Male</p>
            <p><strong>Expected deliver/Sales Date (Calendar):</strong>  27-07-2023</p>
            <p><strong>Available Exchange offer:</strong>Yes</p>
            <p><strong>Purchase Mode:</strong> Cash</p>        
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-lg-12 p-3 bg-white rounded">
            <table class="table mb-0 table-borderless adv-table" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="10">
                <thead>
                    <tr class="userDatatable-header">
                        <th>
                            <span class="userDatatable-title">Date & Time</span>
                        </th>
                        <th data-type="html" data-name='Booking Id'>
                            <span class="userDatatable-title">Follow-up</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">Follow-Up Information
                                </span>
                        </th>
                        <th>
                            <span class="userDatatable-title">Method</span>
                        </th>
                        <th>
                            <span class="userDatatable-title">Note</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="userDatatable-content">23-07-2023</div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="userDatatable-inline-title">
                                    <a href="#" class="text-dark fw-500">
                                        <h6>1st Follow-up</h6>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                Next Month
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                Physical
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content">
                                Note

                            </div>
                        </td>
                    </tr>             
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- <div class="container">
    <div class="row align-items-center py-5">
        <div class="col-lg-6 mx-auto">
            <form class="row g-3">
                
                <div class="col-lg-8">
                  <label for="inputPassword2" class="visually-hidden">Enquiry Type</label>
                  <input type="text" class="form-control"  placeholder="Enquiry Type">
                </div>

                <div class="col-lg-4">
                    <button class="btn btn-primary -bottom-3 -mb-2" type="submit">Save</button>
                </div>
               
              </form>
        </div>
    </div> --}}

{{-- 
    <div class="col-lg-12 p-3 bg-white rounded">
        <table class="table mb-0 table-borderless adv-table" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="10">
            <thead>
                <tr class="userDatatable-header">
                    <th>
                        <span class="userDatatable-title">Date</span>
                    </th>
                    <th data-type="html" data-name='Booking Id'>
                        <span class="userDatatable-title">Booking ID</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Quotation ID</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Customer</span>
                    </th>
                    <th  >
                        <span class="userDatatable-title">Mobile</span>
                    </th>
                    <th>
                        <span class="userDatatable-title">Amount</span>
                    </th>
                    <th data-type="html" data-name='Created'>
                        <span class="userDatatable-title">Created by</span>
                    </th>
                    <th>
                        <span class="userDatatable-title d-block float-right">action</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="userDatatable-content">23-07-2023 </div>
                    </td>
                    <td>
                        <div class="d-flex">
                            <div class="userDatatable-inline-title">
                                <a href="#" class="text-dark fw-500">
                                    <h6>BK-001 </h6>
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            QN-00001
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            Mr. Kamal
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            017xxxxxx
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            2,21,000.00
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content d-inline-block">
                            <span class="color-success  userDatatable-content active">Rahim</span>
                        </div>
                    </td>
                    <td>
                        <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                            <li>
                                <a href="#" title="edit" class="edit">
                                    <i class="uil uil-edit"></i></a>
                            </li>
                            <li>
                                <a href="#" title="remove" class="remove">
                                    <img src="{{ asset('assets/img/svg/trash-2.svg') }}" alt="trash-2" class="svg"></a>
                            </li>
                        </ul>
                    </td>
                </tr>
              
            </tbody>
        </table>
    </div> --}}
</div>


{{-- <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.form-component') }}</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="las la-home"></i>Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('menu.form-component') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card mt-30">
                <div class="card-body">
                    <div class="userDatatable adv-table-table global-shadow border-0 bg-white w-100 adv-table">
                        <div class="table-responsive">
                            <div class="adv-table-table__header">
                                <h4>Pre-Booking List</h4>
                                <div class="adv-table-table__button">
                                    <div class="action-btn">
                                        <a href="#" class="btn px-15 btn-primary" data-bs-toggle="modal" data-bs-target="#new-member">
                                            <i class="las la-plus fs-16"></i>Add New pre-booking</a>
                                    </div>
                                </div>
                            </div>
                            <div id="filter-form-container"></div>
                            <table class="table mb-0 table-borderless adv-table" data-sorting="true" data-filter-container="#filter-form-container" data-paging-current="1" data-paging-position="right" data-paging-size="10">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <span class="userDatatable-title">Date</span>
                                        </th>
                                        <th data-type="html" data-name='Booking Id'>
                                            <span class="userDatatable-title">Booking ID</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Quotation ID</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Customer</span>
                                        </th>
                                        <th  >
                                            <span class="userDatatable-title">Mobile</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Amount</span>
                                        </th>
                                        <th data-type="html" data-name='Created'>
                                            <span class="userDatatable-title">Created by</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title d-block float-right">action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="userDatatable-content">23-07-2023 </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>BK-001 </h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                QN-00001
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                Mr. Kamal
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                017xxxxxx
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                2,21,000.00
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content d-inline-block">
                                                <span class="color-success  userDatatable-content active">Rahim</span>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                <li>
                                                    <a href="#" title="print" class="view">
                                                        <i class="uil uil-print"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" title="edit" class="edit">
                                                        <i class="uil uil-edit"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#" title="remove" class="remove">
                                                        <img src="{{ asset('assets/img/svg/trash-2.svg') }}" alt="trash-2" class="svg"></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div> --}}
@endsection
