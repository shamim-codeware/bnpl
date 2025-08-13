@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="form-element">
        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system support-ticket-system--search">
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center">
                            <h6>Customer</h6>
                            <a class="mx-2 fw-bold excel-btn" href="{{ url('/customer-export') }}">Export</a>
                        </div>                     
                    </div>
                    <div class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                        <div class="row row-cols-3 w-100">
                            <div class="col">
                                <div class="col">
                                    <h2 class="mt-3">Total - {{ $total }}</h2>
                                </div>
                            </div>
                            <div class="col"></div>
                            <div class="col d-flex justify-content-end"> <div class="support-form__search">
                                <div class="support-order-search">
                                    <form action="{{ url('/customer') }}" method="GET" class="support-order-search__form">
                                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                        <input type="search" name="keyword" value="{{ Request::get('keyword') }}" class="form-control border-0 box-shadow-none" placeholder="Search" aria-label="Search">
                                        <input class="search-btn-btn" type="submit" value="Search">
                                    </form>
                                </div>
                            </div></div>
                        </div>
                    </div>
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
                                            <span class="userDatatable-title">Number </span>
                                        </th>   
                                        <th>
                                            <span class="userDatatable-title">Email </span>
                                        </th>      
                                        <th>
                                            <span class="userDatatable-title">Type </span>
                                        </th>                    
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created by</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created Date</span>
                                        </th>
                                        <th class="actions">
                                            <span class="userDatatable-title">Action
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $key=>$type)
                                    <tr>
                                        <td>{{ ($customers->currentpage()-1) * $customers->perpage() + $key + 1 }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $type->name }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                      
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ $type->number }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ $type->email }}
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$type->customer_types->name }}
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <div class="userDatatable-content--subject status-check">
                                                @if ($type->status == 1)
                                                    <p style="background-color: #0e890e">Active</p>  
                                                @else
                                                    <p style="background-color: #ff0000">Inactive</p>  
                                                @endif
                                            </div>
                                        </td>
                                       
                                        <td>
                                            {{ @$type->users->name }}
                                        </td>
                                        <td> {{ date('d/m/Y', strtotime($type->created_at)) }}</td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                <li>
                                                    <a href="{{ url('customer-status/'.$type->id) }}" class="view">
                                                        <i class="las la-history"></i>
                                                    </a>
                                                </li>
                                                {{-- <li>
                                                    <a href="{{url('customer-type/'.$type->id.'/edit')}}" class="edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li> --}}
                                              
                                            </ul>
                                        </td>
                                    </tr>
                                   @endforeach
                                 
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-2">
                            {{ $customers->links() }}
                        </div>   
                    </div>
                </div>
            </div>
         
        </div>
    </div>
</div>
@endsection
