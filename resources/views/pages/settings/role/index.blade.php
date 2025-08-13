@section('title',$title)
@section('description',$description)
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
                                <h6>Add Role</h6>
                            </div>
                            <div class="card-body py-md-30">
                                <form action="{{ url('roles') }}" method="post">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="form-group row mb-n25">
                                        <div class="col-md-4 mb-25">
                                            <div class="with-icon">
                                                <input type="text" required name="name" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Add Role">
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-basic pb-4">
                                            <button  type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                 
                </div>

            </div>
           
        </div>
        <div class="row">
            <div class="col-12 mb-30">
                <div class="support-ticket-system support-ticket-system--search">
                    <div class="support-form datatable-support-form d-flex justify-content-xxl-end justify-content-center align-items-center flex-wrap">
                        <div class="row row-cols-3 w-100">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col d-flex justify-content-end "> <div class="support-form__search">
                                <div class="support-order-search">
                                    <form action="{{ url('/roles') }}" class="support-order-search__form">
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
                                            <span class="userDatatable-title">Role</span>
                                        </th>
                                                                         
                                        <th>
                                            <span class="userDatatable-title">Created by</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created Date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th class="actions">
                                            <span class="userDatatable-title">Action
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $key=>$role)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="userDatatable-inline-title">
                                                    <a href="#" class="text-dark fw-500">
                                                        <h6>{{ $role->name }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$role->users->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ date('d/m/Y', strtotime($role->created_at)) }}
                                            </div>
                                        </td>
                                       
                                        <td>
                                            <div class="userDatatable-content--subject status-check">
                                              {{-- {{ $role->status == 1 ? "Active" : "inactive" }} --}}

                                              @if ($role->status == 1)
                                                    <p style="background-color: #0e890e">Active</p>  
                                                @else
                                                    <p style="background-color: #ff0000">Inactive</p>  
                                                @endif

                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                {{-- <li>
                                                    <a href="{{ url('roles/'.$role->id) }}" class="view">
                                                        <i class="las la-eye"></i>
                                                    </a>
                                                </li> --}}
                                                <li>
                                                    <a data-toggle="tooltip" data-placement="top" title="Change Status" href="{{ url('role-status/'.$role->id) }}" class="view">
                                                        <i class="las la-history"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a data-toggle="tooltip" data-placement="top" title="Edit" href="{{url('roles/'.$role->id.'/edit')}}" class="edit">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li>
                                              
                                            </ul>
                                        </td>
                                    </tr>
                                   @endforeach
                                 
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
         
        </div>
    </div>
</div>
@endsection
