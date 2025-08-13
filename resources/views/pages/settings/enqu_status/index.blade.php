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
                            @if (Auth::user()->user_action(1))
                                <div class="card-header">
                                    <h6>Add Enquiry Status</h6>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card-body py-md-30">
                                    <form action="{{ url('enquiry-status') }}" method="post">
                                        @csrf
                                        <div class="form-group row mb-n25">
                                             <div class="col-md-3 mb-25">
                                                <select name="parent_id" id="select-parent-source" class="form-control">
                                                    <option value="0">Select Parent Status</option>
                                                    @foreach($status as $parent)
                                                        <option value="{{ $parent->id }}">{{ $parent->name  }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-25">
                                                <div class="with-icon">
                                                    <input type="text" required name="name" class="form-control  ih-medium ip-lightradius-xs b-light" id="inputNameIcon1" placeholder="Add Enquiry Status">
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-basic pb-4">
                                                <button  type="submit" class="btn btn-lg btn-primary customr-btn btn-submit">save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
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
                                    <form action="{{ url('enquiry-status') }}" method="get" class="support-order-search__form">
                                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                        <input type="search" name="keyword" value="{{ Request::get('keyword') }}" class="form-control border-0 box-shadow-none" type="search" placeholder="Search" aria-label="Search">
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
                                        <th><span class="userDatatable-title">Sl</span></th>
                                        <th><span class="userDatatable-title">Name</span></th>
                                        <th><span class="userDatatable-title">Parent Status</span></th>
                                        <th>
                                            <span class="userDatatable-title">Created by</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Created Date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Status</span>
                                        </th>
                                        <th class="actions"><span class="userDatatable-title">Action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enquiry_status as $type)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
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
                                                {{ @$type->parents->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content--subject">
                                                {{ @$type->users->name }}
                                            </div>
                                        </td>
                                         
                                        <td>
                                            <div class="userDatatable-content--priority">
                                                {{ date('d/m/Y', strtotime($type->created_at)) }}
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
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center align-items-center flex-wrap">
                                                @if (Auth::user()->user_action(4))
                                                    <li>
                                                        <a href="{{ url('enquiry-status/'.$type->id) }}" class="view"><i class="las la-history"></i></a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->user_action(2))
                                                    <li>
                                                        <a href="{{url('enquiry-status/'.$type->id.'/edit')}}" class="edit"><i class="uil uil-edit"></i></a>
                                                    </li>
                                                @endif    
                                            </ul>
                                        </td>
                                    </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-2">
                            {{ $enquiry_status->links()  }}
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
