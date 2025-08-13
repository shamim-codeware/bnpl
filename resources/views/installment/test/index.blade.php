@section('title',$title)
@section('description',$description)
@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="form-element">
        
        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system support-ticket-system--search">
                    <div class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                        <div class="row row-cols-3 w-100">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col d-flex justify-content-end "> <div class="support-form__search">
                                <div class="support-order-search">
                                    <form action="{{ url('/category') }}" method="GET" class="support-order-search__form">
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
                                            <span class="userDatatable-title">Group Name</span>
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
                                  
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6></h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                          <td>
                                            <div class="userDatatable-content--subject">
                                              
                                            </div>
                                        </td>
                                    
                                        <td>
                                            <div class="userDatatable-content--subject">
                                               
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                             
                                            </div>
                                        </td>
                                     
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                             
                                            </ul>
                                        </td>
                                    </tr>
                                 
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-2">
                         
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
